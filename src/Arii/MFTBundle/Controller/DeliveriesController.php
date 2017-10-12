<?php
// src/Arii/MFTBundle/Controller/PartnersController.php

namespace Arii\MFTBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DeliveriesController extends Controller
{

    public function indexAction($transfer_id = -1)
    {
        $request = Request::createFromGlobals();
        if ($request->get('transfer_id')!='')
            $transfer_id = $request->get('transfer_id');
        
        $Steps = array();
        if ($transfer_id>=0) {
            // on retrouve les opérations en focntion du type de transfer        
            $sql = $this->container->get('arii_core.sql');    
            $qry = $sql->Select(array( 'ID','STEP','TITLE' )) 
                .$sql->From(array('MFT_OPERATIONS'))
                .$sql->Where(array('TRANSFER_ID' => $transfer_id ))
                .$sql->OrderBy(array('STEP'));

            $db = $this->container->get('arii_core.db');
            $data = $db->Connector('form');
            $res = $data->sql->query( $qry );
            while ($line = $data->sql->get_next($res)) {
                array_push($Steps,$line);
            }
        }
        return $this->render('AriiMFTBundle:Deliveries:index.html.twig', array('Operations'=>$Steps));
    }

    public function toolbarAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        
        return $this->render('AriiMFTBundle:Deliveries:toolbar.xml.twig',array(), $response );
    }

    public function gridAction($transfer_id=-1,$run=0)
    {
        $request = Request::createFromGlobals();
        if ($request->get('transfer_id')!='')
            $transfer_id = $request->get('transfer_id');

        $mft = $this->container->get('arii_mft.mft');
        $Deliveries = $mft->TransferDeliveries($transfer_id,$run);
        
        $grid = '<?xml version="1.0" encoding="UTF-8"?>';
        $grid .= "<rows>\n";
        $grid .= '<head>
            <afterInit>
                <call command="clearAll"/>
            </afterInit>
        </head>';
//                'd.ID','d.STATUS', 'd.SIZE','d.DURATION','d.SUCCESS','d.FAILED','d.SKIPPED','d.LAST_ERROR','d.START_TIME','d.END_TIME','d.STATUS_TEXT',
//                'o.SOURCE_PATH','o.TARGET_PATH','o.SOURCE_FILES'        
        foreach ($Deliveries as $k=>$Delivery) {
            $grid .= '<row id="'.$k.'" style="background-color: '.$mft->ColorStatus($Delivery['STATUS']).'">';
            $grid .= "<cell>".$Delivery['NAME']."</cell>";
            $grid .= "<cell>".$Delivery['TITLE']."</cell>";            
            $grid .= "<cell>".$Delivery['RUN']."</cell>";
            $grid .= "<cell>".$Delivery['STEP']."</cell>";
            $grid .= "<cell>".$Delivery['TRY']."</cell>";
            $grid .= "<cell>".$Delivery['STATUS']."</cell>";
            $grid .= "<cell>".$Delivery['STATUS_TEXT']."</cell>";
            $grid .= "<cell>".$Delivery['START_TIME']."</cell>";
            $grid .= "<cell>".$Delivery['END_TIME']."</cell>";
            $grid .= "<cell>".$Delivery['DURATION']."</cell>";
            $grid .= "<cell>".$Delivery['SOURCE_PATH']."</cell>";
            $grid .= "<cell>".$Delivery['TARGET_PATH']."</cell>";
            $grid .= "<cell>".$Delivery['SOURCE_FILES']."</cell>";
            $grid .= "<cell>".$Delivery['FILES_COUNT']."</cell>";
            $grid .= "<cell>".$Delivery['FILES_SIZE']."</cell>";
            $grid .= "<cell>".$Delivery['SUCCESS']."</cell>";
            $grid .= "<cell>".$Delivery['FAILED']."</cell>";
            $grid .= "<cell>".$Delivery['SKIPPED']."</cell>";
            $last = $Delivery['LAST_ERROR'];
/*            if (($p=strpos($last,': '))) {
                $last = substr($last,$p+1);
            }
*/            $grid .= "<cell>".$last."</cell>";
            $grid .= "</row>";
        }
        $grid.='</rows>';
        
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        $response->setContent( $grid );
        return $response;
    }

    public function stackedbarsAction($transfer_id=-1,$run=0)
    {
        $request = Request::createFromGlobals();
        if ($request->get('transfer_id')!='')
            $transfer_id = $request->get('transfer_id');

        $mft = $this->container->get('arii_mft.mft');
        $Deliveries = $mft->TransferDeliveries($transfer_id,$run);

        $Chart = array();
        $Runs = array();
        $Steps = array();
        foreach ($Deliveries as $d) {
            $run = $d['RUN'];
            $step= $d['STEP']; 
            $Runs[$run]=$Steps[$step]=1;
            $id = $run.'_'.$step;            
            $Duration[$id] = $d['DURATION'];
            $DB[$id] = $d['ID'];
        }
        
        $chart = '<data>';
        foreach (array_keys($Runs) as $run) {            
            $chart .= '<item id="'.$run.'">';
            $chart .= '<run>'.$run.'</run>';
            foreach (array_keys($Steps) as $step) {
                $id = $run.'_'.$step;
                if (isset($Duration[$id])) 
                    // $chart .= '<S'.$step.'>'.$Duration[$id].'<userdata>'.$DB[$id].'</userdata></S'.$step.'>';
                    $chart .= '<S'.$step.'>'.$Duration[$id].'</S'.$step.'>';
            }
            $chart .= '</item>';            
        }
        $chart .= '</data>';
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        $response->setContent( $chart );
        return $response;
    }
    
    public function selectAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        $sql = $this->container->get('arii_core.sql');    
        
        $qry = $sql->Select(array('ID','TITLE'))
                .$sql->From(array('MFT_PARTNERS'))
//                ." where PROTOCOL in ('sftp') "
                .$sql->OrderBy(array('TITLE'));
        
        $db = $this->container->get('arii_core.db');
        $data = $db->Connector('select');
        $data->render_sql($qry,'ID','ID,TITLE');
    }
    
    public function pieAction($delivery_id=-1) {
        $request = Request::createFromGlobals();
        if ($request->get('delivery_id')!='')
            $delivery_id = $request->get('delivery_id');

        $mft = $this->container->get('arii_mft.mft');        
        $Deliveries = $mft->Deliveries($delivery_id);
        
        if (!isset($Deliveries[$delivery_id])) exit();
        
        $pie = '<data>';
        $pie .= '<item id="TRANSFERED"><TEXT>Transfered</TEXT><STATUS>'.$Deliveries[$delivery_id]['SUCCESS'].'</STATUS><COLOR>'.$mft->ColorStatus('SUCCESS').'</COLOR></item>';
        $pie .= '<item id="FAILED"><TEXT>Failed</TEXT><STATUS>'.$Deliveries[$delivery_id]['FAILED'].'</STATUS><COLOR>'.$mft->ColorStatus('FAILURE').'</COLOR></item>';
        $pie .= '<item id="SKIPPED"><TEXT>Skipped</TEXT><STATUS>'.$Deliveries[$delivery_id]['SKIPPED'].'</STATUS><COLOR>'.$this->ColorStatus('WARNING').'</COLOR></item>';
        $pie .= '</data>';
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        $response->setContent( $pie );
        return $response;
    }
}
