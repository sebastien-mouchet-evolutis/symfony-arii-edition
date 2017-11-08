<?php

namespace Arii\ReportBundle\Controller\Import;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $request = Request::createFromGlobals();
        $filter = $this->container->get('report.filter');
        list($env,$app,$day_past,$day,$month,$year,$start,$end,$class) = $filter->getFilter(
            $request->query->get( 'env' ),
            $request->query->get( 'app' ),
            $request->query->get( 'day_past' ),
            $request->query->get( 'day' ),
            $request->query->get( 'month' ),
            $request->query->get( 'year' ),
            $request->query->get( 'job_class' )    
        );
        
        return $this->render('AriiReportBundle:Import:aggregation.html.twig', 
            array( 
                'appl' => $app,
                'env' => $env,
                'job_class' => $class,
                'month' => $month,
                'day' => $day,
                'year' => $year,
                'day_past' => $day_past
                ) 
            );
    }
    
    public function toolbarAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render("AriiReportBundle:Import:toolbar.xml.twig", array(), $response);
    }

    public function toolbar_updateAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render("AriiReportBundle:Import:toolbar_update.xml.twig", array(), $response);
    }
    
}

