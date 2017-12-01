<?php

namespace Arii\JIDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InventoryAgentClustermembers
 *
 * @ORM\Table(name="inventory_agent_clustermembers", uniqueConstraints={@ORM\UniqueConstraint(name="INVENTORY_IACM_UNIQUE", columns={"INSTANCE_ID", "AGENT_CLUSTER_ID", "AGENT_INSTANCE_ID"})})
 * @ORM\Entity(readOnly=true)
 */
class InventoryAgentClustermembers
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
     * @ORM\Column(name="AGENT_CLUSTER_ID", type="integer", nullable=false)
     */
    private $agentClusterId;

    /**
     * @var integer
     *
     * @ORM\Column(name="AGENT_INSTANCE_ID", type="integer", nullable=false)
     */
    private $agentInstanceId;

    /**
     * @var string
     *
     * @ORM\Column(name="URL", type="string", length=255, nullable=false)
     */
    private $url;

    /**
     * @var integer
     *
     * @ORM\Column(name="ORDERING", type="integer", nullable=false)
     */
    private $ordering;

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
     * @return InventoryAgentClustermembers
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
     * Set agentClusterId
     *
     * @param integer $agentClusterId
     * @return InventoryAgentClustermembers
     */
    public function setAgentClusterId($agentClusterId)
    {
        $this->agentClusterId = $agentClusterId;

        return $this;
    }

    /**
     * Get agentClusterId
     *
     * @return integer 
     */
    public function getAgentClusterId()
    {
        return $this->agentClusterId;
    }

    /**
     * Set agentInstanceId
     *
     * @param integer $agentInstanceId
     * @return InventoryAgentClustermembers
     */
    public function setAgentInstanceId($agentInstanceId)
    {
        $this->agentInstanceId = $agentInstanceId;

        return $this;
    }

    /**
     * Get agentInstanceId
     *
     * @return integer 
     */
    public function getAgentInstanceId()
    {
        return $this->agentInstanceId;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return InventoryAgentClustermembers
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set ordering
     *
     * @param integer $ordering
     * @return InventoryAgentClustermembers
     */
    public function setOrdering($ordering)
    {
        $this->ordering = $ordering;

        return $this;
    }

    /**
     * Get ordering
     *
     * @return integer 
     */
    public function getOrdering()
    {
        return $this->ordering;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return InventoryAgentClustermembers
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
     * @return InventoryAgentClustermembers
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
