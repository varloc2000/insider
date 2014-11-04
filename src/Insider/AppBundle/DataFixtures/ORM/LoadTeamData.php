<?php

namespace Insider\AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Insider\AppBundle\Entity\Team;

class LoadTeamData implements FixtureInterface
{
    private $teamList = [
        'Arsenal',
        'Manchester City',
        'Chelsea',
        'Liverpool',
    ];

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->teamList as $name) {
            $team = new Team();
            $team->setName($name);

            $manager->persist($team);
        }

        $manager->flush();
    }
}
