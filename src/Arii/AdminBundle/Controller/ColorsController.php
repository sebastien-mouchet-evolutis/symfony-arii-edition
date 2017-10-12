<?php

namespace Arii\AdminBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ColorsController extends Controller{

    public function indexAction()
    {
        return $this->render('AriiAdminBundle:Colors:index.html.twig');
    }

    public function toolbarAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render("AriiAdminBundle:Colors:toolbar.xml.twig", array(), $response);
    }

    public function menuAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
         return $this->render("AriiAdminBundle:Colors:menu.xml.twig", array(), $response);
    }

    public function gridAction()
    {   
        $request = Request::createFromGlobals();
        
        $portal = $this->container->get('arii_core.portal');        
        $Colors = $portal->getColors(); 
        
        $dhtmlx = $this->container->get('arii_core.render'); 
        return $dhtmlx->grid($Colors,'status,bgcolor,color,"Juste un échantillon pour évaluer la lisibilité"');
    }

    public function formAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        
        $portal = $this->container->get('arii_core.portal');        
        $Color = $portal->getColorById($id); 

        $dhtmlx = $this->container->get('arii_core.render'); 
        return $dhtmlx->form($Color,'id,status,bgcolor,color,"Juste un échantillon pour évaluer la lisibilité"');
    }
/*
    function form_render ($data){
        
        $Colors =  explode('/',$data->get_value('VALUE'));
        $bgcolor = $Colors[0];
        if (isset($Colors[1]))
            $color = $Colors[1];
        else
            $color = 'white';
        
        $data->set_value('STATUS',substr($data->get_value('NAME'),13));
        $data->set_value('COLOR',$bgcolor);
        $data->set_value('TEXT',$color);
        $data->set_value('SAMPLE', "Juste un échantillon pour évaluer la lisibilité" );
    }    
    
    public function toolbar2Action()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render("AriiAdminBundle:Color:toolbar.xml.twig",array(),$response);
    }
*/    
    public function deleteAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');

        $em = $this->getDoctrine()->getManager();
       
        $color = $this->getDoctrine()->getRepository("AriiCoreBundle:Parameter")->find($id);      
        
        $em->remove($color);
        $em->flush();
        return new Response("success");
    }
    
    public function saveAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');

        $color = new \Arii\CoreBundle\Entity\Parameter();
        if( $id!="" )
            $color = $this->getDoctrine()->getRepository("AriiCoreBundle:Parameter")->find($id);      
        
        $color->setBundle('arii_core');
        $color->setName($request->get('status'));
        $color->setType('color');
        $color->setValue($request->get('color').'/'.$request->get('bgcolor'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($color);
        $em->flush();
        
        // mise a jour de la session
        $session = $this->container->get('arii_core.session'); 
        $session->setDefaultColors();
        
        return new Response("success");
    }
    
}

?>
