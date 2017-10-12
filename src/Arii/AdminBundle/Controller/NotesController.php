<?php

namespace Arii\AdminBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class NotesController extends Controller{

    public function indexAction()
    {
        return $this->render('AriiAdminBundle:Notes:index.html.twig');
    }

    public function toolbarAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render("AriiAdminBundle:Notes:toolbar.xml.twig", array(), $response);
    }
    
    public function grid_toolbarAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render("AriiAdminBundle:Notes:grid_toolbar.xml.twig", array(), $response);
    }

    public function gridAction()
    {   
        $sql = $this->container->get('arii_core.sql');        
        $qry = $sql->Select(array("ID","NAME","TITLE","DESCRIPTION","NOTE"))
                .$sql->From(array("ARII_NOTE"))
                .$sql->OrderBy(array('NAME,TITLE,DESCRIPTION'));
        
        $db = $this->container->get('arii_core.db');
        $data = $db->Connector('grid');
        $data->render_sql($qry,"ID","NAME,TITLE,DESCRIPTION");
    }
    
    public function formAction()
    {   
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        
        $sql = $this->container->get('arii_core.sql');        
        $qry = $sql->Select(array("ID","NAME","TITLE","DESCRIPTION","NOTE"))
                .$sql->From(array("ARII_NOTE"))
                .$sql->Where(array("ID"=>$id));
        
        $db = $this->container->get('arii_core.db');
        $data = $db->Connector('form');
        $data->render_sql($qry,"ID","ID,NAME,TITLE,DESCRIPTION,NOTE");
    }

    public function selectAction()
    {   
        $sql = $this->container->get('arii_core.sql');        
        $qry = $sql->Select(array("ID","NAME","TITLE","DESCRIPTION","NOTE"))
                .$sql->From(array("ARII_NOTE"))
                .$sql->OrderBy(array("TITLE"));
        
        $db = $this->container->get('arii_core.db');
        $data = $db->Connector('select');
        $data->render_sql($qry,"ID","ID,NAME,TITLE,DESCRIPTION,NOTE");
    }
    
    public function deleteAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('ID');
        
        $note = $this->getDoctrine()->getRepository("AriiCoreBundle:Note")->find($id);      
        if ($note) {
            $em = $this->getDoctrine()->getManager();       
            $em->remove($note);
            $em->flush();
            return new Response("success");            
        }
        
        return new Response("?!");            
    }
    
    public function saveAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('ID');

        $note = new \Arii\CoreBundle\Entity\Note();
        if( $id!="" )
            $note = $this->getDoctrine()->getRepository("AriiCoreBundle:Note")->find($id);      
  
        $note->setName($request->get('NAME'));
        $note->setTitle($request->get('TITLE'));
        $note->setDescription($request->get('DESCRIPTION'));
        $note->setNote($request->get('NOTE'));
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($note);
        $em->flush();
        
        return new Response("success");
    }
        
}

?>
