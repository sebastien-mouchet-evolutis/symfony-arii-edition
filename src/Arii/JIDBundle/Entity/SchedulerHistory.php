<?php

namespace Arii\JIDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SchedulerHistory
 *
 * @ORM\Table(name="scheduler_history", indexes={@ORM\Index(name="SCHEDULER_HISTORY_START_TIME", columns={"START_TIME"}), @ORM\Index(name="SCHEDULER_HISTORY_SPOOLER_ID", columns={"SPOOLER_ID"}), @ORM\Index(name="SCHEDULER_HISTORY_JOB_NAME", columns={"JOB_NAME"}), @ORM\Index(name="SCHEDULER_H_CLUSTER_MEMBER", columns={"CLUSTER_MEMBER_ID"})})
 * @ORM\Entity(readOnly=true)
 */
class SchedulerHistory
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
     * @ORM\Column(name="SPOOLER_ID", type="string", length=100, nullable=true)
     */
    private $spoolerId;

    /**
     * @var string
     *
     * @ORM\Column(name="CLUSTER_MEMBER_ID", type="string", length=100, nullable=true)
     */
    private $clusterMemberId;

    /**
     * @var string
     *
     * @ORM\Column(name="JOB_NAME", type="string", length=255, nullable=true)
     */
    private $jobName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="START_TIME", type="datetime", nullable=false)
     */
    private $startTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="END_TIME", type="datetime", nullable=true)
     */
    private $endTime;

    /**
     * @var string
     *
     * @ORM\Column(name="CAUSE", type="string", length=50, nullable=true)
     */
    private $cause;

    /**
     * @var integer
     *
     * @ORM\Column(name="STEPS", type="integer", nullable=true)
     */
    private $steps;

    /**
     * @var integer
     *
     * @ORM\Column(name="EXIT_CODE", type="integer", nullable=true)
     */
    private $exitCode;

    /**
     * @var integer
     *
     * @ORM\Column(name="ERROR", type="integer", nullable=true)
     */
    private $error;

    /**
     * @var string
     *
     * @ORM\Column(name="ERROR_CODE", type="string", length=50, nullable=true)
     */
    private $errorCode;

    /**
     * @var string
     *
     * @ORM\Column(name="ERROR_TEXT", type="string", length=250, nullable=true)
     */
    private $errorText;

    /**
     * @var string
     *
     * @ORM\Column(name="PARAMETERS", type="text", nullable=true)
     */
    private $parameters;

    /**
     * @var string
     *
     * @ORM\Column(name="LOG", type="blob", nullable=true)
     */
    private $log;

    /**
     * @var string
     *
     * @ORM\Column(name="ITEM_START", type="string", length=250, nullable=true)
     */
    private $itemStart;

    /**
     * @var string
     *
     * @ORM\Column(name="ITEM_STOP", type="string", length=250, nullable=true)
     */
    private $itemStop;

    /**
     * @var integer
     *
     * @ORM\Column(name="PID", type="integer", nullable=true)
     */
    private $pid;

    /**
     * @var string
     *
     * @ORM\Column(name="AGENT_URL", type="string", length=100, nullable=true)
     */
    private $agentUrl;



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
     * @return SchedulerHistory
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
     * Set clusterMemberId
     *
     * @param string $clusterMemberId
     * @return SchedulerHistory
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
     * Set jobName
     *
     * @param string $jobName
     * @return SchedulerHistory
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
     * Set startTime
     *
     * @param \DateTime $startTime
     * @return SchedulerHistory
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
     * @return SchedulerHistory
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
     * Set cause
     *
     * @param string $cause
     * @return SchedulerHistory
     */
    public function setCause($cause)
    {
        $this->cause = $cause;

        return $this;
    }

    /**
     * Get cause
     *
     * @return string 
     */
    public function getCause()
    {
        return $this->cause;
    }

    /**
     * Set steps
     *
     * @param integer $steps
     * @return SchedulerHistory
     */
    public function setSteps($steps)
    {
        $this->steps = $steps;

        return $this;
    }

    /**
     * Get steps
     *
     * @return integer 
     */
    public function getSteps()
    {
        return $this->steps;
    }

    /**
     * Set exitCode
     *
     * @param integer $exitCode
     * @return SchedulerHistory
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
     * Set error
     *
     * @param integer $error
     * @return SchedulerHistory
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
     * Set errorCode
     *
     * @param string $errorCode
     * @return SchedulerHistory
     */
    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;

        return $this;
    }

    /**
     * Get errorCode
     *
     * @return string 
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * Set errorText
     *
     * @param string $errorText
     * @return SchedulerHistory
     */
    public function setErrorText($errorText)
    {
        $this->errorText = $errorText;

        return $this;
    }

    /**
     * Get errorText
     *
     * @return string 
     */
    public function getErrorText()
    {
        return $this->errorText;
    }

    /**
     * Set parameters
     *
     * @param string $parameters
     * @return SchedulerHistory
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
     * Set log
     *
     * @param string $log
     * @return SchedulerHistory
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
     * Set itemStart
     *
     * @param string $itemStart
     * @return SchedulerHistory
     */
    public function setItemStart($itemStart)
    {
        $this->itemStart = $itemStart;

        return $this;
    }

    /**
     * Get itemStart
     *
     * @return string 
     */
    public function getItemStart()
    {
        return $this->itemStart;
    }

    /**
     * Set itemStop
     *
     * @param string $itemStop
     * @return SchedulerHistory
     */
    public function setItemStop($itemStop)
    {
        $this->itemStop = $itemStop;

        return $this;
    }

    /**
     * Get itemStop
     *
     * @return string 
     */
    public function getItemStop()
    {
        return $this->itemStop;
    }

    /**
     * Set pid
     *
     * @param integer $pid
     * @return SchedulerHistory
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
     * Set agentUrl
     *
     * @param string $agentUrl
     * @return SchedulerHistory
     */
    public function setAgentUrl($agentUrl)
    {
        $this->agentUrl = $agentUrl;

        return $this;
    }

    /**
     * Get agentUrl
     *
     * @return string 
     */
    public function getAgentUrl()
    {
        return $this->agentUrl;
    }
}
