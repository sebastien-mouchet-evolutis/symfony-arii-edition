<?php
// src/Arii/MFTBundle/Controller/TransfersController.php

namespace Arii\MFTBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ParametersController extends Controller
{

    public function indexAction()
    {
       return $this->render('AriiMFTBundle:Parameters:index.html.twig');
    }

    public function toolbarAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        
        return $this->render('AriiMFTBundle:Parameters:toolbar.xml.twig',array(), $response );
    }

    public function formAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        
        return $this->render('AriiMFTBundle:Parameters:form.xml.twig',array(), $response );
    }

    public function contextmenuAction()
    {        
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');    
        return $this->render('AriiMFTBundle:Parameters:grid_menu.xml.twig',array(), $response );
    }
    
    public function gridAction( $parameter_id=-1 )
    {
        $request = Request::createFromGlobals();
        if ($request->get('parameter_id')>0)
            $parameter_id = $request->get('parameter_id');

        $history = $this->container->get('arii_mft.mft');
        $Parameters = $history->Parameters($parameter_id);

        $grid = '<?xml version="1.0" encoding="UTF-8"?>';
        $grid .= "<rows>\n";
        $grid .= '<head>
            <afterInit>
                <call command="clearAll"/>
            </afterInit>
        </head>';
        foreach ($Parameters as $k=>$Parameter) {
            $grid .= '<row id="'.$k.'">';
            $grid .= "<cell>".$Parameter['NAME']."</cell>";
            $grid .= "<cell>".$Parameter['TITLE']."</cell>";
            $grid .= "<cell>".$Parameter['DESCRIPTION']."</cell>";            
            $grid .= "</row>";
        }
        $grid.='</rows>';
        
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        $response->setContent( $grid );
        return $response;
    }

    public function listAction( $partner_id=-1 )
    {
        $request = Request::createFromGlobals();
        if ($request->get('partner_id')>0)
            $partner_id = $request->get('partner_id');

        $mft = $this->container->get('arii_mft.mft');
        $Transfers = $mft->Transfers($partner_id,"TITLE");

        $grid = '<?xml version="1.0" encoding="UTF-8"?>';
        $grid .= "<rows>\n";
        $grid .= '<head>
            <afterInit>
                <call command="clearAll"/>
            </afterInit>
        </head>';
        foreach ($Transfers as $k=>$Transfer) {
            $grid .= '<row id="'.$k.'" style="background-color: '.$mft->ColorStatus($Transfer['STATUS']).'">';
            $grid .= "<cell>".$Transfer['TITLE']."</cell>";
            $grid .= "<cell>".$Transfer['PARTNER']."</cell>";
            $grid .= "<cell>".$Transfer['DESCRIPTION']."</cell>";            
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
                .$sql->From(array('MFT_TRANSFERS'))
//                ." where PROTOCOL in ('sftp') "
                .$sql->OrderBy(array('TITLE'));
        
        $db = $this->container->get('arii_core.db');
        $data = $db->Connector('select');
        $data->render_sql($qry,'ID','ID,TITLE');
            
    }

}
