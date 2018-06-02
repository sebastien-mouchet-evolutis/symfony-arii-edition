<?php

namespace Arii\ACKBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ActionsController extends Controller{

    public function indexAction()
    {
        return $this->render('AriiACKBundle:Events:index.html.twig');
    }

    public function toolbarAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render("AriiACKBundle:Actions:toolbar.xml.twig", array(), $response);
    }

    public function gridAction()
    {
        $request = Request::createFromGlobals();
        $event_id = $request->get('event_id');
        
        $Actions = $this->getDoctrine()->getRepository('AriiACKBundle:Action')->getComments($event_id);
        
        $render = $this->container->get('arii_core.render');     
        return $render->grid($Actions,'user,title,date_time');
    }
   
}

?>
