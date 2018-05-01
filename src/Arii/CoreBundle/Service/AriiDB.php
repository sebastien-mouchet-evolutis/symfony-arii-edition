<?php
namespace Arii\CoreBundle\Service;

class AriiDB
{
    protected $conn;
    protected $driver;
    protected $dhtmlx_path;

    public function __construct(\Doctrine\ORM\EntityManager $entityManager)
    {      
        $this->conn = $entityManager->getConnection();
        $this->driver = $this->conn->getDriver()->getName();
        
        $this->dhtmlx_path = '../vendor/dhtmlx/connector-php/codebase';
    }

    public function getDriver() {
        return $this->driver;
    }

    public function Config()
    {
        require_once $this->dhtmlx_path;
        return new \GridConfiguration();
    }

    /**
     * Utilisation du connecteur 
     *
     * @param string $connector
     */
    public function Connector( $type = 'data' )
    {        
        switch ($this->driver) {
            case 'pdo_oci':
            case 'oci8':
                require_once  $this->dhtmlx_path.'/db_oracle.php';
                $Infos = (array) $this->conn->getWrappedConnection();
                $conn = $Infos[chr(0).'*'.chr(0).'dbh'];
                break;
            case 'pdo_pgsql':
                require_once  $this->dhtmlx_path.'/db_postgre.php';
                break;
            default:
                require_once  $this->dhtmlx_path.'/db_mysqli.php';
                $conn = $this->conn->getWrappedConnection()->getWrappedResourceHandle();
                break;
        }
        
        switch ($type) {
            case 'data':
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
            case 'gantt':
                require_once $this->dhtmlx_path.'/gantt_connector.php';
                break;
            case 'dataview':
                require_once $this->dhtmlx_path.'/dataview_connector.php';
                break;
            case 'chart':
                require_once $this->dhtmlx_path.'/chart_connector.php';
            default:
                $this->get('session')->getFlashBag()->add('error', $type );
                return;
                break;
        }

        // connexion courante
        switch ($this->driver) {
            case 'oci8':
                $driver = "Oracle";
                break;
            case 'mysqli':
                mysqli_query($conn, "SET NAMES 'utf8'");
                $driver = "MySQLi";
                break;
            case 'sqllite':
                $driver = "SQLite";
                break;
            case 'postgres':
                $driver = "Postgre";
                break;
            default:
                print $this->driver;
                exit();
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
            case 'gantt':
                return new \JSONGanttConnector($conn,$driver);
                break;
            case 'dataview':
                return new \DataViewConnector($conn,$driver);
                break;
            default:
                break;
        }
    }
}
