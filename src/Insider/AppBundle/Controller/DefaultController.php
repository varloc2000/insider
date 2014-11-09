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

        $games = $this->getDoctrine()
            ->getRepository('InsiderAppBundle:Game')
            ->getGamesByTour($week)
        ;

        $tour = $this->getDoctrine()
            ->getRepository('InsiderAppBundle:Game')
            ->getMaxTour()
        ;

        $teams = $this->getDoctrine()
            ->getRepository('InsiderAppBundle:Team')
            ->getLeagueDataByTour($week)
        ;

        foreach ($teams as $team) {
            $team->calculateGamesStatistic();
        }

        if ($request->isXmlHttpRequest()) {
            $response = new JsonResponse();

            $response->setData([
                'success' => count($games) > 0,
                'content' => $this->render('InsiderAppBundle:Default:week_table.html.twig', [
                    'games' => $games,
                    'week' => $week,
                    'last_week' => $tour ? $tour['tour'] : null,
                    'teams' => $teams,
                ])->getContent(),
            ]);

        } else {

            $response = $this->render('InsiderAppBundle:Default:index.html.twig', [
                'games' => $games,
                'week' => $week,
                'last_week' => $tour ? $tour['tour'] : null,
                'teams' => $teams,
            ]);
        }

        return $response;
    }
}
