<?php
// src/Arii/MFTBundle/Controller/DeliveryController.php

namespace Arii\MFTBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DeliveryController extends Controller
{

    public function toolbarAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        
        return $this->render('AriiMFTBundle:Delivery:toolbar.xml.twig',array(), $response );
    }

    public function form_structAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        
        return $this->render('AriiMFTBundle:Delivery:form.json.twig',array(), $response );
    }

    public function formAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        $sql = $this->container->get('arii_core.sql');    
        
        $qry = $sql->Select(array('ID','TITLE','DESCRIPTION','CATEGORY_ID'))
                .$sql->From(array('MFT_PARTNERS'))
                .$sql->Where(array('ID' => $id));
        
        $dhtmlx = $this->container->get('arii_core.db');
        $data = $dhtmlx->Connector('form');
        $data->render_sql($qry,'ID','ID,CATEGORY_ID,TITLE,DESCRIPTION');
    }

    public function logAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        $sql = $this->container->get('arii_core.sql');   
        
        $history = $this->container->get('arii_mft.mft');
        $Delivery = $history->Delivery($id);

        $response = new Response();
        $response->headers->set('Content-Type', 'text/plain');
        if (isset($Delivery[$id]['LOG_OUTPUT']))
            $response->setContent($Delivery[$id]['LOG_OUTPUT']);
        else 
            $response->setContent('...');
        return $response;
    }
    
    public function deleteAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
       
        $em = $this->getDoctrine()->getEntityManager();
        $delivery = $em->getRepository('AriiMFTBundle:Deliveries')->find($id);

        if (!$delivery) {
            throw $this->createNotFoundException($id);
        }

        $em->remove($delivery);
        $em->flush();
                
        return new Response("success");
    }
    
    public function deleteDHTMLXAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
       
        $db = $this->container->get("arii_core.db");
        $data = $db->Connector('data');

        $qry4 = "DELETE FROM MFT_TRANSMISSIONS WHERE DELIVERY_ID IN "
                ." (SELECT ID FROM MFT_DELIVERIES WHERE ID=$id)";        
        $res = $data->sql->query($qry4);
        
        $qry3 = "DELETE FROM MFT_DELIVERIES WHERE ID=$id";
        $res = $data->sql->query($qry3);
        
        // supressions des operations
        $qry2 = "DELETE FROM MFT_OPERATIONS WHERE TRANSFER_ID=$id";
        $res = $data->sql->query($qry2);
                
        return new Response("success");
    }
}
