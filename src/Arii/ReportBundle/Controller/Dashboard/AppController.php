<?php

namespace Arii\ReportBundle\Controller\Dashboard;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class AppController extends Controller
{

    public function indexAction()
    {          
        $Filters = $this->container->get('report.filter')->getRequestFilter();
        return $this->render('AriiReportBundle:Dashboard\App:index.html.twig', $Filters );
    }

    public function jobsAction()
    {        
        $Filters = $this->container->get('report.filter')->getRequestFilter();

        $em = $this->getDoctrine()->getManager(); 
        $Jobs = $em->getRepository("AriiReportBundle:JOBDay")->findJobs($Filters['start'],$Filters['end'],$Filters['env'],$Filters['appl'],$Filters['job_class']);
        
        $xml = "<?xml version='1.0' encoding='iso-8859-1'?><data>";
        $last = $n = 0;
        foreach ($Jobs as $Job) {
            $xml .= '<item id="'.$Job['date']->format('md').'">';
            $xml .= '<mois>'.$this->get('translator')->trans('month.'.($Job['date']->format('m'))*1).'</mois>';
            $xml .= '<jour>'.$Job['date']->format('d').'</jour>';
            $xml .= '<jobs>'.$Job['jobs'].'</jobs>';
            $xml .= '<created>'.$Job['created'].'</created>';
            $xml .= '<deleted>'.$Job['deleted'].'</deleted>';
            $xml .= '<delta>'.($Job['jobs'] - $last).'</delta>';                
            $xml .= '</item>';
            $last = $Job['jobs'];
            $n++;
        }
        $xml .= '</data>';
        
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');        
        $response->setContent( $xml );
        return $response;            
    }

}

