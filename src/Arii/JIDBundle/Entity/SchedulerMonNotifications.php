<?php

namespace Arii\JIDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SchedulerMonNotifications
 *
 * @ORM\Table(name="scheduler_mon_notifications", uniqueConstraints={@ORM\UniqueConstraint(name="SCHEDULER_MN_UNIQ", columns={"SCHEDULER_ID", "ORDER_HISTORY_ID", "STEP", "TASK_ID", "STANDALONE"})}, indexes={@ORM\Index(name="SCHEDULER_MN_J_C", columns={"JOB_CHAIN_NAME"}), @ORM\Index(name="SCHEDULER_MN_ERR", columns={"ERROR"}), @ORM\Index(name="SCHEDULER_MN_REC", columns={"RECOVERED"})})
 * @ORM\Entity(readOnly=true)
 */
class SchedulerMonNotifications
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
     * @var integer
     *
     * @ORM\Column(name="STANDALONE", type="integer", nullable=false)
     */
    private $standalone;

    /**
     * @var integer
     *
     * @ORM\Column(name="TASK_ID", type="integer", nullable=false)
     */
    private $taskId;

    /**
     * @var integer
     *
     * @ORM\Column(name="STEP", type="integer", nullable=false)
     */
    private $step;

    /**
     * @var integer
     *
     * @ORM\Column(name="ORDER_HISTORY_ID", type="integer", nullable=false)
     */
    private $orderHistoryId;

    /**
     * @var string
     *
     * @ORM\Column(name="JOB_CHAIN_NAME", type="string", length=255, nullable=false)
     */
    private $jobChainName;

    /**
     * @var string
     *
     * @ORM\Column(name="JOB_CHAIN_TITLE", type="string", length=255, nullable=true)
     */
    private $jobChainTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="ORDER_ID", type="string", length=255, nullable=false)
     */
    private $orderId;

    /**
     * @var string
     *
     * @ORM\Column(name="ORDER_TITLE", type="string", length=255, nullable=true)
     */
    private $orderTitle;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ORDER_START_TIME", type="datetime", nullable=true)
     */
    private $orderStartTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ORDER_END_TIME", type="datetime", nullable=true)
     */
    private $orderEndTime;

    /**
     * @var string
     *
     * @ORM\Column(name="ORDER_STEP_STATE", type="string", length=100, nullable=false)
     */
    private $orderStepState;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ORDER_STEP_START_TIME", type="datetime", nullable=true)
     */
    private $orderStepStartTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ORDER_STEP_END_TIME", type="datetime", nullable=true)
     */
    private $orderStepEndTime;

    /**
     * @var string
     *
     * @ORM\Column(name="JOB_NAME", type="string", length=255, nullable=false)
     */
    private $jobName;

    /**
     * @var string
     *
     * @ORM\Column(name="JOB_TITLE", type="string", length=255, nullable=true)
     */
    private $jobTitle;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="TASK_START_TIME", type="datetime", nullable=false)
     */
    private $taskStartTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="TASK_END_TIME", type="datetime", nullable=true)
     */
    private $taskEndTime;

    /**
     * @var integer
     *
     * @ORM\Column(name="RECOVERED", type="integer", nullable=false)
     */
    private $recovered;

    /**
     * @var integer
     *
     * @ORM\Column(name="RETURN_CODE", type="integer", nullable=false)
     */
    private $returnCode;

    /**
     * @var string
     *
     * @ORM\Column(name="AGENT_URL", type="string", length=100, nullable=true)
     */
    private $agentUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="CLUSTER_MEMBER_ID", type="string", length=100, nullable=true)
     */
    private $clusterMemberId;

    /**
     * @var integer
     *
     * @ORM\Column(name="ERROR", type="integer", nullable=false)
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
     * @ORM\Column(name="ERROR_TEXT", type="string", length=255, nullable=true)
     */
    private $errorText;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="CREATED", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="MODIFIED", type="datetime", nullable=false)
     */
    private $modified;



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
     * @return SchedulerMonNotifications
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
     * Set standalone
     *
     * @param integer $standalone
     * @return SchedulerMonNotifications
     */
    public function setStandalone($standalone)
    {
        $this->standalone = $standalone;

        return $this;
    }

    /**
     * Get standalone
     *
     * @return integer 
     */
    public function getStandalone()
    {
        return $this->standalone;
    }

    /**
     * Set taskId
     *
     * @param integer $taskId
     * @return SchedulerMonNotifications
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
     * @return SchedulerMonNotifications
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
     * Set orderHistoryId
     *
     * @param integer $orderHistoryId
     * @return SchedulerMonNotifications
     */
    public function setOrderHistoryId($orderHistoryId)
    {
        $this->orderHistoryId = $orderHistoryId;

        return $this;
    }

    /**
     * Get orderHistoryId
     *
     * @return integer 
     */
    public function getOrderHistoryId()
    {
        return $this->orderHistoryId;
    }

    /**
     * Set jobChainName
     *
     * @param string $jobChainName
     * @return SchedulerMonNotifications
     */
    public function setJobChainName($jobChainName)
    {
        $this->jobChainName = $jobChainName;

        return $this;
    }

    /**
     * Get jobChainName
     *
     * @return string 
     */
    public function getJobChainName()
    {
        return $this->jobChainName;
    }

    /**
     * Set jobChainTitle
     *
     * @param string $jobChainTitle
     * @return SchedulerMonNotifications
     */
    public function setJobChainTitle($jobChainTitle)
    {
        $this->jobChainTitle = $jobChainTitle;

        return $this;
    }

    /**
     * Get jobChainTitle
     *
     * @return string 
     */
    public function getJobChainTitle()
    {
        return $this->jobChainTitle;
    }

    /**
     * Set orderId
     *
     * @param string $orderId
     * @return SchedulerMonNotifications
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
     * Set orderTitle
     *
     * @param string $orderTitle
     * @return SchedulerMonNotifications
     */
    public function setOrderTitle($orderTitle)
    {
        $this->orderTitle = $orderTitle;

        return $this;
    }

    /**
     * Get orderTitle
     *
     * @return string 
     */
    public function getOrderTitle()
    {
        return $this->orderTitle;
    }

    /**
     * Set orderStartTime
     *
     * @param \DateTime $orderStartTime
     * @return SchedulerMonNotifications
     */
    public function setOrderStartTime($orderStartTime)
    {
        $this->orderStartTime = $orderStartTime;

        return $this;
    }

    /**
     * Get orderStartTime
     *
     * @return \DateTime 
     */
    public function getOrderStartTime()
    {
        return $this->orderStartTime;
    }

    /**
     * Set orderEndTime
     *
     * @param \DateTime $orderEndTime
     * @return SchedulerMonNotifications
     */
    public function setOrderEndTime($orderEndTime)
    {
        $this->orderEndTime = $orderEndTime;

        return $this;
    }

    /**
     * Get orderEndTime
     *
     * @return \DateTime 
     */
    public function getOrderEndTime()
    {
        return $this->orderEndTime;
    }

    /**
     * Set orderStepState
     *
     * @param string $orderStepState
     * @return SchedulerMonNotifications
     */
    public function setOrderStepState($orderStepState)
    {
        $this->orderStepState = $orderStepState;

        return $this;
    }

    /**
     * Get orderStepState
     *
     * @return string 
     */
    public function getOrderStepState()
    {
        return $this->orderStepState;
    }

    /**
     * Set orderStepStartTime
     *
     * @param \DateTime $orderStepStartTime
     * @return SchedulerMonNotifications
     */
    public function setOrderStepStartTime($orderStepStartTime)
    {
        $this->orderStepStartTime = $orderStepStartTime;

        return $this;
    }

    /**
     * Get orderStepStartTime
     *
     * @return \DateTime 
     */
    public function getOrderStepStartTime()
    {
        return $this->orderStepStartTime;
    }

    /**
     * Set orderStepEndTime
     *
     * @param \DateTime $orderStepEndTime
     * @return SchedulerMonNotifications
     */
    public function setOrderStepEndTime($orderStepEndTime)
    {
        $this->orderStepEndTime = $orderStepEndTime;

        return $this;
    }

    /**
     * Get orderStepEndTime
     *
     * @return \DateTime 
     */
    public function getOrderStepEndTime()
    {
        return $this->orderStepEndTime;
    }

    /**
     * Set jobName
     *
     * @param string $jobName
     * @return SchedulerMonNotifications
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
     * Set jobTitle
     *
     * @param string $jobTitle
     * @return SchedulerMonNotifications
     */
    public function setJobTitle($jobTitle)
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }

    /**
     * Get jobTitle
     *
     * @return string 
     */
    public function getJobTitle()
    {
        return $this->jobTitle;
    }

    /**
     * Set taskStartTime
     *
     * @param \DateTime $taskStartTime
     * @return SchedulerMonNotifications
     */
    public function setTaskStartTime($taskStartTime)
    {
        $this->taskStartTime = $taskStartTime;

        return $this;
    }

    /**
     * Get taskStartTime
     *
     * @return \DateTime 
     */
    public function getTaskStartTime()
    {
        return $this->taskStartTime;
    }

    /**
     * Set taskEndTime
     *
     * @param \DateTime $taskEndTime
     * @return SchedulerMonNotifications
     */
    public function setTaskEndTime($taskEndTime)
    {
        $this->taskEndTime = $taskEndTime;

        return $this;
    }

    /**
     * Get taskEndTime
     *
     * @return \DateTime 
     */
    public function getTaskEndTime()
    {
        return $this->taskEndTime;
    }

    /**
     * Set recovered
     *
     * @param integer $recovered
     * @return SchedulerMonNotifications
     */
    public function setRecovered($recovered)
    {
        $this->recovered = $recovered;

        return $this;
    }

    /**
     * Get recovered
     *
     * @return integer 
     */
    public function getRecovered()
    {
        return $this->recovered;
    }

    /**
     * Set returnCode
     *
     * @param integer $returnCode
     * @return SchedulerMonNotifications
     */
    public function setReturnCode($returnCode)
    {
        $this->returnCode = $returnCode;

        return $this;
    }

    /**
     * Get returnCode
     *
     * @return integer 
     */
    public function getReturnCode()
    {
        return $this->returnCode;
    }

    /**
     * Set agentUrl
     *
     * @param string $agentUrl
     * @return SchedulerMonNotifications
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

    /**
     * Set clusterMemberId
     *
     * @param string $clusterMemberId
     * @return SchedulerMonNotifications
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
     * Set error
     *
     * @param integer $error
     * @return SchedulerMonNotifications
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
     * @return SchedulerMonNotifications
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
     * @return SchedulerMonNotifications
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
     * Set created
     *
     * @param \DateTime $created
     * @return SchedulerMonNotifications
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
     * Set modified
     *
     * @param \DateTime $modified
     * @return SchedulerMonNotifications
     */
    public function setModified($modified)
    {
        $this->modified = $modified;

        return $this;
    }

    /**
     * Get modified
     *
     * @return \DateTime 
     */
    public function getModified()
    {
        return $this->modified;
    }
}
