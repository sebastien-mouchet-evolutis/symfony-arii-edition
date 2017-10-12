<?php

namespace Arii\JOCBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Schedules
 *
 * @ORM\Table(name="JOC_SCHEDULES")
 * @ORM\Entity
 */
class Schedules
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Arii\JOCBundle\Entity\Spoolers")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     **/
    private $spooler;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=32)
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(name="substitute", type="string", length=255, nullable=true)
     */
    private $substitute;

    /**
     * @var string
     *
     * @ORM\Column(name="valid_from", type="datetime", nullable=true)
     */
    private $valid_from;

    /**
     * @var string
     *
     * @ORM\Column(name="valid_to", type="datetime", nullable=true)
     */
    private $valid_to;
    
    /**
     * @var datetime
     *
     * @ORM\Column(name="updated", type="datetime")
     */
    private $updated;

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
     * Set name
     *
     * @param string $name
     * @return Schedules
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
     * Set path
     *
     * @param string $path
     * @return Schedules
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Schedules
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
     * Set active
     *
     * @param boolean $active
     * @return Schedules
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return Schedules
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set substitute
     *
     * @param string $substitute
     * @return Schedules
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
     * Set valid_from
     *
     * @param \DateTime $validFrom
     * @return Schedules
     */
    public function setValidFrom($validFrom)
    {
        $this->valid_from = $validFrom;

        return $this;
    }

    /**
     * Get valid_from
     *
     * @return \DateTime 
     */
    public function getValidFrom()
    {
        return $this->valid_from;
    }

    /**
     * Set valid_to
     *
     * @param \DateTime $validTo
     * @return Schedules
     */
    public function setValidTo($validTo)
    {
        $this->valid_to = $validTo;

        return $this;
    }

    /**
     * Get valid_to
     *
     * @return \DateTime 
     */
    public function getValidTo()
    {
        return $this->valid_to;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Schedules
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set spooler
     *
     * @param \Arii\JOCBundle\Entity\Spoolers $spooler
     * @return Schedules
     */
    public function setSpooler(\Arii\JOCBundle\Entity\Spoolers $spooler = null)
    {
        $this->spooler = $spooler;

        return $this;
    }

    /**
     * Get spooler
     *
     * @return \Arii\JOCBundle\Entity\Spoolers 
     */
    public function getSpooler()
    {
        return $this->spooler;
    }
}
