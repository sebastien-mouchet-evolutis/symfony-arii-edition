<?php

namespace Arii\JIDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InventoryAgentInstances
 *
 * @ORM\Table(name="inventory_agent_instances", uniqueConstraints={@ORM\UniqueConstraint(name="INVENTORY_IAI_UNIQUE", columns={"INSTANCE_ID", "URL"})})
 * @ORM\Entity(readOnly=true)
 */
class InventoryAgentInstances
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
     * @ORM\Column(name="OS_ID", type="integer", nullable=false)
     */
    private $osId;

    /**
     * @var string
     *
     * @ORM\Column(name="HOSTNAME", type="string", length=100, nullable=true)
     */
    private $hostname;

    /**
     * @var string
     *
     * @ORM\Column(name="VERSION", type="string", length=30, nullable=true)
     */
    private $version;

    /**
     * @var string
     *
     * @ORM\Column(name="URL", type="string", length=100, nullable=false)
     */
    private $url;

    /**
     * @var integer
     *
     * @ORM\Column(name="STATE", type="integer", nullable=false)
     */
    private $state;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="STARTED_AT", type="datetime", nullable=true)
     */
    private $startedAt;

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
     * @return InventoryAgentInstances
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
     * Set osId
     *
     * @param integer $osId
     * @return InventoryAgentInstances
     */
    public function setOsId($osId)
    {
        $this->osId = $osId;

        return $this;
    }

    /**
     * Get osId
     *
     * @return integer 
     */
    public function getOsId()
    {
        return $this->osId;
    }

    /**
     * Set hostname
     *
     * @param string $hostname
     * @return InventoryAgentInstances
     */
    public function setHostname($hostname)
    {
        $this->hostname = $hostname;

        return $this;
    }

    /**
     * Get hostname
     *
     * @return string 
     */
    public function getHostname()
    {
        return $this->hostname;
    }

    /**
     * Set version
     *
     * @param string $version
     * @return InventoryAgentInstances
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return string 
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return InventoryAgentInstances
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
     * Set state
     *
     * @param integer $state
     * @return InventoryAgentInstances
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return integer 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set startedAt
     *
     * @param \DateTime $startedAt
     * @return InventoryAgentInstances
     */
    public function setStartedAt($startedAt)
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    /**
     * Get startedAt
     *
     * @return \DateTime 
     */
    public function getStartedAt()
    {
        return $this->startedAt;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return InventoryAgentInstances
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
     * @return InventoryAgentInstances
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
