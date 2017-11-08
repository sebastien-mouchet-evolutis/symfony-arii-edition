<?php

namespace Arii\ReportBundle\Controller\Dashboard;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class AppsController extends Controller
{
    
    public function indexAction()
    {          
        $Filters = $this->container->get('report.filter')->getRequestFilter();
        return $this->render('AriiReportBundle:Dashboard\Apps:index.html.twig', $Filters );
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
    
    // Nombre de jobs par applications
    public function jobsAction()
    {
        $Filters = $this->container->get('report.filter')->getRequestFilter();

        $em = $this->getDoctrine()->getManager();
        $Jobs = $em->getRepository("AriiReportBundle:JOBDay")->findApps($Filters['start'],$Filters['end'],$Filters['env'],$Filters['tag'],false);

        $portal = $this->container->get('arii_core.portal');
        $App = $portal->getApplications();

        $xml = "<?xml version='1.0' encoding='iso-8859-1'?><data>";
        $nb=0;
        
        foreach ($Jobs as $job) {
            $a = $job['app'];
            if ($a=='') continue;
            if (isset($App[$a])) {
                $title=$App[$a]['title'];
                if ($App[$a]['active']==0)
                    $job['jobs']=0;
            }
            else 
                $title='['.$a.']';
            
            if ($job['jobs']>0) {
                $xml .= '<item id="'.$a.'">';
                $xml .= '<application>'.$title.'</application>';
                $xml .= '<jobs>'.$job['jobs'].'</jobs>';
                $xml .= '<created>'.$job['created'].'</created>';
                $xml .= '<deleted>'.$job['deleted'].'</deleted>';
                $xml .= '</item>';
                $nb++;
            }
            if ($nb>=$Filters['limit']) break;
        }
        $xml .= '</data>';
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');        
        $response->setContent( $xml );
        return $response;            
    }

    // Nombre d'exécution par applications
    public function runsAction ()
    {
        $Filters = $this->container->get('report.filter')->getRequestFilter();
        
        $em = $this->getDoctrine()->getManager();
        $Runs = $em->getRepository("AriiReportBundle:RUNMonth")->findApps($Filters['year'],$Filters['month'],$Filters['env'],$Filters['tag']);
        
        $portal = $this->container->get('arii_core.portal');
        $App = $portal->getApplications();

        $xml = "<?xml version='1.0' encoding='iso-8859-1'?><data>";
        $nb=0;
        foreach ($Runs as $run) {
            $a = $run['app'];
            if ($a=='') continue;
            if (isset($App[$a])) {
                $title=$App[$a]['title'];
                if ($App[$a]['active']==0)
                    $run['runs']=0;
            }
            else 
                $title='['.$a.']';
            
            if ($run['runs']>0) {
                $xml .= '<item id="'.$a.'">';
                $xml .= '<application>'.$title.'</application>';
                $xml .= '<runs>'.$run['runs'].'</runs>';
                $xml .= '</item>';
                $nb++;
            }
            if ($nb>=$Filters['limit']) break;
        }
        $xml .= '</data>';
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');        
        $response->setContent( $xml );
        return $response;            
    }

    // Nombre d'exécution par applications
    public function alertsAction ()
    {
        $Filters = $this->container->get('report.filter')->getRequestFilter();
        
        $em = $this->getDoctrine()->getManager();
        $Runs = $em->getRepository("AriiReportBundle:RUNMonth")->findApps($Filters['year'],$Filters['month'],$Filters['env'],$Filters['tag']);
        
        $portal = $this->container->get('arii_core.portal');
        $App = $portal->getApplications();

        $xml = "<?xml version='1.0' encoding='iso-8859-1'?><data>";
        $nb=0;
        foreach ($Runs as $run) {
            $a = $run['app'];
            if ($a=='') continue;
            if (isset($App[$a])) {
                $title=$App[$a]['title'];
                if ($App[$a]['active']==0)
                    $run['runs']=0;
            }
            else 
                $title='['.$a.']';
            
            if ($run['runs']>0) {
                $xml .= '<item id="'.$a.'">';
                $xml .= '<application>'.$title.'</application>';
                $xml .= '<alarms>'.$run['alarms'].'</alarms>';
                $xml .= '</item>';
                $nb++;
            }
            if ($nb>=$Filters['limit']) break;
        }
        $xml .= '</data>';
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');        
        $response->setContent( $xml );
        return $response;            
    }
    
}

