<?php

namespace Arii\JIDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SchedulerEvents
 *
 * @ORM\Table(name="scheduler_events", indexes={@ORM\Index(name="SCHEDULER_EVENTS_EVENT", columns={"EVENT_CLASS", "EVENT_ID"})})
 * @ORM\Entity(readOnly=true)
 */
class SchedulerEvents
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="SPOOLER_ID", type="string", length=100, nullable=false)
     */
    private $spoolerId;

    /**
     * @var string
     *
     * @ORM\Column(name="REMOTE_SCHEDULER_HOST", type="string", length=100, nullable=true)
     */
    private $remoteSchedulerHost;

    /**
     * @var integer
     *
     * @ORM\Column(name="REMOTE_SCHEDULER_PORT", type="integer", nullable=true)
     */
    private $remoteSchedulerPort;

    /**
     * @var string
     *
     * @ORM\Column(name="JOB_CHAIN", type="string", length=250, nullable=true)
     */
    private $jobChain;

    /**
     * @var string
     *
     * @ORM\Column(name="ORDER_ID", type="string", length=250, nullable=true)
     */
    private $orderId;

    /**
     * @var string
     *
     * @ORM\Column(name="JOB_NAME", type="string", length=100, nullable=true)
     */
    private $jobName;

    /**
     * @var string
     *
     * @ORM\Column(name="EVENT_CLASS", type="string", length=100, nullable=false)
     */
    private $eventClass;

    /**
     * @var string
     *
     * @ORM\Column(name="EVENT_ID", type="string", length=100, nullable=false)
     */
    private $eventId;

    /**
     * @var string
     *
     * @ORM\Column(name="EXIT_CODE", type="string", length=100, nullable=true)
     */
    private $exitCode;

    /**
     * @var string
     *
     * @ORM\Column(name="PARAMETERS", type="text", nullable=true)
     */
    private $parameters;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="CREATED", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="EXPIRES", type="datetime", nullable=true)
     */
    private $expires;



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
     * Set spoolerId
     *
     * @param string $spoolerId
     * @return SchedulerEvents
     */
    public function setSpoolerId($spoolerId)
    {
        $this->spoolerId = $spoolerId;

        return $this;
    }

    /**
     * Get spoolerId
     *
     * @return string 
     */
    public function getSpoolerId()
    {
        return $this->spoolerId;
    }

    /**
     * Set remoteSchedulerHost
     *
     * @param string $remoteSchedulerHost
     * @return SchedulerEvents
     */
    public function setRemoteSchedulerHost($remoteSchedulerHost)
    {
        $this->remoteSchedulerHost = $remoteSchedulerHost;

        return $this;
    }

    /**
     * Get remoteSchedulerHost
     *
     * @return string 
     */
    public function getRemoteSchedulerHost()
    {
        return $this->remoteSchedulerHost;
    }

    /**
     * Set remoteSchedulerPort
     *
     * @param integer $remoteSchedulerPort
     * @return SchedulerEvents
     */
    public function setRemoteSchedulerPort($remoteSchedulerPort)
    {
        $this->remoteSchedulerPort = $remoteSchedulerPort;

        return $this;
    }

    /**
     * Get remoteSchedulerPort
     *
     * @return integer 
     */
    public function getRemoteSchedulerPort()
    {
        return $this->remoteSchedulerPort;
    }

    /**
     * Set jobChain
     *
     * @param string $jobChain
     * @return SchedulerEvents
     */
    public function setJobChain($jobChain)
    {
        $this->jobChain = $jobChain;

        return $this;
    }

    /**
     * Get jobChain
     *
     * @return string 
     */
    public function getJobChain()
    {
        return $this->jobChain;
    }

    /**
     * Set orderId
     *
     * @param string $orderId
     * @return SchedulerEvents
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * Get orderId
     *
     * @return string 
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * Set jobName
     *
     * @param string $jobName
     * @return SchedulerEvents
     */
    public function setJobName($jobName)
    {
        $this->jobName = $jobName;

        return $this;
    }

    /**
     * Get jobName
     *
     * @return string 
     */
    public function getJobName()
    {
        return $this->jobName;
    }

    /**
     * Set eventClass
     *
     * @param string $eventClass
     * @return SchedulerEvents
     */
    public function setEventClass($eventClass)
    {
        $this->eventClass = $eventClass;

        return $this;
    }

    /**
     * Get eventClass
     *
     * @return string 
     */
    public function getEventClass()
    {
        return $this->eventClass;
    }

    /**
     * Set eventId
     *
     * @param string $eventId
     * @return SchedulerEvents
     */
    public function setEventId($eventId)
    {
        $this->eventId = $eventId;

        return $this;
    }

    /**
     * Get eventId
     *
     * @return string 
     */
    public function getEventId()
    {
        return $this->eventId;
    }

    /**
     * Set exitCode
     *
     * @param string $exitCode
     * @return SchedulerEvents
     */
    public function setExitCode($exitCode)
    {
        $this->exitCode = $exitCode;

        return $this;
    }

    /**
     * Get exitCode
     *
     * @return string 
     */
    public function getExitCode()
    {
        return $this->exitCode;
    }

    /**
     * Set parameters
     *
     * @param string $parameters
     * @return SchedulerEvents
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Get parameters
     *
     * @return string 
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return SchedulerEvents
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set expires
     *
     * @param \DateTime $expires
     * @return SchedulerEvents
     */
    public function setExpires($expires)
    {
        $this->expires = $expires;

        return $this;
    }

    /**
     * Get expires
     *
     * @return \DateTime 
     */
    public function getExpires()
    {
        return $this->expires;
    }
}
