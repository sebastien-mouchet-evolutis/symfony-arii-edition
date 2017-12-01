<?php

namespace Arii\JIDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReportExecutions
 *
 * @ORM\Table(name="report_executions", indexes={@ORM\Index(name="REPORTING_RE_SID", columns={"SCHEDULER_ID"}), @ORM\Index(name="REPORTING_RE_TID", columns={"TRIGGER_ID"}), @ORM\Index(name="REPORTING_RE_STIME", columns={"START_TIME"}), @ORM\Index(name="REPORTING_RE_SUSP", columns={"SUSPENDED"}), @ORM\Index(name="REPORTING_RE_NAME", columns={"NAME"})})
 * @ORM\Entity(readOnly=true)
 */
class ReportExecutions
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
     * @ORM\Column(name="STEP", type="integer", nullable=false)
     */
    private $step;

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
     * @ORM\Column(name="SUSPENDED", type="boolean", nullable=false)
     */
    private $suspended;

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
     * @return ReportExecutions
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
     * @return ReportExecutions
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
     * @return ReportExecutions
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
     * Set step
     *
     * @param integer $step
     * @return ReportExecutions
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
     * Set name
     *
     * @param string $name
     * @return ReportExecutions
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
     * @return ReportExecutions
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
     * @return ReportExecutions
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
     * @return ReportExecutions
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
     * @return ReportExecutions
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
     * @return ReportExecutions
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
     * @return ReportExecutions
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
     * Set error
     *
     * @param boolean $error
     * @return ReportExecutions
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
     * @return ReportExecutions
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
     * @return ReportExecutions
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
     * @return ReportExecutions
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
     * @return ReportExecutions
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
     * Set suspended
     *
     * @param boolean $suspended
     * @return ReportExecutions
     */
    public function setSuspended($suspended)
    {
        $this->suspended = $suspended;

        return $this;
    }

    /**
     * Get suspended
     *
     * @return boolean 
     */
    public function getSuspended()
    {
        return $this->suspended;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return ReportExecutions
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
     * @return ReportExecutions
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
