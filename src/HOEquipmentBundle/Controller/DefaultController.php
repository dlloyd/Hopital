<?php

namespace HOEquipmentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('HOEquipmentBundle:Default:index.html.twig');
    }
}
