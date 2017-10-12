<?php

namespace Arii\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class RepositoryController extends Controller {
    
    public function editAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        return $this->render('AriiAdminBundle:Repositories:index.html.twig',array('id'=>$id));
    }
    
    public function formAction()
    {
        $db = $this->container->get('arii_core.db');
        $sql = $this->container->get('arii_core.sql');
        
        $form = $db->Connector('form');
        $qry = $sql->Select(array("d.ID,d.NAME","d.TYPE","d.ROLE","d.DESCRIPTION","d.DBNAME","d.DRIVER",
                "c.TITLE","c.LOGIN","c.ID as CONNECTION_ID" ))
                .$sql->From(array("ARII_DATABASE d"))
                .$sql->LeftJoin("ARII_CONNECTION c",array('d.CONNECTION_ID','c.ID'))
                .$sql->OrderBy(array('d.NAME'));
        
        $form->render_sql($qry,"d.ID","ID,NAME,TYPE,ROLE,DESCRIPTION,DRIVER,DBNAME,CONNECTION_ID");
    }
    
    public function toolbarAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render("AriiAdminBundle:Repository:toolbar.xml.twig", array(), $response);
    }

    public function saveAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('ID');
        
        $database = new \Arii\CoreBundle\Entity\Database();
        if( $id!="" )
            $database = $this->getDoctrine()->getRepository("AriiCoreBundle:Database")->find($id);      
        
        $database->setName($request->get('NAME'));
        $database->setRole($request->get('ROLE'));
        $database->setType($request->get('TYPE'));
        $database->setDriver($request->get('DRIVER'));
        $database->setDbname($request->get('DBNAME'));
        $database->setDescription($request->get('DESCRIPTION'));

        $connection = $this->getDoctrine()->getRepository("AriiCoreBundle:Connection")->find($request->get('CONNECTION_ID'));
        if ($connection)
            $database->setConnection($connection);                

        $em = $this->getDoctrine()->getManager();
        $em->persist($database);
        $em->flush();
        
        return new Response("success");        
    }

    public function deleteAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        
        $database = $this->getDoctrine()->getRepository("AriiCoreBundle:Database")->find($id);

        if ($database) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($database);
            $em->flush();

            return new Response("success");            
        }
        return new Response("failure");                    
    }
    
}

?>
