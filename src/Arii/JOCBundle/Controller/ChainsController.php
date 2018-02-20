<?php

namespace Arii\JOCBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ChainsController extends Controller
{
    protected $images;
    
    public function __construct( )
    {
          $request = Request::createFromGlobals();
          $this->images = $request->getUriForPath('/../arii/images/wa');
    }

    public function indexAction()
    {
        return $this->render('AriiJOCBundle:Chains:index.html.twig');
    }

    public function menuAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render('AriiJOCBundle:Chains:menu.xml.twig', array(), $response);
    }

    public function pie_chartAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render('AriiJOCBundle:Chains:pie_chart.html.twig', array(), $response);
    }

    public function toolbarAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render('AriiJOCBundle:Chains:toolbar.xml.twig', array(), $response);
    }

    public function listAction()
    {
        $state = $this->container->get('arii.joc');
        list($Chains,$Status) = $state->getJobChains($sort=['updated' => 'ASC']);
                
        $Render = $this->container->get('arii_core.render');
        return $Render->Grid($Chains,'SPOOLER,PATH,STATUS,ORDERS,UPDATED','COLOR');
    }

    public function pieAction() {
        $state = $this->container->get('arii.joc');
        list($Chains,$Status) = $state->getJobChains($sort=['updated' => 'ASC']);
                
        $Render = $this->container->get('arii_core.render');
        return $Render->Pie($Status,'STATE','COLOR');
    }
    
}
