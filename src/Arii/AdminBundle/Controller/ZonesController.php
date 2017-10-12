<?php

namespace Arii\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ZonesController extends Controller
{
   public function indexAction()
    {
        return $this->render('AriiAdminBundle:Zones:index.html.twig');
    }

    public function treeAction()
    {
        $db = $this->container->get("arii_core.db");
        $data = $db->Connector("tree");
        
        # Tableau des connections
        $sql = $this->container->get("arii_core.sql");
        $data->sort("NAME");
        
        $data->render_table("ARII_ZONE","ID","NAME","","PARENT_ID");
    }

    public function selectAction()
    {
        $sql = $this->container->get("arii_core.sql");
        $qry = $sql->Select(array("ID","NAME","PARENT_ID"))
               .$sql->From(array("ARII_ZONE"))
               .$sql->OrderBy(array("NAME")); 
        
        $db = $this->container->get('arii_core.db');
        $data = $db->Connector('data');
        $res = $data->sql->query($qry);
        $Cat = array();
        $Label = array( 0 => '' );
        while ($line = $data->sql->get_next($res)) {
            $id = $line['ID'];
            $name = $line['NAME'];
            $category = $line['PARENT_ID'];
            if ($category=="") $category=0;
            $Cat[$id] = $category;
            $Label[$id] = $name;     
        }

        $List = array();
        foreach ($Label as $k=>$v) {
            $label = $v;
            $cat = $k;
            while (isset($Cat[$cat])) {
                $c = $Cat[$cat];
                $label = $Label[$c]."/$label";
                $cat = $c;
            }
            $List[$k] = $label;
        }
        ksort($List);

        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        $list = '<?xml version="1.0" encoding="UTF-8"?>';
        $list .= "<data>";
        foreach ($List as $k=>$v) {
            $list .= '<item value="'.$k.'" label="'.$v.'"/>';
        }
        $list .= "</data>";
        $response->setContent( $list );
        return $response;             
    }
    
}
