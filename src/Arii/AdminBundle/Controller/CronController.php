<?php

namespace Arii\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class CronController extends Controller
{
    
    // On passe les modules dans l'index pour construire la page
    public function indexAction()
    {   
        return $this->render('AriiAdminBundle:Cron:index.html.twig');
    }
    
   public function toolbarAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render("AriiAdminBundle:Cron:toolbar.xml.twig",array(), $response );
    }

   public function menuAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render("AriiAdminBundle:Cron:menu.xml.twig",array(), $response );
    }
    
    public function formAction()
    {
        $dhtmlx = $this->container->get('arii_core.db');
        $form = $dhtmlx->Connector('form');
        
        $form->render_table("ARII_CRON","id","id,NAME,TITLE,URL,DESCRIPTION,NEXT_RUN,MINUTES,HOURS,WEEK_DAYS,MONTH_DAYS,MONTHS,YEARS,CHANGE_TIME,CHANGE_USER,STATUS,ACTIVE");
    }
            
    public function listAction()
    {   
        $db = $this->container->get('arii_core.db');
        $data = $db->Connector('data');

        $sql = $this->container->get('arii_core.sql');        
        $qry = $sql->Select(array('ID','NAME','NEXT_RUN','STATUS','ACTIVE'))
                .$sql->From(array('ARII_CRON'))
                .$sql->OrderBy(array('NEXT_RUN desc'));  
        
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        $list = '<?xml version="1.0" encoding="UTF-8"?>';
        $list .= "<rows>\n";
        $list .= '<head>
            <afterInit>
                <call command="clearAll"/>
            </afterInit>
        </head>';
        $res = $data->sql->query( $qry );
        while ($line = $data->sql->get_next($res)) {
            $status = $line['STATUS'];
            switch ($status) {
                case 'SUCCESS': 
                    $bgcolor="#ccebc5";
                    break;
                case 'ERROR': 
                    $bgcolor="red";
                    break;
                default:
                    $bgcolor="#ffffcc";
                    break;    
            }
            $list .= '<row id="'.$line['ID'].'" style="background-color: '.$bgcolor.'">';
            if ($line['ACTIVE']>0)
                $list .= '<cell>'.$line['NAME'].'</cell>';  
            else
                $list .= '<cell><![CDATA[<strike>'.$line['NAME'].'</strike>]]></cell>';  
            $list .= '<cell>'.$line['NEXT_RUN'].'</cell>';  
            $list .= '</row>';
        }        
        $list .= "</rows>\n";
        $response->setContent( $list );
        return $response;        
    }

    public function historyAction()
    {   
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        
        $db = $this->container->get('arii_core.db');
        $data = $db->Connector('data');

        $sql = $this->container->get('arii_core.sql');        
        $qry = $sql->Select(array('ID','DONE','STATUS','DURATION','MESSAGE'))
                .$sql->From(array('ARII_CRON_HISTORY'))
                .$sql->Where(array('CRON_ID'=>$id))
                .$sql->OrderBy(array('ID desc')); 
        
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        $list = '<?xml version="1.0" encoding="UTF-8"?>';
        $list .= "<rows>\n";
        $list .= '<head>
            <afterInit>
                <call command="clearAll"/>
            </afterInit>
        </head>';
        $res = $data->sql->query( $qry );
        while ($line = $data->sql->get_next($res)) {
            $status = $line['STATUS'];
            switch ($status) {
                case 'SUCCESS': 
                    $bgcolor="#ccebc5";
                    break;
                case 'ERROR': 
                    $bgcolor="red";
                    break;
                default:
                    $bgcolor="#ffffcc";
                    break;                    
            }
            $list .= '<row id="'.$line['ID'].'" style="background-color: '.$bgcolor.'">';
            $list .= '<cell>'.$line['DONE'].'</cell>';  
            $list .= '<cell>'.$line['STATUS'].'</cell>';  
            $list .= '<cell>'.$line['DURATION'].'</cell>';  
            $list .= '<cell>'.$line['MESSAGE'].'</cell>';  
            $list .= '</row>';
        }        
        $list .= "</rows>\n";
        $response->setContent( $list );
        return $response;
        
    }

    public function deleteAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
                
        $cron = $this->getDoctrine()->getRepository("AriiCoreBundle:Cron")->find($id);
        
        if ($cron) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cron);
            $em->flush();
        }
        else {
            return new Response("$id ?");   
        }
        
        return new Response("success");        
    }
    
    public function saveAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        
        $cron = new \Arii\CoreBundle\Entity\Cron();
        if ($id != "")
        {
            $cron = $this->getDoctrine()->getRepository("AriiCoreBundle:Cron")->find($id);
        }

        $schedule = implode(' ',array(
        $request->get('MINUTES'),
        $request->get('HOURS'),
        $request->get('MONTH_DAYS'),
        $request->get('MONTHS'),
        $request->get('WEEK_DAYS'),
        $request->get('YEARS') ) );

        $next = \Cron\CronExpression::factory($schedule);
        $next_run = $next->getNextRunDate()->format('Y-m-d H:i:s');

        $cron->setName($request->get('NAME'));
        $cron->setUrl($request->get('URL'));
        $cron->setDescription($request->get('DESCRIPTION'));
        $cron->setTitle($request->get('TITLE'));
        $cron->setMinutes($request->get('MINUTES'));
        $cron->setHours($request->get('HOURS'));
        $cron->setWeekDays($request->get('WEEK_DAYS'));
        $cron->setMonthDays($request->get('MONTH_DAYS'));
        $cron->setMonths($request->get('MONTHS'));
        $cron->setYears($request->get('YEARS'));
        $cron->setNextRun(new \DateTime($next_run));
        $cron->setStatus($request->get('STATUS'));
        $cron->setActive($request->get('ACTIVE'));
        $cron->setChangeTime(new \DateTime());
        $cron->setChangeUser($request->get('CHANGE_USER'));
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($cron);
        $em->flush();
        
        return new Response($next_run);
    }
    
}
