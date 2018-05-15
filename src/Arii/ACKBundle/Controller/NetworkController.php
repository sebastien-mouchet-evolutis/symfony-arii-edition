<?php

namespace Arii\ACKBundle\Controller;
use Arii\ACKBundle\Entity\Alarm;
use Arii\ACKBundle\Form\AlarmType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NetworkController extends Controller
{
    public function indexAction()
    {
        return $this->render('AriiACKBundle:Network:index.html.twig');
    }

    public function gridAction()
    {
        $Errors = $this->getDoctrine()->getRepository('AriiACKBundle:Network')->listNotOk();
        
        $render = $this->container->get('arii_core.render');     
        return $render->grid($Errors,'name,status,last_state_change');
    }

    public function infoAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        
        $object = $this->getDoctrine()->getRepository("AriiACKBundle:Network")->find($id);
        $serializer = \JMS\Serializer\SerializerBuilder::create()->build();
                
        return $this->render('AriiACKBundle:Network:bootstrap.html.twig', $serializer->toArray($object) );
    }
    
}
