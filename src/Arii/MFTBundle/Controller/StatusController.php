<?php

namespace Arii\MFTBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class StatusController extends Controller
{
    
    public function structAction()
    { 
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');    
        return $this->render('AriiMFTBundle:Status:form.json.twig',array(), $response );
    }

    public function formAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        $sql = $this->container->get('arii_core.sql');    
        $sql->setDriver($this->container->getParameter('database_driver'));
        
        $qry = $sql->Select(array('ID','RUN'))
                .$sql->From(array('MFT_HISTORY'))
                .$sql->Where(array('ID' => $id));
        
        $dhtmlx = $this->container->get('arii_core.db');
        $data = $dhtmlx->Connector('form');
        $data->render_sql($qry,'ID','ID,RUN,STATUS');
    }

    public function saveAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->request->get('ID');
         
        $status = new \Arii\MFTBundle\Entity\History();
        if($id!="")
            $status = $this->getDoctrine()->getRepository("AriiMFTBundle:History")->find($id);
        
        $status->setName(     $request->request->get('NAME'));
        $status->setStep(     $request->request->get('STEP'));
        $status->setRun(      $request->request->get('RUN'));
        $status->setStatus(   $request->request->get('STATUS'));
        
        $em = $this->getDoctrine()->getManager();
        
        $em->persist($status);
        $em->flush();
        
        return new Response('success');
    }

    public function change_statusAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
         
        $status = $this->getDoctrine()->getRepository("AriiMFTBundle:History")->find($id);
        if (!$status) {
            return new Response('failure');
        }
        
        $status->setStatusTime( new \DateTime() );        
        $status->setStatus(   $request->get('status'));
        
        $em = $this->getDoctrine()->getManager();
        
        $em->persist($status);
        $em->flush();
        
        return new Response('success');
    }

}

