<?php

namespace Arii\AdminBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class RulesController extends Controller{

    public function indexAction()
    {
        return $this->render('AriiAdminBundle:Rules:index.html.twig');
    }

    public function toolbarAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render("AriiAdminBundle:Rules:toolbar.xml.twig", array(), $response);
    }

    public function selectAction()
    {
        $request = Request::createFromGlobals();
        
        $portal = $this->container->get('arii_core.portal');        
        $Rules = $portal->getRules(); 
        
        $dhtmlx = $this->container->get('arii_core.render'); 
        return $dhtmlx->select($Rules);
    }
    
    public function gridAction()
    {        
        $portal = $this->container->get('arii_core.portal');        
        $Rules = $portal->getRules(); 

        $dhtmlx = $this->container->get('arii_core.render'); 
        return $dhtmlx->grid($Rules,'InJob,OutApp,OutEnv');
    }
    
    public function formAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        
        $Rule = $this->getDoctrine()->getRepository("AriiCoreBundle:Rule")->find($id);
        
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');    
        $form = '<data>';
        if ($Rule) {
            $form .= '<id>'.$Rule->getId().'</id>';
            $form .= '<in_job>'.$Rule->getInJob().'</in_job>';
            $form .= '<out_app>'.$Rule->getOutApp().'</out_app>';
            $form .= '<out_env>'.$Rule->getOutEnv().'</out_env>';
        }
        $form .= '</data>';
        $response->setContent( $form );
        return $response;        
    }

    public function deleteAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');

        $rule = $this->getDoctrine()->getRepository("AriiCoreBundle:Rule")->find($id);
        if (!$rule)
            return new Response("$id ?!");
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($rule);
        $em->flush();  
        
        return new Response("success");
    }

    public function saveAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        
        $rule = new \Arii\CoreBundle\Entity\Rule();
        if( $id != "" )
            $rule = $this->getDoctrine()->getRepository("AriiCoreBundle:Rule")->find($id);

        $rule->setInJob($request->get('in_job'));
        $rule->setOutApp($request->get('out_app'));
        $rule->setOutEnv($request->get('out_env'));
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($rule);
        $em->flush();

        // Remise a zero
        $portal = $this->container->get('arii_core.portal');        
        $portal->resetRules();         
        
        return new Response("success");
    }
    
}
?>
