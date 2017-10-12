<?php

namespace Arii\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Connection
 *
 * @ORM\Table(name="ARII_CONNECTION")
 * @ORM\Entity
 */
class Connection
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
     * @ORM\Column(name="name", type="string", length=128, unique=true)
     */        
    private $name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=128, nullable=true)
     */        
    private $title;
    
    /**
     * @var string
     *
     * @ORM\Column(name="domain", type="string", length=16, nullable=true)
     */
    private $domain;

    /**
     * @ORM\OneToOne(targetEntity="Arii\CoreBundle\Entity\Connection")
     * @ORM\JoinColumn(nullable=true)
     *      
     */
    private $proxy;

    /**
     * @ORM\OneToOne(targetEntity="Arii\CoreBundle\Entity\Connection")
     * @ORM\JoinColumn(nullable=true)
     *      
     */
    private $backup;

    /**
     * @var string
     *
     * @ORM\Column(name="env", type="string", length=16, nullable=true)
     */        
    private $env;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="host", type="string", length=32, nullable=true)
     */
    private $host;
    
    /**
     * @var string
     *
     * @ORM\Column(name="interface", type="string", length=128, nullable=true)
     * for one host which is a machine, we maybe have different interfaces, several net cards
     */
    private $interface;
	
    /**
     * @var integer
     *
     * @ORM\Column(name="port", type="integer", nullable=true)
     */
    private $port;

    /**
     * @var string
     *
     * @ORM\Column(name="protocol", type="string", length=32, nullable=true)
     */
    private $protocol;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=32, nullable=true)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="auth_method", type="string", length=16, nullable=true)
     */
    private $auth_method;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=32, nullable=true)
     */
    private $password;
    
    /**
     * @var string
     *
     * @ORM\Column(name="pkey", type="string", length=2048, nullable=true)
     */
    private $key;

    /**
     * @var string
     *
     * @ORM\Column(name="driver", type="string", length=32, nullable=true)
     */
    private $driver;

    /**
     * @var string
     *
     * @ORM\Column(name="vendor", type="string", length=32, nullable=true)
     */
    private $vendor;

    /**
     * @var string
     *
     * @ORM\Column(name="db_inst", type="string", length=1024, nullable=true)
     */
    private $instance;
    
    /**
     * @var string
     *
     * @ORM\Column(name="db_name", type="string", length=128, nullable=true)
     */
    private $database;

    /**
     * @var string
     *
     * @ORM\Column(name="db_owner", type="string", length=32, nullable=true)
     */
    private $owner;
    
    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255, nullable=true)
     */
    private $path;

    /**
     * @var boolean
     *
     * @ORM\Column(name="service", type="boolean", nullable=true)
     */
    private $service;
    
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
     * @return Connection
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
     * Set title
     *
     * @param string $title
     * @return Connection
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set domain
     *
     * @param string $domain
     * @return Connection
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Get domain
     *
     * @return string 
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Set env
     *
     * @param string $env
     * @return Connection
     */
    public function setEnv($env)
    {
        $this->env = $env;

        return $this;
    }

    /**
     * Get env
     *
     * @return string 
     */
    public function getEnv()
    {
        return $this->env;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Connection
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set host
     *
     * @param string $host
     * @return Connection
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
     * Set interface
     *
     * @param string $interface
     * @return Connection
     */
    public function setInterface($interface)
    {
        $this->interface = $interface;

        return $this;
    }

    /**
     * Get interface
     *
     * @return string 
     */
    public function getInterface()
    {
        return $this->interface;
    }

    /**
     * Set port
     *
     * @param integer $port
     * @return Connection
     */
    public function setPort($port)
    {
        $this->port = $port;

        return $this;
    }

    /**
     * Get port
     *
     * @return integer 
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Set protocol
     *
     * @param string $protocol
     * @return Connection
     */
    public function setProtocol($protocol)
    {
        $this->protocol = $protocol;

        return $this;
    }

    /**
     * Get protocol
     *
     * @return string 
     */
    public function getProtocol()
    {
        return $this->protocol;
    }

    /**
     * Set login
     *
     * @param string $login
     * @return Connection
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string 
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set auth_method
     *
     * @param string $authMethod
     * @return Connection
     */
    public function setAuthMethod($authMethod)
    {
        $this->auth_method = $authMethod;

        return $this;
    }

    /**
     * Get auth_method
     *
     * @return string 
     */
    public function getAuthMethod()
    {
        return $this->auth_method;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Connection
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set key
     *
     * @param string $key
     * @return Connection
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get key
     *
     * @return string 
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set driver
     *
     * @param string $driver
     * @return Connection
     */
    public function setDriver($driver)
    {
        $this->driver = $driver;

        return $this;
    }

    /**
     * Get driver
     *
     * @return string 
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * Set owner
     *
     * @param string $owner
     * @return Connection
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return string 
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set vendor
     *
     * @param string $vendor
     * @return Connection
     */
    public function setVendor($vendor)
    {
        $this->vendor = $vendor;

        return $this;
    }

    /**
     * Get vendor
     *
     * @return string 
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * Set instance
     *
     * @param string $instance
     * @return Connection
     */
    public function setInstance($instance)
    {
        $this->instance = $instance;

        return $this;
    }

    /**
     * Get instance
     *
     * @return string 
     */
    public function getInstance()
    {
        return $this->instance;
    }

    /**
     * Set database
     *
     * @param string $database
     * @return Connection
     */
    public function setDatabase($database)
    {
        $this->database = $database;

        return $this;
    }

    /**
     * Get database
     *
     * @return string 
     */
    public function getDatabase()
    {
        return $this->database;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Connection
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set proxy
     *
     * @param \Arii\CoreBundle\Entity\Connection $proxy
     * @return Connection
     */
    public function setProxy(\Arii\CoreBundle\Entity\Connection $proxy = null)
    {
        $this->proxy = $proxy;

        return $this;
    }

    /**
     * Get proxy
     *
     * @return \Arii\CoreBundle\Entity\Connection 
     */
    public function getProxy()
    {
        return $this->proxy;
    }

    /**
     * Set backup
     *
     * @param \Arii\CoreBundle\Entity\Connection $backup
     * @return Connection
     */
    public function setBackup(\Arii\CoreBundle\Entity\Connection $backup = null)
    {
        $this->backup = $backup;

        return $this;
    }

    /**
     * Get backup
     *
     * @return \Arii\CoreBundle\Entity\Connection 
     */
    public function getBackup()
    {
        return $this->backup;
    }

    /**
     * Set db_owner
     *
     * @param string $dbOwner
     * @return Connection
     */
    public function setDbOwner($dbOwner)
    {
        $this->db_owner = $dbOwner;

        return $this;
    }

    /**
     * Get db_owner
     *
     * @return string 
     */
    public function getDbOwner()
    {
        return $this->db_owner;
    }

    /**
     * Set service
     *
     * @param boolean $service
     * @return Connection
     */
    public function setService($service)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return boolean 
     */
    public function getService()
    {
        return $this->service;
    }
}
