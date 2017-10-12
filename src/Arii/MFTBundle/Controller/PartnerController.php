<?php
// src/Arii/MFTBundle/Controller/TransfersController.php

namespace Arii\MFTBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class PartnerController extends Controller
{
    
    public function indexAction()
    {       
        $request = Request::createFromGlobals();
        if ($request->get('id')!='')
            $id = $request->get('id');
        else
            $id = -1;
        
        return $this->render('AriiMFTBundle:Partner:index.html.twig',array('id'=>$id ));
    }

    public function toolbarAction()
    {        
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');    
        return $this->render('AriiMFTBundle:Partner:toolbar.xml.twig',array(), $response );
    }

    public function structAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        
        return $this->render('AriiMFTBundle:Partner:form.json.twig',array(), $response );
    }
    
    public function formAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        $sql = $this->container->get('arii_core.sql');    
        
        $qry = $sql->Select(array('ID','NAME','TITLE','DESCRIPTION','CATEGORY_ID'))
                .$sql->From(array('MFT_PARTNERS'))
                .$sql->Where(array('ID' => $id));
        
        $dhtmlx = $this->container->get('arii_core.db');
        $data = $dhtmlx->Connector('form');
        $data->render_sql($qry,'ID','ID,CATEGORY_ID,NAME,TITLE,DESCRIPTION');
    }

    public function configAction($id=-1, $client="yade")
    {
        $request = Request::createFromGlobals();
        if ($id<>'')
            $id = $request->get('id');
        if ($request->get('client')<>'')
            $client = $request->get('client');
        
        $sql = $this->container->get('arii_core.sql');    
        
        $qry = $sql->Select(array(
                    'p.ID as PARTNER_ID','p.TITLE as PARTNER_TITLE','p.DESCRIPTION as PARTNER_DESCRIPTION',
                    't.ID as TRANSFER_ID','t.TITLE as TRANSFER_TITLE','t.DESCRIPTION as TRANSFER_DESCRIPTION',
                    'o.ID as OPERATION_ID','o.TITLE as OPERATION_TITLE','o.DESCRIPTION as OPERATION_DESCRIPTION',
                    'o.SOURCE_ID','o.TARGET_ID',
                    'o.*','a.*'))
               .$sql->From(array('MFT_PARTNERS p'))
               .$sql->LeftJoin('MFT_TRANSFERS t',array('p.ID','t.PARTNER_ID'))
               .$sql->LeftJoin('MFT_OPERATIONS o',array('t.ID','o.TRANSFER_ID'))
               .$sql->LeftJoin('MFT_PARAMETERS a',array('o.PARAMETERS_ID','a.ID'))
               .$sql->Where(array('p.ID' => $id));
        
        $dhtmlx = $this->container->get('arii_core.db');
        $data = $dhtmlx->Connector('data');
        
        // creation du tableau
        $res = $data->sql->query( $qry );
        $Infos = array();
        $Cnx = array();
        while ($line = $data->sql->get_next($res)) {
            $partner =  $line['PARTNER_TITLE'];
            $id = $line['SOURCE_ID'];
            if (!isset($Cnx[$id])) 
                $Cnx[$id]=1;            
            $id = $line['TARGET_ID'];
            if (!isset($Cnx[$id])) 
                $Cnx[$id]=1;            
            
            if (!isset($Infos[$partner])) {
                foreach (array('ID','DESCRIPTION') as $f) {
                    $Infos['PARTNERS'][$partner][$f] = $line['PARTNER_'.$f];
                }
            }
            $transfer = $line['TRANSFER_TITLE'];
            if (!isset($Infos[$partner]['TRANSFERS'][$transfer])) {
                foreach (array('ID','DESCRIPTION') as $f) {
                    $Infos['PARTNERS'][$partner]['TRANSFERS'][$transfer][$f] = $line['TRANSFER_'.$f];
                }
            }
            $operation = $line['OPERATION_TITLE'];
            if (!isset($Infos[$partner]['TRANSFERS'][$transfer]['OPERATIONS'][$operation])) {
                foreach (array('ID','DESCRIPTION') as $f) {
                    $Infos['PARTNERS'][$partner]['TRANSFERS'][$transfer]['OPERATIONS'][$operation][$f] = $line['OPERATION_'.$f];
                }
            }
            $operation = $line['OPERATION_TITLE'];
            if (!isset($Infos[$partner]['TRANSFERS'][$transfer]['OPERATIONS'][$operation])) {
                foreach (array('ID','DESCRIPTION') as $f) {
                    $Infos['PARTNERS'][$partner]['TRANSFERS'][$transfer]['OPERATIONS'][$operation][$f] = $line['OPERATION_'.$f];
                }
            }
            foreach ($line as $k=>$v) {
                $d = substr($k,0,8);
            //    if (($d!='PARTNER_') and ($d!='TRANSFER') and ($d!='OPERATIO')) {
                    $title = strtoupper($k);
                    $Infos['PARTNERS'][$partner]['TRANSFERS'][$transfer]['OPERATIONS'][$operation][$title] = $v;
            //    }
            }
       }
       
       // On complete avec les connexions
       if (count($Cnx)>0) {
            $qry = $sql->Select(array('*'))
                   .$sql->From(array('ARII_CONNECTION'))
                   ." where ID in (".implode(',',array_keys($Cnx)).")";

            // creation du tableau
            $res = $data->sql->query( $qry );
            while ($line = $data->sql->get_next($res)) {
                $title = $line['title'];
                $Infos['CONNECTIONS'][$title] = $line;
            }
        }
        
        // on passe les informations dans le bon generateur        
        $client = $this->container->get("arii_mft.$client");
        $response = new Response();
        $response->headers->set('Content-Type', 'text/plain');
        $response->setContent( $client->Convert($Infos) );
        return $response;      
    }
    
    public function saveAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->request->get('ID');
         
        $partner = new \Arii\MFTBundle\Entity\Partners();
        if($id!="")
            $partner = $this->getDoctrine()->getRepository("AriiMFTBundle:Partners")->find($id);
        
        $partner->setName(         $request->request->get('NAME'));
        $partner->setTitle(        $request->request->get('TITLE'));
        $partner->setDescription(  $request->request->get('DESCRIPTION'));
        
        if ($request->request->get('CATEGORY_ID')!='') {
            $category = $this->getDoctrine()->getRepository("AriiCoreBundle:Category")->find( $request->request->get('CATEGORY_ID') );        
            if (!$category) 
                $category = new \Arii\CoreBundle\Entity\Category();
            $partner->setCategory($category);
        }
           
        $em = $this->getDoctrine()->getManager();
        
        $em->persist($partner);
        $em->flush();
        
        return new Response('success');
    }

    public function deleteAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
       
        $em = $this->getDoctrine()->getEntityManager();
        $partner= $em->getRepository('AriiMFTBundle:Partners')->find($id);

        if (!$partner) {
            throw $this->createNotFoundException($id);
        }

        $em->remove($partner);
        $em->flush();
                
        return new Response("success");
    }
    
    public function deleteDHTMLXAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
       
        $db = $this->container->get("arii_core.db");
        $data = $db->Connector('data');

        // supressions du partenaire
        $qry1 = "DELETE FROM MFT_PARTNERS WHERE ID=$id";
        $res = $data->sql->query($qry1);
        
        return new Response("success");
    }
}
