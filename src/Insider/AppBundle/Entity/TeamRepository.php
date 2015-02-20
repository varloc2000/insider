<?php

namespace Insider\AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * TeamRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TeamRepository extends EntityRepository
{
    /**
     * Group data by team and join it with games data to calculate total goals
     * @param integer $tour
     * @return array
     */
    public function getLeagueDataByTour($tour)
    {
        $qb = $this->createQueryBuilder('t')
            ->addSelect('SUM(hg.homeGoal) as winAtHomeGoals')
            ->addSelect('SUM(hg.guestGoal) as lostAtHomeGoals')
            ->addSelect('SUM(gg.homeGoal) as lostAtGuestGoals')
            ->addSelect('SUM(gg.guestGoal) as winAtGuestGoals')
            ->addSelect('(COALESCE(SUM(hg.homeGoal),0) + COALESCE(SUM(gg.guestGoal),0)) as GF')
            ->addSelect('(COALESCE(SUM(hg.guestGoal),0) + COALESCE(SUM(gg.homeGoal),0)) as GA')
            ->addSelect('((COALESCE(SUM(hg.homeGoal),0) + COALESCE(SUM(gg.guestGoal),0)) - (COALESCE(SUM(hg.guestGoal),0) + COALESCE(SUM(gg.homeGoal),0))) as GD')
            ->addSelect('hg')
            ->addSelect('gg')
            ->leftJoin('t.homeGames', 'hg', \Doctrine\ORM\Query\Expr\Join::WITH, 'hg.guest != t.id AND hg.tour <= :tour')
            ->leftJoin('t.guestGames', 'gg', \Doctrine\ORM\Query\Expr\Join::WITH, 'gg.home != t.id AND gg.tour <= :tour')
            ->setParameter('tour', $tour)
            ->addGroupBy('t.id')
            ->addGroupBy('hg')
            ->addGroupBy('gg')
        ;

        return $qb->getQuery()->execute();
    }

    /**
     * @param integer $tour
     * @return array
     */
    public function getLeagueDataByTourSortedByGD($tour)
    {
        $teams = $this->getLeagueDataByTour($tour);

        usort($teams, function($a, $b) {
            return $b['GD'] - $a['GD'];
        });

        return $teams;
    }
}
