<?php

namespace Arii\ACKBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Network
 * Etat de l'infrastructure
 * 
 * @ORM\Table(name="ARII_NETWORK")
 * @ORM\Entity(repositoryClass="Arii\ACKBundle\Entity\NetworkRepository")
 * 
 */
class Network
{
    public function __construct()
    {
        $this->stateTime = new \DateTime();
    }
    
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
     * @ORM\Column(name="name", type="string", length=64)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=64)
     */
    private $title;
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="host", type="string", length=64, nullable=true)
     */
    private $host;

    /**
     * @var string
     *
     * @ORM\Column(name="ip_address", type="string", length=16, nullable=true)
     */
    private $ip_address;
    
    /**
     * @var string
     *
     * @ORM\Column(name="port", type="integer", nullable=true)
     */
    private $port;

    /**
     * @var integer
     *
     * @ORM\Column(name="state", type="integer")
     */
    private $state=0;

    /**
     * @var string
     *
     * @ORM\Column(name="state_information", type="string", length=255, nullable=true)
     */
    private $state_information;
    
    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=24)
     */
    private $status;
    
    /**
     * @var string
     *
     * @ORM\Column(name="acknowledgement_type", type="string", length=16, nullable=true)
     */
    private $acknowledgement_type;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="acknowledged", type="boolean")
     */
    private $acknowledged=0;

    /**
     * @var integer
     *
     * @ORM\Column(name="downtimes", type="string", length=255, nullable=true)
     */
    private $downtimes;
        
    /**
     * @var string
     *
     * @ORM\Column(name="downtime_info", type="string", length=255, nullable=true)
     */
    private $downtimes_info;

    /**
     * @var string
     *
     * @ORM\Column(name="downtime_user", type="string", length=32, nullable=true)
     */
    private $downtimes_user;
    
    /**
     * @var datetime
     *
     * @ORM\Column(name="last_state_change", type="datetime", nullable=true)
     */
    private $last_state_change;

    /**
     * @var datetime
     *
     * @ORM\Column(name="last_time_down", type="datetime", nullable=true)
     */
    private $last_time_down;
    
    /**
     * @var datetime
     *
     * @ORM\Column(name="last_time_unreachable", type="datetime", nullable=true)
     */
    private $last_time_unreachable;

    /**
     * @var datetime
     *
     * @ORM\Column(name="last_time_up", type="datetime", nullable=true)
     */
    private $last_time_up;

    /**
     * @var float
     *
     * @ORM\Column(name="latency", type="float", nullable=true)
     */
    private $latency;

    /**
     * @var integer
     *
     * @ORM\Column(name="last_state", type="integer")
     */
    private $last_state=0;
    
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
     * @return Network
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
     * @return Network
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
     * Set description
     *
     * @param string $description
     * @return Network
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
     * @return Network
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
     * Set port
     *
     * @param integer $port
     * @return Network
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
     * Set state
     *
     * @param integer $state
     * @return Network
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return integer 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Network
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set ip_address
     *
     * @param string $ipAddress
     * @return Network
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
     * Set state_information
     *
     * @param string $stateInformation
     * @return Network
     */
    public function setStateInformation($stateInformation)
    {
        $this->state_information = $stateInformation;

        return $this;
    }

    /**
     * Get state_information
     *
     * @return string 
     */
    public function getStateInformation()
    {
        return $this->state_information;
    }

    /**
     * Set acknowledgement_type
     *
     * @param string $acknowledgementType
     * @return Network
     */
    public function setAcknowledgementType($acknowledgementType)
    {
        $this->acknowledgement_type = $acknowledgementType;

        return $this;
    }

    /**
     * Get acknowledgement_type
     *
     * @return string 
     */
    public function getAcknowledgementType()
    {
        return $this->acknowledgement_type;
    }

    /**
     * Set acknowledged
     *
     * @param boolean $acknowledged
     * @return Network
     */
    public function setAcknowledged($acknowledged)
    {
        $this->acknowledged = $acknowledged;

        return $this;
    }

    /**
     * Get acknowledged
     *
     * @return boolean 
     */
    public function getAcknowledged()
    {
        return $this->acknowledged;
    }

    /**
     * Set downtimes
     *
     * @param integer $downtimes
     * @return Network
     */
    public function setDowntimes($downtimes)
    {
        $this->downtimes = $downtimes;

        return $this;
    }

    /**
     * Get downtimes
     *
     * @return integer 
     */
    public function getDowntimes()
    {
        return $this->downtimes;
    }

    /**
     * Set downtimes_info
     *
     * @param string $downtimesInfo
     * @return Network
     */
    public function setDowntimesInfo($downtimesInfo)
    {
        $this->downtimes_info = $downtimesInfo;

        return $this;
    }

    /**
     * Get downtimes_info
     *
     * @return string 
     */
    public function getDowntimesInfo()
    {
        return $this->downtimes_info;
    }

    /**
     * Set last_state_change
     *
     * @param \DateTime $lastStateChange
     * @return Network
     */
    public function setLastStateChange($lastStateChange)
    {
        $this->last_state_change = $lastStateChange;

        return $this;
    }

    /**
     * Get last_state_change
     *
     * @return \DateTime 
     */
    public function getLastStateChange()
    {
        return $this->last_state_change;
    }

    /**
     * Set last_time_down
     *
     * @param \DateTime $lastTimeDown
     * @return Network
     */
    public function setLastTimeDown($lastTimeDown)
    {
        $this->last_time_down = $lastTimeDown;

        return $this;
    }

    /**
     * Get last_time_down
     *
     * @return \DateTime 
     */
    public function getLastTimeDown()
    {
        return $this->last_time_down;
    }

    /**
     * Set last_time_unreachable
     *
     * @param \DateTime $lastTimeUnreachable
     * @return Network
     */
    public function setLastTimeUnreachable($lastTimeUnreachable)
    {
        $this->last_time_unreachable = $lastTimeUnreachable;

        return $this;
    }

    /**
     * Get last_time_unreachable
     *
     * @return \DateTime 
     */
    public function getLastTimeUnreachable()
    {
        return $this->last_time_unreachable;
    }

    /**
     * Set last_time_up
     *
     * @param \DateTime $lastTimeUp
     * @return Network
     */
    public function setLastTimeUp($lastTimeUp)
    {
        $this->last_time_up = $lastTimeUp;

        return $this;
    }

    /**
     * Get last_time_up
     *
     * @return \DateTime 
     */
    public function getLastTimeUp()
    {
        return $this->last_time_up;
    }

    /**
     * Set latency
     *
     * @param float $latency
     * @return Network
     */
    public function setLatency($latency)
    {
        $this->latency = $latency;

        return $this;
    }

    /**
     * Get latency
     *
     * @return float 
     */
    public function getLatency()
    {
        return $this->latency;
    }

    /**
     * Set last_state
     *
     * @param integer $lastState
     * @return Network
     */
    public function setLastState($lastState)
    {
        $this->last_state = $lastState;

        return $this;
    }

    /**
     * Get last_state
     *
     * @return integer 
     */
    public function getLastState()
    {
        return $this->last_state;
    }

    /**
     * Set downtimes_user
     *
     * @param string $downtimesUser
     * @return Network
     */
    public function setDowntimesUser($downtimesUser)
    {
        $this->downtimes_user = $downtimesUser;

        return $this;
    }

    /**
     * Get downtimes_user
     *
     * @return string 
     */
    public function getDowntimesUser()
    {
        return $this->downtimes_user;
    }
}
