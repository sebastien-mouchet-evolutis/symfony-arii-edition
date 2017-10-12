<?php

namespace Arii\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class SitesController extends Controller {
    
    public function indexAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        return $this->render('AriiAdminBundle:Sites:index.html.twig',array('id'=>$id));
    }

    public function toolbarAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render("AriiAdminBundle:Sites:toolbar.xml.twig", array(), $response);
    }
    
    public function menuAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render("AriiAdminBundle:Sites:menu.xml.twig", array(), $response);
    }

    public function gridAction()
    {
        $portal = $this->container->get('arii_core.portal');
        $Sites = $portal->getSites();      

        $dhtmlx = $this->container->get('arii_core.render'); 
        return $dhtmlx->grid($Sites,'name,title');
    }
    
    public function selectAction()
    {
        $portal = $this->container->get('arii_core.portal');
        $Sites = $portal->getSites();      

        $dhtmlx = $this->container->get('arii_core.render'); 
        return $dhtmlx->select($Sites,'title,description');
    }
    
    
    public function formAction()
    {
        $request = Request::createFromGlobals();

        $portal = $this->container->get('arii_core.portal');        
        $Site = $portal->getSiteById(($request->query->get('id')>0)?[ 'id'=> $request->query->get('id') ]:[]); 

        $dhtmlx = $this->container->get('arii_core.render'); 
        return $dhtmlx->form($Site);
    }
    
    public function deleteAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        
        $db = $this->container->get('arii_core.db');
        $data = $db->Connector('data');
        $qry1 = "DELETE FROM ARII_SPOOLER WHERE (not(isnull(supervisor_id)) or not(isnull(primary_id))) and site_id='$id'";
        $res = $data->sql->query($qry1);

        $qry2 = "DELETE FROM ARII_SPOOLER WHERE site_id='$id' ";
        $res = $data->sql->query($qry2);

        $qry3 = "DELETE FROM ARII_SITE WHERE id=$id";        
        $res = $data->sql->query($qry3);
        
        return new Response("success");
        
    }
    
    public function saveAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');

        $site = new \Arii\CoreBundle\Entity\Site();
        if ($id != "")
            $site = $this->getDoctrine()->getRepository("AriiCoreBundle:Site")->find($id);
        
        $site->setName($request->get('name'));
        $site->setTitle($request->get('title'));
        $site->setDescription($request->get('description'));
        $site->setTimezone($request->get('timezone'));
        $site->setLatitude($request->get('latitude'));
        $site->setLongitude($request->get('longitude'));
        $site->setAddress($request->get('address'));
        $site->setCity($request->get('city'));
        $site->setZipcode($request->get('zipcode'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($site);
        $em->flush();
        
        $portal = $this->container->get('arii_core.portal');
        $portal->setSites();
        
        return new Response("success");
    }
    
}

?>
