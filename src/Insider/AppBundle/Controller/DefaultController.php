<?php

namespace Insider\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('InsiderAppBundle:Default:index.html.twig');
    }
}
