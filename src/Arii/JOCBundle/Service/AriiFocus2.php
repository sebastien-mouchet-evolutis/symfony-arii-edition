<?php
namespace Arii\JOCBundle\Service;

class AriiFocus2
{
    protected $debug;
    protected $mode;
    protected $tools;
    protected $db;
    protected $em; 
    
    public function __construct( \Arii\CoreBundle\Service\AriiTools $tools, \Doctrine\ORM\EntityManager $em  ) {
        $this->tools = $tools;
        $this->em = $em;
    }

    public function get($spooler='localhost',$port='4444',$what='orders,job_chain_orders,job_orders,jobs,job_chains,schedules,remote_schedulers,payload,job_params',$mode="WEB",$debug=1) {
        set_time_limit ( 900 );
        $f= @fopen("http://$spooler:$port/%3Cshow_state%20what=%22$what%22/%3E","r");
        if (!$f) {
            print "$spooler:$port !";
            exit();
        }
        $data = '';
        while(!feof($f)) {
            $data .= fread($f,10240);
        }
        fclose($f);
        return $this->cache($data,$mode,$debug);
    }

    public function cache($data, $mode='',$debug) {   
        $this->PrintMessage(2,time());
        $this->debug = $debug;
        $this->mode = $mode;
        $maxtime = 900;
        set_time_limit ( $maxtime );
        
        $Result = $this->tools->xml2array( $data , 1, 'attributes');
        if (!isset($Result['spooler'])) {
            print "spooler inconnu ?!";
            exit();
        }
        
        $start = $timer = microtime(true);
        
        // Maintenant !
        $Now = new \DateTime () ;
        
        // Reponse du scheduler
        if (!isset($Result['spooler']['answer']['state'])) {
            print "ANSWER ?!";
            exit();
        } 
        
        // Scheduler
        $Scheduler = $Result['spooler']['answer']['state']['attr'];
        
        $spooler = $Scheduler['id'];
        $host = $Scheduler['host'];
        $port = $Scheduler['tcp_port'];
        $this->PrintMessage(0,"SPOOLER: $spooler ($host:$port)");
        
        $em = $this->em;
        // On retrouve l'entité par rapport au host et au port
        $Spooler = $em
                    ->getRepository( 'AriiJOCBundle:Spoolers')
                    ->findOneBy(array( 'host' => $host, 'tcp_port' => $port));

        if (!$Spooler) {
            $this->PrintMessage(2,"NEW !");
            $Spooler = new \Arii\JOCBundle\Entity\Spoolers(); 
            $spooler_id = -1;
        }
        else {
            $spooler_id = $Spooler->getId();
            
            // Inutile de descendre en dessous de 5s
            $last = $Spooler->getUpdated();
            $interval = $Now->diff($last)->format('%s');
            if ($interval < 5 ) return "success";
        }

        $Spooler->setName         ( $spooler );
        $Spooler->setHost         ( $host );
        $Spooler->setTcpPort      ( $Scheduler['tcp_port'] );
        
        $Spooler->setTime         ( new  \DateTime( $Scheduler['time'] ) );
        $Spooler->setSpoolerRunningSince 
                                  ( new  \DateTime( $Scheduler['spooler_running_since'] ) );
        $Spooler->setState        ( $Scheduler['state'] );
        $Spooler->setLogFile      ( $Scheduler['log_file'] );
        $Spooler->setVersion      ( $Scheduler['version'] );
        $Spooler->setPid          ( $Scheduler['pid'] );
        $Spooler->setConfigFile   ( $Scheduler['config_file'] );
        $Spooler->setIpAddress    ( isset($Scheduler['ip_address']) ? $Scheduler['ip_address']:$host );
        $Spooler->setUdpPort      ( $Scheduler['udp_port'] );
        $Spooler->setUdpPort      ( $Scheduler['udp_port'] );
        $Spooler->setDb           ( $Scheduler['db'] );
        $Spooler->setWaits        ( $Scheduler['waits'] );
        $Spooler->setLoops        ( $Scheduler['loop'] );
        $Spooler->setWaitUntil    ( isset($Scheduler['wait_until']) ? new \DateTime( $Scheduler['wait_until'] ):null );
        $Spooler->setNeedDb       ( isset($Scheduler['need_db']) and ($Scheduler['need_db']=='yes') ? 1:0 );
                
        $Spooler->setUpdated ( $Now );
        $em->persist($Spooler);        

        // Il faut l'id pour un nouveau spooler
        if ($spooler_id == -1 ) {
            $em->flush();             
            $Spooler = $em
                    ->getRepository( 'AriiJOCBundle:Spoolers')
                    ->findOneBy(array( 'host' => $host, 'tcp_port' => $port));            
            $spooler_id = $Spooler->getId();            
        }

        // Process classes
        $n = 0;
        if (isset($Result['spooler']['answer']['state']['process_classes']['process_class'])) {
            
            $Classes = $Result['spooler']['answer']['state']['process_classes']['process_class'];
            if (isset($Classes['attr'])) { $Classes[$n] = $Classes; }
            
            while (isset($Classes[$n])) {
                
                $path = $Classes[$n]['attr']['path'];
                // On evite le null
                if ($path=='') $path="/";
                
                $ProcessClass = $em
                    ->getRepository('AriiJOCBundle:ProcessClasses')
                    ->findOneBy(array(  'spooler' => $Spooler, 
                                        'path' => $path ));
                
                // On ne prend pas les process class par defaut ?
                if (!$ProcessClass) {
                    $this->PrintMessage(2,"+ $path");
                    $ProcessClass = new \Arii\JOCBundle\Entity\ProcessClasses();
                }
                
                $ProcessClass->setSpooler         ( $Spooler );
                $ProcessClass->setPath            ( $path );
                $ProcessClass->setName            ( isset($Classes[$n]['attr']['name']) ? $Classes[$n]['attr']['name']:'' );
                $ProcessClass->setMaxProcesses    ( $Classes[$n]['attr']['max_processes'] );
                $ProcessClass->setProcesses       ( $Classes[$n]['attr']['processes'] );
                $ProcessClass->setRemoteScheduler ( isset($Classes[$n]['attr']['remote_scheduler']) ? $Classes[$n]['attr']['remote_scheduler']:'' );
                
                $ProcessClass->setState           ( $Classes[$n]['file_based']['attr']['state'] );
                $ProcessClass->setLastWriteTime   ( isset($Classes[$n]['file_based']['attr']['last_write_time']) ? new \DateTime ( $Classes[$n]['file_based']['attr']['last_write_time'] ):null );
                
                // est ce qu'on est en erreur ?
                $ProcessClass->setError   ( isset($Classes[$n]['file_based']['ERROR']['attr']['text']) ? $Classes[$n]['file_based']['ERROR']['attr']['text'] : null );
                $ProcessClass->setUpdated ( new \DateTime( ) );
                
                $em->persist($ProcessClass);

                $n++;
            }
        }
        
        // Jobs/Locks use
        $n = 0;
        if (isset( $Result['spooler']['answer']['state']['jobs']['job'] )) {
            if (isset($Result['spooler']['answer']['state']['jobs']['job']['attr']))
                $Jobs[0] = $Result['spooler']['answer']['state']['jobs']['job'];
            else
                $Jobs = $Result['spooler']['answer']['state']['jobs']['job'];

            while (isset($Jobs[$n])) {                               
                $path  = $Jobs[$n]['attr']['path'];
                $this->PrintMessage(3,"JOB  $path");
                
                $Job = $em
                        ->getRepository('AriiJOCBundle:Jobs')
                        ->findOneBy( [
                            'spooler' => $Spooler, 
                            'path' => $path
                        ]);
                if (!$Job) {
                    $this->PrintMessage(2,"+ JOB  $path");
                    $Job = new \Arii\JOCBundle\Entity\Jobs();
                }

                $Job->setSpooler   ( $Spooler );
                $Job->setPath      ( $path );
                $Job->setName      ( $Jobs[$n]['attr']['name'] );                
                $Job->setState     ( $Jobs[$n]['attr']['state'] );
                $Job->setAllSteps  ( isset($Jobs[$n]['attr']['all_steps']) ? $Jobs[$n]['attr']['all_steps'] : 0 );
                $Job->setAllTasks  ( isset( $Jobs[$n]['attr']['all_tasks']) ? $Jobs[$n]['attr']['all_tasks'] : 0 );	
                $Job->setOrdered   ( (isset($Jobs[$n]['attr']['order'])) and ($Jobs[$n]['attr']['order'] == 'yes' ) ? 1:0 );
                $Job->setJobChainPriority  ( isset($Jobs[$n]['attr']['job_chain_priority']) ? $Jobs[$n]['attr']['job_chain_priority'] : -1 );	
                
                # BUG Jobscheduler
                if (isset($Jobs[$n]['attr']['job_chain_priority']) and $Jobs[$n]['attr']['job_chain_priority']>=0) 
                    $Job->setOrdered(1);

                $Job->setTasks             ( isset($Jobs[$n]['attr']['tasks']) ? $Jobs[$n]['attr']['tasks'] : 0 );	
                $Job->setInPeriod          ( (isset($Jobs[$n]['attr']['in_period']) and ($Jobs[$n]['attr']['in_period']=='yes')) ? 1:0 );
                $Job->setEnabled           ( (isset($Jobs[$n]['attr']['enabled']) and ($Jobs[$n]['attr']['enabled']=='yes')) ? 1:0 );
                $Job->setHasDescription    ( (isset($Jobs[$n]['attr']['has_description']) and ($Jobs[$n]['attr']['has_description']=='yes')) ? 1:0 );
                $Job->setWaitingForProcess ( (isset($Jobs[$n]['attr']['waiting_for_process']) and ($Jobs[$n]['attr']['waiting_for_process']=='yes')) ? 1:0 );
                $Job->setNextStartTime     ( isset($Jobs[$n]['attr']['next_start_time']) ? new \DateTime( $Jobs[$n]['attr']['next_start_time'])  : null);	
                
                // Jointure ?
                $Job->setProcessClass (  isset($Jobs[$n]['attr']['process_class']) ? $Jobs[$n]['attr']['process_class'] : null );
                $Job->setSchedule     (  isset($Jobs[$n]['attr']['active_schedule']) ? $Jobs[$n]['attr']['active_schedule'] : null );

                $Job->setTitle         ( isset($Jobs[$n]['attr']['title'])  ? utf8_decode( $Jobs[$n]['attr']['title'] ) : '' );	
                $Job->setLastWriteTime ( isset($Jobs[$n]['file_based']['attr']['last_write_time']) ? new \DateTime( $Jobs[$n]['file_based']['attr']['last_write_time'] ) : null );
                $Job->setLastInfo      ( isset($Jobs[$n]['log']['attr']['last_info']) ? $Jobs[$n]['log']['attr']['last_info'] : null );
                $Job->setLastWarning   ( isset($Jobs[$n]['log']['attr']['last_warning']) ? $Jobs[$n]['log']['attr']['last_warning'] : null );
                $Job->setLastError     ( isset($Jobs[$n]['log']['attr']['last_error']) ? $Jobs[$n]['log']['attr']['last_error'] : null );

                $Job->setLevel         ( isset($Jobs[$n]['log']['attr']['level'])  ? $Jobs[$n]['log']['attr']['level'] : '' );	
                $Job->setHighestLevel  ( isset($Jobs[$n]['log']['attr']['highest_level'])  ? $Jobs[$n]['log']['attr']['highest_level'] : '' );	
                                
                # Gestion des erreurs
                $error = 0;
                $error_code=$error_text='';
                if (isset($Jobs[$n]['file_based']['ERROR'])) {
                    $error = 1;
                    $p = strpos($Jobs[$n]['file_based']['ERROR']['attr']['text'],' ');
                    $error_text = substr($Jobs[$n]['file_based']['ERROR']['attr']['text'],$p+1);
                    $error_code = substr($Jobs[$n]['file_based']['ERROR']['attr']['text'],0,$p);
                }
                $Job->setErrorText ( $error_text );
                $Job->setErrorCode ( $error_code );
                $Job->setUpdated ( new \DateTime( ) );

                $em->persist($Job);

                if (isset($Jobs[$n]['params'])) {
                    
                    $JobParams =$Jobs[$n]['params'];
                    $params_count = $JobParams['attr']['count'];
                    for($i=0;$i<$params_count;$i++) {
                        if (isset($JobParams['param']['attr']))
                            $P = $JobParams['param']['attr'];
                        else 
                            $P = $JobParams['param'][$i]['attr'];                        
                        $name = $P['name'];
                        $value = $P['value'];

                        $JobParam = $em
                                ->getRepository('AriiJOCBundle:JobParams')
                                ->findOneBy( array( 'job' => $Job, 
                                                    'name' => $name ) );
                        if (!$JobParam) {
                            $this->PrintMessage(2,"+ PARAM $name");
                            $JobParam = new \Arii\JOCBundle\Entity\JobParams();
                        }

                        $JobParam->setJob   ( $Job );
                        $JobParam->setName  ( $name );
                        $JobParam->setValue ( $value );
                        $JobParam->setSpoolerId ( $spooler_id );

                        $JobParam->setUpdated ( new \DateTime( ) );
                        $em->persist($JobParam);      
                         
                    }
                }

                // Utilisation des verrous
                if (isset($Jobs[$n]['lock.requestor'])) {
                    $Locks = $Jobs[$n]['lock.requestor'];
                    
                    if (isset($Locks['lock.use'])) {
                        if (isset($Locks['lock.use']['attr'])) {
                            $Locks['lock.use'][0]['attr']['lock']      = $Locks['lock.use']['attr']['lock'];
                            $Locks['lock.use'][0]['attr']['exclusive'] = $Locks['lock.use']['attr']['exclusive'];
                            if (isset($Locks['lock.use']['attr']['is_missing'])) 
                                $Locks['lock.use'][0]['attr']['is_missing'] = $Locks['lock.use']['attr']['is_missing'];
                            if (isset($Locks['lock.use']['attr']['is_available'])) 
                                $Locks['lock.use'][0]['attr']['is_available'] = $Locks['lock.use']['attr']['is_available'];
                        }
                        
                        $nl = 0;
                        while (isset($Locks['lock.use'][$nl]['attr'])) {
                            
                            $path = $Locks['lock.use'][$nl]['attr']['lock'];

                            $LockUse = $em
                                    ->getRepository('AriiJOCBundle:LocksUse')
                                    ->findOneBy( array( 'job' => $Job, 
                                                        'path' => $path) );
                            if (!$LockUse) {
                                $this->PrintMessage(2,"+ LOCK USE  $path");
                                $LockUse = new \Arii\JOCBundle\Entity\LocksUse();
                            }

                            $LockUse->setJob   ( $Job );
                            $LockUse->setPath  ( $path );
                            $LockUse->setSpoolerId   ( $spooler_id );
                            $LockUse->setExclusive   ( isset($Locks['lock.use'][$nl]['attr']['exclusive'] ) and ( $Locks['lock.use'][$nl]['attr']['exclusive'] == 'yes' ) ? 1:0 );
                            $LockUse->setIsMissing   ( isset($Locks['lock.use'][$nl]['attr']['is_missing'] ) and ( $Locks['lock.use'][$nl]['attr']['is_missing'] == 'yes' ) ? 1:0 );
                            if ( isset($Locks['lock.use'][$nl]['attr']['is_available'] ) and ( $Locks['lock.use'][$nl]['attr']['is_available'] == 'no' ))
                                $LockUse->setIsAvailable(0); 
                            else
                                $LockUse->setIsAvailable(1);
                            $LockUse->setUpdated ( new \DateTime( ) );
                            $em->persist($LockUse);
                            
                            $nl++;
                        }
                    }
                }

                // Sauvegarde des taches
                if (isset($Jobs[$n]['tasks']['task'])) {
                    $nt = 0;
                    $Tasks = array();
                    if (isset($Jobs[$n]['tasks']['task']['attr']))
                        $Tasks[$nt] = $Jobs[$n]['tasks']['task'];
                    else
                        $Tasks = $Jobs[$n]['tasks']['task'];
                    
                    while (isset($Tasks[$nt]['attr'])) {
                                                
                            $task_id = $Tasks[$nt]['attr']['id'];
                            $this->PrintMessage(2,"TASK  $task_id");
                            
                            $Task = $em
                                    ->getRepository('AriiJOCBundle:Tasks')
                                    ->findOneBy( array( 'job' => $Job, 
                                                        'task' => $task_id ) );
                            if (!$Task) {
                                $this->PrintMessage(2,"+ TASK  $task_id");
                                $Task = new \Arii\JOCBundle\Entity\Tasks();
                            }
                            
                            $Task->setJob     ( $Job );
                            $Task->setTask    ( $task_id );
                            $Task->setSpoolerId   ( $spooler_id );
                            
                            $Task->setState        ( $Tasks[$nt]['attr']['state'] );
                            $Task->setName         ( $Tasks[$nt]['attr']['name'] );
                            $Task->setRunningSince ( new \DateTime ($Tasks[$nt]['attr']['running_since'])) ;
                            $Task->setEnqueued     ( isset( $Tasks[$nt]['attr']['enqueued'] ) ? new \DateTime ($Tasks[$nt]['attr']['enqueued']) : null );
                            $Task->setStartAt      ( new \DateTime ($Tasks[$nt]['attr']['start_at']));
                            $Task->setCause        ( $Tasks[$nt]['attr']['cause'] );
                            $Task->setSteps        ( $Tasks[$nt]['attr']['steps'] );
                            $Task->setLogFile      ( $Tasks[$nt]['attr']['log_file'] );
                            $Task->setPid          ( isset( $Tasks[$nt]['attr']['pid']) ? $Tasks[$nt]['attr']['pid']:0 ); 
                            $Task->setPriority     ( isset( $Tasks[$nt]['attr']['priority'] ) ? $Tasks[$nt]['attr']['priority']:0 );
                            $Task->setForceStart   ( isset( $Tasks[$nt]['attr']['force_start'] ) and ( $Tasks[$nt]['attr']['force_start'] == 'yes' ) ? 1 : 0 );

                            $Task->setUpdated ( new \DateTime( ) );
                            $em->persist($Task);
                            
                        $nt++;
                    }
                }                
                $n++;
            }
        }
        $timer = microtime(true);
        $em->flush();
        $this->PrintMessage(1,"Flush ".(microtime(true)-$timer).'s');
        
        //=JOB CHAINS/NODES/ORDERS================================================================================================
        $n = 0;
        if (isset($Result['spooler']['answer']['state']['job_chains']['job_chain'])) {
            if ( isset($Result['spooler']['answer']['state']['job_chains']['job_chain']['attr']) )
                $JobChains[0] = $Result['spooler']['answer']['state']['job_chains']['job_chain'];
            else
                $JobChains = $Result['spooler']['answer']['state']['job_chains']['job_chain'];

            while (isset($JobChains[$n])) {
                
                $path  = $JobChains[$n]['attr']['path'];                

                $this->PrintMessage(3,"CHAIN $path");                               
                $JobChain = $em
                        ->getRepository('AriiJOCBundle:JobChains')
                        ->findOneBy( array('spooler' => $Spooler, 'path' => $path) );
                if (!$JobChain) {
                    $this->PrintMessage(2,"+ CHAIN $path");
                    $JobChain = new \Arii\JOCBundle\Entity\JobChains();
                    $job_chain_id = -1;
                }
                else {
                    $job_chain_id = $JobChain->getId();
                }
                
                $JobChain->setSpooler   ( $Spooler );
                $JobChain->setPath      ( $path );
                
                $JobChain->setName          ( $JobChains[$n]['attr']['name'] ); 
                $JobChain->setState         ( $JobChains[$n]['attr']['state'] );
                $JobChain->setOrders        ( isset($JobChains[$n]['attr']['orders']) ? $JobChains[$n]['attr']['orders'] : 0);	
                $JobChain->setRunningOrders ( isset($JobChains[$n]['attr']['running_orders']) ? $JobChains[$n]['attr']['running_orders'] : 0);	
                $JobChain->setMaxOrders     ( isset($JobChains[$n]['attr']['max_orders']) ? $JobChains[$n]['attr']['max_orders'] : null );	
                $JobChain->setOrdersRecoverable 
                                            ( isset($JobChains[$n]['attr']['order']) and ($JobChains[$n]['attr']['order'] == 'yes' ) ? 1:0 );
//                $JobChain->setTitle         ( isset($JobChains[$n]['attr']['title']) ? utf8_decode( $JobChains[$n]['attr']['title'] ) : '' );
                $JobChain->setTitle         ( isset($JobChains[$n]['attr']['title']) ?  $JobChains[$n]['attr']['title'] : '' );
                $JobChain->setOrderIdSpace  ( isset($JobChains[$n]['attr']['order_id_space']) and ($JobChains[$n]['attr']['order_id_space']<>'') ?  $JobChains[$n]['attr']['order_id_space']  : null );
                $JobChain->setLastWriteTime ( isset($JobChains[$n]['file_based']['attr']['last_write_time']) ? new \DateTime( $JobChains[$n]['file_based']['attr']['last_write_time'] ) : null);

                $JobChain->setUpdated ( new \DateTime( ) );

                $em->persist($JobChain);

                $chain_path = $path;
                $default_path = dirname($path);
                
                // Est ce qu'il y a un file order ?
                if (isset(  $JobChains[$n]['file_order_source'] ) ) {
                    $Files = array();
                    if (isset($JobChains[$n]['file_order_source']['attr'])) 
                        $Files[0] = $JobChains[$n]['file_order_source'];
                    else
                        $Files = $JobChains[$n]['file_order_source'];
                    
                    $nf=0;
                    while (isset($Files[$nf])) {
                        $directory = $Files[$nf]['attr']['directory'];
                        $regex =     $Files[$nf]['attr']['regex'];

                        $this->PrintMessage(3,"FILE $directory ($regex)");
                        $FileOrder = $em
                                ->getRepository('AriiJOCBundle:FileOrders')
                                ->findOneBy( array( 'job_chain' => $JobChain, 
                                                    'directory' => $directory,
                                                    'regex'     => $regex ) );
                        if (!$FileOrder) {
                            $this->PrintMessage(2,"+ FILE $directory ($regex)");
                            $FileOrder = new \Arii\JOCBundle\Entity\FileOrders();
                        }

                        $FileOrder->setJobChain  ( $JobChain );
                        $FileOrder->setDirectory ( $directory );
                        $FileOrder->setRegex     ( $regex );
                        $FileOrder->setSpoolerId ( $spooler_id );
                        $FileOrder->setAlertWhenDirectoryMissing ( $Files[$nf]['attr']['alert_when_directory_missing'] );
                        $FileOrder->setDelayAfterError           ( $Files[$nf]['attr']['delay_after_error'] );
                        $FileOrder->setRetry                     ( $Files[$nf]['attr']['repeat'] );
                        $FileOrder->setNextState                 ( $Files[$nf]['attr']['next_state'] ); 

                        $FileOrder->setUpdated ( new \DateTime( ) );

                        $em->persist($FileOrder);
                        $nf++;
                    }
                }
                
                // On passe au job_chain_nodes 
                // Ordre des steps
                if (isset(  $JobChains[$n]['job_chain_node'] ) ) {
                    $Nodes = array();
                    if (isset($JobChains[$n]['job_chain_node']['attr'])) 
                        $Nodes[0] = $JobChains[$n]['job_chain_node'];
                    else
                        $Nodes = $JobChains[$n]['job_chain_node'];
                    
                    $nn=0;
                    $ordering = 0;
                    while (isset($Nodes[$nn])) {

                        $state = $Nodes[$nn]['attr']['state'];

                        $this->PrintMessage(3,"NODE $state");
                        $JobChainNode = $em
                                ->getRepository('AriiJOCBundle:JobChainNodes')
                                ->findOneBy( array('job_chain' => $JobChain, 'state' => $state) );
                        if (!$JobChainNode) {
                            $this->PrintMessage(2,"+ NODE $state");
                            $JobChainNode = new \Arii\JOCBundle\Entity\JobChainNodes();
                        }

                        $JobChainNode->setJobChain   ( $JobChain );
                        $JobChainNode->setState      ( $state );
                        $JobChainNode->setSpoolerId ( $spooler_id );
                        $JobChainNode->setNextState  ( isset($Nodes[$nn]['attr']['next_state']) ?  $Nodes[$nn]['attr']['next_state'] : null );
                        $JobChainNode->setErrorState ( isset($Nodes[$nn]['attr']['error_state']) ? $Nodes[$nn]['attr']['error_state'] : null );
                        $JobChainNode->setAction     ( isset($Nodes[$nn]['attr']['action']) ? $Nodes[$nn]['attr']['action'] : null );

                        // Chaine de jobs
                        $JobChainNode->setJob      ( isset($Nodes[$nn]['attr']['job']) ? $Nodes[$nn]['attr']['job']: null );
                        $JobChainNode->setChain    ( isset($Nodes[$nn]['attr']['job_chain']) ? $Nodes[$nn]['attr']['job_chain']: null );
                        $JobChainNode->setOrdering ( $ordering++ );

                        $JobChainNode->setUpdated ( new \DateTime( ) );

                        $em->persist($JobChainNode);      

                        # A l'interieur du noeud, on regarde si il y a un ordre
                        // Le path est le repertoire de la job chain
                        // Il est vide si l'order est à la volée

                        if (isset($Nodes[$nn]['order_queue']['order'])) {
                            $Orders = array();
                            if (isset($Nodes[$nn]['order_queue']['order']['attr']))                                 
                                $Orders[0] = $Nodes[$nn]['order_queue']['order'];
                            else 
                                $Orders = $Nodes[$nn]['order_queue']['order'];
                            
                            $no = 0;
                            while (isset($Orders[$no])) {
                                
                                $id = $Orders[$no]['attr']['id'];
                                $this->PrintMessage(3,"ORDER $id");
                                $Order = $em
                                        ->getRepository('AriiJOCBundle:Orders')
                                        ->findOneBy( array('job_chain_node' => $JobChainNode, 'id_order' => $id ) );
                                if (!$Order) {
                                    $this->PrintMessage(2,"+ ORDER $state");
                                    $Order = new \Arii\JOCBundle\Entity\Orders();
                                }

                                $name= ( isset($Orders[$no]['attr']['name']) ?  $Orders[$no]['attr']['name']  : null);                                    
                                // cas de la blacklist
                                if ($name=='')
                                    $name= (isset($Orders[$no]['attr']['order']) ?  $Orders[$no]['attr']['order']  : null);

                                // Obligatoirement le path de la chaine
                                $path = $Orders[$no]['attr']['path'];
                                if ($path=='/') {
                                    $path = $chain_path.','.$name;
                                }      

                                $Order->setJobChainNode ( $JobChainNode );
                                $Order->setIdOrder      ( $id );
                                $Order->setName         ( $name );
                                $Order->setPath         ( $path );
                                // raccourcis
                                $Order->setSpoolerId    ( $spooler_id );
                                $Order->setJobChainId   ( $job_chain_id );
                                
                                $Order->setState         ( $Orders[$no]['attr']['state'] );
                                $Order->setTitle         ( isset($Orders[$no]['attr']['title']) ? utf8_decode( $Orders[$no]['attr']['title']) : null );
                                $Order->setStateText     ( isset($Orders[$no]['attr']['state_text']) ?  $Orders[$no]['attr']['state_text'] : null );
                                $Order->setNextStartTime ( isset($Orders[$no]['attr']['next_start_time']) ? new \DateTime ( $Orders[$no]['attr']['next_start_time']) : null );
                                $Order->setStartTime     ( isset($Orders[$no]['attr']['start_time']) ? new \DateTime ( $Orders[$no]['attr']['start_time'])  : null);
                                $Order->setSetback       ( isset($Orders[$no]['attr']['setback']) ? new \DateTime ( $Orders[$no]['attr']['setback'])  : null);
                                $Order->setSetbackCount  ( isset($Orders[$no]['attr']['setback_count']) ? $Orders[$no]['attr']['setback_count'] : null );
                                $Order->setHistoryId     ( isset($Orders[$no]['attr']['history_id']) ? $Orders[$no]['attr']['history_id']: null );
                                $Order->setTaskId        ( isset($Orders[$no]['attr']['task']) ? $Orders[$no]['attr']['task'] : null );
                                $Order->setInProcessSince( isset($Orders[$no]['attr']['in_process_since']) ? new \DateTime ($Orders[$no]['attr']['in_process_since']) : null );
                                $Order->setRunning       ( isset($Orders[$no]['attr']['in_process_since']) ? 1:0 );
                                $Order->setTouched       ( isset($Orders[$no]['attr']['touched']) and ($Orders[$no]['attr']['touched']=='yes') ? 1:0 );
                                $Order->setCreated       ( isset($Orders[$no]['attr']['created']) ? new \DateTime ($Orders[$no]['attr']['created']) : null );
                                $Order->setPriority      ( isset($Orders[$no]['attr']['priority']) ? $Orders[$no]['attr']['priority'] : 0);
                                $Order->setLastWriteTime ( isset($Orders[$no]['file_based']['attr']['last_write_time']) ? new \DateTime ($Orders[$no]['file_based']['attr']['last_write_time']) : null);
                                $Order->setInitialState  ( $Orders[$no]['attr']['initial_state'] );
                                $Order->setEndState      ( isset($Orders[$no]['attr']['end_state']) ? $Orders[$no]['attr']['end_state'] : null );
                                $Order->setSchedule      ( isset($Orders[$no]['attr']['active_schedule']) ? $Orders[$no]['attr']['active_schedule'] : null );	
                                $Order->setSuspended     ( isset($Orders[$no]['attr']['suspended']) and ($Orders[$no]['attr']['suspended']=='yes') ? 1 : 0 ); 
                                $Order->setOnBLacklist   ( isset($Orders[$no]['attr']['on_blacklist']) and ($Orders[$no]['attr']['on_blacklist']=='yes') ? 1 : 0 );
                                
                                $Order->setUpdated ( new \DateTime( ) );
                                $em->persist($Order);      
                                
                                // Payload
                                if ( isset($Orders[$no]['payload']['params']) ) {

                                    $Payloads = $Orders[$no]['payload']['params'];
                                    $params_count = $Payloads['attr']['count'];
                                    if ($params_count>0)
                                         $Params = $Payloads['param'];

                                    for($i=0;$i<$params_count;$i++) {
                                        
                                        if (isset($Params['attr']))
                                            $P = $Params['attr'];
                                        else 
                                            $P = $Params[$i]['attr'];                                        
                                        $name = $P['name'];                                         
                                        $value = ( isset($P['value']) ? $P['value']:null); 
                                        
                                        $Payload = $em
                                                ->getRepository('AriiJOCBundle:Payloads')
                                                ->findOneBy( array('order' => $Order, 'name' => $name ) );
                                        if (!$Payload) {
                                            $this->PrintMessage(2,"+ PAYLOAD $name");
                                            $Payload = new \Arii\JOCBundle\Entity\Payloads();
                                        }
                                        
                                        $Payload->setOrder  ( $Order );
                                        $Payload->setName   ( $name );
                                        $Payload->setValue  ( $value );
                                        $Payload->setSpoolerId ( $spooler_id );
                                        
                                        $Payload->setUpdated ( new \DateTime( ) );
                                        $em->persist($Payload);      
                                        
                                    }
                                }
                                $no++;
                            }
                        }
                        $nn++;
                    }
                }
                $n++;
            }
        }
        $timer = microtime(true);
        $em->flush();
        $this->PrintMessage(1,"Flush ".(microtime(true)-$timer).'s');
        
        //=LOCKS================================================================================================
        $n = 0;
        if (isset($Result['spooler']['answer']['state']['locks']['lock'])) {
            
            $Locks = $Result['spooler']['answer']['state']['locks']['lock'];                
            if (isset($Locks['attr'])) { $Locks[$n] = $Locks; }

            while (isset($Locks[$n])) {

                    $path = $Locks[$n]['attr']['path'];

                    $Lock = $em
                            ->getRepository('AriiJOCBundle:Locks')
                            ->findOneBy( array('spooler' => $Spooler, 'path' => $path) );
                    if (!$Lock) {
                        $this->PrintMessage(2,"+ LOCK $path");
                        $Lock = new \Arii\JOCBundle\Entity\Locks();
                    }

                    $Lock->setSpooler  ( $Spooler );
                    $Lock->setPath     ( $path );
                    $Lock->setName     ( $Locks[$n]['attr']['name'] );

                    $Lock->setIsFree          ( isset($Locks[$n]['attr']['is_free']) and ($Locks[$n]['attr']['is_free']=='yes') ? 1:0 );
                    $Lock->setIsFree          ( isset($Locks[$n]['attr']['is_free']) and ($Locks[$n]['attr']['is_free']=='yes') ? 1:0 );
                    $Lock->setMaxNonExclusive ( isset($Locks[$n]['attr']['max_non_exclusive']) ? $Locks[$n]['attr']['max_non_exclusive']:null );
                    $Lock->setState           ( $Locks[$n]['file_based']['attr']['state'] );

                    $Lock->setUpdated (new \DateTime () );
                    $em->persist( $Lock );
                    $n++;
            }
        }        
        $timer = microtime(true);
        $em->flush();
        $this->PrintMessage(1,"Flush ".(microtime(true)-$timer).'s');

        //=SCHEDULES================================================================================================
        $n = 0;
        if (isset($Result['spooler']['answer']['state']['schedules']['schedule'])) {                
                if (isset($Result['spooler']['answer']['state']['schedules']['schedule']['attr']))
                    $Schedules[$n] = $Result['spooler']['answer']['state']['schedules']['schedule'];
                else
                    $Schedules = $Result['spooler']['answer']['state']['schedules']['schedule'];
                
                while (isset($Schedules[$n])) {
                                        
                    $path = $Schedules[$n]['attr']['path'];
                    $this->PrintMessage(3,"SCHEDULE $path");
                    
                    $Schedule = $em
                            ->getRepository('AriiJOCBundle:Schedules')
                            ->findOneBy( array('spooler' => $Spooler, 'path' => $path) );
                    if (!$Schedule) {
                        $this->PrintMessage(2,"+ SCHEDULE $path");
                        $Schedule = new \Arii\JOCBundle\Entity\Schedules();
                    }

                    $Schedule->setSpooler  ( $Spooler );
                    $Schedule->setPath     ( $path );
                    $Schedule->setName     ( $Schedules[$n]['attr']['name'] );
                    
                    $Schedule->setTitle      ( isset($Schedules[$n]['attr']['title'])? utf8_decode ( $Schedules[$n]['attr']['title'] ) : null );
                    $Schedule->setState      ( $Schedules[$n]['file_based']['attr']['state'] );
                    $Schedule->setActive     ( isset($Schedules[$n]['attr']['active']) and ($Schedules[$n]['attr']['active']=='yes') ? 1:0 );
                    
                    $Schedule->setSubstitute ( isset($Schedules[$n]['attr']['substitute']) ? $Schedules[$n]['attr']['substitute']:null );                    
                    $Schedule->setValidFrom  ( isset($Schedules[$n]['attr']['valid_from']) ? $Schedules[$n]['attr']['valid_from']:null );
                    $Schedule->setValidTo    ( isset($Schedules[$n]['attr']['valid_to'])   ? $Schedules[$n]['attr']['valid_to']:null );

                    $Schedule->setUpdated (new \DateTime () );
                    $em->persist( $Schedule );
                    
                    // Traitement de l'arborescence en ligne de périodes
                    $Periods = $this->Schedule2Rows( $Schedules[$n] );                    
                    // nouvelles periodes
                    // $Period = new \Arii\JOCBundle\Entity\Periods();
                    
                $n++;
                }
        }
        $timer = microtime(true);
        $em->flush();
        $this->PrintMessage(1,"Flush ".(microtime(true)-$timer).'s');
        
        //=REMOTE SCHEDULERS================================================================================================
        if (isset($Result['spooler']['answer']['state']['remote_schedulers']['remote_scheduler'])) {
            if (isset($Result['spooler']['answer']['state']['remote_schedulers']['remote_scheduler']['attr']))
                $Remotes[0] = $Result['spooler']['answer']['state']['remote_schedulers']['remote_scheduler'];
            else
                $Remotes = $Result['spooler']['answer']['state']['remote_schedulers']['remote_scheduler'];
            
            $n = 0;
            while (isset($Remotes[$n])) {
                
                $ip = $Remotes[$n]['attr']['ip'];
                if (isset($Remotes[$n]['attr']['tcp_port']))
                    $port = $Remotes[$n]['attr']['tcp_port'];
                elseif (isset($Remotes[$n]['attr']['udp_port']))
                    $port = $Remotes[$n]['attr']['udp_port'];
                else $port = 0;

                $this->PrintMessage(3,"REMOTE $ip:$port");
                $Remote = $em
                        ->getRepository('AriiJOCBundle:RemoteSchedulers')
                        ->findOneBy( array( 'spooler' => $Spooler, 
                                            'ip' => $ip,
                                            'port' => $port ) );
                if (!$Remote) {
                    $this->PrintMessage(2,"+ REMOTE $ip:$port");
                    $Remote = new \Arii\JOCBundle\Entity\RemoteSchedulers();
                }

                $Remote->setSpooler  ( $Spooler );
                $Remote->setIp       ( $ip );
                $Remote->setPort     ( $port );
                
                $Remote->setName ( $Remotes[$n]['attr']['scheduler_id'] );

                $Remote->setConfigurationChangedAt      ( isset($Remotes[$n]['attr']['configuration_changed_at']) ? new \DateTime ($Remotes[$n]['attr']['configuration_changed_at']) : null );
                $Remote->setConfigurationTransferedAt   ( isset($Remotes[$n]['attr']['configuration_transfered_at']) ? new \DateTime ($Remotes[$n]['attr']['configuration_transfered_at']) : null );
                $Remote->setConnected                   ( isset($Remotes[$n]['attr']['connected']) and ($Remotes[$n]['attr']['connected']=='yes') ? 1 : 0 );
                $Remote->setConnectedAt                 ( isset($Remotes[$n]['attr']['connected_at']) ? new \DateTime ($Remotes[$n]['attr']['connected_at']) : null );
                $Remote->setDisconnectedAt              ( isset($Remotes[$n]['attr']['disconnected_at']) ? new \DateTime ($Remotes[$n]['attr']['disconnected_at']) : null );

                $Remote->setHostname    ( $Remotes[$n]['attr']['hostname'] );                
                $Remote->setVersion     ( $Remotes[$n]['attr']['version'] );                
                $Remote->setError       ( isset($Remotes[$n]['attr']['error_code']) ? $Remotes[$n]['attr']['error_code'] : null );
                $Remote->setErrorAt     ( isset($Remotes[$n]['attr']['error_at']) ? new \DateTime( $Remotes[$n]['attr']['error_at'] ) : null );

                $Remote->setUpdated (new \DateTime () );
                $em->persist( $Remote );
                $n++;
            }
        }

        //=CONNECTIONS================================================================================================
        $n = $nu = $ni = 0;
        if (isset($Result['spooler']['answer']['state']['connections']['connection'])) {
            if (isset($Result['spooler']['answer']['state']['connections']['connection']['attr']))
                $Connections[$n] = $Result['spooler']['answer']['state']['connections']['connection'];
            else
                $Connections = $Result['spooler']['answer']['state']['connections']['connection'];
            
            while (isset($Connections[$n])) {
                                    
                    $host_ip = $Connections[$n]['peer']['attr']['host_ip'];
                    $port = $Connections[$n]['peer']['attr']['port'];
                    
                    $this->PrintMessage(3,"CONNECT. $host_ip:$port");
                    $Connection = $em
                            ->getRepository('AriiJOCBundle:Connections')
                            ->findOneBy( array( 'spooler' => $Spooler, 
                                                'host_ip' => $host_ip,
                                                'port' => $port ) );
                    if (!$Connection) {
                        $this->PrintMessage(2,"+ CONNECT. $host_ip:$port");
                        $Connection = new \Arii\JOCBundle\Entity\Connections();
                    }
                    
                    $Connection->setSpooler ( $Spooler );
                    $Connection->setHostIP  ( $host_ip );
                    $Connection->setPort    ( $port );
                    
                    $Connection->setOperationType  ( isset($Connections[$n]['attr']['operation_type']) ? $Connections[$n]['attr']['operation_type'] : null );
                    $Connection->setReceivedBytes  ( $Connections[$n]['attr']['received_bytes'] );
                    $Connection->setResponses      ( $Connections[$n]['attr']['responses'] );
                    $Connection->setSentBytes      ( $Connections[$n]['attr']['sent_bytes'] );
                    $Connection->setState          ( $Connections[$n]['attr']['state'] );
                    
                    $Connection->setUpdated (new \DateTime () );
                    $em->persist( $Connection );
                    $n++;
            }
        }
        
        //=ORDER_ID_SPACES================================================================================================
        $n = 0;
        if (isset($Result['spooler']['answer']['state']['order_id_spaces']['order_id_space'])) {
            $Spaces = $Result['spooler']['answer']['state']['order_id_spaces']['order_id_space'];
            if (isset($Spaces['attr'])) { $Spaces[$n] = $Spaces; }
            while (isset($Spaces[$n])) {
                $name = $Spaces[$n]['attr']['name'];
                $nc = 0 ;
                while (isset($Spaces[$n]['job_chain'][$nc]['attr']['job_chain'])) {
                    $chain = $Spaces[$n]['job_chain'][$nc]['attr']['job_chain'];
                    if (isset($JobChainID[$chain])) {
                        $jc = $JobChainID[$chain];
                        $idspace = "$name#$jc";
                    }
                    else {
                        $jc = 'null';
                        $idspace = "$name#";
                    }                    
                    $nc++;
                }
                $n++;
            }
        }       
        $timer = microtime(true);
        $em->flush();
        $this->PrintMessage(1,"Flush ".(microtime(true)-$timer).'s');
        
        $timer = microtime(true);
        $qb = $em->createQueryBuilder();
        $now = $Now->format('Y-m-d H:i:s');
        
        // En cascade
        foreach (array( 'Jobs', 'JobChains', 'Schedules', 'Locks', 'Connections', 'RemoteSchedulers' ) as $class) {
            $this->PrintMessage(2,"- $class");
            try {
                $query = $qb->delete('AriiJOCBundle:'.$class, 'j')
                ->where('j.updated < :now')
                ->andWhere('j.spooler = :spooler')
                 ->setParameter('now', $Now )
                 ->setParameter('spooler', $Spooler )
                 ->getQuery();
                $query->execute();
            } catch (Exception $ex) {
                print $ex->getMessage();
            }
        }
        
        // Residus 
        foreach (array( 'Tasks', 'LocksUse', 'JobParams', 'Payloads', 'FileOrders', 'Orders', 'JobChainNodes', 'Periods', 'OrderIdSpaces' ) as $class) {
            $this->PrintMessage(2,"- $class");
            try {
                $query = $qb->delete('AriiJOCBundle:'.$class, 'j')
                ->where('j.updated < :now')
                ->andWhere('j.spooler_id = :spooler')
                 ->setParameter('now', $Now )
                 ->setParameter('spooler', $spooler_id )
                 ->getQuery();
                $query->execute();
            } catch (Exception $ex) {
                print $ex->getMessage();
            }
        }
        $this->PrintMessage(1,"Purge ".(microtime(true)-$timer).'s');
        
        $this->PrintMessage(0,"GLOBAL ".(microtime(true)-$start).'s');
        return "success";
    }
        
    private function PrintMessage($level=0,$message) {
        if ($level>$this->debug) return;
	if ($this->mode == 'BATCH') {
		print str_repeat("\t",$level);
		print "$message\n";
	}
	elseif ($this->mode == 'WEB') {
		print str_repeat("&nbsp;",$level*5);
		print "$message<br/>";
	}
        return;
    }

    private function Schedule2Rows ( $Schedule ) {
        // print_r($Schedule);
        return;
    }

}
