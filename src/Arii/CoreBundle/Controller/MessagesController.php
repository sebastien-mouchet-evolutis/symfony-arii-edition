<?php

namespace Arii\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

// Evenements
use Arii\CoreBundle\EventDispatcher\MessageEvent;

class MessagesController extends Controller
{
    protected $images;
    
    public function __construct( )
    {
          $request = Request::createFromGlobals();
          $this->images = $request->getUriForPath('/../bundles/ariicore/images/wa');
    }
    
    public function indexAction()
    {
        $portal = $this->container->get('arii_core.portal');
        return $this->render('AriiCoreBundle:Messages:index.html.twig',array('Modules' => $portal->getModules()));
    }

    public function toolbarAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render("AriiCoreBundle:Messages:toolbar.xml.twig", array(), $response);
    }

    private function returnMessages($Messages) {
        $Grid = [];
        foreach ($Messages as $Message) {
            array_push($Grid,
                [
                    'id'    => $Message->getId(),
                    'type'  => $Message->getMsgType(),
                    'icon'  => $this->images.'/'.$Message->getMsgType().'.png',
                    'title' => $Message->getTitle(),
                    'sent'  => $Message->getMsgSent()->format('Y-m-d H:i:s'),
                    'from'  => $Message->getMsgFrom()->getUsername(),
                    'to'    => $Message->getMsgTo()->getUsername()
                ]
            );
        }
        $dhtmlx = $this->container->get('arii_core.render'); 
        return $dhtmlx->grid($Grid,'title,icon,sent,from,to','type');
    }
    
    public function inboxAction()
    {
        $portal = $this->container->get('arii_core.portal');
        $id = $portal->getuserid();

        $em = $this->getDoctrine()->getManager();
        $Messages = $this->getDoctrine()->getRepository("AriiCoreBundle:Message")->findBy(
            [ 'msg_to' => $id, 'msg_ack' => null ]
        );      
        return $this->returnMessages($Messages);
    }

    public function getAction()
    {
        $portal = $this->container->get('arii_core.portal');
        $id = $portal->getuserid();

        $em = $this->getDoctrine()->getManager();
        $Messages = $this->getDoctrine()->getRepository("AriiCoreBundle:Message")->findBy(
            [ 'msg_to' => $id, 'msg_ack' => null ]
        );
        $response = new Response();
        $response->headers->set('Content-Type', 'text/plain');
        $response->setContent( count($Messages) );
        return $response;  
    }
    
    public function outboxAction()
    {
        $portal = $this->container->get('arii_core.portal');
        $id = $portal->getuserid();

        $em = $this->getDoctrine()->getManager();
        $Messages = $this->getDoctrine()->getRepository("AriiCoreBundle:Message")->findBy(
            [ 'msg_from' => $id, 'msg_ack' => null  ]
        );      
        return $this->returnMessages($Messages);
    }

    public function usersAction()
    {
        $portal = $this->container->get('arii_core.portal');        
        $U = $this->getDoctrine()->getRepository("AriiUserBundle:User")->findby([ 'enabled' => 1 ], ['username' => 'ASC']);
        $Users = [];
        foreach ($U as $User) {
            array_push( $Users, [ 
                'id' => $User->getId(),
                'name' => $User->getUsername()                
            ] );
        }
        $dhtmlx = $this->container->get('arii_core.render'); 
        return $dhtmlx->select($Users,'id,name');
    }

    public function saveAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        
        $em = $this->getDoctrine()->getManager();
        $Msg = new \Arii\CoreBundle\Entity\Message();
  
        $portal = $this->container->get('arii_core.portal');
        $Info = $portal->getUserInfo();
        $Me = $this->getDoctrine()->getRepository("AriiUserBundle:User")->find($Info['id']); 
        $Msg->setMsgFrom($Me);
        
        $Msg->setMsgSource('User');
        $Msg->setTitle($request->get('title'));
        $Msg->setMsgType($request->get('msg_type'));
        $Msg->setMsgText($request->get('msg_text'));
        
        // On retrouve le user
        $User = $this->getDoctrine()->getRepository("AriiUserBundle:User")->find($request->get('user_id')); 
        if ($User)
            $Msg->setMsgTo($User);

        $Msg->setMsgSent(new \DateTime());
        
        $em->persist($Msg);
        $em->flush();        

        // On envoie l'evenement nouveau_message 
        $event =  new MessageEvent($Msg);
        $event->setMsg($Msg);
        $this->get("event_dispatcher")->dispatch( 'arii_message.after_message_sent', $event);
        return new Response("success");
    }

    public function displayAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');

        $em = $this->getDoctrine()->getManager();
        $Message = $this->getDoctrine()->getRepository("AriiCoreBundle:Message")->find($id);

        // On acquitte si on est destinataire
        $portal = $this->container->get('arii_core.portal');
        $Info = $portal->getUserInfo();
        $Me = $this->getDoctrine()->getRepository("AriiUserBundle:User")->find($Info['id']); 
        
        if ($Message->getMsgTo() == $Me) {        
            $Message->setMsgRead(new \Datetime());
            $Message->setMsgAck(new \Datetime());
            $em->persist($Message);
            $em->flush();  
        }
        
        return $this->render('AriiCoreBundle:Messages:display.html.twig', 
            [   'title' => $Message->getTitle(),
                'text'  => $Message->getMsgText(),
                'type'  => $Message->getMsgType(),
                'sent'  => $Message->getMsgSent()->format('Y-m-d H:i:s'),
                'read'  => (empty($Message->getMsgSent())?null:$Message->getMsgSent()->format('Y-m-d H:i:s')),
                'ack'   => (empty($Message->getMsgAck())?null:$Message->getMsgAck()->format('Y-m-d H:i:s'))
            ]);
    }

    public function ackAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');

        $response = new Response();
        $response->headers->set('Content-Type', 'text/plain');
        $em = $this->getDoctrine()->getManager();
        $Message = $this->getDoctrine()->getRepository("AriiCoreBundle:Message")->find($id);

        if ($Message) {
            $Message->setMsgAck(new \Datetime());
            $em->persist($Message);
            $em->flush();  
            $response->setContent('ack');            
        }
        else {
            $response->setContent('id '.$id.' ?');            
        }
        return $response;  
    }
    
    // affiche les messages non lus
    public function msgboxAction()
    {
        $request = Request::createFromGlobals();
        $first = $request->get('first');
        
        $portal = $this->container->get('arii_core.portal');
        $id = $portal->getuserid();

        $em = $this->getDoctrine()->getManager();
        
        // Une alerte non acquittée est considérée comme non lue
        if ($first=='true') {
            $Messages = $this->getDoctrine()->getRepository("AriiCoreBundle:Message")->findBy(
                [ 'msg_to' => $id, 'msg_type' => 'A', 'msg_ack' => null ]
            );            
            foreach ($Messages as $Message) {
                $Message->setMsgRead(null);
                $em->persist($Message);
            }
            $em->flush();              
        }
        
        $Messages = $this->getDoctrine()->getRepository("AriiCoreBundle:Message")->findBy(
            [ 'msg_to' => $id, 'msg_read' => null ]
        );
        
        $Msg = [];
        foreach ($Messages as $Message) {
            array_push($Msg, [
                'id'    => $Message->getId(),
                'title' => $Message->getTitle(),
                'text' =>  $Message->getMsgText(),
                'date' =>  $Message->getMsgSent()->format('Y-m-d h:i:s'),
                'from' =>  $Message->getMsgFrom(),
                'type' =>  $Message->getMsgType()
            ]);
            $Message->setMsgRead(new \Datetime());
            $em->persist($Message);
        }
        $em->flush();
        
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent( json_encode($Msg) );
        return $response;  
    }
    
}
