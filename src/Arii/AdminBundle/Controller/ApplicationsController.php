<?php

namespace Arii\AdminBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ApplicationsController extends Controller{

    public function indexAction()
    {
        return $this->render('AriiAdminBundle:Applications:index.html.twig');
    }

    public function toolbarAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render("AriiAdminBundle:Applications:toolbar.xml.twig", array(), $response);
    }

    public function selectAction()
    {
        $request = Request::createFromGlobals();
        
        $portal = $this->container->get('arii_core.portal');        
        $Applications = $portal->getApplications(($request->query->get('application')>0)?[ 'id'=>$application_id ]:[]); 
        
        $dhtmlx = $this->container->get('arii_core.render'); 
        return $dhtmlx->select($Applications);
    }
    
    public function gridAction()
    {        
        $portal = $this->container->get('arii_core.portal');        
        $Applications = $portal->getApplications(); 
        
        $dhtmlx = $this->container->get('arii_core.render'); 
        return $dhtmlx->grid($Applications,'title,name,category,description,contact,active');
    }
    
    public function formAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        
        $Application = $this->getDoctrine()->getRepository("AriiCoreBundle:Application")->find($id);
        
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');    
        $form = '<data>';
        if ($Application) {
            $form .= '<id>'.$Application->getId().'</id>';
            $form .= '<name>'.$Application->getName().'</name>';
            $form .= '<title>'.$Application->getTitle().'</title>';
            $form .= '<description><![CDATA['.$Application->getDescription().']]></description>';
            $form .= '<contact><![CDATA['.$Application->getContact().']]></contact>';
            $form .= '<active>'.$Application->getActive().'</active>';
            $Parent = $Application->getCategory();
            if ($Parent) {
                $form .= '<category_id>'.$Parent->getId().'</category_id>';
            }
            else {
                $form .= '<category_id/>';                
            }            
        }
        $form .= '</data>';
        $response->setContent( $form );
        return $response;        
    }

    public function deleteAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');

        $application = $this->getDoctrine()->getRepository("AriiCoreBundle:Application")->find($id);
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
        
        $application = new \Arii\CoreBundle\Entity\Application();
        if( $id != "" )
            $application = $this->getDoctrine()->getRepository("AriiCoreBundle:Application")->find($id);

        $application->setName($request->get('name'));
        $application->setTitle($request->get('title'));
        $application->setDescription($request->get('description'));
        $application->setContact($request->get('contact'));
        $application->setActive($request->get('active'));
        $category_id = $request->get('category_id');        
        if ($category_id!="") {
            $db = $this->getDoctrine()->getRepository("AriiCoreBundle:Category")->find($category_id);
            $application->setCategory($db);
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($application);
        $em->flush();

        // Remise a zero
        $portal = $this->container->get('arii_core.portal');        
        $portal->resetApplications();         
        
        return new Response("success");
    }
    
}
?>
