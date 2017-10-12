<?php

namespace Arii\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class RepositoriesController extends Controller {
    
    public function indexAction()
    {
        return $this->render('AriiAdminBundle:Repositories:index.html.twig', array('id'=>''));
    }

    public function gridAction()
    {             
        $sql = $this->container->get('arii_core.sql');        
        $qry = $sql->Select(array("d.ID,d.NAME","d.TYPE","d.ROLE","d.DESCRIPTION","d.DBNAME","d.DRIVER",
                "c.TITLE","c.LOGIN" ))
                .$sql->From(array("ARII_DATABASE d"))
                .$sql->LeftJoin("ARII_CONNECTION c",array('d.CONNECTION_ID','c.ID'))
                .$sql->OrderBy(array('d.NAME'));
        
        $db = $this->container->get('arii_core.db');
        $select = $db->Connector('grid');
        $select->render_sql($qry,"ID","NAME,TYPE,ROLE,DESCRIPTION,DRIVER,DBNAME,TITLE,LOGIN");
    }
    
    public function menuAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render("AriiAdminBundle:Repositories:menu.xml.twig", array(), $response);
    }

    public function connections_selectAction()
    {
        $dhtmlx = $this->container->get('arii_core.db');
        $select = $dhtmlx->Connector('select');
        
        $sql = $this->container->get('arii_core.sql');
        
        $session = $this->container->get('arii_core.session');
        $qry = $sql->Select(array("ID","NAME"))
                .$sql->From(array("ARII_CONNECTION"))
                ." where PROTOCOL in ('oracle','mysql','postgres','sybase','mssql')"
                .$sql->OrderBy(array("NAME"));
        $select->render_sql($qry,"ID","ID,NAME");
    }   
    
}

?>
