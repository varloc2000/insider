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
    private $teamList = [
        'T1 Arsenal',
        'T2 Manchester City',
        'T3 Chelsea',
        'T4 Liverpool',
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

                $game->setHome($leftCommand);
                $game->setGuest($r[$i]);

                $game->setHomeGoal(rand(0, 7));
                $game->setGuestGoal(rand(0, 7));

                $manager->persist($game);

                $league->addGame($game);
            }
        }

        $manager->persist($league);

        $manager->flush();
    }
}
