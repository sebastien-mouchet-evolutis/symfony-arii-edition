<?php

namespace Arii\JOCBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class RemoteSchedulerController extends Controller
{

    public function formAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        $sql = $this->container->get('arii_core.sql');      
        $qry = $sql->Select(array('ID','NAME','CONFIGURATION_CHANGED_AT','CONFIGURATION_TRANSFERED_AT','CONNECTED_AT','HOSTNAME','IP','NAME','PORT','VERSION','ERROR','ERROR_AT','DISCONNECTED_AT','UPDATED'))
                .$sql->From(array('JOC_REMOTE_SCHEDULERS'))
                .$sql->Where(array('ID' => $id));

        $dhtmlx = $this->container->get('arii_core.db');
        $data = $dhtmlx->Connector('form');
        $data->render_sql($qry,'ID','ID,NAME,CONFIGURATION_CHANGED_AT,CONFIGURATION_TRANSFERED_AT,CONNECTED_AT,HOSTNAME,IP,NAME,PORT,VERSION,ERROR,ERROR_AT,DISCONNECTED_AT,UPDATED');
    }
   
 }
