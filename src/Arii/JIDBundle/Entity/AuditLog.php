<?php

namespace Arii\JIDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AuditLog
 *
 * @ORM\Table(name="audit_log", indexes={@ORM\Index(name="AUDIT_LOG_JS_ID", columns={"SCHEDULER_ID"}), @ORM\Index(name="AUDIT_LOG_JOB", columns={"JOB"}), @ORM\Index(name="AUDIT_LOG_CHAIN", columns={"JOB_CHAIN"}), @ORM\Index(name="AUDIT_LOG_ORDER", columns={"ORDER_ID"}), @ORM\Index(name="AUDIT_LOG_FOLDER", columns={"FOLDER"}), @ORM\Index(name="AUDIT_LOG_CREATED", columns={"CREATED"})})
 * @ORM\Entity(readOnly=true)
 */
class AuditLog
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
     * @ORM\Column(name="SCHEDULER_ID", type="string", length=100, nullable=false)
     */
    private $schedulerId;

    /**
     * @var string
     *
     * @ORM\Column(name="ACCOUNT", type="string", length=255, nullable=false)
     */
    private $account;

    /**
     * @var string
     *
     * @ORM\Column(name="REQUEST", type="string", length=50, nullable=false)
     */
    private $request;

    /**
     * @var string
     *
     * @ORM\Column(name="PARAMETERS", type="text", nullable=true)
     */
    private $parameters;

    /**
     * @var string
     *
     * @ORM\Column(name="JOB", type="string", length=255, nullable=true)
     */
    private $job;

    /**
     * @var string
     *
     * @ORM\Column(name="JOB_CHAIN", type="string", length=255, nullable=true)
     */
    private $jobChain;

    /**
     * @var string
     *
     * @ORM\Column(name="ORDER_ID", type="string", length=255, nullable=true)
     */
    private $orderId;

    /**
     * @var string
     *
     * @ORM\Column(name="FOLDER", type="string", length=255, nullable=true)
     */
    private $folder;

    /**
     * @var string
     *
     * @ORM\Column(name="COMMENT", type="string", length=4000, nullable=true)
     */
    private $comment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="CREATED", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var string
     *
     * @ORM\Column(name="TICKET_LINK", type="string", length=255, nullable=true)
     */
    private $ticketLink;

    /**
     * @var integer
     *
     * @ORM\Column(name="TIME_SPENT", type="integer", nullable=true)
     */
    private $timeSpent;



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
     * Set schedulerId
     *
     * @param string $schedulerId
     * @return AuditLog
     */
    public function setSchedulerId($schedulerId)
    {
        $this->schedulerId = $schedulerId;

        return $this;
    }

    /**
     * Get schedulerId
     *
     * @return string 
     */
    public function getSchedulerId()
    {
        return $this->schedulerId;
    }

    /**
     * Set account
     *
     * @param string $account
     * @return AuditLog
     */
    public function setAccount($account)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return string 
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set request
     *
     * @param string $request
     * @return AuditLog
     */
    public function setRequest($request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Get request
     *
     * @return string 
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Set parameters
     *
     * @param string $parameters
     * @return AuditLog
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
     * Set job
     *
     * @param string $job
     * @return AuditLog
     */
    public function setJob($job)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Get job
     *
     * @return string 
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Set jobChain
     *
     * @param string $jobChain
     * @return AuditLog
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
     * @return AuditLog
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
     * Set folder
     *
     * @param string $folder
     * @return AuditLog
     */
    public function setFolder($folder)
    {
        $this->folder = $folder;

        return $this;
    }

    /**
     * Get folder
     *
     * @return string 
     */
    public function getFolder()
    {
        return $this->folder;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return AuditLog
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return AuditLog
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
     * Set ticketLink
     *
     * @param string $ticketLink
     * @return AuditLog
     */
    public function setTicketLink($ticketLink)
    {
        $this->ticketLink = $ticketLink;

        return $this;
    }

    /**
     * Get ticketLink
     *
     * @return string 
     */
    public function getTicketLink()
    {
        return $this->ticketLink;
    }

    /**
     * Set timeSpent
     *
     * @param integer $timeSpent
     * @return AuditLog
     */
    public function setTimeSpent($timeSpent)
    {
        $this->timeSpent = $timeSpent;

        return $this;
    }

    /**
     * Get timeSpent
     *
     * @return integer 
     */
    public function getTimeSpent()
    {
        return $this->timeSpent;
    }
}
