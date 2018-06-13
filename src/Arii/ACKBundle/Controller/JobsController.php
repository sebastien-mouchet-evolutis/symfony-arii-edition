<?php

namespace Arii\ACKBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class JobsController extends Controller{

    public function indexAction()
    {
        return $this->render('AriiACKBundle:Jobs:index.html.twig');
    }

    public function toolbarAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render("AriiACKBundle:Jobs:toolbar.xml.twig", array(), $response);
    }
    
    public function gridAction()
    {
        $request = Request::createFromGlobals();
        $state = $request->get('state');
        
        $Errors = $this->getDoctrine()->getRepository('AriiACKBundle:Status')->listState($state);
        $render = $this->container->get('arii_core.render');     
        return $render->grid($Errors,'instance,title,status,status_time','state');
    }

    public function countAction()
    {
        return new Response( '{ count: "'.$this->getDoctrine()->getRepository('AriiACKBundle:Status')->getNb().'" }' );
    }
    
    public function formAction()
    {   
        $request = Request::createFromGlobals();
        $id = $request->get('id');

        list($Job) = $this->getDoctrine()->getRepository("AriiACKBundle:Status")->Job($id);      

        $dhtmlx = $this->container->get('arii_core.render'); 
        return $dhtmlx->form($Job);        
    }

    public function deleteAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        
        $alert = $this->getDoctrine()->getRepository("AriiACKBundle:Event")->find($id);      
        if ($alert) {
            $em = $this->getDoctrine()->getManager();       
            $em->remove($alert);
            $em->flush();
            return new Response("success");            
        }
        
        return new Response("?!");            
    }
    
    public function saveAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');

        $alert = new \Arii\ACKBundle\Entity\Event();
        if( $id!="" )
            $alert = $this->getDoctrine()->getRepository("AriiACKBundle:Event")->find($id);      
  
        $alert->setName($request->get('name'));
        $alert->setTitle($request->get('title'));
        $alert->setDescription($request->get('description'));
        $alert->setEvent($request->get('event'));
        $alert->setEventType($request->get('event_type'));

        $alert->setStartTime(new \DateTime($request->get('start_time')));
        $alert->setEndTime(new \DateTime($request->get('end_time')));

        // rattachement
        if ($request->get('application_id')!="") {
            $db = $this->getDoctrine()->getRepository("AriiACKBundle:Application")->find($request->get('application_id'));
            $alert->setApplication($db);
        }
        if ($request->get('domain_id')!="") {
            $db = $this->getDoctrine()->getRepository("AriiACKBundle:Domain")->find($request->get('domain_id'));
            $alert->setDomain($db);
        }
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($alert);
        $em->flush();        

        return new Response("success");
    }
   
}

?>
