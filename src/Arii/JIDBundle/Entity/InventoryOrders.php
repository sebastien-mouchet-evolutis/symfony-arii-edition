<?php

namespace Arii\JIDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InventoryOrders
 *
 * @ORM\Table(name="inventory_orders", uniqueConstraints={@ORM\UniqueConstraint(name="INVENTORY_IO_UNIQUE", columns={"FILE_ID"})}, indexes={@ORM\Index(name="REPORTING_IO_INST_ID", columns={"INSTANCE_ID"}), @ORM\Index(name="REPORTING_IO_FILE_ID", columns={"FILE_ID"}), @ORM\Index(name="REPORTING_IO_JC_NAME", columns={"JOB_CHAIN_NAME"})})
 * @ORM\Entity(readOnly=true)
 */
class InventoryOrders
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
     * @var string
     *
     * @ORM\Column(name="ORDER_ID", type="string", length=255, nullable=false)
     */
    private $orderId;

    /**
     * @var string
     *
     * @ORM\Column(name="JOB_CHAIN_NAME", type="string", length=255, nullable=false)
     */
    private $jobChainName;

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
     * @ORM\Column(name="JOB_CHAIN_ID", type="integer", nullable=false)
     */
    private $jobChainId;

    /**
     * @var string
     *
     * @ORM\Column(name="INITIAL_STATE", type="string", length=100, nullable=true)
     */
    private $initialState;

    /**
     * @var string
     *
     * @ORM\Column(name="END_STATE", type="string", length=100, nullable=true)
     */
    private $endState;

    /**
     * @var integer
     *
     * @ORM\Column(name="PRIORITY", type="integer", nullable=true)
     */
    private $priority;

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
     * @return InventoryOrders
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
     * @return InventoryOrders
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
     * @return InventoryOrders
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
     * @return InventoryOrders
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
     * @return InventoryOrders
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
     * Set orderId
     *
     * @param string $orderId
     * @return InventoryOrders
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
     * Set jobChainName
     *
     * @param string $jobChainName
     * @return InventoryOrders
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
     * Set isRuntimeDefined
     *
     * @param integer $isRuntimeDefined
     * @return InventoryOrders
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
     * @return InventoryOrders
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
     * @return InventoryOrders
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
     * Set jobChainId
     *
     * @param integer $jobChainId
     * @return InventoryOrders
     */
    public function setJobChainId($jobChainId)
    {
        $this->jobChainId = $jobChainId;

        return $this;
    }

    /**
     * Get jobChainId
     *
     * @return integer 
     */
    public function getJobChainId()
    {
        return $this->jobChainId;
    }

    /**
     * Set initialState
     *
     * @param string $initialState
     * @return InventoryOrders
     */
    public function setInitialState($initialState)
    {
        $this->initialState = $initialState;

        return $this;
    }

    /**
     * Get initialState
     *
     * @return string 
     */
    public function getInitialState()
    {
        return $this->initialState;
    }

    /**
     * Set endState
     *
     * @param string $endState
     * @return InventoryOrders
     */
    public function setEndState($endState)
    {
        $this->endState = $endState;

        return $this;
    }

    /**
     * Get endState
     *
     * @return string 
     */
    public function getEndState()
    {
        return $this->endState;
    }

    /**
     * Set priority
     *
     * @param integer $priority
     * @return InventoryOrders
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get priority
     *
     * @return integer 
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set schedule
     *
     * @param string $schedule
     * @return InventoryOrders
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
     * @return InventoryOrders
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
     * @return InventoryOrders
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
     * Set runTimeIsTemporary
     *
     * @param integer $runTimeIsTemporary
     * @return InventoryOrders
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
