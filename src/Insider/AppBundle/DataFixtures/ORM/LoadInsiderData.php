<?php

namespace Insider\AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Insider\AppBundle\Utils\LeagueTourGenerator;
use Insider\AppBundle\Entity\Team;
use Insider\AppBundle\Entity\Game;
use Insider\AppBundle\Entity\League;

class LoadInsiderData extends AbstractFixture implements FixtureInterface
{
    // private $teamList = [
    //     'Arsenal',
    //     'Manchester City',
    //     'Chelsea',
    //     'Liverpool',
    // ];
    private $teamList = [
        'one',
        'two',
        'tree',
        'four',
        'five',
        'six',
        'seven',
        'eight',
    ];

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $persistedCommands = [];
        foreach ($this->teamList as $i => $name) {
            $team = new Team();
            $team->setName($name);

            $manager->persist($team);
            $this->addReference('t' . $i, $team);

            $persistedCommands[] = $this->getReference('t' . $i);
        }

        $generator = new LeagueTourGenerator($persistedCommands);

        $tourTable = $generator->generateCircle();

        $league = new League();
        $league->setName('barclays premier');
        $league->setTourCount(count($tourTable));

        foreach ($tourTable as $tourNumber => $tour) {
            $l = $tour[0];
            $r = $tour[1];

            foreach ($l as $i => $leftCommand) {
                $game = new Game();

                $game->setTour($tourNumber + 1);

                $game->setBlue($leftCommand);
                $game->setRed($r[$i]);

                $game->setBlueGoal(rand(0, 7));
                $game->setRedGoal(rand(0, 7));

                $manager->persist($game);

                $league->addGame($game);
            }
        }

        $manager->persist($league);

        $manager->flush();
    }
}
