<?php
namespace Arii\CoreBundle\Service;

class AriiDHTMLX
{
    protected $id;
    protected $host;
    protected $port;
    protected $database;
    protected $user;
    protected $password;
    protected $instance;
    protected $service;
    protected $driver;
    
    public function __construct(AriiPortal $portal)
    {    
        # Le serveur en cours est dans la variable de session OSJS_DB
        # Si ce n'est pas le cas, il faut la regenerer
        # La connexion passe par la session
        $this->portal = $portal;
        $db = $portal->getDatabase();
        if (isset($db['id']))
            $this->setDBInfo($db);
        $this->dhtmlx_path = '../vendor/dhtmlx/connector-php/codebase';
    }

    public function setDB($name) {
        $DBs = $this->portal->getDatabases();
        if (isset($DBs[$name]))
            return $this->setDBInfo($DBs[$name]);
        return;
    }
    
    private function setDBInfo($db) {        
        $this->id           = $db['id'];
        if ($db['protocol']!='')
            $this->driver       = $db['protocol'];        
        if ($db['driver']!='')
            $this->driver       = $db['driver'];
        $this->host         = $db['host'];
        $this->port         = $db['port'];
        $this->instance     = $db['instance'];
        $this->database     = $db['database'];
        $this->user         = $db['login'];
        $this->password     = $db['password'];
        $this->service      = $db['service'];
        return $db;
    }
        
    public function getDriver() {
        return $this->driver;
    }
    
    public function Id( )
    {   
        return $this->id;
    }
    /**
     * Utilisation du connecteur 
     *
     * @param string $connector
     */
    public function Connector( $type = 'data' )
    {   
        // Si aucune database n'est definie, on sort
        if (!($this->database))
            throw new \Exception('ARI',2);

        switch ($this->driver) {
            case 'postgre':
            case 'postgres':
                require_once  $this->dhtmlx_path.'/db_postgre.php';
                $driver = "Postgre";
                break;
            case 'oci8':
            case 'oracle':
            case 'pdo_oci':
                if (!class_exists('OracleDBDataWrapper'))
                    require_once  $this->dhtmlx_path.'/db_oracle.php';
                $driver = "Oracle";
                break;
            case 'mysql':            
            case 'mysqli':
                require_once  $this->dhtmlx_path.'/db_mysqli.php';
                $driver = "MySQLi";
                break;
            default:
                
                require_once  $this->dhtmlx_path.'/db_pdo.php';
                $driver = "PDO";
                break;
        }
        switch ($type) {
            case 'data':
                if (!class_exists('CommonDataProcessor'))
                    require_once $this->dhtmlx_path.'/data_connector.php';
                break;
            case 'grid':
                require_once $this->dhtmlx_path.'/grid_connector.php';
                break;
            case 'form':
                require_once $this->dhtmlx_path.'/form_connector.php';
                break;
            case 'select':
                require_once $this->dhtmlx_path.'/options_connector.php';
                break;
            case 'combo':
                require_once $this->dhtmlx_path.'/combo_connector.php';
                break;
            case 'tree':
                require_once $this->dhtmlx_path.'/tree_connector.php';
                break;
            case 'treegrid':
                require_once $this->dhtmlx_path.'/treegrid_connector.php';
                break;
            case 'treegridgroup':
                require_once $this->dhtmlx_path.'/treegridgroup_connector.php';
                break;
            case 'chart':
                require_once $this->dhtmlx_path.'/chart_connector.php';
                break;
            case 'scheduler':
                require_once $this->dhtmlx_path.'/scheduler_connector.php';
                break;
            case 'options':
                require_once $this->dhtmlx_path.'/scheduler_connector.php';
                break;
            default:
                $this->get('session')->getFlashBag()->add('error', $type );
                return;
                break;
        }

        switch ($driver) {
            case 'Oracle':
                if ($this->service)
                    $str = $this->host.':'.$this->port.'/'.$this->database;
                else
                    $str = $this->instance;
                $conn= @oci_connect( $this->user,  $this->password, $str );
                if (!$conn) {
                    $e = oci_error();
                    throw new \Exception($e['message']." ($str)");
                }
                
                // normalement pris en charge par le listener ?
                $std = oci_parse($conn,'ALTER SESSION SET NLS_TIME_FORMAT="HH24:MI:SS"');
                oci_execute($std);
                $std = oci_parse($conn,'ALTER SESSION SET NLS_DATE_FORMAT="YYYY-MM-DD HH24:MI:SS"');
                oci_execute($std);
                $std = oci_parse($conn,'ALTER SESSION SET NLS_TIMESTAMP_FORMAT="YYYY-MM-DD HH24:MI:SS"');
                oci_execute($std);
                $std = oci_parse($conn,'ALTER SESSION SET NLS_TIMESTAMP_TZ_FORMAT="YYYY-MM-DD HH24:MI:SS TZH:TZM"');
                oci_execute($std);
                $std = oci_parse($conn,'ALTER SESSION SET NLS_NUMERIC_CHARACTERS=".,"');
                oci_execute($std);         
                break;
            case 'Postgre':
                $conn= pg_connect("host=".$this->host." port=".$this->port." dbname=".$this->database." user=".$this->user." password=".$this->password);
                break;
            case 'MySQLi':
            case 'pdo_mysql':
            case 'mysqli':
            case 'mysql':
                $conn= mysqli_connect( $this->host, $this->user,  $this->password, $this->database );
                mysqli_query($conn, "SET NAMES 'utf8'");
                mysqli_query($conn, "SET CHARACTER SET 'utf8'");
                break;
            default:
                $dsn = substr($this->driver,4).':host='. $this->host.';dbname='.$this->database;
                // $dsn = 'oci:host='. $this->host.';dbname='.$this->database;
                try {
                    $conn = new \PDO( $dsn, $this->user, $this->password, array( \PDO::ATTR_PERSISTENT => true ));
                } catch ( Exception $e ) {
                    echo $e->getMessage();
                    die();
                }
                $conn->exec("SET CHARACTER SET utf8");
                break;
        }

        switch ($type) {
            case 'data':
                return new \Connector($conn,$driver);
                break;
            case 'grid':
                return new \GridConnector($conn,$driver);
                break;
            case 'form':
                return new \FormConnector($conn,$driver);
                break;
            case 'combo':
                return new \ComboConnector($conn,$driver);
                break;
            case 'select':
                return new \SelectOptionsConnector($conn,$driver);
                break;
            case 'tree':
                return new \TreeConnector($conn,$driver);
                break;
            case 'treegrid':
                return new \TreeGridConnector($conn,$driver);
                break;
            case 'treegridgroup':
                return new \TreeGridGroupConnector($conn,$driver);
                break;
            case 'chart':
                return new \ChartConnector($conn,$driver);
                break;
            case 'scheduler':
                return new \SchedulerConnector($conn,$driver);
                break;
            case 'options':
                return new \OptionsConnector($conn,$driver);
                break;            
            default:
                break;
        }
    }
}
