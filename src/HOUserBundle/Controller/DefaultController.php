<?php

namespace HOUserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('HOUserBundle:Default:index.html.twig');
    }
}
