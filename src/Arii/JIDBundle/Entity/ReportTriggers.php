<?php

namespace Arii\JIDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReportTriggers
 *
 * @ORM\Table(name="report_triggers", indexes={@ORM\Index(name="REPORTING_RT_SID", columns={"SCHEDULER_ID"}), @ORM\Index(name="REPORTING_RT_SCOMP", columns={"SYNC_COMPLETED"}), @ORM\Index(name="REPORTING_RT_RCOMP", columns={"RESULTS_COMPLETED"}), @ORM\Index(name="REPORTING_RT_STIME", columns={"START_TIME"}), @ORM\Index(name="REPORTING_RT_SUSP", columns={"SUSPENDED"}), @ORM\Index(name="REPORTING_RT_NAME", columns={"NAME"}), @ORM\Index(name="REPORTING_RT_PNAME", columns={"PARENT_NAME"})})
 * @ORM\Entity(readOnly=true)
 */
class ReportTriggers
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
     * @return ReportTriggers
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
     * @return ReportTriggers
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
     * @return ReportTriggers
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
     * @return ReportTriggers
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
     * Set parentName
     *
     * @param string $parentName
     * @return ReportTriggers
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
     * @return ReportTriggers
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
     * @return ReportTriggers
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
     * @return ReportTriggers
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
     * @return ReportTriggers
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
     * @return ReportTriggers
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
     * @return ReportTriggers
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
     * @return ReportTriggers
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
     * @return ReportTriggers
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
     * @return ReportTriggers
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
     * Set suspended
     *
     * @param boolean $suspended
     * @return ReportTriggers
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
     * @return ReportTriggers
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
     * @return ReportTriggers
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
