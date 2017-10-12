<?php
// src/Arii/MFTBundle/Controller/PartnersController.php

namespace Arii\MFTBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class SummaryController extends Controller
{
    protected  $ColorStatus = array (
            'success' => '#ccebc5',
            'error' => '#fbb4ae'
        );

    public function indexAction()
    {
       return $this->render('AriiMFTBundle:Summary:index.html.twig');
    }

    public function toolbarAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        
        return $this->render('AriiMFTBundle:Summary:toolbar.xml.twig',array(), $response );
    }

    public function contextmenuAction()
    {        
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');    
        return $this->render('AriiMFTBundle:Summary:grid_menu.xml.twig',array(), $response );
    }
    
    public function gridAction($partner_id=-1)
    {
        $request = Request::createFromGlobals();
        if ($request->get('partner_id')!='')
            $partner_id = $request->get('partner_id');

        $history = $this->container->get('arii_mft.mft');
        $Partners = $history->Partners($partner_id);
        
        $grid = '<?xml version="1.0" encoding="UTF-8"?>';
        $grid .= "<rows>\n";
        $grid .= '<head>
            <afterInit>
                <call command="clearAll"/>
            </afterInit>
        </head>';
        foreach ($Partners as $k=>$Partner) {
            $grid .= '<row id="'.$k.'">';
            $grid .= "<cell>".$Partner['CATEGORY']."</cell>";
            $grid .= "<cell>".$Partner['TITLE']."</cell>";
            $grid .= "<cell><![CDATA[".$Partner['DESCRIPTION']."]]></cell>";            
            $grid .= "</row>";
        }
        $grid.='</rows>';
        
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        $response->setContent( $grid );
        return $response;
    }

    public function listAction($partner_id=-1)
    {
        $request = Request::createFromGlobals();
        if ($request->get('partner_id')!='')
            $partner_id = $request->get('partner_id');

        $history = $this->container->get('arii_mft.mft');
        $Partners = $history->Partners($partner_id);
        
        $grid = '<?xml version="1.0" encoding="UTF-8"?>';
        $grid .= "<rows>\n";
        $grid .= '<head>
            <afterInit>
                <call command="clearAll"/>
            </afterInit>
        </head>';
        foreach ($Partners as $k=>$Partner) {
            $grid .= '<row id="'.$k.'">';
            $grid .= "<cell>".$Partner['TITLE']."</cell>";
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
