<?php

namespace Arii\JIDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InventoryJobs
 *
 * @ORM\Table(name="inventory_jobs", uniqueConstraints={@ORM\UniqueConstraint(name="INVENTORY_IJ_UNIQUE", columns={"FILE_ID"})}, indexes={@ORM\Index(name="REPORTING_IJ_INST_ID", columns={"INSTANCE_ID"}), @ORM\Index(name="REPORTING_IJ_FILE_ID", columns={"FILE_ID"}), @ORM\Index(name="REPORTING_IJ_NAME", columns={"NAME"})})
 * @ORM\Entity(readOnly=true)
 */
class InventoryJobs
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
     * @var integer
     *
     * @ORM\Column(name="INSTANCE_ID", type="integer", nullable=false)
     */
    private $instanceId;

    /**
     * @var integer
     *
     * @ORM\Column(name="FILE_ID", type="integer", nullable=false)
     */
    private $fileId;

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
     * @var integer
     *
     * @ORM\Column(name="IS_ORDER_JOB", type="integer", nullable=false)
     */
    private $isOrderJob;

    /**
     * @var integer
     *
     * @ORM\Column(name="IS_RUNTIME_DEFINED", type="integer", nullable=false)
     */
    private $isRuntimeDefined;

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
     * @var integer
     *
     * @ORM\Column(name="USED_IN_JOB_CHAINS", type="integer", nullable=true)
     */
    private $usedInJobChains;

    /**
     * @var string
     *
     * @ORM\Column(name="PROCESS_CLASS", type="string", length=255, nullable=true)
     */
    private $processClass;

    /**
     * @var string
     *
     * @ORM\Column(name="PROCESS_CLASS_NAME", type="string", length=255, nullable=false)
     */
    private $processClassName;

    /**
     * @var integer
     *
     * @ORM\Column(name="PROCESS_CLASS_ID", type="integer", nullable=false)
     */
    private $processClassId;

    /**
     * @var string
     *
     * @ORM\Column(name="SCHEDULE", type="string", length=255, nullable=true)
     */
    private $schedule;

    /**
     * @var string
     *
     * @ORM\Column(name="SCHEDULE_NAME", type="string", length=255, nullable=false)
     */
    private $scheduleName;

    /**
     * @var integer
     *
     * @ORM\Column(name="SCHEDULE_ID", type="integer", nullable=false)
     */
    private $scheduleId;

    /**
     * @var integer
     *
     * @ORM\Column(name="MAX_TASKS", type="integer", nullable=false)
     */
    private $maxTasks;

    /**
     * @var integer
     *
     * @ORM\Column(name="HAS_DESCRIPTION", type="integer", nullable=true)
     */
    private $hasDescription;

    /**
     * @var integer
     *
     * @ORM\Column(name="RUN_TIME_IS_TEMPORARY", type="integer", nullable=false)
     */
    private $runTimeIsTemporary;



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
     * Set instanceId
     *
     * @param integer $instanceId
     * @return InventoryJobs
     */
    public function setInstanceId($instanceId)
    {
        $this->instanceId = $instanceId;

        return $this;
    }

    /**
     * Get instanceId
     *
     * @return integer 
     */
    public function getInstanceId()
    {
        return $this->instanceId;
    }

    /**
     * Set fileId
     *
     * @param integer $fileId
     * @return InventoryJobs
     */
    public function setFileId($fileId)
    {
        $this->fileId = $fileId;

        return $this;
    }

    /**
     * Get fileId
     *
     * @return integer 
     */
    public function getFileId()
    {
        return $this->fileId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return InventoryJobs
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
     * @return InventoryJobs
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
     * @return InventoryJobs
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
     * Set isOrderJob
     *
     * @param integer $isOrderJob
     * @return InventoryJobs
     */
    public function setIsOrderJob($isOrderJob)
    {
        $this->isOrderJob = $isOrderJob;

        return $this;
    }

    /**
     * Get isOrderJob
     *
     * @return integer 
     */
    public function getIsOrderJob()
    {
        return $this->isOrderJob;
    }

    /**
     * Set isRuntimeDefined
     *
     * @param integer $isRuntimeDefined
     * @return InventoryJobs
     */
    public function setIsRuntimeDefined($isRuntimeDefined)
    {
        $this->isRuntimeDefined = $isRuntimeDefined;

        return $this;
    }

    /**
     * Get isRuntimeDefined
     *
     * @return integer 
     */
    public function getIsRuntimeDefined()
    {
        return $this->isRuntimeDefined;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return InventoryJobs
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
     * @return InventoryJobs
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

    /**
     * Set usedInJobChains
     *
     * @param integer $usedInJobChains
     * @return InventoryJobs
     */
    public function setUsedInJobChains($usedInJobChains)
    {
        $this->usedInJobChains = $usedInJobChains;

        return $this;
    }

    /**
     * Get usedInJobChains
     *
     * @return integer 
     */
    public function getUsedInJobChains()
    {
        return $this->usedInJobChains;
    }

    /**
     * Set processClass
     *
     * @param string $processClass
     * @return InventoryJobs
     */
    public function setProcessClass($processClass)
    {
        $this->processClass = $processClass;

        return $this;
    }

    /**
     * Get processClass
     *
     * @return string 
     */
    public function getProcessClass()
    {
        return $this->processClass;
    }

    /**
     * Set processClassName
     *
     * @param string $processClassName
     * @return InventoryJobs
     */
    public function setProcessClassName($processClassName)
    {
        $this->processClassName = $processClassName;

        return $this;
    }

    /**
     * Get processClassName
     *
     * @return string 
     */
    public function getProcessClassName()
    {
        return $this->processClassName;
    }

    /**
     * Set processClassId
     *
     * @param integer $processClassId
     * @return InventoryJobs
     */
    public function setProcessClassId($processClassId)
    {
        $this->processClassId = $processClassId;

        return $this;
    }

    /**
     * Get processClassId
     *
     * @return integer 
     */
    public function getProcessClassId()
    {
        return $this->processClassId;
    }

    /**
     * Set schedule
     *
     * @param string $schedule
     * @return InventoryJobs
     */
    public function setSchedule($schedule)
    {
        $this->schedule = $schedule;

        return $this;
    }

    /**
     * Get schedule
     *
     * @return string 
     */
    public function getSchedule()
    {
        return $this->schedule;
    }

    /**
     * Set scheduleName
     *
     * @param string $scheduleName
     * @return InventoryJobs
     */
    public function setScheduleName($scheduleName)
    {
        $this->scheduleName = $scheduleName;

        return $this;
    }

    /**
     * Get scheduleName
     *
     * @return string 
     */
    public function getScheduleName()
    {
        return $this->scheduleName;
    }

    /**
     * Set scheduleId
     *
     * @param integer $scheduleId
     * @return InventoryJobs
     */
    public function setScheduleId($scheduleId)
    {
        $this->scheduleId = $scheduleId;

        return $this;
    }

    /**
     * Get scheduleId
     *
     * @return integer 
     */
    public function getScheduleId()
    {
        return $this->scheduleId;
    }

    /**
     * Set maxTasks
     *
     * @param integer $maxTasks
     * @return InventoryJobs
     */
    public function setMaxTasks($maxTasks)
    {
        $this->maxTasks = $maxTasks;

        return $this;
    }

    /**
     * Get maxTasks
     *
     * @return integer 
     */
    public function getMaxTasks()
    {
        return $this->maxTasks;
    }

    /**
     * Set hasDescription
     *
     * @param integer $hasDescription
     * @return InventoryJobs
     */
    public function setHasDescription($hasDescription)
    {
        $this->hasDescription = $hasDescription;

        return $this;
    }

    /**
     * Get hasDescription
     *
     * @return integer 
     */
    public function getHasDescription()
    {
        return $this->hasDescription;
    }

    /**
     * Set runTimeIsTemporary
     *
     * @param integer $runTimeIsTemporary
     * @return InventoryJobs
     */
    public function setRunTimeIsTemporary($runTimeIsTemporary)
    {
        $this->runTimeIsTemporary = $runTimeIsTemporary;

        return $this;
    }

    /**
     * Get runTimeIsTemporary
     *
     * @return integer 
     */
    public function getRunTimeIsTemporary()
    {
        return $this->runTimeIsTemporary;
    }
}
