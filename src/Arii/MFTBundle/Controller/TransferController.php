<?php
// src/Arii/MFTBundle/Controller/TransfersController.php

namespace Arii\MFTBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class TransferController extends Controller
{
    public function indexAction()
    {        
        $request = Request::createFromGlobals();
        if ($request->get('id')!='')
            $id = $request->get('id');
        else
            $id = -1;
        
        return $this->render('AriiMFTBundle:Transfer:index.html.twig',array('id'=>$id));
    }
    
    public function toolbarAction()
    {        
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');    
        return $this->render('AriiMFTBundle:Transfer:toolbar.xml.twig',array(), $response );
    }

    public function formAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        $sql = $this->container->get('arii_core.sql');    
        $sql->setDriver($this->container->getParameter('database_driver'));
        
        $qry = $sql->Select(array('ID','NAME','TITLE','DESCRIPTION','PARTNER_ID','STEP_START','STEP_END','CHANGE_TIME','CHANGE_USER','ENV',
                'PARTNER_ID as ID_PARTNER','STEPS','SCHEDULE_ID','0 as TIME')) // bug selection liste
                .$sql->From(array('MFT_TRANSFERS'))
                .$sql->Where(array('ID' => $id));
        
        $dhtmlx = $this->container->get('arii_core.db');
        $data = $dhtmlx->Connector('form');
        $data->event->attach("beforeRender",array($this,"form_render"));
        $data->render_sql($qry,'ID','ID,NAME,TITLE,DESCRIPTION,PARTNER_ID,ID_PARTNER,STEP_START,STEP_END,CHANGE_TIME,CHANGE_USER,ENV,STEPS,SCHEDULE_ID,TIME');
    }

    function form_render ($data){
        $time = ($data->get_value('SCHEDULE_ID')==''?0:1);
        $data->set_value('TIME',$time);
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
        
        $qry = $sql->Select(array('ID','TITLE','DESCRIPTION','TRANSACTIONAL','ATOMIC_TRANSFER','CONCURRENT_TRANSFER','COMPRESS_FILES'))
                .$sql->From(array('MFT_PARAMETERS'))
                .$sql->Where(array('ID' => $id));
        
        $dhtmlx = $this->container->get('arii_core.db');
        $data = $dhtmlx->Connector('form');
        $data->render_sql($qry,'ID','ID','TITLE,DESCRIPTION,TRANSACTIONAL,ATOMIC_TRANSFER,CONCURRENT_TRANSFER,COMPRESS_FILES');
    }
   
    public function structAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        return $this->render("AriiMFTBundle:Transfer:transfer.json.twig",array(), $response );
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
       
        $em = $this->getDoctrine()->getEntityManager();
        $transfer = $em->getRepository('AriiMFTBundle:Transfers')->find($id);

        if (!$transfer) {
            throw $this->createNotFoundException($id);
        }

        $em->remove($transfer);
        $em->flush();
        
        return new Response("success");
    }

    public function saveAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->request->get('ID');
         
        $transfer = new \Arii\MFTBundle\Entity\Transfers();
        if($id!="") {
            $transfer = $this->getDoctrine()->getRepository("AriiMFTBundle:Transfers")->find($id);
            
            // On retrouve les operations pour verifier le nombre d'etapes ?
        }
        $transfer->setName(         $request->request->get('NAME'));
        $transfer->setTitle(        $request->request->get('TITLE'));
        $transfer->setDescription(  $request->request->get('DESCRIPTION'));
        $transfer->setStepStart(    $request->request->get('STEP_START'));
        $transfer->setStepEnd(      $request->request->get('STEP_END'));
        $transfer->setSteps(        $request->request->get('STEPS'));
        $transfer->setEnv(          $request->request->get('ENV'));
        if ($request->request->get('TIME')) {
            $schedule = $this->getDoctrine()->getRepository("AriiMFTBundle:Schedules")->find($request->request->get('SCHEDULE_ID'));
            $transfer->setSchedule($schedule);
        }
        else {
            $transfer->setSchedule(NULL);
        }
        
        $transfer->setChangeTime(    new \DateTime());
        
        // on teste si il est anonyme
        $securityContext = $this->container->get('security.context');
        // est ce qu'il y a un tocken ?
        if( $securityContext->getToken() ) {
            $usr = $securityContext->getToken()->getUsername();
            $transfer->setChangeUser( $usr );
        }
        else {
            $transfer->setChangeUser( 'anonymous' );
        }
        
        if ($request->request->get('PARTNER_ID')!='') {
            $Partner = $this->getDoctrine()->getRepository("AriiMFTBundle:Partners")->find( $request->request->get('PARTNER_ID') );        
            if (!$Partner) 
                $Partner = new \Arii\MFTBundle\Entity\Partners();
            $transfer->setPartner($Partner);
        }
           
        $em = $this->getDoctrine()->getManager();
        
        $em->persist($transfer);
        $em->flush();
        
        return new Response('success');
    }

    public function docAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');

        $em = $this->getDoctrine()->getEntityManager();
        $transfer = $em->getRepository('AriiMFTBundle:Transfers')->find($id);

        if (!$transfer) {
            throw $this->createNotFoundException($id);
        }
        
        $Transfer['id'] =           $transfer->getId();
        $Transfer['title'] =        $transfer->getTitle();
        $Transfer['name'] =         $transfer->getName();
        $Transfer['description'] =  $transfer->getDescription();
        $Transfer['env'] =          $transfer->getEnv();
        $Transfer['steps'] =        $transfer->getSteps();
        
        $partner = $transfer->getPartner();
        $Partner = array();
        if ($partner) {
            $Partner['name'] = $partner->getName();
            $Partner['title'] = $partner->getTitle();
            $Partner['description'] = $partner->getDescription();
        }
                
        $schedule = $transfer->getSchedule();
        $Schedule = array();
        if ($schedule) {
            $Schedule['name'] = $schedule->getName();
            $Schedule['title'] = $schedule->getTitle();
            $Schedule['description'] = $schedule->getDescription();
            $Schedule['minutes'] = $schedule->getMinutes();
            $Schedule['hours'] = $schedule->getHours();
            $Schedule['month_days'] = $schedule->getMonthDays();
            $Schedule['week_days'] = $schedule->getWeekDays();
            $Schedule['months'] = $schedule->getMonths();
            $Schedule['years'] = $schedule->getYears();
        }
        
        $operations = $em->getRepository('AriiMFTBundle:Operations')->findBy( array( 'transfer' => $transfer ), array('step' => 'ASC'));
        $Operations = array();
        foreach ($operations as $operation) {
            $id = $operation->getStep();
            $Operations[$id]['title'] = $operation->getTitle();
            $Operations[$id]['name'] = $operation->getName();
            $Operations[$id]['env'] = $operation->getEnv();
            $Operations[$id]['ordering'] = $operation->getOrdering();
            $Operations[$id]['description'] = $operation->getDescription();
            $Operations[$id]['source_path'] = $operation->getSourcePath();
            $Operations[$id]['target_path'] = $operation->getTargetPath();
            $Operations[$id]['source_files'] = $operation->getSourceFiles();
            $Operations[$id]['target_files'] = $operation->getTargetFiles();
            $Operations[$id]['expected_files'] = $operation->getExpectedFiles();
            $Operations[$id]['exit_if_nothing'] = $operation->getExitIfNothing();
            
            // Parameters
            $parameters = $operation->getParameters();
            $Parameters = array();
            if ($parameters) {
                $Parameters['name'] = $parameters->getName();
                $Parameters['title'] = $parameters->getTitle();
                $Parameters['description'] = $parameters->getDescription();
                $Parameters['recursive'] = $parameters->getRecursive();
                $Parameters['error_when_no_files'] = $parameters->getErrorWhenNoFiles();
                $Parameters['concurrent_transfer'] = $parameters->getConcurrentTransfer();
                $Parameters['max_concurrent_transfers'] = $parameters->getMaxConcurrentTransfers();
                $Parameters['zero_byte_transfer'] = $parameters->getZeroByteTransfer();
                $Parameters['force_files'] = $parameters->getForceFiles();
                $Parameters['compress_files'] = $parameters->getCompressFiles();
                $Parameters['compressed_file_extension'] = $parameters->getCompressedFileExtension();
                $Parameters['remove_files'] = $parameters->getRemoveFiles();
                $Parameters['transactional'] = $parameters->getTransactional();
                $Parameters['atomic_prefix'] = $parameters->getAtomicPrefix();
                $Parameters['atomic_suffix'] = $parameters->getAtomicSuffix();
                $Parameters['mail_on_error'] = $parameters->getMailOnError();
                $Parameters['mail_on_error_to'] = $parameters->getMailOnErrorTo();
                $Parameters['mail_on_error_subject'] = $parameters->getMailOnErrorSubject();
                $Parameters['polling'] = $parameters->getPolling();
                $Parameters['poll_interval'] = $parameters->getPollInterval();
                $Parameters['poll_timeout'] = $parameters->getPollTimeout();
                $Parameters['source_replace'] = $parameters->getSourceReplace();
                $Parameters['source_replacing'] = $parameters->getSourceReplacing();
                $Parameters['source_replacement'] = $parameters->getSourceReplacement();
                $Parameters['target_replace'] = $parameters->getTargetReplace();
                $Parameters['target_replacing'] = $parameters->getTargetReplacing();
                $Parameters['target_replacement'] = $parameters->getTargetReplacement();
                $Parameters['pre_command'] = $parameters->getPreCommand();
                $Parameters['pre_command_str'] = $parameters->getPreCommandStr();
                $Parameters['post_command'] = $parameters->getPostCommand();
                $Parameters['post_command_str'] = $parameters->getPostCommandStr();
            }
            $Operations[$id]['parameters'] = $Parameters;
                       
            // Source
            $source = $operation->getSource();
            $Source = array();
            if ($source) {
                $Source['title'] = $source->getName();
                $Source['description'] = $source->getDescription();
                $Source['host'] = $source->getHost();
                $Source['interface'] = $source->getInterface();
                $Source['protocol'] = $source->getProtocol();
                $Source['login'] = $source->getLogin();
                $Source['pkey'] = $source->getKey();                
            }
            $Operations[$id]['source'] = $Source;
            
            // Target
            $target = $operation->getTarget();
            $Target = array();
            if ($target) {
                $Target['title'] = $target->getName();
                $Target['description'] = $target->getDescription();
                $Target['host'] = $target->getHost();
                $Target['interface'] = $target->getInterface();
                $Target['protocol'] = $target->getProtocol();
                $Target['login'] = $target->getLogin();
                $Target['pkey'] = $target->getKey();
            }
            $Operations[$id]['target'] = $Target;
        }
        
        $response = new Response();
        return $this->render('AriiMFTBundle:Transfer:bootstrap.html.twig', 
                array(  'Transfer' => $Transfer, 
                        'Partner' => $Partner,
                        'Schedule' => $Schedule,
                        'Operations' => $Operations ), 
                        $response );
    }
  
    // conversion du transfer en operation
    public function transfer2operationAction()
    {
        $request = Request::createFromGlobals();
        $parent_id = $request->get('parent_id');
        $transfer_id = $request->get('transfer_id');
        $operation_id = $request->get('operation_id');
        
        $em = $this->getDoctrine()->getEntityManager();
        // Transfert actuel
        $Parent = $em->getRepository('AriiMFTBundle:Transfers')->find($parent_id);
        if (!$Parent)
            throw new \Exception("Transfer $parent_id not found !");
        
        // operation
        $Transfer = $em->getRepository('AriiMFTBundle:Transfers')->find($transfer_id);
        if (!$Transfer)
            throw new \Exception("Transfer $transfer_id not found !");

        $name = $Transfer->getName();
        // Est ce que c'est une opération
        $Operation = $em->getRepository('AriiMFTBundle:Operations')->findOneBy(['name' => $name]);
        if (!$Operation)
            throw new \Exception("Operation '$name' does not exist !");

        // on affecte l'opération au transfert
        $Operation->setTransfer($Parent);        
        // Position de l'operation dans le transfer
        if ($operation_id!='undefined') { // a la fin 
            $Last = $em->getRepository('AriiMFTBundle:Operations')->find($operation_id);            
            $step = $Last->getStep();
            $Operation->setStep($step);            
            $ordering = $Last->getOrdering();
            $Operation->setStep($ordering);
        }
        else {
            $step = $Parent->getStepEnd();
            $step += 10;
            $Operation->setStep($step);
            $Parent->setStepEnd($step);
        }        
        $em->persist($Operation);
        
        // on efface le transfert en doubkle 
        $em->remove($Transfer);
        
        $em->flush();
        
        return new Response('success');
    }
}
