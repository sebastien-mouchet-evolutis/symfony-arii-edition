<?php

namespace Arii\JOCBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JobStatus
 *
 * @ORM\Table(name="JOC_ORDER_STEP_STATUS")
 * @ORM\Entity(repositoryClass="Arii\JOCBundle\Entity\JobStatusRepository")
 */
class OrderStepStatus
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
     * @ORM\OneToOne(targetEntity="Arii\JOCBundle\Entity\Orders")
     * @ORM\JoinColumn(nullable=true)
     **/
    private $order;

    /**
     * @ORM\OneToOne(targetEntity="Arii\JOCBundle\Entity\JobChainNodes")
     * @ORM\JoinColumn(nullable=true)
     **/
    private $node;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="history_id", type="integer")
     */
    private $historyId;

    /**
     * @var integer
     *
     * @ORM\Column(name="task_id", type="integer")
     */
    private $taskId;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="step", type="integer")
     */
    private $step;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_time", type="datetimetz")
     */
    private $startTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_time", type="datetimetz",nullable=true)
     */
    private $endTime;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=64, nullable=true)
     */
    private $state;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="error", type="integer")
     */
    private $error;

    /**
     * @var string
     *
     * @ORM\Column(name="error_code", type="string", length=64, nullable=true)
     */
    private $error_code;

    /**
     * @var string
     *
     * @ORM\Column(name="error_text", type="string", length=255, nullable=true)
     */
    private $error_text;

    /**
     * @var integer
     *
     * @ORM\Column(name="updated", type="integer")
     */
    private $updated;

    /**
     * @var string
     *
     * @ORM\Column(name="crc", type="string", length=9, nullable=true)
     */
    private $crc;

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
     * Set historyId
     *
     * @param integer $historyId
     * @return JobStatus
     */
    public function setHistoryId($historyId)
    {
        $this->historyId = $historyId;

        return $this;
    }

    /**
     * Get historyId
     *
     * @return integer 
     */
    public function getHistoryId()
    {
        return $this->historyId;
    }

    /**
     * Set jobName
     *
     * @param string $jobName
     * @return JobStatus
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
     * Set spooler
     *
     * @param string $spooler
     * @return JobStatus
     */
    public function setSpooler($spooler)
    {
        $this->spooler = $spooler;

        return $this;
    }

    /**
     * Get spooler
     *
     * @return string 
     */
    public function getSpooler()
    {
        return $this->spooler;
    }

    /**
     * Set startTime
     *
     * @param \DateTime $startTime
     * @return JobStatus
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * Get startTime
     *
     * @return \DateTime 
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set endTime
     *
     * @param \DateTime $endTime
     * @return JobStatus
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * Get endTime
     *
     * @return \DateTime 
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Set pid
     *
     * @param integer $pid
     * @return JobStatus
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
     * Set taskId
     *
     * @param integer $taskId
     * @return OrderStepStatus
     */
    public function setTaskId($taskId)
    {
        $this->taskId = $taskId;

        return $this;
    }

    /**
     * Get taskId
     *
     * @return integer 
     */
    public function getTaskId()
    {
        return $this->taskId;
    }

    /**
     * Set step
     *
     * @param integer $step
     * @return OrderStepStatus
     */
    public function setStep($step)
    {
        $this->step = $step;

        return $this;
    }

    /**
     * Get step
     *
     * @return integer 
     */
    public function getStep()
    {
        return $this->step;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return OrderStepStatus
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
     * Set error
     *
     * @param integer $error
     * @return OrderStepStatus
     */
    public function setError($error)
    {
        $this->error = $error;

        return $this;
    }

    /**
     * Get error
     *
     * @return integer 
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Set error_code
     *
     * @param string $errorCode
     * @return OrderStepStatus
     */
    public function setErrorCode($errorCode)
    {
        $this->error_code = $errorCode;

        return $this;
    }

    /**
     * Get error_code
     *
     * @return string 
     */
    public function getErrorCode()
    {
        return $this->error_code;
    }

    /**
     * Set error_text
     *
     * @param string $errorText
     * @return OrderStepStatus
     */
    public function setErrorText($errorText)
    {
        $this->error_text = $errorText;

        return $this;
    }

    /**
     * Get error_text
     *
     * @return string 
     */
    public function getErrorText()
    {
        return $this->error_text;
    }

    /**
     * Set updated
     *
     * @param integer $updated
     * @return OrderStepStatus
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return integer 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set crc
     *
     * @param string $crc
     * @return OrderStepStatus
     */
    public function setCrc($crc)
    {
        $this->crc = $crc;

        return $this;
    }

    /**
     * Get crc
     *
     * @return string 
     */
    public function getCrc()
    {
        return $this->crc;
    }

    /**
     * Set order
     *
     * @param \Arii\JOCBundle\Entity\Orders $order
     * @return OrderStepStatus
     */
    public function setOrder(\Arii\JOCBundle\Entity\Orders $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \Arii\JOCBundle\Entity\Orders 
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set node
     *
     * @param \Arii\JOCBundle\Entity\JobChainNodes $node
     * @return OrderStepStatus
     */
    public function setNode(\Arii\JOCBundle\Entity\JobChainNodes $node = null)
    {
        $this->node = $node;

        return $this;
    }

    /**
     * Get node
     *
     * @return \Arii\JOCBundle\Entity\JobChainNodes 
     */
    public function getNode()
    {
        return $this->node;
    }
}
