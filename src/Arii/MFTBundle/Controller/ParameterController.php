<?php
// src/Arii/MFTBundle/Controller/TransfersController.php

namespace Arii\MFTBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ParameterController extends Controller
{
    public function toolbarAction()
    {        
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');    
        return $this->render('AriiMFTBundle:Parameter:toolbar.xml.twig',array(), $response );
    }
    
    public function formAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        $sql = $this->container->get('arii_core.sql');    
        $sql->setDriver($this->container->getParameter('database_driver'));
        
        $qry = $sql->Select(array('ID','NAME','TITLE','DESCRIPTION','PARTNER_ID','STEP_START','STEP_END','CHANGE_TIME','CHANGE_USER','ENV'))
                .$sql->From(array('MFT_PARAMETERS'))
                .$sql->Where(array('ID' => $id));
        
        $dhtmlx = $this->container->get('arii_core.db');
        $data = $dhtmlx->Connector('form');
        $data->render_sql($qry,'ID','ID,NAME,TITLE,DESCRIPTION,PARTNER_ID,STEP_START,STEP_END,CHANGE_TIME,CHANGE_USER,ENV');
    }

    public function connectionAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        $sql = $this->container->get('arii_core.sql');    
        
        $qry = $sql->Select(array('ID','TITLE','DESCRIPTION','HOST','INTERFACE','PORT','LOGIN','PASSWORD','PROTOCOL','PKEY','CATEGORY_ID'))
                .$sql->From(array('ARII_CONNECTION'))
                .$sql->Where(array('ID' => $id));
        
        $dhtmlx = $this->container->get('arii_core.db');
        $data = $dhtmlx->Connector('form');
        $data->render_sql($qry,'ID','ID','TITLE,DESCRIPTION,HOST,INTERFACE,PORT,LOGIN,PASSWORD,PROTOCOL,PKEY,CATEGORY_ID');
    }

    public function optionsAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        $sql = $this->container->get('arii_core.sql');    
        
        $Fields = array('ID','TITLE','NAME','DESCRIPTION','TRANSACTIONAL','CONCURRENT_TRANSFER','COMPRESS_FILES',
                'ATOMIC_SUFFIX','ATOMIC_PREFIX',
                'SOURCE_REPLACEMENT','SOURCE_REPLACING',
                'TARGET_REPLACEMENT','TARGET_REPLACING',
                'POLLING','POLL_INTERVAL','POLL_TIMEOUT',
                'RECURSIVE',
                'PRE_COMMAND','PRE_COMMAND_STR',
                'POST_COMMAND','POST_COMMAND_STR',
                'MAIL_ON_ERROR','MAIL_ON_ERROR_TO','MAIL_ON_ERROR_SUBJECT',
                'MAIL_ON_SUCCESS','MAIL_ON_SUCCESS_TO','MAIL_ON_SUCCESS_SUBJECT',
                'APPEND_FILES','OVERWRITE_FILES',
                'CONCURRENT_TRANSFER','MAX_CONCURRENT_TRANSFERS',
                'COMPRESS_FILES','COMPRESSED_FILE_EXTENSION'
            );
        $qry = $sql->Select($Fields)
                .$sql->From(array('MFT_PARAMETERS'))
                .$sql->Where(array('ID' => $id));
        
        $dhtmlx = $this->container->get('arii_core.db');
        $data = $dhtmlx->Connector('form');
        // $data->event->attach("beforeRender", array( $this, "form_render") );
        $data->render_sql($qry,'ID','ID',implode(',',$Fields).',POLLING');
    }
    
    function form_render($row){
        $row->set_value("POLLING",$row->get_value("POLL_INTERVAL")>0);
    }
    
    public function structAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        return $this->render("AriiMFTBundle:Parameter:parameter.json.twig",array(), $response );
    }

    public function struct_optionsAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        return $this->render("AriiMFTBundle:Parameter:options.json.twig",array(), $response );
    }

    public function struct_connectionAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        return $this->render("AriiMFTBundle:Parameter:connection.json.twig",array(), $response );
    }

    public function connectionsSelectAction($field = 'SOURCE_ID')
    {
        $sql = $this->container->get('arii_core.sql');    
        
        $qry = $sql->Select(array('ID as $field','TITLE'))
                .$sql->From(array('ARII_CONNECTION'))
                ." where PROTOCOL in ('sftp') "
                .$sql->OrderBy(array('TITLE'));
        
        $db = $this->container->get('arii_core.db');
        $data = $db->Connector('select');
        $data->render_sql($qry,$field,"$field,TITLE");
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
       
        $db = $this->container->get("arii_core.db");
        $data = $db->Connector('data');

        // verifier si il est utilisé !
        // 
        // supressions du transfers
        $qry1 = "DELETE FROM MFT_PARAMETERS WHERE ID=$id";
        $res = $data->sql->query($qry1);
        
        return new Response("success");
    }

    public function deleteDHTMLXAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
       
        $em = $this->getDoctrine()->getEntityManager();
        $parameter = $em->getRepository('AriiMFTBundle:Parameters')->find($id);

        if (!$parameter) {
            throw $this->createNotFoundException($id);
        }

        $em->remove($parameter);
        $em->flush();
        
        return new Response("success");
    }

    public function saveAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->request->get('ID');
        
        $parameters = new \Arii\MFTBundle\Entity\Parameters();
        if($id!="")
            $parameters = $this->getDoctrine()->getRepository("AriiMFTBundle:Parameters")->find($id);
        
        $parameters->setName(           $request->request->get('NAME'));
        $parameters->setTitle(          $request->request->get('TITLE'));
        $parameters->setDescription(    $request->request->get('DESCRIPTION'));
        $parameters->setRecursive(         $request->request->get('RECURSIVE')?1:0);
        $parameters->setErrorWhenNoFiles(  $request->request->get('ERROR_WHEN_NO_FILES')?1:0);
        $parameters->setOverwriteFiles(    $request->request->get('OVERWRITE_FILES')?1:0);
        $parameters->setRemoveFiles(    $request->request->get('REMOVE_FILES')?1:0);

        $parameters->setTransactional(     $request->request->get('TRANSACTIONAL')?1:0);
        $parameters->setAtomicSuffix(     $request->request->get('ATOMIC_SUFFIX'));
        $parameters->setAtomicPrefix(     $request->request->get('ATOMIC_PREFIX'));
                
        $parameters->setConcurrentTransfer($request->request->get('CONCURRENT_TRANSFER')?1:0);
        $parameters->setMaxConcurrentTransfers($request->request->get('MAX_CONCURRENT_TRANSFERS'));
        
        $parameters->setCompressFiles(     $request->request->get('COMPRESS_FILES')?1:0);
        $parameters->setCompressedFileExtension(     $request->request->get('COMPRESSED_FILE_EXTENSION'));
        
        $parameters->setZeroByteTransfer(  $request->request->get('ZERO_BYTE_TRANSFER')?1:0);
        $parameters->setForceFiles(        $request->request->get('FORCE_FILES')?1:0);
        
        $parameters->setPolling(   $request->request->get('POLLING')?1:0 );
        $parameters->setPollInterval(   $request->request->get('POLL_INTERVAL') );
        $parameters->setPollTimeout(    $request->request->get('POLL_TIMEOUT') );
        
        $parameters->setPreCommand( $request->request->get('PRE_COMMAND')?1:0);        
        $parameters->setPostCommand( $request->request->get('POST_COMMAND')?1:0);
        $parameters->setPreCommandStr( $request->request->get('PRE_COMMAND_STR'));        
        $parameters->setPostCommandStr( $request->request->get('POST_COMMAND_STR'));
        
        $parameters->setMailOnError( $request->request->get('MAIL_ON_ERROR')?1:0 );
        $parameters->setMailOnErrorTo( $request->request->get('MAIL_ON_ERROR_TO') );
        $parameters->setMailOnErrorSubject( $request->request->get('MAIL_ON_ERROR_SUBJECT') );

        $parameters->setMailOnSuccess( $request->request->get('MAIL_ON_SUCCESS')?1:0 );
        $parameters->setMailOnSuccessTo( $request->request->get('MAIL_ON_SUCCESS_TO') );
        $parameters->setMailOnSuccessSubject( $request->request->get('MAIL_ON_SUCCESS_SUBJECT') );
        
        $parameters->setSourceReplace( $request->request->get('SOURCE_REPLACE')?1:0 );
        $parameters->setSourceReplacing( $request->request->get('SOURCE_REPLACING') );
        $parameters->setSourceReplacement( $request->request->get('SOURCE_REPLACEMENT') );
        
        $parameters->setTargetReplace( $request->request->get('TARGET_REPLACE')?1:0 );
        $parameters->setTargetReplacing( $request->request->get('TARGET_REPLACING') );
        $parameters->setTargetReplacement( $request->request->get('TARGET_REPLACEMENT') );

        $em = $this->getDoctrine()->getManager();
        
        $em->persist($parameters);
        $em->flush();
        
        return new Response('success');
    }
    
    // Pour Yade par défaut
    public function docAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');

        $parameters = $this->getDoctrine()->getRepository("AriiMFTBundle:Parameters")->find($id);
                
        // Creation du .ini
        $ini = '<pre>';
        $ini .= '['.$parameters->getName()."]\n";
        $ini .= ';'.$parameters->getTitle()."\n";
        $ini .= ';'.$parameters->getDescription()."\n";
        if ($parameters->getTransactional()) {
            $ini .= "transactional=true\n";
            if ($parameters->getAtomicPrefix()!='')
                $ini .= "atomic_prefix=".$parameters->getAtomicPrefix()."\n";
            if ($parameters->getAtomicSuffix()!='')
                $ini .= "atomic_suffix=".$parameters->getAtomicSuffix()."\n";
        }
        
        if ($parameters->getConcurrentTransfer()) {
            $ini .= "concurrent_transfer=true\n";
            $ini .= "max_concurrent_transfers=".$parameters->getConcurrentTransfer()."\n";
        }

        if ($parameters->getPreCommand()!='')
            $ini .= "pre_command=".$parameters->getPreCommandStr()."\n";
        if ($parameters->getPostCommand()!='')
            $ini .= "post_command=".$parameters->getPostCommandStr()."\n";
       
        if ($parameters->getPolling()) {
            if ($parameters->getPollInterval()>0)
            $ini .= "poll_interval=".$parameters->getPollInterval()."\n";
            if ($parameters->getPollTimeout()>0)
                $ini .= "poll_timeout=".$parameters->getPollTimeout()."\n";
        }
        
        if ($parameters->getMailOnError()) {
            $ini .= "mail_on_error=true\n";
            if ($parameters->getMailOnErrorTo()) {
                $ini .= "mail_on_error_to=".$parameters->getMailOnErrorTo()."\n";
            }
            if ($parameters->getMailOnErrorSubject()!='') {
                $ini .= "mail_on_error_subject=".$parameters->getMailOnErrorSubject()."\n";                    
            }
        }
        
        if ($parameters->getMailOnSuccess()) {
            $ini .= "mail_on_success=true\n";
            if ($parameters->getMailOnSuccessTo()) {
                $ini .= "mail_on_success_to=".$parameters->getMailOnSuccessTo()."\n";
            }
            if ($parameters->getMailOnSuccessSubject()!='') {
                $ini .= "mail_on_success_subject=".$parameters->getMailOnSuccessSubject()."\n";                    
            }
        }
        
        if ($parameters->getSourceReplace()) {
            $ini .= "source_replacing=".$parameters->getSourceReplacing()."\n";
            $ini .= "source_replacement=".$parameters->getSourceReplacement()."\n";
        }
        if ($parameters->getTargetReplace()) {
            $ini .= "target_replacing=".$parameters->getTargetReplacing()."\n";
            $ini .= "target_replacement=".$parameters->getTargetReplacement()."\n";
        }

        if ($parameters->getRemoveFiles()) {
            $ini .= "remove_files=true\n";
        }
        
        $ini .= '</pre>';
                
        $response = new Response();
        $response->setContent( $ini );
        return $response;        
    }
}
