<?php
// src/Arii/MFTBundle/Controller/PartnersController.php

namespace Arii\MFTBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class TransmissionsController extends Controller
{

    public function indexAction()
    {
       return $this->render('AriiMFTBundle:Transmissions:index.html.twig');
    }

    public function toolbarAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        
        return $this->render('AriiMFTBundle:Transmissions:toolbar.xml.twig',array(), $response );
    }

    public function gridAction($delivery_id=-1,$run="",$try=0)
    {
        $request = Request::createFromGlobals();
        if ($request->get('delivery_id')!='')
            $delivery_id = $request->get('delivery_id');
        if ($request->get('run')!='')
            $run = $request->get('run');
        if ($request->get('try')!='')
            $try = $request->get('try');

        $history = $this->container->get('arii_mft.mft');
        $Transmissions = $history->Transmissions($delivery_id,$run,$try);
        
        $grid = '<?xml version="1.0" encoding="UTF-8"?>';
        $grid .= "<rows>\n";
        $grid .= '<head>
            <afterInit>
                <call command="clearAll"/>
            </afterInit>
        </head>';
        foreach ($Transmissions as $k=>$Transmission) {
            $grid .= '<row id="'.$k.'">';
            $grid .= "<cell>".$Transmission['OPERATION']."</cell>";
            $grid .= "<cell>".$Transmission['SOURCE_FILE']."</cell>";
            $grid .= "<cell>".$Transmission['START_TIME']."</cell>";            
            $grid .= "<cell>".$Transmission['END_TIME']."</cell>";            
            $grid .= "<cell>".$Transmission['STATUS']."</cell>";
            $grid .= "<cell>".$Transmission['FILE_SIZE']."</cell>";
            $grid .= "<cell>".$Transmission['MD5']."</cell>";
            $grid .= "<cell>1</cell>"; // Pour compter dans le graphique
            $grid .= "</row>";
        }
        $grid.='</rows>';
        
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        $response->setContent( $grid );
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
}
