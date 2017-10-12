<?php

namespace Arii\JOCBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * state_schedulers
 *
 * @ORM\Table(name="JOC_SPOOLERS")
 * @ORM\Entity(repositoryClass="Arii\JOCBundle\Entity\SpoolersRepository")
 *  */
class Spoolers
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=32)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="connection", type="string", length=30, nullable=true )
     */
    private $connection;

    /**
     * @var datetime
     *
     * @ORM\Column(name="updated", type="datetime" )
     */
    private $updated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="spooler_running_since", type="datetime", nullable=true)
     */
    private $spooler_running_since;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=100, nullable=true)
     */
    private $state;
    /**
     * @var string
     *
     * @ORM\Column(name="log_file", type="string", length=255, nullable=true)
     */
    private $log_file;
     /**
     * @var string
     *
     * @ORM\Column(name="version", type="string", length=100, nullable=true)
     */
    private $version;

    /**
     * @var integer
     *
     * @ORM\Column(name="pid", type="integer", nullable=true)
     */
    private $pid;

    /**
     * @var string
     *
     * @ORM\Column(name="host", type="string", length=100, nullable=true)
     */
    private $host;

    /**
     * @var string
     *
     * @ORM\Column(name="ip_address", type="string", length=100, nullable=true)
     */
    private $ip_address;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="need_db", type="boolean", nullable=true)
     */
    private $need_db;

    /**
     * @var integer
     *
     * @ORM\Column(name="tcp_port", type="integer", nullable=true)
     */
    private $tcp_port;

    /**
     * @var integer
     *
     * @ORM\Column(name="udp_port", type="integer", nullable=true)
     */
    private $udp_port;

    /**
     * @var string
     *
     * @ORM\Column(name="config_file", type="string", length=512, nullable=true)
     */
    private $config_file;

    /**
     * @var string
     *
     * @ORM\Column(name="db", type="string", length=255, nullable=true)
     */
    private $db;

    /**
     * @var float
     *
     * @ORM\Column(name="cpu_time", type="decimal", nullable=true)
     */
    private $cpu_time;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time", type="datetime", nullable=true)
     */
    private $time;

    /**
     * @var integer
     *
     * @ORM\Column(name="waits", type="integer", nullable=true)
     */
    private $waits;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="wait_until", type="datetime", nullable=true)
     */
    private $wait_until;

    /**
     * @var integer
     *
     * @ORM\Column(name="loops", type="integer", nullable=true)
     */
    private $loops;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Spoolers
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set connection
     *
     * @param string $connection
     * @return Spoolers
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;

        return $this;
    }

    /**
     * Get connection
     *
     * @return string 
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Spoolers
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set spooler_running_since
     *
     * @param \DateTime $spoolerRunningSince
     * @return Spoolers
     */
    public function setSpoolerRunningSince($spoolerRunningSince)
    {
        $this->spooler_running_since = $spoolerRunningSince;

        return $this;
    }

    /**
     * Get spooler_running_since
     *
     * @return \DateTime 
     */
    public function getSpoolerRunningSince()
    {
        return $this->spooler_running_since;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return Spoolers
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set log_file
     *
     * @param string $logFile
     * @return Spoolers
     */
    public function setLogFile($logFile)
    {
        $this->log_file = $logFile;

        return $this;
    }

    /**
     * Get log_file
     *
     * @return string 
     */
    public function getLogFile()
    {
        return $this->log_file;
    }

    /**
     * Set version
     *
     * @param string $version
     * @return Spoolers
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return string 
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set pid
     *
     * @param integer $pid
     * @return Spoolers
     */
    public function setPid($pid)
    {
        $this->pid = $pid;

        return $this;
    }

    /**
     * Get pid
     *
     * @return integer 
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * Set host
     *
     * @param string $host
     * @return Spoolers
     */
    public function setHost($host)
    {
        $this->host = $host;

        return $this;
    }

    /**
     * Get host
     *
     * @return string 
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Set ip_address
     *
     * @param string $ipAddress
     * @return Spoolers
     */
    public function setIpAddress($ipAddress)
    {
        $this->ip_address = $ipAddress;

        return $this;
    }

    /**
     * Get ip_address
     *
     * @return string 
     */
    public function getIpAddress()
    {
        return $this->ip_address;
    }

    /**
     * Set need_db
     *
     * @param boolean $needDb
     * @return Spoolers
     */
    public function setNeedDb($needDb)
    {
        $this->need_db = $needDb;

        return $this;
    }

    /**
     * Get need_db
     *
     * @return boolean 
     */
    public function getNeedDb()
    {
        return $this->need_db;
    }

    /**
     * Set tcp_port
     *
     * @param integer $tcpPort
     * @return Spoolers
     */
    public function setTcpPort($tcpPort)
    {
        $this->tcp_port = $tcpPort;

        return $this;
    }

    /**
     * Get tcp_port
     *
     * @return integer 
     */
    public function getTcpPort()
    {
        return $this->tcp_port;
    }

    /**
     * Set udp_port
     *
     * @param integer $udpPort
     * @return Spoolers
     */
    public function setUdpPort($udpPort)
    {
        $this->udp_port = $udpPort;

        return $this;
    }

    /**
     * Get udp_port
     *
     * @return integer 
     */
    public function getUdpPort()
    {
        return $this->udp_port;
    }

    /**
     * Set config_file
     *
     * @param string $configFile
     * @return Spoolers
     */
    public function setConfigFile($configFile)
    {
        $this->config_file = $configFile;

        return $this;
    }

    /**
     * Get config_file
     *
     * @return string 
     */
    public function getConfigFile()
    {
        return $this->config_file;
    }

    /**
     * Set db
     *
     * @param string $db
     * @return Spoolers
     */
    public function setDb($db)
    {
        $this->db = $db;

        return $this;
    }

    /**
     * Get db
     *
     * @return string 
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * Set cpu_time
     *
     * @param string $cpuTime
     * @return Spoolers
     */
    public function setCpuTime($cpuTime)
    {
        $this->cpu_time = $cpuTime;

        return $this;
    }

    /**
     * Get cpu_time
     *
     * @return string 
     */
    public function getCpuTime()
    {
        return $this->cpu_time;
    }

    /**
     * Set time
     *
     * @param \DateTime $time
     * @return Spoolers
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return \DateTime 
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set waits
     *
     * @param integer $waits
     * @return Spoolers
     */
    public function setWaits($waits)
    {
        $this->waits = $waits;

        return $this;
    }

    /**
     * Get waits
     *
     * @return integer 
     */
    public function getWaits()
    {
        return $this->waits;
    }

    /**
     * Set wait_until
     *
     * @param \DateTime $waitUntil
     * @return Spoolers
     */
    public function setWaitUntil($waitUntil)
    {
        $this->wait_until = $waitUntil;

        return $this;
    }

    /**
     * Get wait_until
     *
     * @return \DateTime 
     */
    public function getWaitUntil()
    {
        return $this->wait_until;
    }

    /**
     * Set loops
     *
     * @param integer $loops
     * @return Spoolers
     */
    public function setLoops($loops)
    {
        $this->loops = $loops;

        return $this;
    }

    /**
     * Get loops
     *
     * @return integer 
     */
    public function getLoops()
    {
        return $this->loops;
    }

}
