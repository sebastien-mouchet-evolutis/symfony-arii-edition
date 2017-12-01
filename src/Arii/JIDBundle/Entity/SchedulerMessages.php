<?php

namespace Arii\JIDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SchedulerMessages
 *
 * @ORM\Table(name="scheduler_messages")
 * @ORM\Entity(readOnly=true)
 */
class SchedulerMessages
{
    /**
     * @var integer
     *
     * @ORM\Column(name="MESSAGE_ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $messageId;

    /**
     * @var string
     *
     * @ORM\Column(name="SCHEDULER_ID", type="string", length=100, nullable=false)
     */
    private $schedulerId;

    /**
     * @var string
     *
     * @ORM\Column(name="CLUSTER_MEMBER_ID", type="string", length=100, nullable=false)
     */
    private $clusterMemberId;

    /**
     * @var string
     *
     * @ORM\Column(name="LOGFILE", type="string", length=255, nullable=false)
     */
    private $logfile;

    /**
     * @var string
     *
     * @ORM\Column(name="SEVERITY", type="string", length=20, nullable=false)
     */
    private $severity;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="LOGTIME", type="datetime", nullable=false)
     */
    private $logtime;

    /**
     * @var string
     *
     * @ORM\Column(name="JOB_CHAIN", type="string", length=255, nullable=false)
     */
    private $jobChain;

    /**
     * @var string
     *
     * @ORM\Column(name="ORDER_ID", type="string", length=255, nullable=false)
     */
    private $orderId;

    /**
     * @var string
     *
     * @ORM\Column(name="JOB_NAME", type="string", length=255, nullable=false)
     */
    private $jobName;

    /**
     * @var integer
     *
     * @ORM\Column(name="TASK", type="integer", nullable=false)
     */
    private $task;

    /**
     * @var string
     *
     * @ORM\Column(name="LOG", type="text", length=65535, nullable=false)
     */
    private $log;

    /**
     * @var integer
     *
     * @ORM\Column(name="REFERENCE_MESSAGE_ID", type="integer", nullable=true)
     */
    private $referenceMessageId;

    /**
     * @var integer
     *
     * @ORM\Column(name="STATUS", type="integer", nullable=true)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="CREATION_DATE", type="datetime", nullable=true)
     */
    private $creationDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="CNT", type="integer", nullable=true)
     */
    private $cnt;



    /**
     * Get messageId
     *
     * @return integer 
     */
    public function getMessageId()
    {
        return $this->messageId;
    }

    /**
     * Set schedulerId
     *
     * @param string $schedulerId
     * @return SchedulerMessages
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
     * Set clusterMemberId
     *
     * @param string $clusterMemberId
     * @return SchedulerMessages
     */
    public function setClusterMemberId($clusterMemberId)
    {
        $this->clusterMemberId = $clusterMemberId;

        return $this;
    }

    /**
     * Get clusterMemberId
     *
     * @return string 
     */
    public function getClusterMemberId()
    {
        return $this->clusterMemberId;
    }

    /**
     * Set logfile
     *
     * @param string $logfile
     * @return SchedulerMessages
     */
    public function setLogfile($logfile)
    {
        $this->logfile = $logfile;

        return $this;
    }

    /**
     * Get logfile
     *
     * @return string 
     */
    public function getLogfile()
    {
        return $this->logfile;
    }

    /**
     * Set severity
     *
     * @param string $severity
     * @return SchedulerMessages
     */
    public function setSeverity($severity)
    {
        $this->severity = $severity;

        return $this;
    }

    /**
     * Get severity
     *
     * @return string 
     */
    public function getSeverity()
    {
        return $this->severity;
    }

    /**
     * Set logtime
     *
     * @param \DateTime $logtime
     * @return SchedulerMessages
     */
    public function setLogtime($logtime)
    {
        $this->logtime = $logtime;

        return $this;
    }

    /**
     * Get logtime
     *
     * @return \DateTime 
     */
    public function getLogtime()
    {
        return $this->logtime;
    }

    /**
     * Set jobChain
     *
     * @param string $jobChain
     * @return SchedulerMessages
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
     * @return SchedulerMessages
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
     * @return SchedulerMessages
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
     * Set task
     *
     * @param integer $task
     * @return SchedulerMessages
     */
    public function setTask($task)
    {
        $this->task = $task;

        return $this;
    }

    /**
     * Get task
     *
     * @return integer 
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * Set log
     *
     * @param string $log
     * @return SchedulerMessages
     */
    public function setLog($log)
    {
        $this->log = $log;

        return $this;
    }

    /**
     * Get log
     *
     * @return string 
     */
    public function getLog()
    {
        return $this->log;
    }

    /**
     * Set referenceMessageId
     *
     * @param integer $referenceMessageId
     * @return SchedulerMessages
     */
    public function setReferenceMessageId($referenceMessageId)
    {
        $this->referenceMessageId = $referenceMessageId;

        return $this;
    }

    /**
     * Get referenceMessageId
     *
     * @return integer 
     */
    public function getReferenceMessageId()
    {
        return $this->referenceMessageId;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return SchedulerMessages
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     * @return SchedulerMessages
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime 
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set cnt
     *
     * @param integer $cnt
     * @return SchedulerMessages
     */
    public function setCnt($cnt)
    {
        $this->cnt = $cnt;

        return $this;
    }

    /**
     * Get cnt
     *
     * @return integer 
     */
    public function getCnt()
    {
        return $this->cnt;
    }
}
