<?php

namespace Arii\JIDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReportingExecutions
 *
 * @ORM\Table(name="reporting_executions", uniqueConstraints={@ORM\UniqueConstraint(name="REPORTING_INX_RE_UNIQUE", columns={"SCHEDULER_ID", "HISTORY_ID", "TRIGGER_ID", "STEP"})}, indexes={@ORM\Index(name="REPORTING_INX_RE_TASKID", columns={"TASK_ID"}), @ORM\Index(name="REPORTING_INX_RE_FOLDER", columns={"FOLDER"}), @ORM\Index(name="REPORTING_INX_RE_NAME", columns={"NAME"}), @ORM\Index(name="REPORTING_INX_RE_STIME", columns={"START_TIME"}), @ORM\Index(name="REPORTING_INX_RE_SCOMP", columns={"SYNC_COMPLETED"}), @ORM\Index(name="REPORTING_INX_RE_RCOMP", columns={"RESULTS_COMPLETED"})})
 * @ORM\Entity(readOnly=true)
 */
class ReportingExecutions
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
     * @ORM\Column(name="HISTORY_ID", type="integer", nullable=false)
     */
    private $historyId;

    /**
     * @var integer
     *
     * @ORM\Column(name="TRIGGER_ID", type="integer", nullable=false)
     */
    private $triggerId;

    /**
     * @var integer
     *
     * @ORM\Column(name="TASK_ID", type="integer", nullable=false)
     */
    private $taskId;

    /**
     * @var string
     *
     * @ORM\Column(name="CLUSTER_MEMBER_ID", type="string", length=100, nullable=true)
     */
    private $clusterMemberId;

    /**
     * @var integer
     *
     * @ORM\Column(name="STEP", type="integer", nullable=false)
     */
    private $step;

    /**
     * @var string
     *
     * @ORM\Column(name="FOLDER", type="string", length=255, nullable=false)
     */
    private $folder;

    /**
     * @var string
     *
     * @ORM\Column(name="NAME", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="BASENAME", type="string", length=255, nullable=false)
     */
    private $basename;

    /**
     * @var string
     *
     * @ORM\Column(name="TITLE", type="string", length=255, nullable=true)
     */
    private $title;

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
     * @ORM\Column(name="STATE", type="string", length=255, nullable=false)
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(name="CAUSE", type="string", length=50, nullable=false)
     */
    private $cause;

    /**
     * @var integer
     *
     * @ORM\Column(name="EXIT_CODE", type="integer", nullable=false)
     */
    private $exitCode;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ERROR", type="boolean", nullable=false)
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
     * @var string
     *
     * @ORM\Column(name="AGENT_URL", type="string", length=100, nullable=true)
     */
    private $agentUrl;

    /**
     * @var boolean
     *
     * @ORM\Column(name="IS_RUNTIME_DEFINED", type="boolean", nullable=false)
     */
    private $isRuntimeDefined;

    /**
     * @var boolean
     *
     * @ORM\Column(name="SYNC_COMPLETED", type="boolean", nullable=false)
     */
    private $syncCompleted;

    /**
     * @var boolean
     *
     * @ORM\Column(name="RESULTS_COMPLETED", type="boolean", nullable=false)
     */
    private $resultsCompleted;

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
     * @return ReportingExecutions
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
     * Set historyId
     *
     * @param integer $historyId
     * @return ReportingExecutions
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
     * Set triggerId
     *
     * @param integer $triggerId
     * @return ReportingExecutions
     */
    public function setTriggerId($triggerId)
    {
        $this->triggerId = $triggerId;

        return $this;
    }

    /**
     * Get triggerId
     *
     * @return integer 
     */
    public function getTriggerId()
    {
        return $this->triggerId;
    }

    /**
     * Set taskId
     *
     * @param integer $taskId
     * @return ReportingExecutions
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
     * Set clusterMemberId
     *
     * @param string $clusterMemberId
     * @return ReportingExecutions
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
     * Set step
     *
     * @param integer $step
     * @return ReportingExecutions
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
     * Set folder
     *
     * @param string $folder
     * @return ReportingExecutions
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
     * Set name
     *
     * @param string $name
     * @return ReportingExecutions
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
     * Set basename
     *
     * @param string $basename
     * @return ReportingExecutions
     */
    public function setBasename($basename)
    {
        $this->basename = $basename;

        return $this;
    }

    /**
     * Get basename
     *
     * @return string 
     */
    public function getBasename()
    {
        return $this->basename;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return ReportingExecutions
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
     * Set startTime
     *
     * @param \DateTime $startTime
     * @return ReportingExecutions
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
     * @return ReportingExecutions
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
     * Set state
     *
     * @param string $state
     * @return ReportingExecutions
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
     * Set cause
     *
     * @param string $cause
     * @return ReportingExecutions
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
     * Set exitCode
     *
     * @param integer $exitCode
     * @return ReportingExecutions
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
     * @param boolean $error
     * @return ReportingExecutions
     */
    public function setError($error)
    {
        $this->error = $error;

        return $this;
    }

    /**
     * Get error
     *
     * @return boolean 
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Set errorCode
     *
     * @param string $errorCode
     * @return ReportingExecutions
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
     * @return ReportingExecutions
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
     * Set agentUrl
     *
     * @param string $agentUrl
     * @return ReportingExecutions
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
     * Set isRuntimeDefined
     *
     * @param boolean $isRuntimeDefined
     * @return ReportingExecutions
     */
    public function setIsRuntimeDefined($isRuntimeDefined)
    {
        $this->isRuntimeDefined = $isRuntimeDefined;

        return $this;
    }

    /**
     * Get isRuntimeDefined
     *
     * @return boolean 
     */
    public function getIsRuntimeDefined()
    {
        return $this->isRuntimeDefined;
    }

    /**
     * Set syncCompleted
     *
     * @param boolean $syncCompleted
     * @return ReportingExecutions
     */
    public function setSyncCompleted($syncCompleted)
    {
        $this->syncCompleted = $syncCompleted;

        return $this;
    }

    /**
     * Get syncCompleted
     *
     * @return boolean 
     */
    public function getSyncCompleted()
    {
        return $this->syncCompleted;
    }

    /**
     * Set resultsCompleted
     *
     * @param boolean $resultsCompleted
     * @return ReportingExecutions
     */
    public function setResultsCompleted($resultsCompleted)
    {
        $this->resultsCompleted = $resultsCompleted;

        return $this;
    }

    /**
     * Get resultsCompleted
     *
     * @return boolean 
     */
    public function getResultsCompleted()
    {
        return $this->resultsCompleted;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return ReportingExecutions
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
     * @return ReportingExecutions
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
