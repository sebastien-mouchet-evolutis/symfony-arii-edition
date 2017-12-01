<?php

namespace Arii\JIDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReportingTasks
 *
 * @ORM\Table(name="reporting_tasks", uniqueConstraints={@ORM\UniqueConstraint(name="REPORTING_INX_RTS_UNIQUE", columns={"SCHEDULER_ID", "HISTORY_ID"})}, indexes={@ORM\Index(name="REPORTING_INX_RTS_FOLDER", columns={"FOLDER"}), @ORM\Index(name="REPORTING_INX_RTS_NAME", columns={"NAME"}), @ORM\Index(name="REPORTING_INX_RTS_STIME", columns={"START_TIME"}), @ORM\Index(name="REPORTING_INX_RTS_SCOMP", columns={"SYNC_COMPLETED"}), @ORM\Index(name="REPORTING_INX_RTS_RCOMP", columns={"RESULTS_COMPLETED"})})
 * @ORM\Entity(readOnly=true)
 */
class ReportingTasks
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
     * @ORM\Column(name="IS_ORDER", type="integer", nullable=false)
     */
    private $isOrder;

    /**
     * @var string
     *
     * @ORM\Column(name="CLUSTER_MEMBER_ID", type="string", length=100, nullable=true)
     */
    private $clusterMemberId;

    /**
     * @var integer
     *
     * @ORM\Column(name="STEPS", type="integer", nullable=false)
     */
    private $steps;

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
     * @return ReportingTasks
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
     * @return ReportingTasks
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
     * Set isOrder
     *
     * @param integer $isOrder
     * @return ReportingTasks
     */
    public function setIsOrder($isOrder)
    {
        $this->isOrder = $isOrder;

        return $this;
    }

    /**
     * Get isOrder
     *
     * @return integer 
     */
    public function getIsOrder()
    {
        return $this->isOrder;
    }

    /**
     * Set clusterMemberId
     *
     * @param string $clusterMemberId
     * @return ReportingTasks
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
     * Set steps
     *
     * @param integer $steps
     * @return ReportingTasks
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
     * Set folder
     *
     * @param string $folder
     * @return ReportingTasks
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
     * @return ReportingTasks
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
     * @return ReportingTasks
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
     * @return ReportingTasks
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
     * @return ReportingTasks
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
     * @return ReportingTasks
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
     * @return ReportingTasks
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
     * @return ReportingTasks
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
     * @return ReportingTasks
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
     * @return ReportingTasks
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
     * @return ReportingTasks
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
     * @return ReportingTasks
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
     * @return ReportingTasks
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
     * @return ReportingTasks
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
     * @return ReportingTasks
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
     * @return ReportingTasks
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
     * @return ReportingTasks
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
