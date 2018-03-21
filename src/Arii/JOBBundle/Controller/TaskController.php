<?php

namespace Arii\JOBBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    public function indexAction()
    {        
        return $this->render('AriiJOBBundle:Task:index.html.twig' );
    }

    public function editAction()
    {   
        return $this->render('AriiJOBBundle:Task:edit.html.twig' );
    }

    public function toolbarAction()
    {        
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        
        return $this->render('AriiJOBBundle:Task:toolbar.xml.twig', array(), $response  );
    }

}

