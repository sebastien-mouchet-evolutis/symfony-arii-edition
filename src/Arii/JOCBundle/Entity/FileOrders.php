<?php

namespace Arii\JOCBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FileOrders
 *
 * @ORM\Table(name="JOC_FILE_ORDERS")
 * @ORM\Entity
 */
class FileOrders
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
     * @ORM\ManyToOne(targetEntity="Arii\JOCBundle\Entity\JobChains")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     **/
    private $job_chain;

    /**
     * @var integer
     *
     * @ORM\Column(name="spooler_id", type="integer")
     */
    private $spooler_id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="directory", type="string", length=512)
     */
    private $directory;

    /**
     * @var string
     *
     * @ORM\Column(name="regex", type="string", length=255)
     */
    private $regex;

    /**
     * @var boolean
     *
     * @ORM\Column(name="alert_when_directory_missing", type="boolean")
     */
    private $alert_when_directory_missing;

    /**
     * @var integer
     *
     * @ORM\Column(name="delay_after_error", type="integer")
     */
    private $delay_after_error;

    /**
     * @var string
     *
     * @ORM\Column(name="next_state", type="string", length=100)
     */
    private $next_state;

    /**
     * @var integer
     *
     * @ORM\Column(name="retry", type="integer")
     */
    private $retry;

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
     * Set spooler_id
     *
     * @param integer $spoolerId
     * @return FileOrders
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
     * Set directory
     *
     * @param string $directory
     * @return FileOrders
     */
    public function setDirectory($directory)
    {
        $this->directory = $directory;

        return $this;
    }

    /**
     * Get directory
     *
     * @return string 
     */
    public function getDirectory()
    {
        return $this->directory;
    }

    /**
     * Set regex
     *
     * @param string $regex
     * @return FileOrders
     */
    public function setRegex($regex)
    {
        $this->regex = $regex;

        return $this;
    }

    /**
     * Get regex
     *
     * @return string 
     */
    public function getRegex()
    {
        return $this->regex;
    }

    /**
     * Set alert_when_directory_missing
     *
     * @param boolean $alertWhenDirectoryMissing
     * @return FileOrders
     */
    public function setAlertWhenDirectoryMissing($alertWhenDirectoryMissing)
    {
        $this->alert_when_directory_missing = $alertWhenDirectoryMissing;

        return $this;
    }

    /**
     * Get alert_when_directory_missing
     *
     * @return boolean 
     */
    public function getAlertWhenDirectoryMissing()
    {
        return $this->alert_when_directory_missing;
    }

    /**
     * Set delay_after_error
     *
     * @param integer $delayAfterError
     * @return FileOrders
     */
    public function setDelayAfterError($delayAfterError)
    {
        $this->delay_after_error = $delayAfterError;

        return $this;
    }

    /**
     * Get delay_after_error
     *
     * @return integer 
     */
    public function getDelayAfterError()
    {
        return $this->delay_after_error;
    }

    /**
     * Set next_state
     *
     * @param string $nextState
     * @return FileOrders
     */
    public function setNextState($nextState)
    {
        $this->next_state = $nextState;

        return $this;
    }

    /**
     * Get next_state
     *
     * @return string 
     */
    public function getNextState()
    {
        return $this->next_state;
    }

    /**
     * Set retry
     *
     * @param integer $retry
     * @return FileOrders
     */
    public function setRetry($retry)
    {
        $this->retry = $retry;

        return $this;
    }

    /**
     * Get retry
     *
     * @return integer 
     */
    public function getRetry()
    {
        return $this->retry;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return FileOrders
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
     * Set job_chain
     *
     * @param \Arii\JOCBundle\Entity\JobChains $jobChain
     * @return FileOrders
     */
    public function setJobChain(\Arii\JOCBundle\Entity\JobChains $jobChain = null)
    {
        $this->job_chain = $jobChain;

        return $this;
    }

    /**
     * Get job_chain
     *
     * @return \Arii\JOCBundle\Entity\JobChains 
     */
    public function getJobChain()
    {
        return $this->job_chain;
    }
}
