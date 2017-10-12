<?php
// src/Arii/MFTBundle/Controller/HistoryController.php

namespace Arii\MFTBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class HistoryController extends Controller
{
    public function indexAction()
    {       
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        
        return $this->render('AriiMFTBundle:History:index.html.twig', array('id' => $id ));
    }

    public function chartAction()
    {
        $request = Request::createFromGlobals();
        $transfer_id = $request->get('transfer_id');
        if ($transfer_id=='') exit();
        
        $history = $this->container->get('arii_mft.mft');
        $Transfers = $history->Histories($transfer_id);

        $grid = '<data>';        
        foreach ($Transfers as $k=>$Transfer) {
            $grid .= '<item id="'.$k.'">';
            $grid .= "<CHRONO>".strtotime($Transfer['STATUS_TIME'])."</CHRONO>";            
            $grid .= "<STATUS_TIME>".$Transfer['STATUS_TIME']."</STATUS_TIME>";
            $grid .= "<STATE>".$Transfer['STATE']."</STATE>";            
            $grid .= "<RUN>".$Transfer['RUN']."</RUN>";            
            $grid .= "<COUNT>".$Transfer['COUNT']."</COUNT>"; 
            $grid .= "<SIZE>".$Transfer['SIZE']."</SIZE>"; 
            switch ($Transfer['STATE']) {
                case 'FAILED':
                    $grid .= "<COLOR>red</COLOR>"; 
                    break;
                case 'SUCCESS':
                    $grid .= "<COLOR>green</COLOR>"; 
                    break;
                case 'RUNNING':
                    $grid .= "<COLOR>orange</COLOR>"; 
                    break;
                case 'ABORT':
                    $grid .= "<COLOR>grey</COLOR>"; 
                    break;
                default:
                    $grid .= "<COLOR>".$Transfer['COLOR']."</COLOR>";         
                    break;
            }            
            $grid .= "<LAST_ERROR>".$Transfer['LAST_ERROR']."</LAST_ERROR>"; 
            $grid .= "</item>";
        }
        $grid.='</data>';
        
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        $response->setContent( $grid );
        return $response;
    }
    
    public function gridAction( $transfer_id=-1 )
    {
        $request = Request::createFromGlobals();
        if ($request->get('transfer_id')>0)
            $transfer_id = $request->get('transfer_id');

        // a repasser dans un nouveau service em
        // $history = $this->container->get('arii_mft.mft');
        // $Transfers = $history->Histories($transfer_id);
        
        $grid = '<?xml version="1.0" encoding="UTF-8"?>';
        $grid .= "<rows>\n";
        $grid .= '<head>
            <afterInit>
                <call command="clearAll"/>
            </afterInit>
        </head>';

        $em = $this->getDoctrine()->getEntityManager();
        $Transfer = $em->getRepository('AriiMFTBundle:Transfers')->find( $transfer_id );
        if ($Transfer)
            $History = $em->getRepository('AriiMFTBundle:History')->findBy( [ 'transfer'  => $Transfer ] );
        else 
            throw $this->createNotFoundException($transfer_id);
        if (!$History)
            throw $this->createNotFoundException($id);

        $mft = $this->container->get('arii_mft.mft');        
        $Status = $mft->Status();            
        foreach ($History as $H) {
            $grid .= '<row id="'.$H->getId().'" style="background-color: '.$mft->ColorStatus($H->getStatus()).'">';
            $grid .= "<cell>".$H->getStatusTime()->format('Y-m-d H:i:s')."</cell>";
            $grid .= "<cell>".$H->getStatus()."</cell>";            
            $grid .= "<cell>".$H->getRun()."</cell>";            
            $grid .= "</row>";
        }
        $grid.='</rows>';
        
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        $response->setContent( $grid );
        return $response;
    }

    public function docAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('delivery_id');

        $em = $this->getDoctrine()->getEntityManager();
        $history = $em->getRepository('AriiMFTBundle:History')->find( $id );
        if (!$history)
            throw $this->createNotFoundException($id);

        $History['id'] =          $history->getId();
        $History['status'] =      $history->getStatus();
        $History['status_time'] = $history->getStatusTime()->format('Y-m-d H:i:s');
        $History['run'] =         $history->getRun();

        $transfer = $history->getTransfer();
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
  
        $operations = $em->getRepository('AriiMFTBundle:Operations')->findBy( [ 'transfer' => $transfer ] );
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

            // livraison
            $deliveries = $em->getRepository('AriiMFTBundle:Deliveries')->findBy( [ 'operation' => $operation, 'run' =>  $History['run'] ] );
            // eventuellement des reprises ?
            $Deliveries =[];
            foreach ($deliveries as $delivery) { 
                $try = $delivery->getTry();
                $Deliveries[$try]['log'] = $delivery->getLogOutput();
                $Deliveries[$try]['start_time'] = $delivery->getStartTime()->format('Y-m-d H:i:s');
                $Deliveries[$try]['end_time'] = $delivery->getEndTime()->format('Y-m-d H:i:s');
                $Deliveries[$try]['duration'] = $delivery->getDuration();
                $Deliveries[$try]['status'] = $delivery->getStatus();
                $Deliveries[$try]['status_text'] = $delivery->getStatusText();
                $Deliveries[$try]['files_count'] = $delivery->getFilesCount();
                $Deliveries[$try]['files_size'] = $delivery->getFilesSize();
                $Deliveries[$try]['success'] = $delivery->getSuccess();
                $Deliveries[$try]['skipped'] = $delivery->getSkipped();
                $Deliveries[$try]['failed'] = $delivery->getFailed();
                $Deliveries[$try]['last_error'] = $delivery->getLastError();
                $Deliveries[$try]['log_name'] = $delivery->getLogName();
            }
            $Operations[$id]['deliveries'] = $Deliveries;
            
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
            
        };

        $response = new Response();
        return $this->render('AriiMFTBundle:History:bootstrap.html.twig', 
            array(  
                'Transfer' => $Transfer,
                'History'  => $History,
                'Partner' => $Partner,
                'Schedule' => $Schedule,
                'Operations' => $Operations ), 
                $response );
    }

    // suivi graphique
    // Doctrine + Mermaid
    public function graphAction(Request $request)
    {
        $id = $request->query->get( 'history_id' );

        $em = $this->getDoctrine()->getEntityManager();
        $History = $em->getRepository('AriiMFTBundle:History')->find( $id );

        $uml = "sequenceDiagram\n";
        
        $Deliveries = $em->getRepository('AriiMFTBundle:Deliveries')->findBy( [ 'history' => $History ] );
        $n=0;
        foreach ($Deliveries as $Delivery) {  
            
            // On retrouve l'operation
            $Operation = $Delivery->getOperation();
            $From = $Operation->getSource();
            $To = $Operation->getTarget();

            $source = $From->getTitle();
            if ($source=='') $source = $From->getName();
            $target = $To->getTitle();
            if ($target=='') $target = $To->getName();
            
            if ($Delivery->getStartTime())
                $uml .= "Note over ".$source.": ".$Delivery->getStartTime()->format('Y-m-d H:i:s')."\n";
            
            $uml .= $source."->>".$target." : ".$Operation->getTitle()."\n";
            
            // On affiche les transmissions
            $Transmissions = $em->getRepository('AriiMFTBundle:Transmissions')->findBy( [ 'delivery' => $Delivery ] );
            $Files = [];
            foreach ($Transmissions as $Transmission) {
                if ($Transmission->getStatus()=='success')
                    array_push($Files, basename($Transmission->getSourceFile()));
                else 
                    array_push($Files, '['.basename($Transmission->getSourceFile()).']');
            }
            
            $uml .= "Note over ".$source.','.$target.": ".implode(',<br/>',$Files)."\n";
            $uml .= "Note over ".$target.": ".$Delivery->getEndTime()->format('Y-m-d H:i:s')."\n";
            $uml .= "Note right of ".$target.": ".$Delivery->getStatus()."\n";
            $n++;
        }

/*        $uml = '
    Alice ->> Bob: Hello Bob, how are you?
    Bob-->>John: How about you John?
    Bob--x Alice: I am good thanks!
    Bob-x John: I am good thanks!
    Note right of John: Bob thinks a long<br/>long time, so long<br/>that the text does<br/>not fit on a row.

    Bob-->Alice: Checking with John...
    Alice->John: Yes... John, how are you?';
*/        
        $mermaid = $this->container->get('arii_core.mermaid');
        return $mermaid->sequence($uml);
    }

    public function ganttAction(Request $request)
    {
        $id = $request->query->get( 'history_id' );

        $em = $this->getDoctrine()->getEntityManager();
        $History = $em->getRepository('AriiMFTBundle:History')->find( $id );

        $gantt = "gantt\n";
        $gantt .= "dateFormat YYYY-MM-DD H:m:s\n";
        
        $Transfer = $History->getTransfer();
        $gantt .= "title ".$Transfer->getTitle()."\n";
        
        $Deliveries = $em->getRepository('AriiMFTBundle:Deliveries')->findBy( [ 'history' => $History ] );
        $n=0;
        foreach ($Deliveries as $Delivery) {  
            
            // On retrouve l'operation
            $Operation = $Delivery->getOperation();
            $From = $Operation->getSource();
            $To = $Operation->getTarget();

            $source = $From->getTitle();
            if ($source=='') $source = $From->getName();
            $target = $To->getTitle();
            if ($target=='') $target = $To->getName();
            
            $gantt .= "section $source -> $target\n";
            
            if ($Delivery->getStartTime())
                $gantt .= $Delivery->getOperation()->getTitle()." :active,    des1, ".$Delivery->getStartTime()->format('Y-m-d H:i:s').",".$Delivery->getEndTime()->format('Y-m-d H:i:s')."\n";
            
            // On affiche les transmissions
            $Transmissions = $em->getRepository('AriiMFTBundle:Transmissions')->findBy( [ 'delivery' => $Delivery ] );
            foreach ($Transmissions as $Transmission) {
                $gantt .= basename($Transmission->getSourceFile())." :done,    crit, ".$Transmission->getStartTime()->format('Y-m-d H:i:s').",".$Transmission->getEndTime()->format('Y-m-d H:i:s')."\n";
            }
            $n++;
        }

/*        $uml = '
    Alice ->> Bob: Hello Bob, how are you?
    Bob-->>John: How about you John?
    Bob--x Alice: I am good thanks!
    Bob-x John: I am good thanks!
    Note right of John: Bob thinks a long<br/>long time, so long<br/>that the text does<br/>not fit on a row.

    Bob-->Alice: Checking with John...
    Alice->John: Yes... John, how are you?';
*/        
        $mermaid = $this->container->get('arii_core.mermaid');
        return $mermaid->gantt($gantt);
    }
    
}
