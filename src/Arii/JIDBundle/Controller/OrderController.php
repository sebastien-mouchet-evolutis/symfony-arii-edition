<?php

namespace Arii\JIDBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller {

    
/* ==================================================================================
 * PASSAGE EN DOCTRINE
 * ==================================================================================
 */
        
    public function logAction($id=-1,$db='')
    {
        if ($id<0) {
            $request = Request::createFromGlobals();
            $id = $request->get('id');
        }
        
        $JID = $this->container->get('arii.JID');
        $log = $JID->getOrderLog($id,$db);
        if (!$log) {
            $sos = $this->container->get('arii_jid.sos');
            // $log = $sos->Log($spooler, '/show_log?order='.$order.'&history_id='.$id);
        }
        
        $response = new Response();
        $response->setContent($log);
        return $response;
    }
    
    public function historyAction($spooler='',$job_chain='',$order_id='', $db='' )
    {
        $request = Request::createFromGlobals();
        if ($request->get('spooler')!='')
            $spooler = $request->get('spooler');
        if ($request->get('job_chain')!='')
            $job_chain = $request->get('job_chain');
        if ($request->get('order')!='')
            $order_id = $request->get('order');
        
        $JID = $this->container->get('arii.JID');
        $History = $JID->getOrderHistory($spooler, $job_chain, $order_id, $db );

        // Grid XML
        $Render = $this->container->get('arii_core.Render');
        return $Render->grid($History,$fields='SPOOLER_ID,JOB_CHAIN,START_TIME,END_TIME,STATE',$color='color');
    }        
    
    /* ANCIENNES FONCTIONS */
    public function indexAction()
    {
       $request = Request::createFromGlobals();
        $id = $request->query->get( 'id' );

        $dhtmlx = $this->container->get('arii_core.dhtmlx');
        $data = $dhtmlx->Connector('data');
        $sql = $this->container->get('arii_core.sql');
        $qry = $sql->Select(array('SPOOLER_ID','JOB_CHAIN','ORDER_ID'))
                .$sql->From(array('SCHEDULER_ORDER_HISTORY'))
                .$sql->Where(array('HISTORY_ID'=>$id));
        $res = $data->sql->query( $qry );
        $Infos = $data->sql->get_next($res);

        return $this->render('AriiJIDBundle:Order:index.html.twig',
                array('id' => $id, 'spooler' => $Infos['SPOOLER_ID'], 'chain' => $Infos['JOB_CHAIN'], 'order' => $Infos['ORDER_ID'] ) );
    }

    public function historyByIdAction($db)
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        
        $dhtmlx = $this->container->get('arii_core.dhtmlx');
        $dhtmlx->setDB($db);

        $sql = $this->container->get('arii_core.sql');

        // Recherche des informations
        $qry = $sql->Select(array('SPOOLER_ID','JOB_CHAIN','ORDER_ID'))
                .$sql->From(array('SCHEDULER_ORDER_HISTORY'))
                .$sql->Where(array('HISTORY_ID' => $id));

        $data = $dhtmlx->Connector('data');
        $res = $data->sql->query( $qry );
        if ($line = $data->sql->get_next($res)) {
            $spooler = $line['SPOOLER_ID'];
            $job_chain = $line['JOB_CHAIN'];
            $order = $line['ORDER_ID'];
        }
        else {
            exit();
        }
        
        return $this->historyByNameAction($db,$spooler,$job_chain,$order);
    }

    public function historyPageAction()
    {
       $request = Request::createFromGlobals();
        $id = $request->query->get( 'id' );

        $dhtmlx = $this->container->get('arii_core.dhtmlx');
        $data = $dhtmlx->Connector('data');
        $sql = $this->container->get('arii_core.sql');
        $qry = $sql->Select(array('SPOOLER_ID','JOB_CHAIN','ORDER_ID'))
                .$sql->From(array('SCHEDULER_ORDER_HISTORY'))
                .$sql->Where(array('HISTORY_ID'=>$id));
        $res = $data->sql->query( $qry );
        $Infos = $data->sql->get_next($res);

        return $this->render('AriiJIDBundle:Order:history.html.twig',
                array('id' => $id, 'spooler' => $Infos['SPOOLER_ID'], 'chain' => $Infos['JOB_CHAIN'], 'order' => $Infos['ORDER_ID'] ) );
    }

    public function toolbar_startAction() {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render("AriiJIDBundle:_Order:toolbar_start.xml.twig", array(), $response);
    }

    // version synthetique
    public function stepsAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');

        $dhtmlx = $this->container->get('arii_core.dhtmlx');
        $sql = $this->container->get('arii_core.sql');
        $date = $this->container->get('arii_core.date');

        $qry = $sql->Select(array(  'soh.SPOOLER_ID','soh.JOB_CHAIN',
                                    'sosh.HISTORY_ID','sosh.STEP','sosh.TASK_ID','sosh.STATE','sosh.START_TIME','sosh.END_TIME','sosh.ERROR','sosh.ERROR_CODE','sosh.ERROR_TEXT'))
                .$sql->From(array('SCHEDULER_ORDER_STEP_HISTORY sosh'))
                .$sql->LeftJoin('SCHEDULER_ORDER_HISTORY soh',array('sosh.HISTORY_ID','soh.HISTORY_ID'))
                .$sql->Where(array('sosh.HISTORY_ID' => $id));

        $data = $dhtmlx->Connector('data');

        $res = $data->sql->query( $qry );
        $State = array();
        while ($line = $data->sql->get_next($res)) {
            $scheduler_id = $line['SPOOLER_ID'];
            $job_chain = $line['JOB_CHAIN'];
            $chain_id = $scheduler_id.'/'.$line['JOB_CHAIN'];
            $state_id = $chain_id.'/'.$line['STATE'];
            $State[$state_id] = $line;
            $State[$state_id]['ACTION'] = '';
        }

        // Etat des noeuds
        $qry =  $sql->Select(array('SPOOLER_ID','JOB_CHAIN','ORDER_STATE','ACTION'))
                .$sql->From(array('SCHEDULER_JOB_CHAIN_NODES'))
                .$sql->Where(array('SPOOLER_ID' => $scheduler_id, 'JOB_CHAIN' => $job_chain ));

        $res = $data->sql->query( $qry );
        while ($line = $data->sql->get_next($res)) {
            $step_id = $chain_id.'/'.$line['ORDER_STATE'];
            // Si non defini
            if (!isset($State[$step_id])) {
                $State[$step_id]['STATE']= $line['ORDER_STATE'];
                $State[$step_id]['TASK_ID']= $line['ORDER_STATE'];
                $State[$step_id]['STEP'] = '?';
            }
            $State[$step_id]['ACTION']= $line['ACTION'];
        }

        $res = $data->sql->query( $qry );
        while ($line = $data->sql->get_next($res)) {
        }

        $xml = "<?xml version='1.0' encoding='utf-8' ?>";
        $xml .= "<rows>";
        $xml .= '<head>
            <afterInit>
                <call command="clearAll"/>
            </afterInit>
        </head>';
        foreach ($State as $state_id=>$line) {
            $s = $line['STATE'];

            if ($line['ACTION']=='stop') {
                $color = "red";
                $status = "STOPPED";
            }
            elseif ($line['ACTION']=='next_state') {
                $color = "orange";
                $status = "SKIPPED";
            }
            elseif ($line['END_TIME']=='') {
                $color = "#ffffcc";
                $status = "RUNNING";
            }
            elseif ($line['ERROR']>0) {
                $color = "#fbb4ae";
                $status = "FAILURE";
            }
            else {
                $color = "#ccebc5";
                $status = "SUCCESS";
            }
            if (isset($line['ERROR_CODE']))
                $line['ERROR_CODE'] = substr($line['ERROR_CODE'],15);
            else
                $line['ERROR_CODE'] = '';
            $xml .= "<row id='".$line['TASK_ID']."' bgColor='$color'>";
            $xml .= "<cell>".$line['STEP']."</cell>";
            $xml .= "<cell><![CDATA[".$line['STATE']."]]></cell>";
            $xml .= "<cell><![CDATA[".$status."]]></cell>";
            if (isset($line['START_TIME'])) {
                $line['START_TIME'] = $date->ShortDate( $date->Date2Local( $line['START_TIME'],  $line['SPOOLER_ID'] ) );
                $xml .= "<cell><![CDATA[".$line['START_TIME']."]]></cell>";
                $xml .= "<cell><![CDATA[".$line['END_TIME']."]]></cell>";
            }
            else {
                $xml .= "<cell/><cell/>";
            }
            if (isset($line['ERROR'])) {
                $xml .= "<cell><![CDATA[".$line['ERROR']."]]></cell><cell><![CDATA[]]></cell>";
                $xml .= "<cell><![CDATA[".$line['ERROR_CODE']."]]></cell>";
                $xml .= "<cell><![CDATA[".$line['ERROR_TEXT']."]]></cell>";
                $xml .= "<cell/><cell/><cell/>";
            }
            $xml .= "</row>";
        }
        $xml .= "</rows>";

        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        $response->setContent( $xml );
        return $response;
    }

    // version DHTMLX
    public function steps2Action()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        $sql = $this->container->get('arii_core.sql');
        $qry = $sql->Select(array('soh.SPOOLER_ID','sosh.HISTORY_ID','sosh.STEP','sosh.TASK_ID','sosh.STATE','sosh.START_TIME','sosh.END_TIME','sosh.ERROR','sosh.ERROR_CODE','sosh.ERROR_TEXT'))
                .$sql->From(array('SCHEDULER_ORDER_STEP_HISTORY sosh'))
                .$sql->LeftJoin('SCHEDULER_ORDER_HISTORY soh',array('sosh.HISTORY_ID','soh.HISTORY_ID'))
                .$sql->Where(array('sosh.HISTORY_ID' => $id));

        $dhtmlx = $this->container->get('arii_core.dhtmlx');
        $data = $dhtmlx->Connector('grid');
        $data->event->attach("beforeRender",array($this,"steps_render"));
        $data->render_sql($qry,'TASK_ID','STEP,STATE,START_TIME,END_TIME,ERROR,ERROR_CODE,ERROR_TEXT');
    }

    function steps_render ($data){
        $svcdate = $this->container->get('arii_core.date');
        $data->set_value('START_TIME',
                $svcdate->ShortDate( $svcdate->Date2Local( $data->get_value('START_TIME'), $data->get_value('SPOOLER_ID') ) ) );
        if ($data->get_value('END_TIME')=='') {
            $data->set_row_color("#ffffcc");
        }
        elseif ($data->get_value('ERROR')>0) {
            $data->set_row_color("#fbb4ae");
        }
        else {
            $data->set_row_color("#ccebc5");
        }
        $data->set_value('ERROR_CODE',substr($data->get_value('ERROR_CODE'),15));
    }

    function grid_render ($data){
        if ($data->get_value('ERROR')==0) {
            $data->set_row_color("#ccebc5");
        }
        else {
            $data->set_row_color("#fbb4ae");
        }
        if ($data->get_value('STATE_TEXT')!='')
            $msg = '['.$data->get_value('STATE_TEXT').']';
        else
            $msg = '';
        if ($data->get_value('ERROR_TEXT')!='')
            $err = substr($data->get_value('ERROR_TEXT'),15);
        else
            $err = '';
        $data->set_value('MESSAGE', implode(' ', array(  $err, $msg )));
    }


    public function formAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        $sql = $this->container->get('arii_core.sql');
        $qry = $sql->Select(array('HISTORY_ID','JOB_CHAIN','ORDER_ID','SPOOLER_ID','TITLE','STATE','STATE_TEXT','START_TIME','END_TIME'))
               .$sql->From(array('SCHEDULER_ORDER_HISTORY'))
               .$sql->Where(array('HISTORY_ID' => $id));
        $dhtmlx = $this->container->get('arii_core.dhtmlx');
        $data = $dhtmlx->Connector('form');
        $data->event->attach("beforeRender",array($this,"form_render"));

        // Attention, bug avec le 'form'
        $portal = $this->container->get('arii_core.portal');
        $db = $portal->getDatabase();
        if (($db['driver']=='postgres') or ($db['driver']=='postgre') or ($db['driver']=='pdo_pgsql'))
            $data->render_sql($qry,'HISTORY_ID','FOLDER,HISTORY_ID,STATUS,JOB_CHAIN,ORDER_ID,SPOOLER_ID,TITLE,STATE,STATE_TEXT,START_TIME,END_TIME');
        else
            $data->render_sql($qry,'HISTORY_ID','FOLDER,HISTORY_ID,STATUS,JOB_CHAIN,ORDER_ID,SPOOLER_ID,TITLE,STATE,STATE_TEXT,START_TIME,END_TIME');
        
      }

    function form_render ($data){
        $data->set_value('FOLDER',dirname($data->get_value('JOB_CHAIN')));
        $data->set_value('NAME',basename($data->get_value('JOB_CHAIN')));
        if ($data->get_value('END_TIME')=='') {
            $data->set_value('STATUS','RUNNING');
        }
        elseif (substr($data->get_value('STATE'),0,1)=='!') {
            $data->set_value('STATUS','FATAL');
        }
        else {
            $data->set_value('STATUS','SUCCESS');
        }
    }

// rien a faire ici    
    public function paramsAction() {
        // recherche des infos
        $request = Request::createFromGlobals();
        $id = $request->get('id');

        // Recherche des informations dans la base de données
        // Nécessaire pour la securité, inutile de faire un accès direct !
        $sos = $this->container->get('arii_jid.sos');
        list($spooler_id, $order_id, $job_chain) = $sos->getOrderInfos($id);

        // On recupere les informations du job chain
        $cmd = '<show_order order="' . $order_id . '" job_chain="' . $job_chain . '" what="payload"/>';
        $result = $sos->Command($spooler_id, $cmd);

        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        $list = '<?xml version="1.0" encoding="UTF-8"?>';
        $list .= "<rows>\n";
        if (isset($result['spooler']['answer']['order']['payload']['params']['param'])) {
            if (!isset($result['spooler']['answer']['order']['payload']['params']['param'][0])) {
                $result['spooler']['answer']['order']['payload']['params']['param'][0] = $result['spooler']['answer']['order']['payload']['params']['param'];
            }
            $n = 0;
            while (isset($result['spooler']['answer']['order']['payload']['params']['param'][$n])) {
                if (isset($result['spooler']['answer']['order']['payload']['params']['param'][$n]['attr'])) {
                    $param = $result['spooler']['answer']['order']['payload']['params']['param'][$n]['attr'];
                    $list .= "<row><cell>".$param['name']."</cell><cell>".$param['value']."</cell></row>";
                }
                $n++;
            }
        }
        $list .= "</rows>\n";
        $response->setContent($list);
        return $response;
    }

    public function logDBAction($db)
    {
        # Il est preferable de connaitre le type de base plutot que le deviner
        $portal = $this->container->get('arii_core.portal');
        $db = $portal->getDatabase();

        $request = Request::createFromGlobals();
        $id = $request->get('id');

        $dhtmlx = $this->container->get('arii_core.dhtmlx');
        $sql = $this->container->get('arii_core.sql');
        $qry = $sql->Select(array('HISTORY_ID','JOB_CHAIN','ORDER_ID','SPOOLER_ID','TITLE','STATE','STATE_TEXT','START_TIME','END_TIME'))
                .$sql->From(array('SCHEDULER_ORDER_HISTORY'))
                .$sql->Where(array('HISTORY_ID' => $id));

        $data = $dhtmlx->Connector('data');
        $qry = $sql->Select(array('HISTORY_ID','LOG','END_TIME','SPOOLER_ID','ORDER_ID'))
                .$sql->From(array('SCHEDULER_ORDER_HISTORY'))
                .$sql->Where(array('HISTORY_ID' => $id));

        try {
            $res = $data->sql->query( $qry );
        } catch (Exception $exc) {
            exit();
        }
        $svcdate = $this->container->get('arii_core.date');

        $Res = array();
        while ($Infos = $data->sql->get_next($res))
        {
            $spooler = $Infos['SPOOLER_ID'];
            if($Infos['END_TIME'] == '')
            {
                $query = "select ID,ORDER_XML from SCHEDULER_ORDERS where ID='".$Infos['ORDER_ID']."'";
                $result = $data->sql->query($query);
                $order = $data->sql->get_next($result);
                $xml = simplexml_load_string($order['ORDER_XML']);
                $logs = trim((string)$xml->log);
                $log = gzdeflate($logs,9);
                $Res = explode("\n",@gzinflate($log));
            }
            else{
                switch ($db['driver']) {
                    case 'postgre':
                    case 'postgres':
                    case 'pdo_pgsql':
                        $Res = explode("\n",gzinflate (substr(pg_unescape_bytea( $Infos['LOG']), 10, -8) ));
                        break;
                    case 'oci8':
                    case 'oracle':
                    case 'pdo_oci':
                        print $Infos['LOG']->load();
                        exit();
                        $Res = explode("\n",gzinflate ( mb_substr($Infos['LOG']->load(), 10, -8) ));
                        break;
                    default:
                        $Res = explode("\n",gzinflate ( mb_substr($Infos['LOG'], 10, -8) ));
                }
            }

            $xml = '<?xml version="1.0" encoding="UTF-8"?>';
            $xml .= '<rows>';
            $xml .= '<head><afterInit><call command="clearAll"/></afterInit></head>';
            foreach ($Res as $l) {
                if ($l=='') continue;

                $date = substr($l,0,23);
                $type = rtrim(substr($l,29,8));
                $info = mb_substr($l,38);
                $task = $type;
                $error = '';
                if (mb_substr($info,0,6)==='(Task ') {
                    $type = 'Task';
                    $p = strpos($info,')');
                    $task = substr($info,6,$p-6);
                    $info = mb_substr($info,$p+2);
                }
                if (substr($info,0,10)==='SCHEDULER-') {
                    $error = substr($info,10,3);
                    $info = mb_substr($info, 14);
                }

                // coloration
                $bgcolor='';
                if ($type == '[info]') {
                    $bgcolor = ' style="background-color: lightblue;"';
                }
                elseif ($type == '[ERROR]') {
                    $bgcolor = ' style="background-color: red; color: yellow;"';
                }

                $xml .= "<row$bgcolor>";
                $logtime = $svcdate->ShortDate( $svcdate->Date2Local( $date, $spooler ));
                $xml .= '<cell>'.$logtime.'</cell>';
//                $xml .= '<cell>'.$type.'</cell>';
                $xml .= '<cell>'.$task.'</cell>';
                $xml .= '<cell><![CDATA['.htmlspecialchars($info, ENT_IGNORE, 'UTF-8').']]></cell>';
                $xml .= '<cell>'.$error.'</cell>';
//                $xml .= '<cell>'.$l.'</cell>';
                $xml .= '</row>';
            }
            $xml .= '</rows>';

            $response = new Response();
            $response->headers->set('Content-Type', 'text/xml');
            $response->setContent( $xml );
            return $response;
        }
    }

    public function chartAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->query->get('id');

        $dhtmlx = $this->container->get('arii_core.dhtmlx');
        $sql = $this->container->get('arii_core.sql');
        $data =$dhtmlx->Connector('data');
        $qry = $sql->Select(array('soh.SPOOLER_ID','soh.JOB_CHAIN','soh.ORDER_ID'))
                .$sql->From(array('SCHEDULER_ORDER_HISTORY soh'))
                .$sql->Where(array('soh.HISTORY_ID'=>$id));

        $res = $data->sql->query( $qry );
        $Infos = $data->sql->get_next($res);

        $spooler_id = $Infos['SPOOLER_ID'];
        $order_id = $Infos['ORDER_ID'];
        $job_chain = $Infos['JOB_CHAIN'];
        print $spooler_id;
        $chart = $dhtmlx->Connector('chart');
        $qry2 = $sql->Select(array('soh.HISTORY_ID','sosh.TASK_ID','soh.ORDER_ID','soh.START_TIME','soh.END_TIME','sosh.ERROR'))
                .$sql->From(array('SCHEDULER_ORDER_HISTORY soh'))
                .$sql->LeftJoin('SCHEDULER_ORDER_STEP_HISTORY sosh',array('soh.HISTORY_ID','sosh.HISTORY_ID'))
                .$sql->Where(array('soh.SPOOLER_ID' => $spooler_id,
                        'soh.ORDER_ID' => $order_id,
                        'soh.JOB_CHAIN' => $job_chain))
                .$sql->OrderBy(array('soh.START_TIME DESC'));

        $chart->event->attach("beforeRender",array( $this, "render_order_chart"));
        $chart->render_sql($qry2,'ID',"START,DURATION,COLOR");
    }

    public function render_order_chart($row)
    {
        $start = strtotime($row->get_value("START_TIME"));
	$end = $row->get_value("END_TIME");
	$row->set_value("DURATION",strtotime($end)-$start );

        $error = $row->get_value("ERROR");
        if($error == 0)
        {
            $row->set_value("COLOR", "#749400");
        }
        else
        {
            $row->set_value("COLOR", "red");
        }
        $row->set_value("START", $start);
        $row->set_value("ID", $row->get_value("HISTORY_ID"));
    }
    
    // Chaque noeud est un step
    public function graphvizAction()
    {
        // Localisation des images 
        $root = $this->get('kernel')->getRootDir();
        $images = '/bundles/ariicore/images/silk';
        $images_path =  str_replace('/',DIRECTORY_SEPARATOR,$root.'/../web'.$images);
        $images_url = $this->container->get('templating.helper.assets')->getUrl($images);        

        $request = Request::createFromGlobals();
        $id = $request->query->get( 'id' );
        if ($id==0) exit();
        $return = 0;

        $file = '.*';
        $rankdir = 'LR';
        $splines = 'polyline';
        $show_params = 'n';
        $show_events = 'n';

        if ($request->query->get( 'splines' ))
            $splines = $request->query->get( 'splines' );
        if ($request->query->get( 'show_params' ))
            $show_params = $request->query->get( 'show_params' );
        if ($show_params == 'true') {
            $show_params = 'y';
        }
        else {
            $show_params = 'n';
        }
        if ($request->query->get( 'show_events' ))
            $show_events = $request->query->get( 'show_events' );
        if ($show_events == 'true') {
            $show_events = 'y';
        }
        else {
            $show_events = 'n';
        }

        if ($request->query->get( 'output' ))
            $output = $request->query->get( 'output' );
        else {
            $output = "svg";
        }

        // on commence par recuperer le statut de l'ordre
        $dhtmlx = $this->container->get('arii_core.dhtmlx');
        $data = $dhtmlx->Connector('data');

        $SOS = $this->container->get('arii_core.sos');
        $sql = $this->container->get('arii_core.sql');
        $date = $this->container->get('arii_core.date');

        // On construit les donnees
        $qry = $sql->Select(array('soh.JOB_CHAIN','soh.ORDER_ID','soh.SPOOLER_ID','soh.TITLE as ORDER_TITLE','soh.STATE as CURRENT_STATE','soh.START_TIME as ORDER_START_TIME','soh.END_TIME as ORDER_END_TIME',
            'sosh.TASK_ID','sosh.STATE','sosh.STEP','sosh.START_TIME','sosh.END_TIME','sosh.ERROR','sosh.ERROR_TEXT'))
        .$sql->From(array('SCHEDULER_ORDER_HISTORY soh'))
        .$sql->LeftJoin('SCHEDULER_ORDER_STEP_HISTORY sosh',array('soh.HISTORY_ID','sosh.HISTORY_ID'))
        .$sql->Where(array('soh.HISTORY_ID' => $id ))
        .$sql->OrderBy(array('sosh.STEP'));

        $res = $data->sql->query( $qry );
        $Steps = $CHain = $OrderInfo = array();
        $job_chain='UNKNOWN ?';
        while ($line = $data->sql->get_next($res)) {
            $scheduler_id = $line['SPOOLER_ID'];
            $chain_id = $scheduler_id.'/'.$line['JOB_CHAIN'];

            $line['START_TIME']=$date->ShortDate( $date->Date2Local($line['START_TIME'],$scheduler_id));
            $line['END_TIME']=$date->ShortDate( $date->Date2Local($line['END_TIME'],$scheduler_id));

            // Ordres
            $order = $line['ORDER_ID'];
            $order_id = $chain_id.'/'.$line['ORDER_ID'];

            $step_id = $chain_id.'/'.$line['STATE'];
            $Steps[$step_id] = $line;

            $job_chain = $line['JOB_CHAIN'];
            $OrderInfo[$order_id] = $line;
        }

        // est on en mode splitté ?
        // le mieux serait de reprendre les ordres du xml
        $qry = $sql->Select(array('soh.JOB_CHAIN','soh.ORDER_ID','soh.SPOOLER_ID','soh.TITLE as ORDER_TITLE','soh.STATE as CURRENT_STATE','soh.START_TIME as ORDER_START_TIME','soh.END_TIME as ORDER_END_TIME',
            'sosh.TASK_ID','sosh.STATE','sosh.STEP','sosh.START_TIME','sosh.END_TIME','sosh.ERROR','sosh.ERROR_TEXT'))
        .$sql->From(array('SCHEDULER_ORDER_HISTORY soh'))
        .$sql->LeftJoin('SCHEDULER_ORDER_STEP_HISTORY sosh',array('soh.HISTORY_ID','sosh.HISTORY_ID'))
        .$sql->Where(array(
                'soh.HISTORY_ID>=' => $id,
                'soh.JOB_CHAIN' => $job_chain,
                'soh.SPOOLER_ID' => $scheduler_id,
                'soh.ORDER_ID' => '%:%' ))
        .$sql->OrderBy(array('sosh.TASK_ID'));

        $res = $data->sql->query( $qry );
        while ($line = $data->sql->get_next($res)) {
            $chain_id = $scheduler_id.'/'.$line['JOB_CHAIN'];

            $line['START_TIME']=$date->ShortDate( $date->Date2Local($line['START_TIME'],$scheduler_id));
            $line['END_TIME']=$date->ShortDate( $date->Date2Local($line['END_TIME'],$scheduler_id));

            // Ordres
            $order = $line['ORDER_ID'];
            $order_id = $chain_id.'/'.$line['ORDER_ID'];

            $step_id = $chain_id.'/'.$line['STATE'];
            $Steps[$step_id] = $line;

            $OrderInfo[$order_id] = $line;
        }

        // On complete avec l'etat de la chaine
        $qry =  $sql->Select(array('SPOOLER_ID','PATH','STOPPED'))
                .$sql->From(array('SCHEDULER_JOB_CHAINS'))
                .$sql->Where(array('SPOOLER_ID' => $scheduler_id, 'PATH' => $job_chain, 'STOPPED' => 1 ));

        $res = $data->sql->query( $qry );
        $Chain[$chain_id]['STOPPED']=0;
        if ($line = $data->sql->get_next($res)) {
            $Chain[$chain_id]['STOPPED']=1;
        }

        // On complete avec l'etat des steps
        $qry =  $sql->Select(array('SPOOLER_ID','JOB_CHAIN','ORDER_STATE','ACTION'))
                .$sql->From(array('SCHEDULER_JOB_CHAIN_NODES'))
                .$sql->Where(array('SPOOLER_ID' => $scheduler_id, 'JOB_CHAIN' => $job_chain ));

        $res = $data->sql->query( $qry );
        while ($line = $data->sql->get_next($res)) {
            $step_id = $chain_id.'/'.$line['ORDER_STATE'];
            // Si il n'est pas dans l'historique
            if (!isset($Steps[$step_id])) {
                $Steps[$step_id]['STATE']= $line['ORDER_STATE'];
            }
            $Steps[$step_id]['ACTION']= $line['ACTION'];
        }

        // On complete avec les infos de l'ordre
        $qry =  $sql->Select(array('SPOOLER_ID','JOB_CHAIN','STATE','STATE_TEXT','TITLE','PAYLOAD','INITIAL_STATE','ORDER_XML'))
                .$sql->From(array('SCHEDULER_ORDERS'))
                .$sql->Where(array('SPOOLER_ID' => $scheduler_id, 'JOB_CHAIN' => $job_chain, 'ID' => $order ));

        $res = $data->sql->query( $qry );
        while ($line = $data->sql->get_next($res)) {
            $OrderInfo[$order_id]['ORDER_XML'] = $line['ORDER_XML'];
            $OrderInfo[$order_id]['PAYLOAD'] = $line['PAYLOAD'];
        }

        $last = '';
        $Done = array(); // Noeuds traités

        // Schema de base
        $tmp = sys_get_temp_dir();      
        $cache = $tmp.'/'.$scheduler_id.',job_chains,job_commands.'.$scheduler_id.'.xml';
        $I =  @stat( $cache );
        $modif = $I[9];
        $SOS = $this->container->get('arii_jid.sos');
        
        if ((time() - $I[9])>3) {
            $cmd = '<show_state what="job_chains,job_commands"/>';
            $xml = $SOS->Command($scheduler_id,$cmd, 'xml');
            if (isset($xml['ERROR'])) {
                print $xml['ERROR'];
                exit();
            }
            file_put_contents($cache, $xml);
        }
        else {
            $xml = file_get_contents($cache);
        }
        $result = $SOS->xml2array($xml,1,'value');

        if (!isset($result['spooler'])) exit();

       $JobChains = $result['spooler']['answer']['state']['job_chains']['job_chain'];

       $XMLJobs = $result['spooler']['answer']['state']['jobs']['job'];

       // On ne conserve que le significatif
       $n=0;
       $Jobs = array();
       while (isset($XMLJobs[$n]['attr']['job'])) {
           $job = $XMLJobs[$n]['attr']['path'];
           // successeurs
           if (isset($XMLJobs[$n]['commands'])) {
                if (isset($XMLJobs[$n]['commands']['order'])) {
                   $XMLJobs[$n]['commands'][0]['attr'] = $XMLJobs[$n]['commands']['attr'];
                   $XMLJobs[$n]['commands'][0]['order'] = $XMLJobs[$n]['commands']['order'];
                }
                // Commandes
                $c = 0;
                $Commands = array();
                while (isset($XMLJobs[$n]['commands'][$c]['attr']['on_exit_code'])) {
                    $next = $XMLJobs[$n]['commands'][$c]['attr']['on_exit_code'];
                    if (isset($XMLJobs[$n]['commands'][$c]['attr'])) {
                        // mise en tableau forcée
                        $o = 0;
                        if (isset($XMLJobs[$n]['commands'][$c]['order']['attr']))
                            $XMLJobs[$n]['commands'][$c]['order'][$o]['attr'] = $XMLJobs[$n]['commands'][$c]['order']['attr'];
                        while (isset($XMLJobs[$n]['commands'][$c]['order'][$o])) {
                            $XMLJobs[$n]['commands'][$c]['order'][$o]['attr']['on_exit_code'] = $next;
                            array_push($Commands,$XMLJobs[$n]['commands'][$c]['order'][$o]);
                            $o++;
                        }
                    }
                    $c++;
                }
                $Jobs[$job] = $Commands;
           }
           // Next ?
           elseif (substr($XMLJobs[$n]['attr']['job'],0,1)=='_') {
               $Jobs[$job][0]['synchro']=1;
           }
           $n++;
       }

        // Dessin des étapes
        $gvz = $this->container->get('arii_jid.graphviz');
        $last = '';
        $etape=0;
        $svg = '';        
        foreach ($Steps as $step_id=>$line) {

            $s='/'.$line['JOB_CHAIN'].'/'.$line['STATE'];

            $svg .= $gvz->Node($images_path, $line);
            $Done[$s]=1;

            // si on est en split, cest différents
            if ($last !='') {
                if (($p=strpos($s,':'))>0) {
                    $svg .= "\"".substr($s,0,$p)."\" -> \"$s\" [label=$etape,color=$color]\n";
                }
                else {
                    $svg .= "\"$last\" -> \"$s\" [label=$etape,color=$color]\n";
                }
            }
            // On relie avec le noeud précédent
            // donc la couleur est pour le prochain lien
            if (!isset($line['ERROR'])) {
                $color= "grey";
            }
            elseif ($line['ERROR']==0 )
                $color= "green";
            else
                $color= "red";

            $last = $s;
            $etape++;
        }

        $svg .= $gvz->Chain($images_path, $scheduler_id, "/$job_chain", $order_id, $Steps, $JobChains, $Jobs  );

        foreach ($OrderInfo as $order_id => $Order ) {
            $svg .= $gvz->Order($images_path, $Order);
            $svg .= '"O.'.$Order['ORDER_ID'].'" -> "/'.$job_chain.'/'.$Order['CURRENT_STATE'].'" [style=dashed]'."\n";
        }
        
        $graphviz = $this->container->get('arii_core.graphviz');
        $Options = array(
            'digraph' => true,
            'output' => $output
        );

        return $graphviz->dot($svg, $Options);
    }

//----------------------NEW --------------------------


//NEW

//pour creer le tableau d'Informations
private function recursive($array){
  $res = '';
  foreach($array as $key => $value){
    //If $value is an array.
    if(is_array($value)){
      //We need to loop through it.

      $res .= '<item text="'.$key.'" id="'.$key.'">';
      //echo $key ,'<br>';
      $res .= $this->recursive($value);
      $res .= '</item>';
    } else{
      //It is not an array, so print it out.
      //echo $key .' : '. $value, '<br>';
      $res .= '<item text="'.strtoupper($key).' : '.str_replace("\"", "&quot;",$value).'" id="'.$key.'"/>';
      //return 'item type="input" label="state" name="'.$key.'" value="'.$value.'"  \n';
    }
  }
  return $res;
}

    public function testAction(){
      $request = Request::createFromGlobals();
      $dhtmlx = $this->container->get('arii_core.dhtmlx');
      $sql = $this->container->get('arii_core.sql');

      $qry = $sql->Select(array('h.ORDER_ID','h.JOB_CHAIN', 'h.SPOOLER_ID'))
              .$sql->From(array('SCHEDULER_ORDER_HISTORY h'));
          $id = $request->query->get( 'id' );
          $qry .= $sql->Where(array('h.HISTORY_ID'=>$id));

      $data = $dhtmlx->Connector('data');
      $res = $data->sql->query( $qry );
      $Infos = $data->sql->get_next($res);

      $spooler =  $Infos['SPOOLER_ID'];
      $job_chain = $Infos['JOB_CHAIN'];
      //$order = $Infos['ORDER_ID'];

      //$spooler =  "formationc2t";
      //$job =   "sos/dailyschedule/CheckDaysSchedule";
      //$job_chain = "formationc2t/Jobchain02";
      //$order = "Order02";

      //echo "ok : ".$job."   ".$spooler;

      $sos = $this->container->get('arii_jid.sos'); //service AriiSos

      $array = $sos->Command($spooler, '<show_job_chain job_chain="'.$job_chain.'" what="source" />'  );

      $xml = '<?xml version="1.0" encoding="iso-8859-1"?><tree id="0"><item text="Lawrence Block" id="t2_lb"><item text="All the Flowers Are Dying" id="lb_1"/><item text="The Burglar on the Prowl" id="lb_2"/><item text="The Plot Thickens" id="lb_3"/><item text="Grifter Game" id="lb_4"/><item text="The Burglar Who Thought He Was Bogart" id="lb_5"/></item><item text="Robert Crais" id="t2_rc" open="1"><item text="The Forgotten Man" id="rc_1"/><item text="Stalking the Angel" id="rc_2"/><item text="Free Fall" id="rc_3"/>       <item text="Sunset Express" id="rc_4"/> <item text="Hostage" id="rc_5"/></item><item text="Dan Brown" id="t2_db">                    <item text="Angels &amp; Demons" id="db_1"/><item text="Deception Point" id="db_2"/><item text="Digital Fortress" id="db_3"/><item text="The Da Vinci Code" id="db_4"/><item text="Deception Point" id="db_5"/></item><item  text="Joss Whedon" id="t2_jw"><item text="Astonishing X-Men" id="jw_1"/><item text="Joss Whedon: The Genius Behind Buffy" id="jw_2"/><item text="Fray" id="jw_3"/><item text="Tales Of The Vampires" id="jw_4"/><item text="The Harvest" id="jw_5"/></item></tree>';

      //$root = array('Job' =>  $array['spooler']['answer']['job']['source']['job']);


      $res .= $sos->createTree($array);

      $response = new Response($res);
      $response->headers->set('Content-Type', 'text/xml');

      //echo print_r($array);

      //return new Response("ok");

      return $response;
    }



    public function orderInfoAction(){
      $request = Request::createFromGlobals();
      $dhtmlx = $this->container->get('arii_core.dhtmlx');
      $sql = $this->container->get('arii_core.sql');

      $qry = $sql->Select(array('h.ORDER_ID','h.JOB_CHAIN', 'h.SPOOLER_ID'))
              .$sql->From(array('SCHEDULER_ORDER_HISTORY h'));
              $id = $request->query->get( 'id' );
          $qry .= $sql->Where(array('h.HISTORY_ID'=>$id));

      $data = $dhtmlx->Connector('data');
      $res = $data->sql->query( $qry );
      $Infos = $data->sql->get_next($res);

      $spooler =  $Infos['SPOOLER_ID'];
      $job_chain = $Infos['JOB_CHAIN'];
      $order = $Infos['ORDER_ID'];


      $sos = $this->container->get('arii_jid.sos'); //service AriiSos

      $type = $request->query->get( 'type' );
      if($type == 'order'){
        $array = $sos->Command($spooler, '<show_order job_chain="'.$job_chain.'" order="'.$order.'" />' );
      }else if ($type == 'chain'){
        $array = $sos->Command($spooler, '<show_job_chain job_chain="'.$job_chain.'" what="source" />'  );
      }


      $xml = '<?xml version="1.0" encoding="iso-8859-1"?><tree id="0"><item text="Lawrence Block" id="t2_lb"><item text="All the Flowers Are Dying" id="lb_1"/><item text="The Burglar on the Prowl" id="lb_2"/><item text="The Plot Thickens" id="lb_3"/><item text="Grifter Game" id="lb_4"/><item text="The Burglar Who Thought He Was Bogart" id="lb_5"/></item><item text="Robert Crais" id="t2_rc" open="1"><item text="The Forgotten Man" id="rc_1"/><item text="Stalking the Angel" id="rc_2"/><item text="Free Fall" id="rc_3"/>       <item text="Sunset Express" id="rc_4"/> <item text="Hostage" id="rc_5"/></item><item text="Dan Brown" id="t2_db">                    <item text="Angels &amp; Demons" id="db_1"/><item text="Deception Point" id="db_2"/><item text="Digital Fortress" id="db_3"/><item text="The Da Vinci Code" id="db_4"/><item text="Deception Point" id="db_5"/></item><item  text="Joss Whedon" id="t2_jw"><item text="Astonishing X-Men" id="jw_1"/><item text="Joss Whedon: The Genius Behind Buffy" id="jw_2"/><item text="Fray" id="jw_3"/><item text="Tales Of The Vampires" id="jw_4"/><item text="The Harvest" id="jw_5"/></item></tree>';

      $res = '<?xml version="1.0" encoding="UTF-8"?>';
      $res .= '<tree id="0">';
      $res .= $this->recursive($array);
      $res .= '</tree>';
      $response = new Response($res);
      $response->headers->set('Content-Type', 'text/xml');

      return $response;
    }

}
