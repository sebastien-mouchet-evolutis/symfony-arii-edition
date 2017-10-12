<?php

namespace Arii\TimeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class RulesController extends Controller
{
    public function indexAction()
    {
        return $this->render('AriiTimeBundle:Rules:index.html.twig');
    }

    public function toolbarAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render('AriiTimeBundle:Rules:toolbar.xml.twig',array(), $response );
    }
    
    public function formAction() {
        $em = $this->getDoctrine()->getManager();
        $request = $this->getRequest();
        $request->getLocale();
        $id = $request->get( 'id' );
        $Rules = $em->getRepository("AriiTimeBundle:Rules")->findRule($id);        

        $dhtmlx = $this->container->get('arii_core.render'); 
        return $dhtmlx->form($Rules,'id,name,title,description,rule,zone_id');        
    }

    public function gridAction() {        
        $em = $this->getDoctrine()->getManager();
        $request = $this->getRequest();
        $request->getLocale();
        $Rules = $em->getRepository("AriiTimeBundle:Rules")->findRules();        
        
        $dhtmlx = $this->container->get('arii_core.render'); 
        return $dhtmlx->grid($Rules,'name,title,description,rule');        
    }
    
    public function treeAction() {
        $sql = $this->container->get('arii_core.sql');                  
        $qry = $sql->Select(array('ID','NAME','COMMENT','PARENT_ID'))
                .$sql->From(array('TC_ZONES'))
                .$sql->OrderBy(array('NAME'));

        $db = $this->container->get('arii_core.db');
        $data = $db->Connector('tree');
//        $data->event->attach("beforeRender",array($this,"form_render"));
        $data->render_table('TC_ZONES','ID','NAME','COMMENT','PARENT_ID');
    }
    
    public function testAction() {
        $request = $this->getRequest();
        $locale = $request->getLocale();
        $rule =$request->get( 'rule' );
        
        // Appel du service timecode
        $tc = $this->container->get('arii_time.timecode');

        setlocale(LC_ALL, 'fr_FR.utf8','fra');
        $year = 2015;
        $grid = "<?xml version='1.0' encoding='utf-8' ?>\n<rows>\n";
        for($i=0;$i<=30;$i++) {
            $date = $tc->Date2ISO($tc->Reference($rule,$year+$i));
            $grid .= "<row><cell>".$date."</cell></row>\n";            
        }
        $grid .= "</rows>";
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        $response->setContent( $grid );
        return $response;
    }

    public function saveAction() {
        $request = $this->getRequest();
        $id =$request->get( 'id' );
        
        // connexion base de données
        $em = $this->getDoctrine()->getManager();
        
        $rules = new \Arii\TimeBundle\Entity\Rules();
        if ($id!="") {
            $rules = $em->getRepository("AriiTimeBundle:Rules")->find($id);
            
            // Suppression des dates deja calculées
            $days = $em->getRepository("AriiTimeBundle:Holidays")->findBy(array('rule'=>$id));
            foreach ($days as $d) {
                $em->remove($d);
                $em->flush();
            }
        }
        
        $rule = $request->get( 'rule' ); 
        $rules->setRule ( $rule );
        $rules->setName ( $request->get( 'name' ) );
        $rules->setTitle( $request->get( 'title' ) );
        $rules->setDescription( $request->get( 'description' ) );
        
        $rules->setUpdated(new \DateTime());
        
        $em->persist($rules);
        
        // On rajoute les dates
        // Appel du service timecode
        $tc = $this->container->get('arii_time.timecode');
        $year = 2000;
        for($i=0;$i<50;$i++) {
            $date = $tc->Date2ISO($tc->Reference($rule,$year+$i));
            $days = new \Arii\TimeBundle\Entity\Holidays();
            $days->setRule($rules);
            $days->setDay(new \DateTime($date));
            $em->persist($days);
        }
        
        $em->flush();
        
        print $this->get('translator')->trans('Rule saved');
        exit();
    }
    
    public function scheduleAction() {
        $sql = $this->container->get('arii_core.sql'); 
        $sql->setDriver($this->container->getParameter('database_driver'));
        
        $request = $this->getRequest();
        $locale = $request->getLocale();
        $rule =$request->query->get( 'rule' );

        // Appel du service timecode
        $tc = $this->container->get('arii_time.timecode');
        $year = 2010;
        $grid = "<?xml version='1.0' encoding='utf-8' ?>\n<data>\n";
        for($i=0;$i<10;$i++) {
            $grid .= "<event>";
            $date = $tc->Date2ISO($tc->Reference($rule,$year+$i));
            $grid .= "<text>$rule</text><start_date>$date</start_date><end_date>$date</end_date><color>red</color>\n";            
            $grid .= "</event>";
        }
        $grid .= "</data>";
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        $response->setContent( $grid );
        return $response;
    }

}
