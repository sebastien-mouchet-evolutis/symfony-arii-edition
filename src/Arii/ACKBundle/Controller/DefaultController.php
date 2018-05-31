<?php

namespace Arii\ACKBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AriiACKBundle:Default:index.html.twig');
    }

    public function readmeAction()
    {
        return $this->render('AriiACKBundle:Default:readme.html.twig');
    }

    public function menuAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        return $this->render('AriiACKBundle:Default:menu.json.twig',array(), $response);
    }
    
    public function ribbonAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        return $this->render('AriiACKBundle:Default:ribbon.json.twig',array(), $response);
    }

    public function toolbarAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render('AriiACKBundle:Default:toolbar.xml.twig', array(), $response );
    }
}
