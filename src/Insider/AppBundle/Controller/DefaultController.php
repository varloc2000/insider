<?php

namespace Insider\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        // One game for comand per week
        $week = $request->query->get('week') ?: null;

        $games = $this->getGameRepository()->getGamesByTour($week);

        $tour = $this->getGameRepository()->getMaxTour();

        $teams = $this->getTeamRepository()->getLeagueDataByTourSortedByGD(null !== $week ? $week : $tour);

        foreach ($teams as $team) {
            $team[0]->calculateGamesStatistic();
        }

        if ($request->isXmlHttpRequest()) {
            $response = new JsonResponse();

            $response->setData(array(
                'success' => count($games) > 0,
                'content' => $this->render('InsiderAppBundle:Default:week_table.html.twig', array(
                    'games' => $games,
                    'week' => $week,
                    'last_week' => $tour,
                    'teams' => $teams,
                ))->getContent(),
            ));
        } else {
            $response = $this->render('InsiderAppBundle:Default:index.html.twig', array(
                'games' => $games,
                'week' => $week,
                'last_week' => $tour,
                'teams' => $teams,
            ));
        }

        return $response;
    }

    /**
     * @return \Insider\AppBundle\Entity\GameRepository
     */
    protected function getGameRepository()
    {
        return $this->getDoctrine()->getRepository('InsiderAppBundle:Game');
    }

    /**
     * @return \Insider\AppBundle\Entity\TeamRepository
     */
    protected function getTeamRepository()
    {
        return $this->getDoctrine()->getRepository('InsiderAppBundle:Team');
    }
}
