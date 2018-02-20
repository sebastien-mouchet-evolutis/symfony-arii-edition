<?php

namespace Arii\JOCBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * lock_use
 *
 * @ORM\Table(name="JOC_LOCKS_USE")
 * @ORM\Entity
 */
class LocksUse
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
     * @ORM\ManyToOne(targetEntity="Arii\JOCBundle\Entity\Jobs")
     * @ORM\JoinColumn(name="job_id", onDelete="CASCADE")
     * 
     **/
    private $job;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="spooler_id", type="integer")
     */
    private $spooler_id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * @var integer
     *
     * @ORM\Column(name="exclusive_use", type="boolean",nullable=true)
     */
    private $exclusive;

    /**
     * @var integer
     *
     * @ORM\Column(name="is_available", type="boolean",nullable=true)
     */
    private $is_available;

    /**
     * @var integer
     *
     * @ORM\Column(name="is_missing", type="boolean",nullable=true)
     */
    private $is_missing;

    /**
     * @var datetime
     *
     * @ORM\Column(name="updated", type="datetime",nullable=true)
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
     * Set spooler_id
     *
     * @param integer $spoolerId
     * @return LocksUse
     */
    public function setSpoolerId($spoolerId)
    {
        $this->spooler_id = $spoolerId;

        return $this;
    }

    /**
     * Get spooler_id
     *
     * @return integer 
     */
    public function getSpoolerId()
    {
        return $this->spooler_id;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return LocksUse
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
     * Set exclusive
     *
     * @param boolean $exclusive
     * @return LocksUse
     */
    public function setExclusive($exclusive)
    {
        $this->exclusive = $exclusive;

        return $this;
    }

    /**
     * Get exclusive
     *
     * @return boolean 
     */
    public function getExclusive()
    {
        return $this->exclusive;
    }

    /**
     * Set is_available
     *
     * @param boolean $isAvailable
     * @return LocksUse
     */
    public function setIsAvailable($isAvailable)
    {
        $this->is_available = $isAvailable;

        return $this;
    }

    /**
     * Get is_available
     *
     * @return boolean 
     */
    public function getIsAvailable()
    {
        return $this->is_available;
    }

    /**
     * Set is_missing
     *
     * @param boolean $isMissing
     * @return LocksUse
     */
    public function setIsMissing($isMissing)
    {
        $this->is_missing = $isMissing;

        return $this;
    }

    /**
     * Get is_missing
     *
     * @return boolean 
     */
    public function getIsMissing()
    {
        return $this->is_missing;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return LocksUse
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
     * Set job
     *
     * @param \Arii\JOCBundle\Entity\Jobs $job
     * @return LocksUse
     */
    public function setJob(\Arii\JOCBundle\Entity\Jobs $job = null)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Get job
     *
     * @return \Arii\JOCBundle\Entity\Jobs 
     */
    public function getJob()
    {
        return $this->job;
    }
}
