<?php
// src/Arii/JOCBundle/Service/AriiJOC.php
/*
 * Service d'interface avec la base de données en ORM
 */
namespace Arii\JOCBundle\Service;

class AriiJOC
{
    protected $portal;
    protected $doctrine;
    protected $requests;

    public function __construct (
            \Arii\CoreBundle\Service\AriiPortal $portal,
            $doctrine,
            \Arii\CoreBundle\Service\AriiRequests $request ) {

        $this->portal = $portal;
        $this->doctrine = $doctrine;
        $this->requests = $request;
    }

    
    public function getSpooler($id) {
        $em = $this->doctrine->getManager();        
        $Spooler = $em->getRepository("AriiJOCBundle:Spoolers")->find($id);        
        if (!$Spooler)
            throw new \Exception('JOC',1);
        
        return [
            'SPOOLER'           => $Spooler->getName(),
            'HOST'              => $Spooler->getHost(),
            'IP_ADDRESS'        => $Spooler->getIpAddress(),
            'PORT'              => $Spooler->getTcpPort(),
            'CONNECTION'        => $Spooler->getDb()
        ];
    }

    public function getJobChain($id) {
        $em = $this->doctrine->getManager();        
        $Chain = $em->getRepository("AriiJOCBundle:JobChains")->find($id);        
        if (!$Chain)
            throw new \Exception('JOC',2);
        
        return [
            'SPOOLER_ID'     => $Chain->getSpooler()->getId(),
            'NAME'           => $Chain->getName()   
        ];
    }
    
    public function getJobChainNode($id) {
        $em = $this->doctrine->getManager();        
        $Node = $em->getRepository("AriiJOCBundle:JobChainNodes")->find($id);        
        if (!$Node)
            throw new \Exception('JOC',3);
        
        return [
            'JOB_CHAIN_ID'     => $Node->getJobChain()->getId()
        ];
    }
    
    public function getOrders($sort) {    
        $em = $this->doctrine->getManager();  
        $Orders = $em->getRepository("AriiJOCBundle:Orders")->findBy([],$sort);
        $Status = [
            'SUSPENDED'   => 0,
            'FAILURE'     => 0,
            'RUNNING'     => 0,
            'READY'       => 0,
            'QUEUED'      => 0,
            'PAUSED'      => 0,
            ''            => 0
        ];
        $Grid = $Spooler = $SpoolerState = [];
        foreach ($Orders as $Order) {
            $id  = $Order->getId();
            $name = $Order->getName();
            $status = $Order->getState();
            $status = $Order->getSuspended();
            $status = ''; // ne devrait pas exister
            // La date 
            if ($Order->getRunning()>0) {
                $status = 'RUNNING';
                $time = $Order->getStartTime()->format('Y-m-d H:i:s');
            }
            else if ($Order->getSuspended()>0) {                
                $time = $Order->getUpdated()->format('Y-m-d H:i:s');
                if (substr($Order->getState(),0,1)=='!') {
                    $status = 'FAILURE';
                }
                else {
                    $status = 'SUSPENDED';
                }
            }
            else {
                if ($Order->getNextStartTime()) {
                    $status = 'READY';
                    $time = $Order->getNextStartTime()->format('Y-m-d H:i:s');
                }
                else {
                    $status = 'QUEUED';
                    if ($Order->getStartTime())
                        $time = $Order->getStartTime()->format('Y-m-d H:i:s');
                    else 
                        $time = '...';
                }
            }
            
            $spooler_id = $Order->getSpoolerId();
            // Spooler ?
            if (!isset($Spooler[$spooler_id])) {
                $S = $em->getRepository("AriiJOCBundle:Spoolers")->find($spooler_id);
                $Spooler[$spooler_id] = $S->getName();
                if ($S->getName() != $S->getHost()) {
                    $Spooler[$spooler_id] .= '/'.$S->getHost();
                }
                // on en profite pour l'état du scheduler
                $SpoolerState[$spooler_id] = $S->getState();
                
            }
            if ($SpoolerState[$spooler_id]=='paused') {
                $status = 'PAUSED';
            }
            $Grid[$id] = [
                'ID'        => $id,
                'SPOOLER'   => $Spooler[$spooler_id],
                'PATH'      => dirname($Order->getPath()),
                'ORDER'     => $name,
                'STATE'     => $Order->getState(),
                'STATUS'    => $status,
                'UPDATED'   => $time,
                'SPOOLER_STATE' => $SpoolerState[$spooler_id],
                'COLOR'     => $status
            ];
            $Status[$status]++;
        }

        // On sauvegarde les resultats
        $this->requests->writeStatus([
            'name'    => 'SUSPENDED',
            'title'   => 'Orders suspended',
            'results' => $Status['SUSPENDED'],
            'status'  => 0
            ]
            , 'JOC');
        return [$Grid,$Status];
    }

    public function getJobChains($sort) {
        $em = $this->doctrine->getManager();  
        $Chains = $em->getRepository("AriiJOCBundle:JobChains")->findBy([],$sort);
        $Status = [
            'STOPPED'   => 0,
            'RUNNING'   => 0,
            'READY'     => 0,
            'QUEUED'    => 0,
            'MANUAL'    => 0,
            ''          => 0
        ];
        $Grid = $Spooler = $SpoolerState = [];
        foreach ($Chains as $Chain) {
            $id  = $Chain->getId();
            $name = $Chain->getName();
            $status = ''; // ne devrait pas exister

            $running_orders = $Chain->getRunningOrders();
            $max_orders = $Chain->getMaxOrders();
            $orders = $Chain->getOrders();
            $order_info = '';
            
            $state = $Chain->getState();
            if ($state == 'stopped') {
                $status = 'STOPPED';
                $order_info = $orders;
            }
            elseif ($orders == 0) {
                $status = "MANUAL";
            }
            else {
                if ($running_orders>0) {
                    $status = 'RUNNING';
                    $order_info = "$orders [$running_orders]";
                    if ($max_orders>0) {
                        $order_info = "$orders [$running_orders/$max_orders]";
                    }
                }
                else {
                    $status = 'READY';
                    $order_info = "$orders";
                }
            }

            $S = $Chain->getSpooler();            
            $spooler_id = $S->getId();
            // Spooler ?
            if (!isset($Spooler[$spooler_id])) {                
                $Spooler[$spooler_id] = $S->getName();
                if ($S->getName() != $S->getHost()) {
                    $Spooler[$spooler_id] .= '/'.$S->getHost();
                }
                // on en profite pour l'état du scheduler
                $SpoolerState[$spooler_id] = $S->getState();
                
            }
            if ($SpoolerState[$spooler_id]=='paused') {
                $status = 'PAUSED';
            }
            $Grid[$id] = [
                'ID'        => $id,
                'SPOOLER'   => $Spooler[$spooler_id],
                'PATH'      => dirname($Chain->getPath()),
                'STATE'     => $state = $Chain->getState(),
                'STATUS'    => $status,
                'UPDATED'   => $Chain->getUpdated()->format('Y-m-d H:i:s'),
                'SPOOLER_STATE' => $SpoolerState[$spooler_id],
                'ORDERS'    => $order_info,
                'COLOR'     => $status
            ];
            $Status[$status]++;
        }

        // On sauvegarde les resultats
        $this->requests->writeStatus([
            'name'    => 'CHAINS STOPPED',
            'title'   => 'Chains stopped',
            'results' => $Status['STOPPED'],
            'status'  => 0
            ]
            , 'JOC');
        return [$Grid,$Status];
    }
    
    public function getJobs($sort) {    
        $em = $this->doctrine->getManager();  
        $Jobs = $em->getRepository("AriiJOCBundle:Jobs")->findBy([],$sort);
        $Status = [
            'STOPPED'     => 0,
            'RUNNING'     => 0,
            'QUEUED'      => 0,
            'READY'       => 0,
            'PAUSED'      => 0,
            ''            => 0
        ];
        $Grid = $Spooler = $SpoolerState = [];
        foreach ($Jobs as $Job) {
            $id  = $Job->getId();
            $name = $Job->getName();
            
            if ($Job->getState()=='stopped') {
                $status  = 'STOPPED';
            }
            elseif ($Job->getState()=='running') {
                $status  = 'RUNNING';
            }
            elseif ($Job->getError()>0) {
                $status = 'FAILURE';
            }
            elseif ($Job->getWaitingForProcess()) {
                $status = 'QUEUED';
            }
            else {
                $status = 'READY';
            }

            $S = $Job->getSpooler();
            $spooler_id = $S->getId();
            // Spooler ?
            if (!isset($Spooler[$spooler_id])) {
                $Spooler[$spooler_id] = $S->getName();
                if ($S->getName() != $S->getHost()) {
                    $Spooler[$spooler_id] .= '/'.$S->getHost();
                }
                // on en profite pour l'état du scheduler
                $SpoolerState[$spooler_id] = $S->getState();
                
            }
            if ($SpoolerState[$spooler_id]=='paused') {
                $status = 'PAUSED';
            }
            $Grid[$id] = [
                'ID'        => $id,
                'SPOOLER'   => $Spooler[$spooler_id],
                'PATH'      => $Job->getPath(),
                'STATUS'    => $status,
                'TASKS'     => $Job->getTasks(),
                'NEXT_START'=> $Job->getNextStartTime(),
                'SPOOLER_STATE' => $SpoolerState[$spooler_id],
                'COLOR'     => $status,
                'UPDATED'   => $Job->getUpdated()->format('Y-m-d H:i:s')
            ];
            $Status[$status]++;
        }

        // On sauvegarde les resultats
        $this->requests->writeStatus([
            'name'    => 'JOBS STOPPED',
            'title'   => 'Jobs stopped',
            'results' => $Status['STOPPED'],
            'status'  => 0
            ]
            , 'JOC');
        
        return [$Grid,$Status];
    }

    public function getProcessClasses($sort=['updated' => 'DESC']) {    
        $em = $this->doctrine->getManager();  
        $Classes = $em->getRepository("AriiJOCBundle:ProcessClasses")->findBy([],$sort);
        $Status = [
            'RUNNING'     => 0,
            'READY'       => 0,
            'FULL'        => 0,
            'PAUSED'      => 0,
            ''            => 0
        ];
        $Grid = $Spooler = $SpoolerState = [];
        foreach ($Classes as $Class) {
            $id  = $Class->getId();
            $name = $Class->getName();
            
            $info = '';
            if ($Class->getProcesses()==$Class->getMaxProcesses()) {
                $status  = 'FULL';
                $info = '100%';
            }
            elseif ($Class->getProcesses()>0) {
                $status  = 'RUNNING';                
                $info = round($Class->getProcesses()*100/$Class->getMaxProcesses()).'%';
            }
            else {
                $status = 'READY';
            }

            $S = $Class->getSpooler();
            $spooler_id = $S->getId();
            // Spooler ?
            if (!isset($Spooler[$spooler_id])) {
                $Spooler[$spooler_id] = $S->getName();
                if ($S->getName() != $S->getHost()) {
                    $Spooler[$spooler_id] .= '/'.$S->getHost();
                }
                // on en profite pour l'état du scheduler
                $SpoolerState[$spooler_id] = $S->getState();
                
            }
            if ($SpoolerState[$spooler_id]=='paused') {
                $status = 'PAUSED';
            }
            $Grid[$id] = [
                'ID'        => $id,
                'SPOOLER'   => $Spooler[$spooler_id],
                'PATH'      => $Class->getPath(),
                'STATUS'    => $status,
                'PROCESSES' => $Class->getProcesses(),
                'REMOTE_SCHEDULER' => $Class->getRemoteScheduler(),
                'SPOOLER_STATE' => $SpoolerState[$spooler_id],
                'COLOR'     => $status,
                'UPDATED'   => $Class->getUpdated()->format('Y-m-d H:i:s'),
                'INFO'      => $info
                    
            ];
            $Status[$status]++;
        }

        // On sauvegarde les resultats
        $this->requests->writeStatus([
            'name'    => 'PROCESS CLASSES FULL',
            'title'   => 'Process classes not available',
            'results' => $Status['FULL'],
            'status'  => 0
            ]
            , 'JOC');
        
        return [$Grid,$Status];
    }

    
    public function getLocks($sort) {   
        $em = $this->doctrine->getManager();  
        $Locks = $em->getRepository("AriiJOCBundle:Locks")->findBy([],$sort);
        $Status = [
            'FREE'   => 0,
            'USED'   => 0,
            'PAUSED' => 0
        ];
        $Grid = $Spooler = $SpoolerState = [];
        $status = '';
        foreach ($Locks as $Lock) {
            $id  = $Lock->getId();
            $path = dirname($Lock->getPath());
            $name = basename($Lock->getPath());
            // La date 
            if ($Lock->getIsFree()>0) {
                $status = 'FREE';
            }
            else {
                $status = 'USED';
            }
            
            $S = $Lock->getSpooler();
            $spooler_id = $S->getId();
            // Spooler ?
            if (!isset($Spooler[$spooler_id])) { 
                $Spooler[$spooler_id] = $S->getName();
                if ($S->getName() != $S->getHost()) {
                    $Spooler[$spooler_id] .= '/'.$S->getHost();
                }
                // on en profite pour l'état du scheduler
                $SpoolerState[$spooler_id] = $S->getState();
                
            }
            if ($SpoolerState[$spooler_id]=='paused') {
                $status = 'PAUSED';
            }
            $Grid[$id] = [
                'ID'        => $id,
                'SPOOLER'   => $Spooler[$spooler_id],
                'PATH'      => $path,
                'LOCK'      => $name,
                'STATUS'    => $status,
                'UPDATED'   => $Lock->getUpdated()->format('Y-m-d H:i:s'),
                'SPOOLER_STATE' => $SpoolerState[$spooler_id],
                'COLOR'     => $status
            ];
            $Status[$status]++;
        }

        // On sauvegarde les resultats
        $this->requests->writeStatus([
            'name'    => 'LOCKS_MISSING',
            'title'   => 'Locks missing',
            'results' => $Status['USED'],
            'status'  => 0
            ]
            , 'JOC');
        return [$Grid,$Status];
    }
    
    public function getLocksUse($sort) {    
        $em = $this->doctrine->getManager();
        
        $Locks = $em->getRepository("AriiJOCBundle:LocksUse")->findBy([],$sort);
        $Status = [
            'MISSING'   => 0,
            'FREE'   => 0,
            'WAIT'   => 0,
            'PAUSED' => 0
        ];
        $Grid = $Spooler = $SpoolerState = [];
        $status = '';
        $Used = [];
        foreach ($Locks as $Lock) {
            $id  = $Lock->getId();
            $path = dirname($Lock->getPath());
            $name = basename($Lock->getPath());
            // La date 
            if ($Lock->getIsMissing()>0) {
                $status = 'MISSING';
            }
            else if ($Lock->getIsAvailable()==0) {
                $status = 'WAIT';
            }
            else {
                $status = 'FREE';
            }
            
            $spooler_id = $Lock->getSpoolerId();
            // Spooler ?
            if (!isset($Spooler[$spooler_id])) {                
                $S = $em->getRepository("AriiJOCBundle:Spoolers")->find($spooler_id);
                $Spooler[$spooler_id] = $S->getName();
                if ($S->getName() != $S->getHost()) {
                    $Spooler[$spooler_id] .= '/'.$S->getHost();
                }
                // on en profite pour l'état du scheduler
                $SpoolerState[$spooler_id] = $S->getState();
                
            }
            if ($SpoolerState[$spooler_id]=='paused') {
                $status = 'PAUSED';
            }
            $Grid[$id] = [
                'ID'        => $id,
                'SPOOLER'   => $Spooler[$spooler_id],
                'PATH'      => $path,
                'LOCK'      => $name,
                'STATUS'    => $status,
                'UPDATED'   => $Lock->getUpdated()->format('Y-m-d H:i:s'),
                'SPOOLER_STATE' => $SpoolerState[$spooler_id],
                'COLOR'     => $status,
                'UPDATED'   => $Lock->getIsAvailable()
            ];
            $id = $Spooler[$spooler_id].'/'.$path.'/'.$name;
            $Used[$id]=true;
            $Status[$status]++;
        }

        // On sauvegarde les resultats
        $this->requests->writeStatus([
            'name'    => 'LOCKS_MISSING',
            'title'   => 'Locks missing',
            'results' => $Status['MISSING'],
            'status'  => 0
            ]
            , 'JOC');
        $this->requests->writeStatus([
            'name'    => 'LOCKS NOT AVAILABLE',
            'title'   => 'Locks not available',
            'results' => $Status['WAIT'],
            'status'  => 0
            ]
            , 'JOC');
        return [$Grid,$Status];
    }

    public function getOrder($id) {
        $em = $this->doctrine->getManager();        
        $Order = $em->getRepository("AriiJOCBundle:Orders")->find($id);
        if (!$Order)
            throw new \Exception('JOC',4);
        
        // Pour le complement
        $p = strpos($Order->getName(),',');

        return [
            'ID'                => $Order->getId(),
            'END_STATE'         => $Order->getEndState(),
            'HISTORY_ID'        => $Order->getHistoryId(),
            'IN_PROCESS_SINCE'  => $Order->getInProcessSince(),
            'INITIAL_STATE'     => $Order->getInitialState(),
            'JOB_CHAIN_NODE_ID' => $Order->getJobChainNode()->getId(),
            'PATH'              => $Order->getPath(),
            'STATE'             => $Order->getState(),
            'STATE_TEXT'        => $Order->getStateText(),
            'SCHEDULE'          => $Order->getSchedule(),
            'SETBACK'           => $Order->getSetback(),
            'SETBACK_COUNT'     => $Order->getSetbackCount(),
            'TITLE'             => $Order->getTitle(),
            'NEXT_START_TIME'   => $Order->getNextStartTime(),                
            'ORDER'             => $Order->getIdOrder(),
            'PRIORITY'          => $Order->getPriority(),
            'SPOOLER_ID'        => $Order->getSpoolerId(),
            'START_TIME'        => $Order->getStartTime(),
            'SUSPENDED'         => $Order->getSuspended(),
            'TASK_ID'           => $Order->getTaskId(),
            'ON_BLACKLIST'      => $Order->getOnBlacklist(),
            // Complement
            'NAME'              => substr($Order->getName(),$p+1),
            'CHAIN'             => substr($Order->getName(),0,$p),
            'FOLDER'            => dirname($Order->getPath()),
            'STATUS'            => ($Order->getSuspended()>0?'SUSPENDED':'ACTIVE')
        ];
    }
}

