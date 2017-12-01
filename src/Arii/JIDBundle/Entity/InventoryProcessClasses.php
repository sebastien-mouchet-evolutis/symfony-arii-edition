<?php

namespace Arii\JIDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InventoryProcessClasses
 *
 * @ORM\Table(name="inventory_process_classes", uniqueConstraints={@ORM\UniqueConstraint(name="INVENTORY_IPC_UNIQUE", columns={"INSTANCE_ID", "FILE_ID"})})
 * @ORM\Entity(readOnly=true)
 */
class InventoryProcessClasses
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
     * @var integer
     *
     * @ORM\Column(name="MAX_PROCESSES", type="integer", nullable=true)
     */
    private $maxProcesses;

    /**
     * @var integer
     *
     * @ORM\Column(name="HAS_AGENTS", type="integer", nullable=false)
     */
    private $hasAgents;

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
     * Set instanceId
     *
     * @param integer $instanceId
     * @return InventoryProcessClasses
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
     * @return InventoryProcessClasses
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
     * @return InventoryProcessClasses
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
     * @return InventoryProcessClasses
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
     * Set maxProcesses
     *
     * @param integer $maxProcesses
     * @return InventoryProcessClasses
     */
    public function setMaxProcesses($maxProcesses)
    {
        $this->maxProcesses = $maxProcesses;

        return $this;
    }

    /**
     * Get maxProcesses
     *
     * @return integer 
     */
    public function getMaxProcesses()
    {
        return $this->maxProcesses;
    }

    /**
     * Set hasAgents
     *
     * @param integer $hasAgents
     * @return InventoryProcessClasses
     */
    public function setHasAgents($hasAgents)
    {
        $this->hasAgents = $hasAgents;

        return $this;
    }

    /**
     * Get hasAgents
     *
     * @return integer 
     */
    public function getHasAgents()
    {
        return $this->hasAgents;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return InventoryProcessClasses
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
     * @return InventoryProcessClasses
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
