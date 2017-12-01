<?php

namespace Arii\JIDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JocConfigurations
 *
 * @ORM\Table(name="joc_configurations", uniqueConstraints={@ORM\UniqueConstraint(name="JOC_CONFIGURATIONS_ID_UNIQUE", columns={"SCHEDULER_ID", "ACCOUNT", "OBJECT_TYPE", "CONFIGURATION_TYPE", "NAME"})})
 * @ORM\Entity(readOnly=true)
 */
class JocConfigurations
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
     * @ORM\Column(name="INSTANCE_ID", type="integer", nullable=true)
     */
    private $instanceId;

    /**
     * @var string
     *
     * @ORM\Column(name="ACCOUNT", type="string", length=255, nullable=false)
     */
    private $account;

    /**
     * @var string
     *
     * @ORM\Column(name="OBJECT_TYPE", type="string", length=30, nullable=true)
     */
    private $objectType;

    /**
     * @var string
     *
     * @ORM\Column(name="CONFIGURATION_TYPE", type="string", length=30, nullable=false)
     */
    private $configurationType;

    /**
     * @var string
     *
     * @ORM\Column(name="NAME", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="SHARED", type="integer", nullable=false)
     */
    private $shared;

    /**
     * @var string
     *
     * @ORM\Column(name="CONFIGURATION_ITEM", type="text", nullable=false)
     */
    private $configurationItem;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="MODIFIED", type="datetime", nullable=false)
     */
    private $modified;

    /**
     * @var string
     *
     * @ORM\Column(name="SCHEDULER_ID", type="string", length=100, nullable=true)
     */
    private $schedulerId;



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
     * @return JocConfigurations
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
     * Set account
     *
     * @param string $account
     * @return JocConfigurations
     */
    public function setAccount($account)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return string 
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set objectType
     *
     * @param string $objectType
     * @return JocConfigurations
     */
    public function setObjectType($objectType)
    {
        $this->objectType = $objectType;

        return $this;
    }

    /**
     * Get objectType
     *
     * @return string 
     */
    public function getObjectType()
    {
        return $this->objectType;
    }

    /**
     * Set configurationType
     *
     * @param string $configurationType
     * @return JocConfigurations
     */
    public function setConfigurationType($configurationType)
    {
        $this->configurationType = $configurationType;

        return $this;
    }

    /**
     * Get configurationType
     *
     * @return string 
     */
    public function getConfigurationType()
    {
        return $this->configurationType;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return JocConfigurations
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
     * Set shared
     *
     * @param integer $shared
     * @return JocConfigurations
     */
    public function setShared($shared)
    {
        $this->shared = $shared;

        return $this;
    }

    /**
     * Get shared
     *
     * @return integer 
     */
    public function getShared()
    {
        return $this->shared;
    }

    /**
     * Set configurationItem
     *
     * @param string $configurationItem
     * @return JocConfigurations
     */
    public function setConfigurationItem($configurationItem)
    {
        $this->configurationItem = $configurationItem;

        return $this;
    }

    /**
     * Get configurationItem
     *
     * @return string 
     */
    public function getConfigurationItem()
    {
        return $this->configurationItem;
    }

    /**
     * Set modified
     *
     * @param \DateTime $modified
     * @return JocConfigurations
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
     * Set schedulerId
     *
     * @param string $schedulerId
     * @return JocConfigurations
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
}
