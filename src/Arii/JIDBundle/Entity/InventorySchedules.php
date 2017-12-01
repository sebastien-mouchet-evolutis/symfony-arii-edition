<?php

namespace Arii\JIDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InventorySchedules
 *
 * @ORM\Table(name="inventory_schedules", uniqueConstraints={@ORM\UniqueConstraint(name="INVENTORY_IS_UNIQUE", columns={"FILE_ID"})})
 * @ORM\Entity(readOnly=true)
 */
class InventorySchedules
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
     * @ORM\Column(name="SUBSTITUTE", type="string", length=255, nullable=true)
     */
    private $substitute;

    /**
     * @var string
     *
     * @ORM\Column(name="SUBSTITUTE_NAME", type="string", length=255, nullable=false)
     */
    private $substituteName;

    /**
     * @var integer
     *
     * @ORM\Column(name="SUBSTITUTE_ID", type="integer", nullable=false)
     */
    private $substituteId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="SUBSTITUTE_VALID_FROM", type="datetime", nullable=true)
     */
    private $substituteValidFrom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="SUBSTITUTE_VALID_TO", type="datetime", nullable=true)
     */
    private $substituteValidTo;

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
     * @return InventorySchedules
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
     * @return InventorySchedules
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
     * @return InventorySchedules
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
     * @return InventorySchedules
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
     * @return InventorySchedules
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
     * Set substitute
     *
     * @param string $substitute
     * @return InventorySchedules
     */
    public function setSubstitute($substitute)
    {
        $this->substitute = $substitute;

        return $this;
    }

    /**
     * Get substitute
     *
     * @return string 
     */
    public function getSubstitute()
    {
        return $this->substitute;
    }

    /**
     * Set substituteName
     *
     * @param string $substituteName
     * @return InventorySchedules
     */
    public function setSubstituteName($substituteName)
    {
        $this->substituteName = $substituteName;

        return $this;
    }

    /**
     * Get substituteName
     *
     * @return string 
     */
    public function getSubstituteName()
    {
        return $this->substituteName;
    }

    /**
     * Set substituteId
     *
     * @param integer $substituteId
     * @return InventorySchedules
     */
    public function setSubstituteId($substituteId)
    {
        $this->substituteId = $substituteId;

        return $this;
    }

    /**
     * Get substituteId
     *
     * @return integer 
     */
    public function getSubstituteId()
    {
        return $this->substituteId;
    }

    /**
     * Set substituteValidFrom
     *
     * @param \DateTime $substituteValidFrom
     * @return InventorySchedules
     */
    public function setSubstituteValidFrom($substituteValidFrom)
    {
        $this->substituteValidFrom = $substituteValidFrom;

        return $this;
    }

    /**
     * Get substituteValidFrom
     *
     * @return \DateTime 
     */
    public function getSubstituteValidFrom()
    {
        return $this->substituteValidFrom;
    }

    /**
     * Set substituteValidTo
     *
     * @param \DateTime $substituteValidTo
     * @return InventorySchedules
     */
    public function setSubstituteValidTo($substituteValidTo)
    {
        $this->substituteValidTo = $substituteValidTo;

        return $this;
    }

    /**
     * Get substituteValidTo
     *
     * @return \DateTime 
     */
    public function getSubstituteValidTo()
    {
        return $this->substituteValidTo;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return InventorySchedules
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
     * @return InventorySchedules
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
