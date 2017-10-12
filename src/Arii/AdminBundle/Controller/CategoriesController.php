<?php

namespace Arii\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class CategoriesController extends Controller
{
    public function indexAction()
    {
        return $this->render('AriiAdminBundle:Categories:index.html.twig');
    }

    public function toolbarAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render('AriiAdminBundle:Categories:toolbar.xml.twig', array(), $response);
    }
    
    public function menuAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render("AriiAdminBundle:Categories:menu.xml.twig", array(), $response );
    }

    public function gridAction()
    {
        $request = Request::createFromGlobals();
        
        $portal = $this->container->get('arii_core.portal');        
        $Categories = $portal->getCategories(($request->query->get('category')>0)?[ 'category_id'=>$request->query->get('category') ]:[]); 
        
        $dhtmlx = $this->container->get('arii_core.render'); 
        return $dhtmlx->grid($Categories,'title,/,description');
    }
    
    public function treeAction()
    {        
        $request = Request::createFromGlobals();
        
        $portal = $this->container->get('arii_core.portal');        
        $Categories = $portal->getCategories(($request->query->get('category')>0)?[ 'id'=>$request->query->get('category') ]:[]); 
        
        $dhtmlx = $this->container->get('arii_core.render'); 
        return $dhtmlx->tree($Categories);
    }
    
    public function selectAction()
    {
        $request = Request::createFromGlobals();
        
        $portal = $this->container->get('arii_core.portal');        
        $Categories = $portal->getCategories(($request->query->get('category')>0)?[ 'id'=>$category_id ]:[]); 
        
        $dhtmlx = $this->container->get('arii_core.render'); 
        return $dhtmlx->select($Categories);
    }

     public function formAction()
    {
        $request = Request::createFromGlobals();

        $portal = $this->container->get('arii_core.portal');        
        $Category = $portal->getCategoryById($request->get('id')); 

        $dhtmlx = $this->container->get('arii_core.render'); 
        return $dhtmlx->form($Category);
    }

    public function saveAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');

        $category_id = $request->get('category_id');        
        $category = new \Arii\CoreBundle\Entity\Category();
        if( $id != "" )
            $category = $this->getDoctrine()->getRepository("AriiCoreBundle:Category")->find($id);

        $category->setName($request->get('name'));
        $category->setTitle($request->get('title'));
        $category->setDescription($request->get('description'));

        if ($category_id != "") 
        {
            $db = $this->getDoctrine()->getRepository("AriiCoreBundle:Category")->find($category_id);
            $category->setCategory($db);            
        }
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->flush();
        
        // Remise à zéro
        $portal = $this->container->get('arii_core.portal');
        $portal->resetCategories();
        
        return new Response("success");
    }
    
    public function deleteAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        
        if( $id == "" ) return new Response("?!");
        
        $category = $this->getDoctrine()->getRepository("AriiCoreBundle:Category")->find($id);
        
        $em = $this->getDoctrine()->getManager();
         $em->remove($category);
        $em->flush();
        
        return new Response("success");
    }
 
    // Juste la catégorie pour le drag and drop
    public function dragdropAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        if ($id=="") return new Response("id $id ?");
        
        $category_id = $request->get('category_id');
        if ($category_id=="") return new Response("category $category_id ?");
        
        $category = $this->getDoctrine()->getRepository("AriiCoreBundle:Category")->find($id);
        $db = $this->getDoctrine()->getRepository("AriiCoreBundle:Category")->find($category_id);
        $category->setCategory($db);            

        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->flush();
        
        return new Response("success");
    }
    
}
