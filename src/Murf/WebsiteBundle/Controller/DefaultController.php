<?php

namespace Murf\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {

        return $this->render('MurfWebsiteBundle:Default:index.html.twig', array());
    }
    public function aboutAction()
    {

        return $this->render('MurfWebsiteBundle:Default:about.html.twig', array());
    }
}
