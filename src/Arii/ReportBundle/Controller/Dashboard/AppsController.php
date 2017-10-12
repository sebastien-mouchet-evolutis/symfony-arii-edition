<?php

namespace Arii\ReportBundle\Controller\Dashboard;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class AppsController extends Controller
{
    
    public function indexAction()
    {                
        $request = Request::createFromGlobals();
        $session = $this->container->get('arii_core.session');
        return $this->render('AriiReportBundle:Dashboard\Apps:index.html.twig' );
    }

    public function gridAction()
    {
        $em = $this->getDoctrine()->getManager();
        $Apps = $em->getRepository("AriiCoreBundle:Application")->findApplications();
        $xml = "<?xml version='1.0' encoding='iso-8859-1'?><rows>";
        foreach ($Apps as $app) {
            $xml .= '<row id="'.$app['name'].'">';
            if ($app['title']!='')
                $xml .= '<cell>'.$app['title'].'</cell>';
            else
                $xml .= '<cell>'.$app['name'].'</cell>';
            $xml .= '</row>';
        }
        $xml .= '</rows>';
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');        
        $response->setContent( $xml );
        return $response;    
        
    }
}

