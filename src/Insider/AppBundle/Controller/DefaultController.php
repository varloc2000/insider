<?php

namespace Insider\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        // One game for comand per week
        $week = $request->query->get('week') ?: 1;

        $games = $this->getDoctrine()
            ->getRepository('InsiderAppBundle:Game')
            ->getGamesByTour($week)
        ;

        return $this->render('InsiderAppBundle:Default:index.html.twig', [
            'games' => $games,
            'week' => $week,
        ]);
    }
}
