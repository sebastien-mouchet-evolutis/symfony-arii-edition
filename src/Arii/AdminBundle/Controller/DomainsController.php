<?php

namespace Arii\AdminBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DomainsController extends Controller{

    public function indexAction()
    {
        return $this->render('AriiAdminBundle:Domains:index.html.twig');
    }

    public function toolbarAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render("AriiAdminBundle:Domains:toolbar.xml.twig", array(), $response);
    }

    public function selectAction()
    {
        $request = Request::createFromGlobals();
        
        $portal = $this->container->get('arii_core.portal');        
        $Domains = $portal->getDomains(($request->query->get('application')>0)?[ 'id'=>$application_id ]:[]); 
        
        $dhtmlx = $this->container->get('arii_core.render'); 
        return $dhtmlx->select($Domains);
    }
    
    public function gridAction()
    {        
        $portal = $this->container->get('arii_core.portal');        
        $Domains = $portal->getDomains(); 

        $dhtmlx = $this->container->get('arii_core.render'); 
        return $dhtmlx->grid($Domains,'name,title,description');
    }
    
    public function formAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        
        $Domain = $this->getDoctrine()->getRepository("AriiCoreBundle:Domain")->find($id);
        
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');    
        $form = '<data>';
        if ($Domain) {
            $form .= '<id>'.$Domain->getId().'</id>';
            $form .= '<name>'.$Domain->getName().'</name>';
            $form .= '<title>'.$Domain->getTitle().'</title>';
            $form .= '<description><![CDATA['.$Domain->getDescription().']]></description>';
        }
        $form .= '</data>';
        $response->setContent( $form );
        return $response;        
    }

    public function deleteAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');

        $application = $this->getDoctrine()->getRepository("AriiCoreBundle:Domain")->find($id);
        if (!$application)
            return new Response("$id ?!");
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($application);
        $em->flush();  
        
        return new Response("success");
    }

    public function saveAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        
        $application = new \Arii\CoreBundle\Entity\Domain();
        if( $id != "" )
            $application = $this->getDoctrine()->getRepository("AriiCoreBundle:Domain")->find($id);

        $application->setName($request->get('name'));
        $application->setTitle($request->get('title'));
        $application->setDescription($request->get('description'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($application);
        $em->flush();

        // Remise a zero
        $portal = $this->container->get('arii_core.portal');        
        $portal->resetDomains();         
        
        return new Response("success");
    }
    
}
?>
