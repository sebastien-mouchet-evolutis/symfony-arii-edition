<?php

namespace Arii\ReportBundle\Controller\Dashboard;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class RunsDayController extends Controller
{
    
    public function indexAction()
    {
        $request = Request::createFromGlobals();
        $filter = $this->container->get('report.filter');
        list($env,$app,$day_past,$day,$month,$year,$start,$end) = $filter->getFilter(
            $request->query->get( 'env' ),
            $request->query->get( 'app' ),
            $request->query->get( 'day_past' ),                
            $request->query->get( 'day' ),
            $request->query->get( 'month' ),
            $request->query->get( 'year' )
        );
        
        return $this->render('AriiReportBundle:Dashboard\Runs:day.html.twig', 
            array( 
                'appl' => $app,
                'env' => $env,
                'day' => $day,
                'month' => $month,
                'year' => $year,
                'day_past' => $day_past
                ) 
            );
    }

    public function gridAction($limit=999)
    {
        $request = Request::createFromGlobals();
        $filter = $this->container->get('report.filter');
        list($env,$application,$day_past,$day,$month,$year,$start,$end) = $filter->getFilter(
            $request->query->get( 'env' ),
            $request->query->get( 'app' ),
            0,
            $request->query->get( 'day' ),
            $request->query->get( 'month' ),
            $request->query->get( 'year' )
        );
        
        // date fixe pour les jours
        $date = new \DateTime(sprintf("%04d-%02d-%02d",$year,$month,$day));
        $em = $this->getDoctrine()->getManager();        
        $Runs = $em->getRepository("AriiReportBundle:RUNDay")->findExecutionsByApp($date,$env);
        
        $portal = $this->container->get('arii_core.portal');
        $App = $portal->getApplications();

        $xml = "<?xml version='1.0' encoding='iso-8859-1'?><rows>";
        $xml .= '<head><afterInit><call command="clearAll"/></afterInit></head>';
        $nb=0;
        foreach ($Runs as $run) {
            if ($run['executions']>0) { 
                $a = $run['application'];
                if (!isset($App[$a])) continue;
                if ($App[$a]['active']!=1) continue;
                $xml .= '<row id="'.$run['application'].'">';
                $xml .= '<cell>'.$App[$a]['title'].'</cell>';
                $xml .= '<cell>'.$run['application'].'</cell>';                
                $xml .= '<cell>'.$run['executions'].'</cell>';
                $xml .= '<cell>'.$run['alarms'].'</cell>';
                $xml .= '<cell>'.$run['acks'].'</cell>';
                $xml .= '</row>';
                $nb++;
            }
            if ($nb>=$limit) break;
        }
        $xml .= '</rows>';
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');        
        $response->setContent( $xml );
        return $response;            
    }

    public function jobsAction($application='%',$env='P')
    {
        $request = Request::createFromGlobals();
        $filter = $this->container->get('report.filter');
        list($env,$application,$day_past,$day,$month,$year,$start,$end,$class) = $filter->getFilter(
            $request->query->get( 'env' ),
            $request->query->get( 'app' ),
            0,
            $request->query->get( 'day' ),
            $request->query->get( 'month' ),
            $request->query->get( 'year' ),
            $request->query->get( 'class' )
        );

        $em = $this->getDoctrine()->getManager();
        // date fixe pour les jours
        $now = sprintf("%04d-%02d-%02d",$year,$month,$day);
        $start = new \DateTime($now.' 00:00:00');
        $end   = new \DateTime($now.' 23:59:59');

        if ($env=='%') $env='*';
        $Runs = $em->getRepository("AriiReportBundle:RUN")->findExecutionsByAppAndDay($start,$end,$application,$env,$class);
        
        $xml = "<?xml version='1.0' encoding='iso-8859-1'?><rows>";
        $xml .= '<head><afterInit><call command="clearAll"/></afterInit></head>';
        foreach ($Runs as $run) {
            if ($run['status']=='SUCCESS') { // prise en compte
                $color='#ccebc5';
            }
            elseif (($run['status']=='FAILURE') || ($run['status']=='TERMINATED')) { // prise en compte
                $color='#fbb4ae';
            }
            else {
                $color='#ffffcc';
            }
            $xml .= '<row style="background-color: '.$color.';">';
            $xml .= '<cell>'.$run['job_name'].'</cell>';
            $xml .= '<cell>'.$run['job_type'].'</cell>';
            $xml .= '<cell>'.$run['class'].'</cell>';            
            $xml .= '<cell>'.$run['start_time']->format('Y-m-d H:i:s').'</cell>';
            // lisibilité
            if ($run['end_time']) {
                if ($run['end_time']->format('Y-m-d')!=$run['start_time']->format('Y-m-d'))
                    $xml .= '<cell>'.$run['end_time']->format('Y-m-d H:i:s').'</cell>';
                else
                    $xml .= '<cell>'.$run['end_time']->format('H:i:s').'</cell>';
            }
            else {
             $xml .= '<cell/>';   
            }            
            $xml .= '<cell>'.$run['status'].'</cell>';            
            $xml .= '<cell>'.$run['alarm'].'</cell>';
            $xml .= '<cell>'.($run['alarm_time']?$run['alarm_time']->format('Y-m-d H:i:s'):'').'</cell>';
            $xml .= '<cell>'.$run['ack'].'</cell>';
            if (isset($run['ack_time']) and ($run['ack_time']!='') and is_object($run['ack_time']))
                $xml .= '<cell>'.$run['ack_time']->format('Y-m-d h:i:s').'</cell>';
            else 
                $xml .= '<cell/>';
            $xml .= '</row>';
        }
        $xml .= '</rows>';
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');        
        $response->setContent( $xml );
        return $response;            
    }
    
}

