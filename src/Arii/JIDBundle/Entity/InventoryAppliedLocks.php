<?php

namespace Arii\JIDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InventoryAppliedLocks
 *
 * @ORM\Table(name="inventory_applied_locks", uniqueConstraints={@ORM\UniqueConstraint(name="INVENTORY_IAL_UNIQUE", columns={"JOB_ID", "LOCK_ID"})})
 * @ORM\Entity(readOnly=true)
 */
class InventoryAppliedLocks
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
     * @ORM\Column(name="JOB_ID", type="integer", nullable=false)
     */
    private $jobId;

    /**
     * @var integer
     *
     * @ORM\Column(name="LOCK_ID", type="integer", nullable=false)
     */
    private $lockId;

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
     * Set jobId
     *
     * @param integer $jobId
     * @return InventoryAppliedLocks
     */
    public function setJobId($jobId)
    {
        $this->jobId = $jobId;

        return $this;
    }

    /**
     * Get jobId
     *
     * @return integer 
     */
    public function getJobId()
    {
        return $this->jobId;
    }

    /**
     * Set lockId
     *
     * @param integer $lockId
     * @return InventoryAppliedLocks
     */
    public function setLockId($lockId)
    {
        $this->lockId = $lockId;

        return $this;
    }

    /**
     * Get lockId
     *
     * @return integer 
     */
    public function getLockId()
    {
        return $this->lockId;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return InventoryAppliedLocks
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
     * @return InventoryAppliedLocks
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
