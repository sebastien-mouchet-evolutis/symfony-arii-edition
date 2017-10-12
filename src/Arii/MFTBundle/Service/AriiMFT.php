<?php
// src/Arii/JIDBundle/Service/AriiHistory.php
/*
 * Recupere les données et fournit un tableau pour les composants DHTMLx
 */ 
namespace Arii\MFTBundle\Service;

class AriiMFT
{
    protected $db;
    protected $sql;
    protected $date;
    protected $driver;
    protected $ColorStatus;

    public function __construct (  
            \Arii\CoreBundle\Service\AriiPortal $portal,            
            \Arii\CoreBundle\Service\AriiDB $db, 
            \Arii\CoreBundle\Service\AriiSQL $sql,
            \Arii\CoreBundle\Service\AriiDate $date,
            $driver ) {
        $this->db = $db;
        $this->sql = $sql;
        $this->date = $date;
        
        // Les couleurs enctralisées
        $this->ColorStatus = $portal->getColors();
        
        // Le driver SQL est celui de la DB Arii
        $sql->setDriver($db->getDriver());

    }

    public function ColorStatus($status) {
        if (isset($this->ColorStatus[$status]['bgcolor'])) 
            return $this->ColorStatus[$status]['bgcolor'];
        return $this->ColorStatus['unknown']['bgcolor'];
    }
    
/*********************************************************************
 * Informations de connexions
 *********************************************************************/
   public function Status($partner=-1,$sort="HISTORY_ID desc") {   
        $data = $this->db->Connector('data');
        $sql = $this->sql;
        
        $Fields = array(
        );
        if ($partner>0) {
            $Fields['PARTNER_ID'] = $partner;
        }
        
        $qry = $sql->Select(
            array(  
                    's.ID','s.TRANSFER_ID','s.HISTORY_ID',
                    't.NAME','t.TITLE as TRANSFER','t.DESCRIPTION','t.STEP_START','t.STEP_END','t.PARTNER_ID','t.STEPS','t.SCHEDULE_ID',
                    'h.STATUS_TIME','h.TRANSFERRING','h.STATUS',
                    'd.START_TIME','d.END_TIME','d.RUN','d.STATUS as DELIVERY_STATUS','d.OPERATION_ID','d.ID as DELIVERY_ID',
                    'o.TITLE as OPERATION','o.STEP','o.EXIT_IF_NOTHING','o.EXPECTED_FILES','o.ORDERING',
                    'p.TITLE as PARTNER',
                    'c.NEXT_RUN'
                )
            )
        .$sql->From(array('MFT_STATUS s'))
        .$sql->LeftJoin('MFT_TRANSFERS t',array('s.TRANSFER_ID','t.ID'))                
        .$sql->LeftJoin('MFT_PARTNERS p',array('t.PARTNER_ID','p.ID'))
        .$sql->LeftJoin('MFT_HISTORY h',array('s.HISTORY_ID','h.ID'))
        .$sql->LeftJoin('MFT_DELIVERIES d',array('d.HISTORY_ID','h.ID'))
        .$sql->LeftJoin('MFT_OPERATIONS o',array('d.OPERATION_ID','o.ID'))
        .$sql->LeftJoin('MFT_SCHEDULES c',array('t.SCHEDULE_ID','c.ID'))
        .$sql->Where($Fields)
        .$sql->OrderBy(array( $sort));

        $res = $data->sql->query( $qry );
        $Status = array();
        while ($line = $data->sql->get_next($res)) {
            $id=$line['ID'];
            if (isset($this->ColorStatus[$line['STATUS']]['bgcolor']))
                $line['COLOR'] = $this->ColorStatus[$line['STATUS']]['bgcolor'];       
            else 
                $line['COLOR'] = '#FFFFFF';       
            $line['PROGRESS'] = $line['ORDERING'].'/'.$line['STEPS'];       
            $Status[$id] = $line;
        }        
        return $Status;
   }

   public function Histories($transfer=-1,$sort="ID desc") {   
        $data = $this->db->Connector('data');
        $sql = $this->sql;
        
        $Fields = array(
        );
        if ($transfer>0) {
            $Fields['h.TRANSFER_ID'] = $transfer;
        }
        
        $qry = $sql->Select(
            array(  
                    'h.STATUS_TIME','d.ID','d.STATUS','d.START_TIME','d.END_TIME','d.FILES_SIZE','d.DURATION','d.SUCCESS','d.SKIPPED','d.FAILED','d.RUN','d.TRY','d.LAST_ERROR','d.FILES_COUNT'
                )
            )
        .$sql->From(array('MFT_HISTORY h'))
        .$sql->LeftJoin('MFT_DELIVERIES d',array('h.ID','d.HISTORY_ID'))
        .$sql->Where($Fields)
        .$sql->OrderBy(array( 'h.'.$sort));

        $res = $data->sql->query( $qry );
        $Status = array();
        while ($line = $data->sql->get_next($res)) {
            $id=$line['ID'];
            // calcul de l'etat et donc de la couleur
            if ($line['FAILED']>0) {
                $line['STATE'] = 'FAILED';
            }
            elseif ($line['SKIPPED']>0) {
                $line['STATE'] = 'SKIPPED';
            }
            elseif ($line['SUCCESS']>0) {
                $line['STATE'] = 'SUCCESS';
            }
            else {
                $line['STATE'] = strtoupper($line['STATUS']);                
            }
            $line['COLOR'] = $this->ColorStatus($line['STATE']);
            $Status[$id] = $line;
        }        
        return $Status;
   }

   public function History($history=-1) {   
        $data = $this->db->Connector('data');
        $sql = $this->sql;
        
        $Fields = array(
        );
        if ($history>0) {
            $Fields['h.ID'] = $history;
        }
        
        $qry = $sql->Select(
            array(  
                    'h.ID','h.STATUS','h.START_TIME','h.END_TIME','h.STATUS_TIME','h.STEP','h.RUN',
                    't.STEP_END','t.NAME','t.TITLE','t.ENV'
                )
            )
        .$sql->From(array('MFT_HISTORY h'))
        .$sql->LeftJoin('MFT_DELIVERIES d',array('d.HISTORY_ID','h.ID'))                
        .$sql->LeftJoin('MFT_TRANSFERS t',array('h.TRANSFER_ID','t.ID'))
        .$sql->Where($Fields);

        $res = $data->sql->query( $qry );
        $Status = array();
        while ($line = $data->sql->get_next($res)) {
            $id=$line['ID'];
            // calcul de l'etat et donc de la couleur
            if ($line['STEP']>=$line['STEP_END']) {
                $line['STATE'] = 'ENDED';
            }
            elseif ($line['STATUS']=='success') {
                $line['STATE'] = 'RUNNING';
            }
            elseif ($line['STATUS']=='transfer_aborted') {
                $line['STATE'] = 'ABORTED';
            }
            else {
                $line['STATE'] = 'STOPPED';                
            }
            $line['COLOR'] = $this->ColorStatus($line['STATE']);
            $Status = $line;
        }        
        return $Status;
   }

   public function Operations($transfer=-1) {   
        $data = $this->db->Connector('data');
        $sql = $this->sql;
        
        $Fields = array(
        );
        if ($transfer>0) {
            $Fields['TRANSFER_ID'] = $transfer;
        }
        $qry = $sql->Select(
            array(  't.ID', 't.NAME','t.TITLE', 't.STEP','t.DESCRIPTION', 't.SOURCE_PATH', 't.TARGET_PATH', 't.SOURCE_FILES', 't.TARGET_FILES',
                    't.SOURCE_ID','t.TARGET_ID','t.ENV',
                    'p.TITLE as TRANSFER',                
                    'source.NAME as SOURCE',
                    'target.NAME as TARGET',
                )
            ) 
        .$sql->From(array('MFT_OPERATIONS t'))
        .$sql->LeftJoin('MFT_TRANSFERS p',array('t.TRANSFER_ID','p.ID'))
        .$sql->LeftJoin('ARII_CONNECTION source',array('t.SOURCE_ID','source.ID'))
        .$sql->LeftJoin('ARII_CONNECTION target',array('t.TARGET_ID','target.ID'))
        .$sql->Where($Fields)
        .$sql->OrderBy(array( 't.TRANSFER_ID', 't.STEP'));

        $res = $data->sql->query( $qry );
        $Transfers = array();
        while ($line = $data->sql->get_next($res)) {

            $id=$line['ID'];
            $Transfers[$id] = $line;
        }
        return $Transfers;
   }

   public function Transfers($partner=-1,$sort="TITLE") {   
        $data = $this->db->Connector('data');
        $sql = $this->sql;

        $Fields = array(
        );
        if ($partner>0) {
            $Fields['PARTNER_ID'] = $partner;
        }
        
        $qry = $sql->Select(
            array(  't.ID','t.TITLE', 't.DESCRIPTION','t.NAME','t.STEP_START','t.STEP_END','t.PARTNER_ID','t.CHANGE_TIME','t.CHANGE_USER','t.ENV',
                    'p.TITLE as PARTNER'
                )
            )
        .$sql->From(array('MFT_TRANSFERS t'))
        .$sql->LeftJoin('MFT_PARTNERS p',array('t.PARTNER_ID','p.ID'))
        .$sql->Where($Fields)
        .$sql->OrderBy(array( 't.'.$sort));

        $res = $data->sql->query( $qry );
        $Transfers = array();
        while ($line = $data->sql->get_next($res)) {
            $id=$line['ID'];
            
            $Transfers[$id] = $line;
        }        
        return $Transfers;
   }

   public function Partners($partner=-1) {   
        $data = $this->db->Connector('data');
        $sql = $this->sql;
        
        $Fields = array(
        );        
        if ($partner>0) {
            $Fields['t.ID'] = $partner;
        }
        
        $qry = $sql->Select(
            array(  't.ID','t.TITLE', 't.DESCRIPTION',
                    'c.NAME as CATEGORY'
                )
            ) 
        .$sql->From(array('MFT_PARTNERS t'))
        .$sql->LeftJoin('ARII_CATEGORY c',array('t.CATEGORY_ID','c.ID'))
        .$sql->Where($Fields)
        .$sql->OrderBy(array( 't.TITLE'));

        $res = $data->sql->query( $qry );
        $nb=0;
        $Transfers = array();
        while ($line = $data->sql->get_next($res)) {
            $id=$line['ID'];
            
            $Transfers[$id] = $line;
        }        
        return $Transfers;
   }
   
   // toutes les livraisons d'un transfert
   public function TransferDeliveries($transfer=-1, $log=false) {   
        $data = $this->db->Connector('data');
        $sql = $this->sql;

        $Select = array(  
                'd.ID','d.RUN','d.TRY','d.STATUS', 'd.FILES_SIZE','d.DURATION','d.SUCCESS','d.FAILED','d.SKIPPED','d.LAST_ERROR','d.START_TIME','d.END_TIME','d.STATUS_TEXT','d.FILES_COUNT',
                'o.NAME','o.TITLE','o.SOURCE_PATH','o.TARGET_PATH','o.SOURCE_FILES','o.STEP',
                'source.NAME as SOURCE',
                'target.NAME as TARGET'
                );

        if ($transfer>0) 
            $Fields = array( 'h.TRANSFER_ID' => $transfer );
        else 
            $Fields = array( '{start_time}' => 'd.START_TIME' );

        if ($log)
            array_push($Select,'d.LOG');
        
        $qry = $sql->Select($Select) 
        .$sql->From(array('MFT_DELIVERIES d'))
        .$sql->LeftJoin('MFT_HISTORY h',array('d.HISTORY_ID','h.ID'))
        .$sql->LeftJoin('MFT_OPERATIONS o',array('d.OPERATION_ID','o.ID'))
        .$sql->LeftJoin('ARII_CONNECTION source',array('o.SOURCE_ID','source.ID'))
        .$sql->LeftJoin('ARII_CONNECTION target',array('o.TARGET_ID','target.ID'))
        .$sql->Where($Fields)
        .$sql->OrderBy(array( 'd.END_TIME desc'));

        $res = $data->sql->query( $qry );
        $nb=0;
        $Deliveries = array();
        while (($line = $data->sql->get_next($res) and ($nb<100))) {
            $id=$line['ID'];

            $line['STATUS'] = $this->getStatus($line['STATUS'], $line['FAILED'], $line['SKIPPED'], $line['SUCCESS']);
            $line['COLOR']  = $this->ColorStatus($line['STATUS']);
            $Deliveries[$id] = $line;
            $nb++;
        }        
                
        return $Deliveries;
   }

   // toutes les livraisons d'un historique
   public function HistoryDeliveries($history=-1, $log=false) {   
        $data = $this->db->Connector('data');
        $sql = $this->sql;

        $Select = array(  
                'd.ID','d.RUN','d.TRY','d.STATUS', 'd.FILES_SIZE','d.DURATION','d.SUCCESS','d.FAILED','d.SKIPPED','d.LAST_ERROR','d.START_TIME','d.END_TIME','d.STATUS_TEXT','d.FILES_COUNT',
                'o.NAME','o.TITLE','o.SOURCE_PATH','o.TARGET_PATH','o.SOURCE_FILES','o.STEP',
                'source.NAME as SOURCE',
                'target.NAME as TARGET'
                );

        $Fields = array();
        if ($history>0)
            $Fields['d.HISTORY_ID'] = $history;
        if ($log)
            array_push($Select,'d.LOG_OUTPUT');
        
        $qry = $sql->Select($Select) 
        .$sql->From(array('MFT_DELIVERIES d'))
        .$sql->LeftJoin('MFT_OPERATIONS o',array('d.OPERATION_ID','o.ID'))
        .$sql->LeftJoin('ARII_CONNECTION source',array('o.SOURCE_ID','source.ID'))
        .$sql->LeftJoin('ARII_CONNECTION target',array('o.TARGET_ID','target.ID'))
        .$sql->Where($Fields)
        .$sql->OrderBy(array( 'o.STEP'));

        $res = $data->sql->query( $qry );
        $nb=0;
        $Deliveries = array();
        while (($line = $data->sql->get_next($res)) and ($nb<100)) {
            $id=$line['ID'];

            $line['STATUS'] = $this->getStatus($line['STATUS'], $line['FAILED'], $line['SKIPPED'], $line['SUCCESS']);
            $line['COLOR']  = $this->ColorStatus($line['STATUS']);
            $Deliveries[$id] = $line;
            $nb++;
        }        
                
        return $Deliveries;
   }

   public function Delivery($delivery=-1) {   
        $data = $this->db->Connector('data');
        $sql = $this->sql;

        $Fields = array(
        );
        $Select = array(  
                'd.ID','d.RUN','d.TRY','d.STATUS', 'd.FILES_SIZE','d.DURATION','d.SUCCESS','d.FAILED','d.SKIPPED','d.LAST_ERROR','d.START_TIME','d.END_TIME','d.STATUS_TEXT','d.FILES_COUNT',
                'o.NAME','o.TITLE','o.SOURCE_PATH','o.TARGET_PATH','o.SOURCE_FILES','o.STEP' );

        if ($delivery>0) {
            $Fields['d.ID'] = $delivery;
            array_push($Select,'d.LOG_OUTPUT');
        }        
        
        $qry = $sql->Select($Select) 
        .$sql->From(array('MFT_DELIVERIES d'))
        .$sql->LeftJoin('MFT_OPERATIONS o',array('d.OPERATION_ID','o.ID'))
        .$sql->Where($Fields)
        .$sql->OrderBy(array( 'd.START_TIME desc','o.NAME'));

        $res = $data->sql->query( $qry );
        $nb=0;
        $Deliveries = array();
        while ($line = $data->sql->get_next($res)) {
            $id=$line['ID'];
            
            // Calcul du status
            if ($line['STATUS']=='failure')
                $line['STATUS'] = 'FAILURE';
            elseif ($line['FAILED']>0)
                $line['STATUS'] = 'FAILURE';
            elseif ($line['SKIPPED']>0)
                $line['STATUS'] = 'WARNING';
            else
                $line['STATUS'] = 'SUCCESS';
            
            if (!isset($line['LOG_OUTPUT'])) {
                $line['LOG_OUTPUT'] = '';
            }
            elseif (is_object($line['LOG_OUTPUT'])) {
                $line['LOG_OUTPUT'] = $line['LOG_OUTPUT']->load();
            }
            $Deliveries[$id] = $line;
            
        }        
        return $Deliveries;
   }

   public function Transmissions($delivery,$run="",$try=0) {   
        $data = $this->db->Connector('data');
        $sql = $this->sql;

        $Fields = array();

        if ($delivery>0) {
            $Fields['t.DELIVERY_ID'] = $delivery;
        }
        if ($run!=0) {
            $Fields['d.RUN'] = $run;
            $Fields['d.TRY'] = $try;
        }
        
        $qry = $sql->Select(array(  
                't.ID','t.DELIVERY_ID','t.STATUS', 't.PID','t.FILE_SIZE','t.MD5','t.SOURCE_FILE','t.TARGET_FILE','t.DURATION','t.START_TIME','t.END_TIME',
                'o.TITLE as OPERATION')) 
        .$sql->From(array('MFT_TRANSMISSIONS t'))
        .$sql->LeftJoin('MFT_DELIVERIES d',array('t.DELIVERY_ID','d.ID'))
        .$sql->LeftJoin('MFT_OPERATIONS o',array('d.OPERATION_ID','o.ID'))
        .$sql->Where($Fields)
        .$sql->OrderBy(array( 't.START_TIME desc'));

        $res = $data->sql->query( $qry );
        $nb=0;
        $Transmissions = array();
        while (($line = $data->sql->get_next($res)) and ($nb<200)) {
            $id=$line['ID'];
            $Transmissions[$id] = $line;
            $nb++;
        }        
        return $Transmissions;
   }

   public function Parameters($parameters_id) {   
        $data = $this->db->Connector('data');
        $sql = $this->sql;

        $Fields = array();

        if ($parameters_id>0) {
            $Fields['ID'] = $parameters_id;
        }
        
        $qry = $sql->Select(array(  
                'ID','NAME','TITLE','DESCRIPTION' )) 
        .$sql->From(array('MFT_PARAMETERS t'))
        .$sql->Where($Fields)
        .$sql->OrderBy(array( 'TITLE'));

        $res = $data->sql->query( $qry );
        $nb=0;
        $Transmissions = array();
        while ($line = $data->sql->get_next($res)) {
            $id=$line['ID'];
            $Transmissions[$id] = $line;
        }        
        return $Transmissions;
   }

    private function getStatus($status, $failed, $skipped, $success) {
        return $status;
        if ($failed+$skipped+$success==0)
            return 'NOTHING';
        elseif ($failed>0) 
            return 'FAILED';
        elseif ($skipped>0) 
            return 'SKIPPED';
        elseif ($success>0) 
            return 'SUCCESS';
        else return $status;
    }
}
