<?php
// src/Arii/MFTBundle/Controller/TransfersController.php

namespace Arii\MFTBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class OperationController extends Controller
{
    public function toolbarAction()
    {        
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');    
        return $this->render('AriiMFTBundle:Operation:toolbar.xml.twig',array(), $response );
    }

    public function structAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        return $this->render("AriiMFTBundle:Operation:operation.json.twig",array(), $response );
    }

    public function formAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        $sql = $this->container->get('arii_core.sql');    
        
        $qry = $sql->Select(array('ID','NAME','TITLE','DESCRIPTION','TRANSFER_ID','SOURCE_ID','TARGET_ID','ENV','STEP','SOURCE_PATH','TARGET_PATH','SOURCE_FILES','TARGET_FILES','EXPECTED_FILES','EXIT_IF_NOTHING'))
                .$sql->From(array('MFT_OPERATIONS'))
                .$sql->Where(array('ID' => $id));
        
        $dhtmlx = $this->container->get('arii_core.db');
        $data = $dhtmlx->Connector('form');
        $data->render_sql($qry,'ID','ID,NAME,TITLE,DESCRIPTION,TRANSFER_ID,SOURCE_ID,TARGET_ID,ENV,STEP,SOURCE_PATH,TARGET_PATH,SOURCE_FILES,TARGET_FILES,EXPECTED_FILES,EXIT_IF_NOTHING');
    }

    public function connectionAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        $sql = $this->container->get('arii_core.sql');    
        
        $qry = $sql->Select(array('ID','TITLE','DESCRIPTION','HOST','INTERFACE','PORT','LOGIN','PASSWORD','PROTOCOL','PKEY'))
                .$sql->From(array('ARII_CONNECTION'))
                .$sql->Where(array('ID' => $id));
        
        $dhtmlx = $this->container->get('arii_core.db');
        $data = $dhtmlx->Connector('form');
        $data->render_sql($qry,'ID','ID','TITLE,DESCRIPTION,HOST,INTERFACE,PORT,LOGIN,PASSWORD,PROTOCOL,PKEY');
    }

    public function optionsAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        $sql = $this->container->get('arii_core.sql');    
        
        $qry = $sql->Select(array('ID','TRANSACTIONAL','ATOMIC_TRANSFER','CONCURRENT_TRANSFER','COMPRESS_FILES'))
                .$sql->From(array('MFT_PARAMETERS'))
                .$sql->Where(array('ID' => $id));
        
        $dhtmlx = $this->container->get('arii_core.db');
        $data = $dhtmlx->Connector('form');
        $data->render_sql($qry,'ID','ID','TRANSACTIONAL,ATOMIC_TRANSFER,CONCURRENT_TRANSFER,COMPRESS_FILES');
    }
   
    public function struct_optionsAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        return $this->render("AriiMFTBundle:Transfer:options.json.twig",array(), $response );
    }

    public function struct_connectionAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        return $this->render("AriiMFTBundle:Transfer:connection.json.twig",array(), $response );
    }

    public function connectionsSelectAction()
    {
        $sql = $this->container->get('arii_core.sql');    
        
        $qry = $sql->Select(array('ID','TITLE'))
                .$sql->From(array('ARII_CONNECTION'))
                ." where PROTOCOL in ('sftp','smb','local','http','http','https') "
                .$sql->OrderBy(array('TITLE'));
        
        $db = $this->container->get('arii_core.db');
        $data = $db->Connector('select');
        $data->render_sql($qry,'ID',"ID,TITLE");
    }

    public function parametersSelectAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        $sql = $this->container->get('arii_core.sql');    
        
        $qry = $sql->Select(array('ID','TITLE'))
                .$sql->From(array('MFT_PARAMETERS'))
                .$sql->OrderBy(array('TITLE'));
        
        $db = $this->container->get('arii_core.db');
        $data = $db->Connector('select');
        $data->render_sql($qry,'ID','ID,TITLE');
    }
    
    public function historyAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        $sql = $this->container->get('arii_core.sql');    
	        
        $qry = $sql->Select(array('GUID','TRANSFER_TIMESTAMP','PID','PPID','TARGET_HOST','TARGET_HOST_IP','OPERATION','TARGET_USER','TARGET_DIR','TARGET_FILENAME','PROTOCOL','PORT','STATUS','LAST_ERROR_MESSAGE'))
                .$sql->From(array('SOSFTP_FILES_HISTORY'))
                .$sql->Where(array('SOSFTP_ID' => $id));
        
        $dhtmlx = $this->container->get('arii_core.dhtmlx');
        $data = $dhtmlx->Connector('grid');
        $data->event->attach("beforeRender",array($this,"grid_render"));
        $data->render_sql($qry,'GUID','TRANSFER_TIMESTAMP,TARGET_HOST,TARGET_DIR,TARGET_FILENAME,STATUS,LAST_ERROR_MESSAGE');
    }

    function grid_render ($data){
        $mft = $this->container->get('arii_mft.mft');        
        $data->set_row_color($mft->ColorStatus($data->get_value('STATUS')));
    }

    public function deleteAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
       
        $em = $this->getDoctrine()->getEntityManager();
        $operation = $em->getRepository('AriiMFTBundle:Operations')->find($id);

        if (!$operation) {
            throw $this->createNotFoundException($id);
        }

        $em->remove($operation);
        $em->flush();
                
        return new Response("success");
    }
    
    public function deleteDHTMLXAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
       
        $db = $this->container->get("arii_core.db");
        $data = $db->Connector('data');

        $qry4 = "DELETE FROM MFT_TRANSMISSIONS WHERE DELIVERY_ID IN "
                ." (SELECT ID FROM MFT_DELIVERIES WHERE OPERATION_ID IN "
                ." (SELECT ID FROM MFT_OPERATIONS WHERE TRANSFER_ID=$id))";
        $res = $data->sql->query($qry4);
        
        $qry3 = "DELETE FROM MFT_DELIVERIES WHERE OPERATION_ID IN "
                ." (SELECT ID FROM MFT_OPERATIONS WHERE TRANSFER_ID=$id)";
        $res = $data->sql->query($qry3);
        
        // supressions des operations
        $qry2 = "DELETE FROM MFT_OPERATIONS WHERE TRANSFER_ID=$id";
        $res = $data->sql->query($qry2);
                
        return new Response("success");
    }
    
    public function saveAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->request->get('ID');
         
        $Operation = new \Arii\MFTBundle\Entity\Operations();
        if($id!="") {
            $Operation = $this->getDoctrine()->getRepository("AriiMFTBundle:Operations")->find($id);            
        }
        
        $Operation->setName(         $request->request->get('NAME'));
        $Operation->setTitle(        $request->request->get('TITLE'));
        $Operation->setDescription(  $request->request->get('DESCRIPTION'));
        $Operation->setEnv(  $request->request->get('ENV'));
        $Operation->setStep(  $request->request->get('STEP'));
        $Operation->setSourcePath(  $request->request->get('SOURCE_PATH'));
        $Operation->setTargetPath(  $request->request->get('TARGET_PATH'));
        $Operation->setSourceFiles(  $request->request->get('SOURCE_FILES'));
        $Operation->setExpectedFiles (  $request->request->get('EXPECTED_FILES'));
        $Operation->setExitIfNothing (  $request->request->get('EXIT_IF_NOTHING'));
        $Operation->setTargetFiles(  $request->request->get('TARGET_FILES'));
        $Operation->setClient(  $request->request->get('CLIENT'));
        
        if ($request->request->get('PARAMETERS_ID')!='') {
            $Parameters = $this->getDoctrine()->getRepository("AriiMFTBundle:Parameters")->find( $request->request->get('PARAMETERS_ID') );        
            if ($Parameters)
                $Operation->setParameters($Parameters);
        }
        if ($request->request->get('TRANSFER_ID')!='') {
            $Transfer = $this->getDoctrine()->getRepository("AriiMFTBundle:Transfers")->find( $request->request->get('TRANSFER_ID') );        
            if ($Transfer)
                $Operation->setTransfer($Transfer);
        }
        if ($request->request->get('SOURCE_ID')!='') {
            $Source = $this->getDoctrine()->getRepository("AriiCoreBundle:Connection")->find( $request->request->get('SOURCE_ID') );        
            if ($Source)
                $Operation->setSource($Source);
        }
        if ($request->request->get('TARGET_ID')!='') {
            $Target = $this->getDoctrine()->getRepository("AriiCoreBundle:Connection")->find( $request->request->get('TARGET_ID') );        
            if ($Target)
                $Operation->setTarget($Target);
        }
           
        $em = $this->getDoctrine()->getManager();
        
        $em->persist($Operation);                       
        $em->flush();
        
        // On remet a jour l'ordre des operations
        $Operations =  $this->getDoctrine()
                            ->getRepository("AriiMFTBundle:Operations")
                            ->findBy(array('transfer' => $Transfer), array('step' => 'ASC'));
        
        $n = 0;
        foreach ($Operations as $Operation) {
            $n++;
            $Operation->setOrdering($n);            
            $em->persist($Operation);
        }
        
        // on mets a juor le nombre de steps du transfert
        $Transfer->setSteps($n);            
        
        $em->flush();
        return new Response('success');
    }

}
