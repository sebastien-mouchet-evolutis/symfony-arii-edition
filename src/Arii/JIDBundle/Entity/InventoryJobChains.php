<?php

namespace Arii\JIDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InventoryJobChains
 *
 * @ORM\Table(name="inventory_job_chains", uniqueConstraints={@ORM\UniqueConstraint(name="INVENTORY_IJC_UNIQUE", columns={"FILE_ID"})}, indexes={@ORM\Index(name="REPORTING_IJC_INST_ID", columns={"INSTANCE_ID"}), @ORM\Index(name="REPORTING_IJC_FILE_ID", columns={"FILE_ID"}), @ORM\Index(name="REPORTING_IJC_NAME", columns={"NAME"})})
 * @ORM\Entity(readOnly=true)
 */
class InventoryJobChains
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
     * @ORM\Column(name="START_CAUSE", type="string", length=50, nullable=false)
     */
    private $startCause;

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
     * @ORM\Column(name="MAX_ORDERS", type="integer", nullable=true)
     */
    private $maxOrders;

    /**
     * @var integer
     *
     * @ORM\Column(name="DISTRIBUTED", type="integer", nullable=false)
     */
    private $distributed;

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
     * @ORM\Column(name="FW_PROCESS_CLASS", type="string", length=255, nullable=true)
     */
    private $fwProcessClass;

    /**
     * @var string
     *
     * @ORM\Column(name="FW_PROCESS_CLASS_NAME", type="string", length=255, nullable=false)
     */
    private $fwProcessClassName;

    /**
     * @var integer
     *
     * @ORM\Column(name="FW_PROCESS_CLASS_ID", type="integer", nullable=false)
     */
    private $fwProcessClassId;



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
     * @return InventoryJobChains
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
     * @return InventoryJobChains
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
     * Set startCause
     *
     * @param string $startCause
     * @return InventoryJobChains
     */
    public function setStartCause($startCause)
    {
        $this->startCause = $startCause;

        return $this;
    }

    /**
     * Get startCause
     *
     * @return string 
     */
    public function getStartCause()
    {
        return $this->startCause;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return InventoryJobChains
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
     * @return InventoryJobChains
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
     * @return InventoryJobChains
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
     * Set created
     *
     * @param \DateTime $created
     * @return InventoryJobChains
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
     * @return InventoryJobChains
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
     * Set maxOrders
     *
     * @param integer $maxOrders
     * @return InventoryJobChains
     */
    public function setMaxOrders($maxOrders)
    {
        $this->maxOrders = $maxOrders;

        return $this;
    }

    /**
     * Get maxOrders
     *
     * @return integer 
     */
    public function getMaxOrders()
    {
        return $this->maxOrders;
    }

    /**
     * Set distributed
     *
     * @param integer $distributed
     * @return InventoryJobChains
     */
    public function setDistributed($distributed)
    {
        $this->distributed = $distributed;

        return $this;
    }

    /**
     * Get distributed
     *
     * @return integer 
     */
    public function getDistributed()
    {
        return $this->distributed;
    }

    /**
     * Set processClass
     *
     * @param string $processClass
     * @return InventoryJobChains
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
     * @return InventoryJobChains
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
     * @return InventoryJobChains
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
     * Set fwProcessClass
     *
     * @param string $fwProcessClass
     * @return InventoryJobChains
     */
    public function setFwProcessClass($fwProcessClass)
    {
        $this->fwProcessClass = $fwProcessClass;

        return $this;
    }

    /**
     * Get fwProcessClass
     *
     * @return string 
     */
    public function getFwProcessClass()
    {
        return $this->fwProcessClass;
    }

    /**
     * Set fwProcessClassName
     *
     * @param string $fwProcessClassName
     * @return InventoryJobChains
     */
    public function setFwProcessClassName($fwProcessClassName)
    {
        $this->fwProcessClassName = $fwProcessClassName;

        return $this;
    }

    /**
     * Get fwProcessClassName
     *
     * @return string 
     */
    public function getFwProcessClassName()
    {
        return $this->fwProcessClassName;
    }

    /**
     * Set fwProcessClassId
     *
     * @param integer $fwProcessClassId
     * @return InventoryJobChains
     */
    public function setFwProcessClassId($fwProcessClassId)
    {
        $this->fwProcessClassId = $fwProcessClassId;

        return $this;
    }

    /**
     * Get fwProcessClassId
     *
     * @return integer 
     */
    public function getFwProcessClassId()
    {
        return $this->fwProcessClassId;
    }
}
