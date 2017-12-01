<?php

namespace Arii\JIDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InventoryOperatingSystems
 *
 * @ORM\Table(name="inventory_operating_systems", uniqueConstraints={@ORM\UniqueConstraint(name="INVENTORY_IOS_UNIQUE", columns={"HOSTNAME"})})
 * @ORM\Entity(readOnly=true)
 */
class InventoryOperatingSystems
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
     * @ORM\Column(name="HOSTNAME", type="string", length=100, nullable=false)
     */
    private $hostname;

    /**
     * @var string
     *
     * @ORM\Column(name="NAME", type="string", length=50, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="ARCHITECTURE", type="string", length=255, nullable=true)
     */
    private $architecture;

    /**
     * @var string
     *
     * @ORM\Column(name="DISTRIBUTION", type="string", length=255, nullable=true)
     */
    private $distribution;

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
     * Set hostname
     *
     * @param string $hostname
     * @return InventoryOperatingSystems
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
     * Set name
     *
     * @param string $name
     * @return InventoryOperatingSystems
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
     * Set architecture
     *
     * @param string $architecture
     * @return InventoryOperatingSystems
     */
    public function setArchitecture($architecture)
    {
        $this->architecture = $architecture;

        return $this;
    }

    /**
     * Get architecture
     *
     * @return string 
     */
    public function getArchitecture()
    {
        return $this->architecture;
    }

    /**
     * Set distribution
     *
     * @param string $distribution
     * @return InventoryOperatingSystems
     */
    public function setDistribution($distribution)
    {
        $this->distribution = $distribution;

        return $this;
    }

    /**
     * Get distribution
     *
     * @return string 
     */
    public function getDistribution()
    {
        return $this->distribution;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return InventoryOperatingSystems
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
     * @return InventoryOperatingSystems
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
