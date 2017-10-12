<?php

namespace Arii\ReportBundle\Controller\Import;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IPAMController extends Controller
{
    public function indexAction()
    {
        return $this->render('AriiReportBundle:Ipam:index.html.twig' );
    }
    
    public function gridAction() {
        $request = Request::createFromGlobals();
            
        $sql = $this->container->get('arii_core.sql');                  

        $qry = $sql->Select(array('ID','NAME','DISCOVERED','IP','MAC_ADDRESS','MAC_VENDOR'))
                .$sql->From(array('IMPORT_IPAM'));
        $qry .= $sql->OrderBy(array('NAME'));

        $dhtmlx = $this->container->get('arii_core.db');
        $data = $dhtmlx->Connector('grid');
        $data->event->attach("beforeRender",array($this,"grid_render"));
        $data->render_sql($qry,'ID','NAME,DISCOVERED,IP,MAC_ADDRESS,MAC_VENDOR');        
    }

    function grid_render($row)
    {
        $row->set_value('DISCOVERED', substr($row->get_value('DISCOVERED'),0, 10) );    
    }

}

