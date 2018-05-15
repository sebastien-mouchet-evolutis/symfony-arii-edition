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
     * @Serializer\Groups({"list","detail"})
     */
    private $id;
   
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=64)
     * @Assert\NotBlank(groups={"Create"})
     * 
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=64)
     * 
     * @Serializer\Groups({"list"})
     */
    private $title;
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     * @Assert\NotBlank(groups={"Create"})
     * 
     * @Serializer\Groups({"detail"})
     */
    private $description;

    /**
    * @ORM\ManyToOne(targetEntity="Arii\CoreBundle\Entity\Node")
    * @ORM\JoinColumn(nullable=true)
    */
    private $node;

    /**
    * @ORM\ManyToOne(targetEntity="Arii\CoreBundle\Entity\Job")
    * @ORM\JoinColumn(nullable=true)
    */
    private $job;
    
    /**
    * @ORM\ManyToOne(targetEntity="Arii\UserBundle\Entity\User")
    * @ORM\JoinColumn(nullable=true)
    */
    private $user;

    /**
     * @var integer
     *
     * @ORM\Column(name="alarm_type", type="string", length=32 )
     * 
     * @Serializer\Groups({"list"})
     */
    private $alarmType="MESSAGE";

    /**
     * @var integer
     *
     * @ORM\Column(name="alarm_time", type="datetime")
     * 
     * @Serializer\Groups({"list"})
     */
    private $alarmTime;

    /**
     * @var integer
     *
     * @ORM\Column(name="exit_code", type="integer" )
     * 
     * @Serializer\Groups({"list"})
     */
    private $exitCode=0;
    
    /**
     * @var string
     *
     * @ORM\Column(name="response", type="string", length=255, nullable=true)
     */
    private $response;

    /**
     * @var integer
     *
     * @ORM\Column(name="state", type="integer", nullable=true)
     * 
     * @Serializer\Groups({"list"})
     */
    private $state=0;

    /**
     * @var integer
     *
     * @ORM\Column(name="state_time", type="datetime", nullable=true)
     */
    private $stateTime;

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
     * Set alarmType
     *
     * @param string $alarmType
     * @return Alarm
     */
    public function setAlarmType($alarmType)
    {
        $this->alarmType = $alarmType;
    
        return $this;
    }

    /**
     * Get alarmType
     *
     * @return string 
     */
    public function getAlarmType()
    {
        return $this->alarmType;
    }

    /**
     * Set alarmTime
     *
     * @param \DateTime $alarmTime
     * @return Alarm
     */
    public function setAlarmTime($alarmTime)
    {
        $this->alarmTime = $alarmTime;
    
        return $this;
    }

    /**
     * Get alarmTime
     *
     * @return \DateTime 
     */
    public function getAlarmTime()
    {
        return $this->alarmTime;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Alarm
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
     * @return Alarm
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
     * @return Alarm
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
     * Set response
     *
     * @param string $response
     * @return Alarm
     */
    public function setResponse($response)
    {
        $this->response = $response;
    
        return $this;
    }

    /**
     * Get response
     *
     * @return string 
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Set state
     *
     * @param integer $state
     * @return Alarm
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
     * Set stateTime
     *
     * @param integer $stateTime
     * @return Alarm
     */
    public function setStateTime($stateTime)
    {
        $this->stateTime = $stateTime;
    
        return $this;
    }

    /**
     * Get stateTime
     *
     * @return integer 
     */
    public function getStateTime()
    {
        return $this->stateTime;
    }

    /**
     * Set node
     *
     * @param \Arii\CoreBundle\Entity\Node $node
     * @return Alarm
     */
    public function setNode(\Arii\CoreBundle\Entity\Node $node = null)
    {
        $this->node = $node;
    
        return $this;
    }

    /**
     * Get node
     *
     * @return \Arii\CoreBundle\Entity\Node 
     */
    public function getNode()
    {
        return $this->node;
    }

    /**
     * Set job
     *
     * @param \Arii\CoreBundle\Entity\Job $job
     * @return Alarm
     */
    public function setJob(\Arii\CoreBundle\Entity\Job $job = null)
    {
        $this->job = $job;
    
        return $this;
    }

    /**
     * Get job
     *
     * @return \Arii\CoreBundle\Entity\Job 
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Set user
     *
     * @param \Arii\UserBundle\Entity\User $user
     * @return Alarm
     */
    public function setUser(\Arii\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Arii\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set exitCode
     *
     * @param integer $exitCode
     * @return Alarm
     */
    public function setExitCode($exitCode)
    {
        $this->exitCode = $exitCode;

        return $this;
    }

    /**
     * Get exitCode
     *
     * @return integer 
     */
    public function getExitCode()
    {
        return $this->exitCode;
    }

    /**
     * Set stdout
     *
     * @param string $stdout
     * @return Alarm
     */
    public function setStdout($stdout)
    {
        $this->stdout = $stdout;

        return $this;
    }

    /**
     * Get stdout
     *
     * @return string 
     */
    public function getStdout()
    {
        return $this->stdout;
    }

    /**
     * Set stderr
     *
     * @param string $stderr
     * @return Alarm
     */
    public function setStderr($stderr)
    {
        $this->stderr = $stderr;

        return $this;
    }

    /**
     * Get stderr
     *
     * @return string 
     */
    public function getStderr()
    {
        return $this->stderr;
    }
}
