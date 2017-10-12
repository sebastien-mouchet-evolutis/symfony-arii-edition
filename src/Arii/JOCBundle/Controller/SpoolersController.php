<?php

namespace Arii\JOCBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class SpoolersController extends Controller
{
    protected $ColorStatus = array (
            'RUNNING' => '#ccebc5',
            'PAUSED' => '#ffffcc',
            'UNKNOWN' => '#fbb4ae',
            'LOST' => '#FF0000'
          );

    public function indexAction()   
    {
        return $this->render('AriiJOCBundle:Spoolers:index.html.twig' );
    }

    public function formAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        return $this->render('AriiJOCBundle:Spoolers:form.json.twig',array(), $response );
    }

    public function menuAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render("AriiJOCBundle:Spoolers:menu.xml.twig", array(), $response);
    }

    public function toolbarAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render("AriiJOCBundle:Spoolers:grid_toolbar.xml.twig", array(), $response);
    }

    public function chartsAction()   
    {
        $session = $this->container->get('arii_core.session');
        
        // Une date peut etre passe en get
        $request = Request::createFromGlobals();
        if ($request->query->get( 'ref_date' )) {
            $ref_date   = $request->query->get( 'ref_date' );
            $session->setRefDate( $ref_date );
        } else {
            $ref_date   = $session->getRefDate();
        }
        $Timeline['ref_date'] = $ref_date;
        
        $past   = $session->getRefPast();
        $future = $session->getRefFuture();
        
        // On prend 24 fuseaux entre maintenant et le passe
        // on trouve le step en minute
        $step = ($future-$past)*2.5; // heure * 60 minutes / 24 fuseaux
        $Timeline['step'] = $step;
    
        // on recalcule la date courante moins la plage de passé 
        $year = substr($ref_date, 0, 4);
        $month = substr($ref_date, 5, 2);
        $day = substr($ref_date, 8, 2);
        
        $start = substr($session->getPast(),11,2);
        $Timeline['start'] = (60/$step)*$start;
        $Timeline['js_date'] = $year.','.($month - 1).','.$day;
        
        $refresh = $session->GetRefresh();
        
        // Liste des spoolers pour cette plage
        
        $dhtmlx = $this->container->get('arii_core.dhtmlx');
        $data = $dhtmlx->Connector('data');
        
        $sql = $this->container->get('arii_core.sql');
        $Fields = array (
            'spooler'    => 'SPOOLER_ID',
            'start_time' => 'START_TIME',
            'end_time'   => 'END_TIME' );

        $qry = 'SELECT DISTINCT SPOOLER_ID 
                FROM SCHEDULER_HISTORY
                where '.$sql->History($Fields).'
                ORDER BY SPOOLER_ID';
        
        $SPOOLERS = array();
        $res = $data->sql->query( $qry );
        while ($line = $data->sql->get_next($res)) {
            array_push( $SPOOLERS,$line['SPOOLER_ID'] ); 
        }
        $Timeline['spoolers'] = $SPOOLERS;
        
        
        return $this->render('AriiJOCBundle:Spoolers:charts.html.twig', array('refresh' => $refresh, 'Timeline' => $Timeline ) );
    }

    public function pieAction($history_max=0,$ordered = 0, $only_warning = 1) {        

        $request = Request::createFromGlobals();

        $state = $this->container->get('arii_joc.state');
        $Spoolers = $state->Spoolers();
        $State = array('RUNNING' => 0,'PAUSED'=>0,'LOST'=>0);
        foreach ($Spoolers as $k=>$spooler) {
            $state = $spooler['STATUS'];
            if (isset($State[$state])) 
                $State[$state]++;
            else 
                $State[$state]=1;
        }
        
        $pie = '<data>';
        // ksort($State);
        foreach (array_keys($State) as $k) {
            if (isset($this->ColorStatus[$k])) 
                $color = $this->ColorStatus[$k];
            else
                $color = 'black';
            $pie .= '<item id="'.$k.'"><STATUS>'.$k.'</STATUS><JOBS>'.$State[$k].'</JOBS><COLOR>'.$color.'</COLOR></item>';
        }
        $pie .= '</data>';
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        $response->setContent( $pie );
        return $response;
    }

    public function timelineAction()
    {
        $dhtmlx = $this->container->get('arii_core.dhtmlx');
        $data = $dhtmlx->Connector('scheduler');

        $session =  $this->container->get('arii_core.session'); 
        $this->ref_date  =  $session->getRefDate();

//        $options = $dhtmlx->Connector('options');

        $sql = $this->container->get('arii_core.sql');
        $Fields = array (
            'spooler'    => 'sh.SPOOLER_ID',
            'job_name'   => 'sh.JOB_NAME',
            'error'      => 'sh.ERROR',
            'start_time' => 'sh.START_TIME',
            'end_time'   => 'sh.END_TIME' );

  /*        $qry = 'SELECT distinct sh.SPOOLER_ID as label, sh.SPOOLER_ID as value
                  FROM SCHEDULER_HISTORY sh
                  where not(sh.JOB_NAME="(Spooler)") and '.$sql->History($Fields).' order by sh.SPOOLER_ID';  
          $options->render_sql($qry,"section_id","value,label");
 */          
          $qry = 'SELECT sh.ID, sh.SPOOLER_ID as section_id, sh.JOB_NAME, sh.START_TIME, sh.END_TIME, sh.ERROR, sh.EXIT_CODE, sh.CAUSE, sh.PID, "green" as color  
                  FROM SCHEDULER_HISTORY sh
                  where not(sh.JOB_NAME="(Spooler)") and '.$sql->History($Fields).' order by sh.SPOOLER_ID, sh.JOB_NAME,sh.START_TIME';  

//          $data->set_options("section_id", $options );
          $data->event->attach("beforeRender", array( $this, "color_rows") );
          $data->render_sql($qry,"ID","START_TIME,END_TIME,JOB_NAME,color,section_id");
    }
    
    function color_rows($row){
        if ($row->get_value('END_TIME')=='') {
            $row->set_value("color", 'orange');
            $row->set_value("END_TIME", $this->ref_date );
        }
        elseif ($row->get_value('ERROR')>0) {
            $row->set_value("color", 'red');
        }
    }    
    
    public function timeline_xmlAction()
    {
        $dhtmlx = $this->container->get('arii_core.dhtmlx');
        $data = $dhtmlx->Connector('scheduler');

       $session =  $this->container->get('arii_core.session'); 
        $this->ref_date  =  $session->get('ref_date');

        $sql = $this->container->get('arii_core.sql');
        
        $Fields = array (
            'spooler'    => 'soh.SPOOLER_ID',
            'job_chain'   => 'soh.JOB_CHAIN',
            'error'      => 'sosh.ERROR',
            'start_time' => 'soh.START_TIME',
            'end_time'   => 'soh.END_TIME' );

          $qry = 'SELECT soh.HISTORY_ID as ID, soh.SPOOLER_ID as section_id, soh.JOB_CHAIN, soh.START_TIME, soh.END_TIME, sosh.ERROR, "green" as fill  
                  FROM SCHEDULER_ORDER_HISTORY soh
                  left join SCHEDULER_ORDER_STEP_HISTORY sosh
                  on soh.HISTORY_ID=sosh.HISTORY_ID
                  where '.$sql->Filter($Fields).' order by soh.SPOOLER_ID, soh.JOB_CHAIN,soh.START_TIME';  

          $data->event->attach("beforeRender", array( $this, "color_rows") );
          $data->render_sql($qry,"ID","START_TIME,END_TIME,JOB_CHAIN,fill,section_id");
    }

    public function gridAction()
    {
        $request = Request::createFromGlobals();

        $State = $this->container->get('arii_joc.state');
        $Spoolers = $State->Spoolers();

        $list = '<?xml version="1.0" encoding="UTF-8"?>';
        $list .= "<rows>\n";
        $list .= '<head>
            <afterInit>
                <call command="clearAll"/>
            </afterInit>
        </head>';
        foreach ($Spoolers as $k=>$line) {
            // on cacule la couleur
            $status = $line['STATUS'];
            if (isset($this->ColorStatus[$status]))
                $color=$this->ColorStatus[$status];
            else 
                $color='white';
            $list .= '<row id="'.$line['DBID'].'" bgColor="'.$color.'">';
            $list .= '<cell>'.$line['SPOOLER'].'</cell>';
            $list .= '<cell>'.$status.'</cell>';
            $list .= '<cell>'.$line['VERSION'].'</cell>';
            $list .= '<cell>'.$line['HOST'].'</cell>';
            $list .= '<cell>'.$line['IP_ADDRESS'].'</cell>';
            $list .= '<cell>'.$line['TCP_PORT'].'</cell>';
            $list .= '<cell>'.$line['TIME'].'</cell>';
            $list .= '<cell>'.$line['LAST_UPDATE'].'</cell>';
            $list .= '<cell>'.$line['UPDATED'].'</cell>';
            $list .= '</row>';
            
            // si le temps est trop long, on tente nue connexion à la volée pour le prochain update
/*            if ($line['LAST_UPDATE']>30) {
                $focus = $this->container->get('arii_joc.focus2');        
                $focus->get($line['IP_ADDRESS'],$line['TCP_PORT'],'orders,job_chain_orders,job_orders,jobs,job_chains,schedules,remote_schedulers,payload,job_params',"WEB",-1);
            }
*/
        }
        $list .= "</rows>\n";
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        $response->setContent( $list );
        return $response;
    }
    
    public function barJobsAction()
    {
        $db = $this->container->get('arii_core.db');
        $data = $db->Connector('data');
        
        $sql = $this->container->get('arii_core.sql');
        $Fields = array (
            '{spooler}'    => 's.NAME' );

        $qry = $sql->Select(array('s.NAME as SPOOLER','j.STATE','count(j.ID) as NB'))
                .$sql->From(array('JOC_JOBS j'))
                .$sql->LeftJoin('JOC_SPOOLERS s',array('j.SPOOLER_ID','s.ID'))
                .$sql->Where($Fields)
                .$sql->GroupBy(array('s.NAME','j.STATE'))
                .$sql->OrderBy(array('s.NAME'));

        $res = $data->sql->query( $qry );
        while ($line = $data->sql->get_next($res)) {
                $spooler = $line['SPOOLER'];
                $state = $line['STATE'];
                $Bar[$spooler][$state] = $line['NB'];
        }
        $bar = "<?xml version='1.0' encoding='utf-8' ?>";
        $bar .= '<data>';
        foreach ($Bar as $k=>$States) {
            $bar .= '<item id="'.$k.'"><SPOOLER>'.$k.'</SPOOLER>';
            foreach (array('pending', 'running', 'stopped') as $state) {
                $bar .= "<$state>";
                if (isset($States[$state]))
                    $bar .= $States[$state];
                else
                    $bar .= '0';
                $bar .= "</$state>";
            }
            $bar .= '</item>';
        }
        $bar .= '</data>';        
        
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        $response->setContent( $bar );
        return $response;
    }
 
    public function barOrdersAction()
    {
        $db = $this->container->get('arii_core.db');
        $data = $db->Connector('data');
        
        $sql = $this->container->get('arii_core.sql');
        $Fields = array (
            '{spooler}'    => 's.NAME' );

        $qry = $sql->Select(array('s.NAME as SPOOLER','j.SUSPENDED','j.RUNNING','count(j.ID) as NB'))
                .$sql->From(array('JOC_ORDERS j'))
                .$sql->LeftJoin('JOC_SPOOLERS s',array('j.SPOOLER_ID','s.ID'))
                .$sql->Where($Fields)
                .$sql->GroupBy(array('s.NAME','j.SUSPENDED'))
                .$sql->OrderBy(array('s.NAME'));

        $res = $data->sql->query( $qry );
        while ($line = $data->sql->get_next($res)) {
                $spooler = $line['SPOOLER'];
                if ($spooler=='') continue;
                if (!isset($Bar[$spooler]['suspended']))
                    $Bar[$spooler]['suspended'] = 0;
                if (!isset($Bar[$spooler]['running']))
                    $Bar[$spooler]['running'] = 0;
                if (!isset($Bar[$spooler]['pending']))
                    $Bar[$spooler]['pending'] = 0;
                
                if (($line['SUSPENDED']>0) and ($line['RUNNING']>0)) {
                    $Bar[$spooler]['suspended'] += $line['NB'];
                    $Bar[$spooler]['running'] += $line['NB'];
                }
                else if ($line['SUSPENDED']>0) {
                    $Bar[$spooler]['suspended'] += $line['NB'];
                }
                else if ($line['RUNNING']>0) {
                    $Bar[$spooler]['running'] += $line['NB'];
                }
                else {
                    $Bar[$spooler]['pending'] += $line['NB'];
                }                        
        }
        $bar = "<?xml version='1.0' encoding='utf-8' ?>";
        $bar .= '<data>';
        foreach ($Bar as $k=>$States) {
            $bar .= '<item id="'.$k.'"><SPOOLER>'.$k.'</SPOOLER>';
            foreach (array('pending', 'running', 'suspended') as $state) {
                $bar .= "<$state>";
                if (isset($States[$state]))
                    $bar .= $States[$state];
                else
                    $bar .= '0';
                $bar .= "</$state>";
            }
            $bar .= '</item>';
        }
        $bar .= '</data>';        
        
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        $response->setContent( $bar );
        return $response;
    }

}
