<?php
namespace Arii\ReportBundle\Service;

class ImportEZV {
    
    protected $em;
    
    public function __construct(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;        
    }

    public function Import() {
        set_time_limit(600); 
        if (function_exists('mssql_connect')) {
            $Asset = $this->getMSSql();
        }
        elseif (function_exists('sqlsrv_connect')) {
            $Asset = $this->getSqlSrv();
        }
        else {
            print "Aucun pilote de connexion pour SqlServer";
            exit();
        }
        $this->importIP($Asset);
        return $this->importEZV($Asset);        
    }

    // Driver MSSQL 
    private function getMSSql() {
        set_time_limit(180);
        
        $EZV = $this->em->getRepository("AriiCoreBundle:Connection")->findOneBy([ 'name' => 'ezv' ]);
        if (!$EZV) { 
            print "EZV not defined !!!";
            exit();
        }
        
        // Replace the value of these variables with your own data
        $serverName = $EZV->getInterface().'\\'.$EZV->getInstance();      
        $conn = mssql_connect($serverName, $EZV->getLogin(), $EZV->getPassword());
        if( $conn ) {
             echo "Connexion établie.<br />";
        }else{
             echo "La connexion n'a pu être établie.<br />";
             die( print_r( sqlsrv_errors(), true));
        }

        $sql = "select * from AM_ASSET_CHARACTERISTICS where CHARACTERISTIC_ID in (104,56,57,62)";
        $stmt = mssql_query( $sql );
        if( $stmt === false) {
            die( print_r( mssql_errors(), true) );
        }

        $Asset = $Role = $OS = $Component = $Env = array();
        while( $row = mssql_fetch_array( $stmt) ) {
            $asset = $row['ASSET_ID'];
            $type = $row['CHARACTERISTIC_ID'];
            switch($type) {
                case '104':
                    $Role[$asset] = $row['DATA_1'];
                    break;
                case '57':
                    $OS[$asset] = $row['DATA_1'];
                    break;
                case '56':
                    $Component[$asset] = $row['DATA_1'];
                    break;
                case '62':
                    $Env[$asset] = $row['DATA_1'];
                    break;
            }            
        }
        // mssql_free_statement ( $stmt);

        $cols = "ASSET_ID,NETWORK_IDENTIFIER,BELONGS_TO_THE_ASSETS,IS_STOCK_STATUS,INSTALLATION_DATE,REMOVED_DATE,ASSET_TAG,SERIAL_NUMBER,E_CMDB_BKPSTATUS,E_CMDB_BKPPLATF,E_CMDB_BKPTYPE,E_CMDB_BKPPOL,E_CMDB_BKPAGENT,E_CMDB_BKPALARM,E_CMDB_BKPSELECT,E_CMDB_BKPSETDATE,E_CMDB_RAISONNOBKP,E_CMDB_RDI,E_CMDB_RDA,E_CMDB_RDM,E_CMDB_ALIAS,E_AM_FUNCTION,STATUS_FR,CI_STATUS_FR,IS_CI,UN_CLASSIFICATION_FR,UN_CLASSIFICATION_PATH_FR";

        $sql = "SELECT a.LAST_UPDATE,$cols"
            . " FROM AM_ASSET a "
            . " left join AM_STATUS s on a.STATUS_ID=s.STATUS_ID"
            . " left join AM_CATALOG cat on a.CATALOG_ID=cat.CATALOG_ID"
            . " left join AM_UN_CLASSIFICATION class on cat.UN_CLASSIFICATION_ID=class.UN_CLASSIFICATION_ID"
            . " left join AM_UN_CLASSIFICATION_PATH path on class.UN_CLASSIFICATION_ID=path.UN_CLASSIFICATION_ID"
            . " left join CMDB_CI_STATUS c on a.CI_STATUS_ID=c.CI_STATUS_ID"
            . " where (IS_CI=1) AND ((ASSET_TAG like 'xx%') or (ASSET_TAG like 'sg%') or (ASSET_TAG like 'SG%') or (ASSET_TAG like 'va400%') or (NETWORK_IDENTIFIER like 'xx%') or (NETWORK_IDENTIFIER like 'sg%') or (NETWORK_IDENTIFIER like 'SG%') or (NETWORK_IDENTIFIER like 'va400%')) "
            . " order by ASSET_TAG ";
        $Columns = explode(",","LAST_UPDATE,$cols");
        
        $stmt = mssql_query( $sql );
        if( $stmt === false) {
            die( print_r( mssql_errors(), true) );
        }

        $Asset = array();
        while( $row = mssql_fetch_array( $stmt) ) {
            $asset = $row["ASSET_ID"];
            foreach ($Columns as $c) {
                $Asset[$asset][$c] = $row[$c];                    
            }
            // on ajoute le type
            if (!isset($Role[$asset]))
                $Role[$asset] = '';
            $Asset[$asset]['ROLE'] = $Role[$asset];  
            
            if (!isset($OS[$asset]))
                $OS[$asset] = '';
            $Asset[$asset]['OS'] = $OS[$asset];  

            if (!isset($Component[$asset]))
                $Component[$asset] = '';
            $Asset[$asset]['Component'] = $Component[$asset];  

            if (!isset($Env[$asset]))
                $Env[$asset] = '';
            $Asset[$asset]['Env'] = $Env[$asset];  

            
        }
        // mssql_free_statement ( $stmt);

        return $Asset;
    }
    
    private function getSqlSrv() {
        set_time_limit(180);
        
        $EZV = $this->em->getRepository("AriiCoreBundle:Connection")->findOneBy([ 'name' => 'ezv' ]);
        if (!$EZV) { 
            print "EZV not defined !!!";
            exit();
        }
        
        // Replace the value of these variables with your own data
        $serverName = $EZV->getInterface().'\\'.$EZV->getInstance();      
        if ($EZV->getLogin()!='') 
            $connectionInfo = array( 
                "Database"=> $EZV->getDatabase(), 
                "UID"=> $EZV->getLogin(), 
                "PWD"=> $EZV->getPassword() );
        else # Connexion Windows
            $connectionInfo = array( 
                "Database"=> $EZV->getDatabase() );

        $conn = sqlsrv_connect( $serverName, $connectionInfo);
        if( $conn ) {
             echo "Connexion établie.<br />";
        }else{
             echo "La connexion n'a pu être établie.<br />";
             die( print_r( sqlsrv_errors(), true));
        }

        $sql = "select * from AM_ASSET_CHARACTERISTICS where CHARACTERISTIC_ID in (104,56,57,62)";
        $stmt = sqlsrv_query( $conn, $sql );
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }

        $Asset = $Role = $OS = $Component = $Env = array();
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $asset = $row['ASSET_ID'];
            $type = $row['CHARACTERISTIC_ID'];
            switch($type) {
                case '104':
                    $Role[$asset] = $row['DATA_1'];
                    break;
                case '57':
                    $OS[$asset] = $row['DATA_1'];
                    break;
                case '56':
                    $Component[$asset] = $row['DATA_1'];
                    break;
                case '62':
                    $Env[$asset] = $row['DATA_1'];
                    break;
            }            
        }
        sqlsrv_free_stmt( $stmt);

        $cols = "ASSET_ID,NETWORK_IDENTIFIER,BELONGS_TO_THE_ASSETS,IS_STOCK_STATUS,INSTALLATION_DATE,REMOVED_DATE,ASSET_TAG,SERIAL_NUMBER,E_CMDB_BKPSTATUS,E_CMDB_BKPPLATF,E_CMDB_BKPTYPE,E_CMDB_BKPPOL,E_CMDB_BKPAGENT,E_CMDB_BKPALARM,E_CMDB_BKPSELECT,E_CMDB_BKPSETDATE,E_CMDB_RAISONNOBKP,E_CMDB_RDI,E_CMDB_RDA,E_CMDB_RDM,E_CMDB_ALIAS,E_AM_FUNCTION,STATUS_FR,CI_STATUS_FR,IS_CI,UN_CLASSIFICATION_FR,UN_CLASSIFICATION_PATH_FR";

        $sql = "SELECT a.LAST_UPDATE,$cols"
            . " FROM AM_ASSET a "
            . " left join AM_STATUS s on a.STATUS_ID=s.STATUS_ID"
            . " left join AM_CATALOG cat on a.CATALOG_ID=cat.CATALOG_ID"
            . " left join AM_UN_CLASSIFICATION class on cat.UN_CLASSIFICATION_ID=class.UN_CLASSIFICATION_ID"
            . " left join AM_UN_CLASSIFICATION_PATH path on class.UN_CLASSIFICATION_ID=path.UN_CLASSIFICATION_ID"
            . " left join CMDB_CI_STATUS c on a.CI_STATUS_ID=c.CI_STATUS_ID"
            . " where (IS_CI=1) AND ((ASSET_TAG like 'xx%') or (ASSET_TAG like 'sg%') or (ASSET_TAG like 'SG%') or (ASSET_TAG like 'va400%') or (NETWORK_IDENTIFIER like 'xx%') or (NETWORK_IDENTIFIER like 'sg%') or (NETWORK_IDENTIFIER like 'SG%') or (NETWORK_IDENTIFIER like 'va400%')) "
            . " order by ASSET_TAG ";
        $Columns = explode(",","LAST_UPDATE,$cols");
        
        $stmt = sqlsrv_query( $conn, $sql );
        if( $stmt === false) {
            die( print_r( sqlsrv_errors(), true) );
        }

        $Asset = array();
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $asset = $row["ASSET_ID"];
            foreach ($Columns as $c) {
                $Asset[$asset][$c] = $row[$c];                    
            }
            // on ajoute le type
            if (!isset($Role[$asset]))
                $Role[$asset] = '';
            $Asset[$asset]['ROLE'] = $Role[$asset];  
            
            if (!isset($OS[$asset]))
                $OS[$asset] = '';
            $Asset[$asset]['OS'] = $OS[$asset];  

            if (!isset($Component[$asset]))
                $Component[$asset] = '';
            $Asset[$asset]['Component'] = $Component[$asset];  

            if (!isset($Env[$asset]))
                $Env[$asset] = '';
            $Asset[$asset]['Env'] = $Env[$asset];  

            
        }
        sqlsrv_free_stmt( $stmt);
        return $Asset;
    }
    
    private function importEZV($Asset) {
        
        $EZV = $this->em->getRepository("AriiReportBundle:EZV")->findAll();
        $nb=0;
        foreach ($EZV as $easy) {
            $id = $easy->getAssetId();
            if (isset($Asset[$id])) continue;
            print $id.":".$easy->getAssetTag()." ".$easy->getNetworkIdentifier()."<br/>";
            $this->em->remove($easy);
            $nb++;
            if ($nb % 100 == 0)
                $this->em->flush();  
        }
        $this->em->flush();  
        
         foreach ($Asset as $name => $asset) {
            
            $EZV = $this->em->getRepository("AriiReportBundle:EZV")->findOneBy(array('asset_id'=> $name));        
            if (!$EZV) {
                $EZV= new \Arii\ReportBundle\Entity\EZV();
            }
            
            $EZV->setAssetId($asset['ASSET_ID']);
            $EZV->setAssetTag(strtolower($asset['ASSET_TAG']));
            
            $EZV->setStatus(utf8_encode($asset['STATUS_FR']));
            $EZV->setStatusCi(utf8_encode($asset['CI_STATUS_FR']));
            
//            $EZV->setInstallation(new \DateTime($asset['INSTALLATION_DATE']));
//            $EZV->setRemoved(new \DateTime($asset['REMOVED_DATE']));
            
//            if ($asset['LAST_UPDATE']!='')
//                $EZV->setLastUpdate(new \DateTime($asset['LAST_UPDATE']));

            $EZV->setRole(utf8_encode($asset['ROLE']));
            
            $EZV->setSerial($asset['SERIAL_NUMBER']);
            
            $EZV->setRdi(str_replace(' ','',$asset['E_CMDB_RDI']));
            $EZV->setRda(str_replace(' ','',$asset['E_CMDB_RDA']));
            $EZV->setRdm(str_replace(' ','',$asset['E_CMDB_RDM']));
            
            if ($asset['E_CMDB_BKPSETDATE'] != '') {
                $date = sprintf("%04d-%02d-%02d 00:00:00",substr($asset['E_CMDB_BKPSETDATE'],6,4),substr($asset['E_CMDB_BKPSETDATE'],3,2),substr($asset['E_CMDB_BKPSETDATE'],0,2));
                if (substr($asset['E_CMDB_BKPSETDATE'],6,4)>2000) {
                    // le champ est une chaine ?! 
                    $BackupDate = new \DateTime($date);
                    if ($BackupDate)
                        $EZV->setBackupDate($BackupDate);
                }
            }
            
            $EZV->setBackupStatus(utf8_encode($asset['E_CMDB_BKPSTATUS']));
            $EZV->setBackupPlatform($asset['E_CMDB_BKPPLATF']);
            $EZV->setBackupType($asset['E_CMDB_BKPTYPE']);
            $EZV->setBackupPolicy(utf8_encode($asset['E_CMDB_BKPPOL']));            
            $EZV->setBackupAgent($asset['E_CMDB_BKPAGENT']);

            $EZV->setBackupAlarm($asset['E_CMDB_BKPALARM']);
            switch (substr($asset['E_CMDB_BKPALARM'],0,1)) {
                case 1: 
                    $EZV->setBackupAlarmNotify();
                    break;
                case 2:
                    $EZV->setBackupAlarmNotify(2);
                    break;
                case 3:
                    $EZV->setBackupAlarmNotify(180);
                    break;
                case 4:
                    $EZV->setBackupAlarmNotify(-1);
                    break;
                case 5:
                    $EZV->setBackupAlarmNotify(30);
                    break;
                case 6:
                    $EZV->setBackupAlarmNotify(7);
                    break;
                default:
                    $EZV->setBackupAlarmNotify(0);      
            }
            
            $EZV->setBackupSelect($asset['E_CMDB_BKPSELECT']);
            $EZV->setIsCi($asset['IS_CI']);
            $EZV->setBelongsToTheAssets($asset['BELONGS_TO_THE_ASSETS']);
            $EZV->setIsStockStatus($asset['IS_STOCK_STATUS']);
            $EZV->setClassification($asset['UN_CLASSIFICATION_FR']);
            $EZV->setClassificationPath(utf8_encode($asset['UN_CLASSIFICATION_PATH_FR']));
            $EZV->setNetworkIdentifier(strtolower($asset['NETWORK_IDENTIFIER']));
            
            $EZV->setBackupNo(utf8_encode($asset['E_CMDB_RAISONNOBKP']));
            $EZV->setUpdated(new \DateTime());

            $EZV->setComponent(utf8_encode($asset['Component']));
            $EZV->setEnvironment($asset['Env']);
            $EZV->setOs(utf8_encode($asset['OS']));
            
            $EZV->setBackupNo(utf8_encode($asset['E_CMDB_RAISONNOBKP']));
            $this->em->persist($EZV);
        }
        $this->em->flush();  
        
        print "<pre>";
        print_r($Asset);
               
        // pour la cron
        print "<!-- {{MESSAGE ".count($Asset)."}} -->";
        return "success";
    }

    private function importIP($Asset) {    
        set_time_limit(600);
        $Done = array(); // unicite
        foreach ($Asset as $name => $asset) {
            $host = $asset['NETWORK_IDENTIFIER'];
            if ($host=='-') {
                $host = $asset['ASSET_TAG'];
            }
            $host = strtolower($host);
            if (($host!='-') and (!isset($Done[$host]))) {
                $IP = $this->em->getRepository("AriiReportBundle:IP")->findOneBy(array('name'=> $host)); 
                if ($asset['IS_CI']>0) {
                    if (!$IP)
                        $IP= new \Arii\ReportBundle\Entity\IP();

                    $IP->setName($host);
                    $this->em->persist($IP);
                }
                else {
                    if ($IP)
                        $this->em->remove($IP);
                }
            }
            $Done[$host]=1;
        }
        $this->em->flush();            
        return "success";
    }

    private function status() {
        // Replace the value of these variables with your own data
        $server = $this->Parameters['server'];
        $user =   $this->Parameters['login'];
        $pass =   $this->Parameters['password'];

        // No changes needed from now on
        $connection_string = "DRIVER={SQL Server};SERVER=$server";
        $conn = odbc_connect("EasyVista",$user,$pass);

        if ($conn) {
            echo "Connection established.";
        } else{
            print "((".odbc_errormsg();
            die("Connection could not be established.");
        }
        $sql = "SELECT * FROM AM_STATUS";
        
        $res = odbc_exec($conn, $sql);

        $Columns = array();
        for ($j = 1; $j <= odbc_num_fields($res); $j++) {
            $field_name = odbc_field_name($res, $j);
            array_push($Columns,$field_name);
        }
        $Asset = array();
        while (odbc_fetch_row($res)) {
            $id = strtolower(odbc_result($res,"STATUS_ID"));
            for ($j = 1; $j <= odbc_num_fields($res); $j++) {        
                $c = $Columns[$j-1];
                $Asset[$id][$c] = odbc_result($res,$j);
            }
        }
        odbc_free_result($res);
        odbc_close($conn); 

        print_r($Asset);
    }
    
}