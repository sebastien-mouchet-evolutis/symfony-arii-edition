<?php

namespace Arii\JOCBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * statelocks
 *
 * @ORM\Table(name="JOC_LOCKS")
 * @ORM\Entity
 */
class Locks
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
     * @var integer
     *
     * @ORM\Column(name="max_non_exclusive", type="integer", nullable=true)
     */
    private $max_non_exclusive;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_free", type="boolean")
     */
    private $is_free;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=100)
     */
    private $state;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_write_time", type="datetime", nullable=true)
     */
    private $last_write_time;
    
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
     * @return Locks
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
     * @return Locks
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
     * Set max_non_exclusive
     *
     * @param integer $maxNonExclusive
     * @return Locks
     */
    public function setMaxNonExclusive($maxNonExclusive)
    {
        $this->max_non_exclusive = $maxNonExclusive;

        return $this;
    }

    /**
     * Get max_non_exclusive
     *
     * @return integer 
     */
    public function getMaxNonExclusive()
    {
        return $this->max_non_exclusive;
    }

    /**
     * Set is_free
     *
     * @param boolean $isFree
     * @return Locks
     */
    public function setIsFree($isFree)
    {
        $this->is_free = $isFree;

        return $this;
    }

    /**
     * Get is_free
     *
     * @return boolean 
     */
    public function getIsFree()
    {
        return $this->is_free;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return Locks
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
     * Set last_write_time
     *
     * @param \DateTime $lastWriteTime
     * @return Locks
     */
    public function setLastWriteTime($lastWriteTime)
    {
        $this->last_write_time = $lastWriteTime;

        return $this;
    }

    /**
     * Get last_write_time
     *
     * @return \DateTime 
     */
    public function getLastWriteTime()
    {
        return $this->last_write_time;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Locks
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
     * @return Locks
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
