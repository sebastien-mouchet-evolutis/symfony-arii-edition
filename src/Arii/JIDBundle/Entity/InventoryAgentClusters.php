<?php

namespace Arii\JIDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InventoryAgentClusters
 *
 * @ORM\Table(name="inventory_agent_clusters", uniqueConstraints={@ORM\UniqueConstraint(name="INVENTORY_IAC_UNIQUE", columns={"PROCESS_CLASS_ID"})})
 * @ORM\Entity(readOnly=true)
 */
class InventoryAgentClusters
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
     * @ORM\Column(name="PROCESS_CLASS_ID", type="integer", nullable=false)
     */
    private $processClassId;

    /**
     * @var string
     *
     * @ORM\Column(name="SCHEDULING_TYPE", type="string", length=15, nullable=false)
     */
    private $schedulingType;

    /**
     * @var integer
     *
     * @ORM\Column(name="NUMBER_OF_AGENTS", type="integer", nullable=false)
     */
    private $numberOfAgents;

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
     * @return InventoryAgentClusters
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
     * Set processClassId
     *
     * @param integer $processClassId
     * @return InventoryAgentClusters
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
     * Set schedulingType
     *
     * @param string $schedulingType
     * @return InventoryAgentClusters
     */
    public function setSchedulingType($schedulingType)
    {
        $this->schedulingType = $schedulingType;

        return $this;
    }

    /**
     * Get schedulingType
     *
     * @return string 
     */
    public function getSchedulingType()
    {
        return $this->schedulingType;
    }

    /**
     * Set numberOfAgents
     *
     * @param integer $numberOfAgents
     * @return InventoryAgentClusters
     */
    public function setNumberOfAgents($numberOfAgents)
    {
        $this->numberOfAgents = $numberOfAgents;

        return $this;
    }

    /**
     * Get numberOfAgents
     *
     * @return integer 
     */
    public function getNumberOfAgents()
    {
        return $this->numberOfAgents;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return InventoryAgentClusters
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
     * @return InventoryAgentClusters
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
