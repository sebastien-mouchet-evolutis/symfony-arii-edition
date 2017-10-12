<?php
// src/Arii/MFTBundle/Controller/PartnersController.php

namespace Arii\MFTBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class TransmissionController extends Controller
{

    public function toolbarAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        
        return $this->render('AriiMFTBundle:Transmission:toolbar.xml.twig',array(), $response );
    }

    public function gridAction($partner_id=-1)
    {
        $request = Request::createFromGlobals();
        if ($request->get('partner')!='')
            $partner_id = $request->get('partner_id');

        $history = $this->container->get('arii_mft.mft');
        $Transmissions = $history->Transmissions($partner_id);
        
        $grid = '<?xml version="1.0" encoding="UTF-8"?>';
        $grid .= "<rows>\n";
        $grid .= '<head>
            <afterInit>
                <call command="clearAll"/>
            </afterInit>
        </head>';

        foreach ($Transmissions as $k=>$Transmission) {
            $grid .= '<row id="'.$k.'">';
            $grid .= "<cell>".$Transmission['START_TIME']."</cell>";
            $grid .= "<cell>".$Transmission['END_TIME']."</cell>";            
            $grid .= "<cell>".$Transmission['DURATION']."</cell>";            
            $grid .= "<cell>".$Transmission['STATUS']."</cell>";            
            $grid .= "<cell>".$Transmission['SOURCE_FILE']."</cell>";            
            $grid .= "<cell>".$Transmission['TARGET_FILE']."</cell>";            
            $grid .= "<cell>".$Transmission['FILE_SIZE']."</cell>";            
            $grid .= "<cell>".$Transmission['MD5']."</cell>";            
            $grid .= "</row>";
        }
        $grid.='</rows>';
        
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        $response->setContent( $grid );
        return $response;
    }
}
