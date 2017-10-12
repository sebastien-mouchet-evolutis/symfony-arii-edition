<?php

namespace Arii\MFTBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class SchedulesController extends Controller
{
    
    public function indexAction()
    {       
        return $this->render('AriiMFTBundle:Schedules:index.html.twig' );
    }
 
   public function toolbarAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render("AriiMFTBundle:Schedules:toolbar.xml.twig",array(), $response );
    }

    public function formAction()
    {
        $dhtmlx = $this->container->get('arii_core.db');
        $form = $dhtmlx->Connector('form');
        
        $form->render_table("MFT_SCHEDULES","id","id,NAME,TITLE,DESCRIPTION,NEXT_RUN,MINUTES,HOURS,WEEK_DAYS,MONTH_DAYS,MONTHS,YEARS,CHANGE_TIME,CHANGE_USER");
    }

    public function selectAction()
    {
        $sql = $this->container->get("arii_core.sql");
        $qry = $sql->Select(array("ID","NAME"))
               .$sql->From(array("MFT_SCHEDULES"))
               .$sql->OrderBy(array("NAME")); 
        
        $db = $this->container->get('arii_core.db');
        $select = $db->Connector('select');       
        $select->render_sql($qry,"ID","ID,NAME");
    }
    
    public function listAction()
    {   
        $db = $this->container->get('arii_core.db');
        $data = $db->Connector('data');

        $sql = $this->container->get('arii_core.sql');        
        $qry = $sql->Select(array('ID','NAME','NEXT_RUN'))
                .$sql->From(array('MFT_SCHEDULES'))
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
        
        $datetime = new \DateTime(); 
        $now = $datetime->format('Y-m-d H:i:s'); 
        
        require_once('../vendor/autoload.php');
       
        $em = $this->getDoctrine()->getManager();
        while ($line = $data->sql->get_next($res)) {
            $id = $line['ID'];
            
            // nouveau calcul
            if ($line['NEXT_RUN']<$now) {
                $Task = $this->getDoctrine()->getRepository("AriiMFTBundle:Schedules")->find($id);
                $schedule = implode(' ',array(
                    $Task->getMinutes(),
                    $Task->getHours(),
                    $Task->getMonthDays(),
                    $Task->getMonths(),
                    $Task->getWeekDays(),
                    $Task->getYears() ) );
                    $cron = \Cron\CronExpression::factory($schedule);
                    $next_run = $cron->getNextRunDate()->format('Y-m-d H:i:s');
                    $Task->setNextRun(new \DateTime($next_run));  
                    $em->persist($Task);
            }            
            else {
                $next_run = $line['NEXT_RUN'];
            }
            $list .= '<row id="'.$id.'">';
            $list .= '<cell>'.$line['NAME'].'</cell>';  
            $list .= '<cell>'.$next_run.'</cell>';                          
            $list .= '</row>';
        }    
        $em->flush();
       
        $list .= "</rows>\n";
        $response->setContent( $list );
        return $response;        
    }

    public function transfersAction()
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
                
        $cron = $this->getDoctrine()->getRepository("AriiMFTBundle:Schedules")->find($id);
        
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
        
        $cron = new \Arii\MFTBundle\Entity\Schedules();
        if ($id != "")
        {
            $cron = $this->getDoctrine()->getRepository("AriiMFTBundle:Schedules")->find($id);
        }
        
        $cron->setName($request->get('NAME'));
        $cron->setDescription($request->get('DESCRIPTION'));
        $cron->setTitle($request->get('TITLE'));
        $cron->setMinutes($request->get('MINUTES'));
        $cron->setHours($request->get('HOURS'));
        $cron->setWeekDays($request->get('WEEK_DAYS'));
        $cron->setMonthDays($request->get('MONTH_DAYS'));
        $cron->setMonths($request->get('MONTHS'));
        $cron->setYears($request->get('YEARS'));        
        $cron->setNextRun(new \DateTime($request->get('NEXT_RUN')));
        
        $cron->setChangeTime(new \DateTime());
        $cron->setChangeUser($request->get('CHANGE_USER'));
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($cron);
        $em->flush();
        
        return new Response("success");
    }

}
