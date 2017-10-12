<?php

namespace Arii\MFTBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Connections
 *
 * @ORM\Table(name="MFT_HISTORY")
 * @ORM\Entity()
 */
class History
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
    * @ORM\ManyToOne(targetEntity="Arii\MFTBundle\Entity\Transfers")
    * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
    */
    private $transfer;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=16, nullable=true )
     */        
    private $status;

    /**
     * @var datetime
     *
     * @ORM\Column(name="status_time", type="datetime", nullable=true )
     */        
    private $status_time;

    /**
     * @var integer
     *
     * @ORM\Column(name="run", type="integer", nullable=true )
     */        
    private $run;

    /**
     * @var integer
     *
     * @ORM\Column(name="transferring", type="boolean", nullable=true )
     */        
    private $transferring;
        
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
     * Set status_time
     *
     * @param \DateTime $statusTime
     * @return History
     */
    public function setStatusTime($statusTime)
    {
        $this->status_time = $statusTime;

        return $this;
    }

    /**
     * Get status_time
     *
     * @return \DateTime 
     */
    public function getStatusTime()
    {
        return $this->status_time;
    }

    /**
     * Set transfer
     *
     * @param \Arii\MFTBundle\Entity\Transfers $transfer
     * @return History
     */
    public function setTransfer(\Arii\MFTBundle\Entity\Transfers $transfer = null)
    {
        $this->transfer = $transfer;

        return $this;
    }

    /**
     * Get transfer
     *
     * @return \Arii\MFTBundle\Entity\Transfers 
     */
    public function getTransfer()
    {
        return $this->transfer;
    }

    /**
     * Set run
     *
     * @param integer $run
     * @return History
     */
    public function setRun($run)
    {
        $this->run = $run;

        return $this;
    }

    /**
     * Get run
     *
     * @return integer 
     */
    public function getRun()
    {
        return $this->run;
    }

    /**
     * Set transferring
     *
     * @param boolean $transferring
     * @return History
     */
    public function setTransferring($transferring)
    {
        $this->transferring = $transferring;

        return $this;
    }

    /**
     * Get transferring
     *
     * @return boolean 
     */
    public function getTransferring()
    {
        return $this->transferring;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return History
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
}
