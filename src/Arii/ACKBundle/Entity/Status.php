<?php

namespace Arii\ACKBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;

/**
 * Status
 * Etat des systemes
 * 
 * @ORM\Table(name="ARII_STATUS")
 * @ORM\Entity(repositoryClass="Arii\ACKBundle\Entity\StatusRepository")
 * 
 */
class Status
{
    public function __construct()
    {
        $this->alarmTime = new \DateTime();
        $this->stateTime = new \DateTime();
    }
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    private $id;
   
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     * 
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     * 
     */
    private $title;
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     * @Assert\NotBlank(groups={"Create"})
     * 
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="string", length=32 )
     * 
     */
    private $type;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="source", type="string", length=32 )
     * 
     */
    private $source;

    /**
     * @var integer
     *
     * @ORM\Column(name="instance", type="string", length=32 )
     * 
     */
    private $instance;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="user", type="string", length=32, nullable=true )
     * 
     */
    private $user;    

    /**
     * @var integer
     *
     * @ORM\Column(name="exit_code", type="integer" )
     * 
     */
    private $exit_code=0;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="run_try", type="float" )
     * 
     */
    private $run_try=0;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="string", length=32, nullable=true)
     * 
     */
    private $status;

    /**
     * @var integer
     *
     * @ORM\Column(name="last_start", type="datetime", nullable=true)
     * 
     */
    private $last_start;

    /**
     * @var integer
     *
     * @ORM\Column(name="last_end", type="datetime", nullable=true)
     * 
     */
    private $last_end;

    /**
     * @var integer
     *
     * @ORM\Column(name="updated", type="datetime")
     * 
     */
    private $updated;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="message", type="string", length=255, nullable=true)
     * 
     */
    private $message;
    
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
     * @return Status
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
     * @return Status
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
     * @return Status
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
     * Set type
     *
     * @param string $type
     * @return Status
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set source
     *
     * @param string $source
     * @return Status
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return string 
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set user
     *
     * @param string $user
     * @return Status
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set exit_code
     *
     * @param integer $exitCode
     * @return Status
     */
    public function setExitCode($exitCode)
    {
        $this->exit_code = $exitCode;

        return $this;
    }

    /**
     * Get exit_code
     *
     * @return integer 
     */
    public function getExitCode()
    {
        return $this->exit_code;
    }

    /**
     * Set run_try
     *
     * @param float $runTry
     * @return Status
     */
    public function setRunTry($runTry)
    {
        $this->run_try = $runTry;

        return $this;
    }

    /**
     * Get run_try
     *
     * @return float 
     */
    public function getRunTry()
    {
        return $this->run_try;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Status
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
     * Set last_start
     *
     * @param \DateTime $lastStart
     * @return Status
     */
    public function setLastStart($lastStart)
    {
        $this->last_start = $lastStart;

        return $this;
    }

    /**
     * Get last_start
     *
     * @return \DateTime 
     */
    public function getLastStart()
    {
        return $this->last_start;
    }

    /**
     * Set last_end
     *
     * @param \DateTime $lastEnd
     * @return Status
     */
    public function setLastEnd($lastEnd)
    {
        $this->last_end = $lastEnd;

        return $this;
    }

    /**
     * Get last_end
     *
     * @return \DateTime 
     */
    public function getLastEnd()
    {
        return $this->last_end;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Status
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
     * Set instance
     *
     * @param string $instance
     * @return Status
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
     * Set message
     *
     * @param string $message
     * @return Status
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }
}
