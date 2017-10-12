<?php

namespace Arii\SelfBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ExchangeController extends Controller
{
    
    public function todoAction($model='')
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/plain');
        $Request = $this->getDoctrine()->getRepository("AriiSelfBundle:Request")->findOneBy(
            [   'name' => $model,
                'processed' => NULL
            ]);
        
        if (!$Request) {
            $response->setStatusCode( '404' );
            return $response;   
        }
        $call = $Request->getRunCommand();
        
        foreach ($Request->getParameters() as $k=>$v) {
            $call = str_replace('{{'.$k.'}}',$v,$call);
        }        
        $response->setContent( $call );

        // Module a démarrer
        $Request->setReqStatus('RUNNING');

        // On ajoute les informations d'historique
        $History = new \Arii\SelfBundle\Entity\History();
        $History->setRequest($Request);
        $History->setClientIP($this->container->get('request')->getClientIp());
        $History->setStarted(new \Datetime());
        $History->setRunExit(-1);
        $History->setRunStatus('STARTED');        
        
        $em = $this->getDoctrine()->getManager();       
        $em->persist($Request);
        $em->persist($History);        
        $em->flush();

        return $response;    
    }

    // converti les arguments en variables
    public function shAction($model='')
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/plain');
        $Request = $this->getDoctrine()->getRepository("AriiSelfBundle:Request")->findOneBy(
            [   'name' => $model,
                'processed' => NULL
            ]);
        
        if (!$Request) {
            $response->setStatusCode( '404' );
            return $response;   
        }
        
        $call = "#!/bin/sh\n";        
        $call .= "REF=".$Request->getReference().";export REF\n";
        foreach ($Request->getParameters() as $k=>$v) {
            $call .= "$k='$v';export $k\n";
        }        
        $response->setContent( $call );

        // Module a démarrer
        $Request->setReqStatus('RUNNING');

        // On ajoute les informations d'historique
        $History = new \Arii\SelfBundle\Entity\History();
        $History->setRequest($Request);
        $History->setClientIP($this->container->get('request')->getClientIp());
        $History->setStarted(new \Datetime());
        $History->setRunStatus('STARTED');        

        $em = $this->getDoctrine()->getManager();        
        $em->persist($Request);
        $em->persist($History);
        $em->flush();

        return $response;    
    }

    // converti les arguments en variables
    public function cmdAction($model='')
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/plain');
        $Request = $this->getDoctrine()->getRepository("AriiSelfBundle:Request")->findOneBy(
            [   'name' => $model,
                'processed' => NULL
            ]);
        
        if (!$Request) {
            $response->setStatusCode( '404' );
            return $response;   
        }
        
        $call = "@echo off\n";    
        $call .= "set REF=".$Request->getReference()."\n";
        foreach ($Request->getParameters() as $k=>$v) {
            $call .= "set $k=$v\n";
        }        
        $response->setContent( $call );
        
        // Module a démarrer
        $Request->setReqStatus('RUNNING');

        // On ajoute les informations d'historique
        $History = new \Arii\SelfBundle\Entity\History();
        $History->setRequest($Request);
        $History->setClientIP($this->container->get('request')->getClientIp());
        $History->setStarted(new \Datetime());
        $History->setRunStatus('STARTED');        

        $em = $this->getDoctrine()->getManager();        
        $em->persist($Request);
        $em->persist($History);
        $em->flush();

        return $response;    
    }
    
    public function returnAction($model='')
    {
        $request = Request::createFromGlobals();
        $exit = $request->get('exit');

        $response = new Response();
        $response->headers->set('Content-Type', 'text/plain');
        if ($exit=='') {
            $response->setStatusCode( '400' );
            return $response;               
        }

        $em = $this->getDoctrine()->getManager();        
        
        // Demande terminée
        $Request = $this->getDoctrine()->getRepository("AriiSelfBundle:Request")->findOneBy(
            [   'name' => $model,
                'processed' => NULL
            ]);
        
        if (!$Request) {
            $response->setStatusCode( '404' );
            return $response;               
        }

        if ($exit==0)
            $Request->setReqStatus('SUCCESS');
        else 
            $Request->setReqStatus('FAILURE');
        
        $Request->setProcessed(new \Datetime());               
        
        // Historique
        $History = $this->getDoctrine()->getRepository("AriiSelfBundle:History")->findOneBy(
            [   'request' => $Request,
                'processed' => NULL
                // client_ip ?
            ]);
        if (!$History) 
            throw new \Exception('HISTORY?');
            
        $fp = fopen("php://input",'r+');       
        $History->setProcessed(   new \DateTime());
        $History->setRunLog(stream_get_contents($fp));
        if ($exit==0)
            $History->setRunStatus('SUCCESS');
        else 
        $History->setRunStatus('FAILURE');        
        $History->setRunExit( $exit);
        
        $em->persist($Request);
        $em->persist($History);
        $em->flush();

        
        $response->setContent( 'OK!' );
        return $response;      
    }

}
