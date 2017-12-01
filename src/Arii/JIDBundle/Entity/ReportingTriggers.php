<?php

namespace Arii\JIDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReportingTriggers
 *
 * @ORM\Table(name="reporting_triggers", uniqueConstraints={@ORM\UniqueConstraint(name="REPORTING_INX_RT_UNIQUE", columns={"SCHEDULER_ID", "HISTORY_ID"})}, indexes={@ORM\Index(name="REPORTING_INX_RT_NAME", columns={"NAME"}), @ORM\Index(name="REPORTING_INX_RT_PFOLDER", columns={"PARENT_FOLDER"}), @ORM\Index(name="REPORTING_INX_RT_PNAME", columns={"PARENT_NAME"}), @ORM\Index(name="REPORTING_INX_RT_STIME", columns={"START_TIME"}), @ORM\Index(name="REPORTING_INX_RT_SCOMP", columns={"SYNC_COMPLETED"}), @ORM\Index(name="REPORTING_INX_RT_RCOMP", columns={"RESULTS_COMPLETED"})})
 * @ORM\Entity(readOnly=true)
 */
class ReportingTriggers
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
     * @var string
     *
     * @ORM\Column(name="NAME", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="TITLE", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="PARENT_FOLDER", type="string", length=255, nullable=false)
     */
    private $parentFolder;

    /**
     * @var string
     *
     * @ORM\Column(name="PARENT_NAME", type="string", length=255, nullable=false)
     */
    private $parentName;

    /**
     * @var string
     *
     * @ORM\Column(name="PARENT_BASENAME", type="string", length=255, nullable=false)
     */
    private $parentBasename;

    /**
     * @var string
     *
     * @ORM\Column(name="PARENT_TITLE", type="string", length=255, nullable=true)
     */
    private $parentTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="STATE", type="string", length=255, nullable=true)
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(name="STATE_TEXT", type="string", length=255, nullable=true)
     */
    private $stateText;

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
     * @var boolean
     *
     * @ORM\Column(name="IS_RUNTIME_DEFINED", type="boolean", nullable=false)
     */
    private $isRuntimeDefined;

    /**
     * @var string
     *
     * @ORM\Column(name="RESULT_START_CAUSE", type="string", length=50, nullable=false)
     */
    private $resultStartCause;

    /**
     * @var integer
     *
     * @ORM\Column(name="RESULT_STEPS", type="integer", nullable=false)
     */
    private $resultSteps;

    /**
     * @var boolean
     *
     * @ORM\Column(name="RESULT_ERROR", type="boolean", nullable=false)
     */
    private $resultError;

    /**
     * @var string
     *
     * @ORM\Column(name="RESULT_ERROR_CODE", type="string", length=50, nullable=true)
     */
    private $resultErrorCode;

    /**
     * @var string
     *
     * @ORM\Column(name="RESULT_ERROR_TEXT", type="string", length=255, nullable=true)
     */
    private $resultErrorText;

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
     * @return ReportingTriggers
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
     * @return ReportingTriggers
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
     * Set name
     *
     * @param string $name
     * @return ReportingTriggers
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
     * @return ReportingTriggers
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
     * Set parentFolder
     *
     * @param string $parentFolder
     * @return ReportingTriggers
     */
    public function setParentFolder($parentFolder)
    {
        $this->parentFolder = $parentFolder;

        return $this;
    }

    /**
     * Get parentFolder
     *
     * @return string 
     */
    public function getParentFolder()
    {
        return $this->parentFolder;
    }

    /**
     * Set parentName
     *
     * @param string $parentName
     * @return ReportingTriggers
     */
    public function setParentName($parentName)
    {
        $this->parentName = $parentName;

        return $this;
    }

    /**
     * Get parentName
     *
     * @return string 
     */
    public function getParentName()
    {
        return $this->parentName;
    }

    /**
     * Set parentBasename
     *
     * @param string $parentBasename
     * @return ReportingTriggers
     */
    public function setParentBasename($parentBasename)
    {
        $this->parentBasename = $parentBasename;

        return $this;
    }

    /**
     * Get parentBasename
     *
     * @return string 
     */
    public function getParentBasename()
    {
        return $this->parentBasename;
    }

    /**
     * Set parentTitle
     *
     * @param string $parentTitle
     * @return ReportingTriggers
     */
    public function setParentTitle($parentTitle)
    {
        $this->parentTitle = $parentTitle;

        return $this;
    }

    /**
     * Get parentTitle
     *
     * @return string 
     */
    public function getParentTitle()
    {
        return $this->parentTitle;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return ReportingTriggers
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
     * Set stateText
     *
     * @param string $stateText
     * @return ReportingTriggers
     */
    public function setStateText($stateText)
    {
        $this->stateText = $stateText;

        return $this;
    }

    /**
     * Get stateText
     *
     * @return string 
     */
    public function getStateText()
    {
        return $this->stateText;
    }

    /**
     * Set startTime
     *
     * @param \DateTime $startTime
     * @return ReportingTriggers
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
     * @return ReportingTriggers
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
     * Set isRuntimeDefined
     *
     * @param boolean $isRuntimeDefined
     * @return ReportingTriggers
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
     * Set resultStartCause
     *
     * @param string $resultStartCause
     * @return ReportingTriggers
     */
    public function setResultStartCause($resultStartCause)
    {
        $this->resultStartCause = $resultStartCause;

        return $this;
    }

    /**
     * Get resultStartCause
     *
     * @return string 
     */
    public function getResultStartCause()
    {
        return $this->resultStartCause;
    }

    /**
     * Set resultSteps
     *
     * @param integer $resultSteps
     * @return ReportingTriggers
     */
    public function setResultSteps($resultSteps)
    {
        $this->resultSteps = $resultSteps;

        return $this;
    }

    /**
     * Get resultSteps
     *
     * @return integer 
     */
    public function getResultSteps()
    {
        return $this->resultSteps;
    }

    /**
     * Set resultError
     *
     * @param boolean $resultError
     * @return ReportingTriggers
     */
    public function setResultError($resultError)
    {
        $this->resultError = $resultError;

        return $this;
    }

    /**
     * Get resultError
     *
     * @return boolean 
     */
    public function getResultError()
    {
        return $this->resultError;
    }

    /**
     * Set resultErrorCode
     *
     * @param string $resultErrorCode
     * @return ReportingTriggers
     */
    public function setResultErrorCode($resultErrorCode)
    {
        $this->resultErrorCode = $resultErrorCode;

        return $this;
    }

    /**
     * Get resultErrorCode
     *
     * @return string 
     */
    public function getResultErrorCode()
    {
        return $this->resultErrorCode;
    }

    /**
     * Set resultErrorText
     *
     * @param string $resultErrorText
     * @return ReportingTriggers
     */
    public function setResultErrorText($resultErrorText)
    {
        $this->resultErrorText = $resultErrorText;

        return $this;
    }

    /**
     * Get resultErrorText
     *
     * @return string 
     */
    public function getResultErrorText()
    {
        return $this->resultErrorText;
    }

    /**
     * Set syncCompleted
     *
     * @param boolean $syncCompleted
     * @return ReportingTriggers
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
     * @return ReportingTriggers
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
     * @return ReportingTriggers
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
     * @return ReportingTriggers
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
