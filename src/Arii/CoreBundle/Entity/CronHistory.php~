<?php

namespace Arii\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cron
 *
 * @ORM\Table(name="ARII_CRON_HISTORY")
 * @ORM\Entity
 * 
 */
class CronHistory
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
    * @ORM\ManyToOne(targetEntity="Arii\CoreBundle\Entity\Cron")
    * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
    */
    private $cron;

    /**
     * @var datetime
     *
     * @ORM\Column(name="done", type="datetime", nullable=true )
     */        
    private $done;

    /**
     * @var integer
     *
     * @ORM\Column(name="duration", type="integer" )
     */        
    private $duration;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=16 )
     */        
    private $status;    

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=255, nullable=true )
     */        
    private $message;    

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
     * Set done
     *
     * @param \DateTime $done
     * @return CronHistory
     */
    public function setDone($done)
    {
        $this->done = $done;

        return $this;
    }

    /**
     * Get done
     *
     * @return \DateTime 
     */
    public function getDone()
    {
        return $this->done;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return CronHistory
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set cron
     *
     * @param \Arii\CoreBundle\Entity\Cron $cron
     * @return CronHistory
     */
    public function setCron(\Arii\CoreBundle\Entity\Cron $cron = null)
    {
        $this->cron = $cron;

        return $this;
    }

    /**
     * Get cron
     *
     * @return \Arii\CoreBundle\Entity\Cron 
     */
    public function getCron()
    {
        return $this->cron;
    }

    /**
     * Set duration
     *
     * @param integer $duration
     * @return CronHistory
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return integer 
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return CronHistory
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }
}
