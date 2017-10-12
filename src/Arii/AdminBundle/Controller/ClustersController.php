<?php

namespace Arii\AdminBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ClustersController extends Controller {
    
    protected $images;
    protected $CurrentDate;
     
    public function __construct( )
    {
          $request = Request::createFromGlobals();
          $this->images = $request->getUriForPath('/../arii/images/wa');
          
          $this->CurrentDate = date('Y-m-d');
    }

    public function indexAction()
    {
        return $this->render('AriiAdminBundle:Clusters:index.html.twig');
    }

    public function menuAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render('AriiAdminBundle:Clusters:menu.xml.twig', array(), $response);
    }

    public function gridAction()
    {             
        $sql = $this->container->get('arii_core.sql');        
        $qry = $sql->Select(array( "sp.ID","sp.INSTANCE","sp.NAME","sp.DESCRIPTION","sp.STATUS",
                    "c.HOST","c.PORT",
                    "c1.NAME as DB,c1.ID" ))
                .$sql->From(array("ARII_SPOOLER sp"))
                .$sql->LeftJoin('ARII_CONNECTION c',array('sp.PRIMARY_NODE_ID','c.ID'))
                .$sql->LeftJoin('ARII_CONNECTION c1',array('sp.PRIMARY_DB_ID','c1.ID'))
                .$sql->OrderBy(array('sp.NAME'));
        
        $db = $this->container->get('arii_core.db');
        $select = $db->Connector('grid');
        $select->render_sql($qry,"ID","INSTANCE,NAME,DESCRIPTION");
    }   

}
?>
