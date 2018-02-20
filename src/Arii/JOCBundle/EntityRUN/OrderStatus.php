<?php

namespace Arii\JOCBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JobStatus
 *
 * @ORM\Table(name="JOC_ORDER_STATUS")
 * @ORM\Entity(repositoryClass="Arii\JOCBundle\Entity\JobStatusRepository")
 */
class OrderStatus
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
     * @ORM\OneToOne(targetEntity="Arii\JOCBundle\Entity\Orders")
     * @ORM\JoinColumn(nullable=true)
     **/
    private $order;

    /**
     * @var integer
     *
     * @ORM\Column(name="history_id", type="integer")
     */
    private $historyId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_time", type="datetimetz")
     */
    private $startTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_time", type="datetimetz",nullable=true)
     */
    private $endTime;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=64, nullable=true)
     */
    private $state;
    
    /**
     * @var string
     *
     * @ORM\Column(name="state_text", type="string", length=255, nullable=true)
     */
    private $state_text;

    /**
     * @var integer
     *
     * @ORM\Column(name="updated", type="integer")
     */
    private $updated;

    /**
     * @var string
     *
     * @ORM\Column(name="crc", type="string", length=9, nullable=true)
     */
    private $crc;

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
     * Set historyId
     *
     * @param integer $historyId
     * @return JobStatus
     */
    public function setHistoryId($historyId)
    {
        $this->historyId = $historyId;

        return $this;
    }

    /**
     * Get historyId
     *
     * @return integer 
     */
    public function getHistoryId()
    {
        return $this->historyId;
    }

    /**
     * Set jobName
     *
     * @param string $jobName
     * @return JobStatus
     */
    public function setJobName($jobName)
    {
        $this->jobName = $jobName;

        return $this;
    }

    /**
     * Get jobName
     *
     * @return string 
     */
    public function getJobName()
    {
        return $this->jobName;
    }

    /**
     * Set spooler
     *
     * @param string $spooler
     * @return JobStatus
     */
    public function setSpooler($spooler)
    {
        $this->spooler = $spooler;

        return $this;
    }

    /**
     * Get spooler
     *
     * @return string 
     */
    public function getSpooler()
    {
        return $this->spooler;
    }

    /**
     * Set startTime
     *
     * @param \DateTime $startTime
     * @return JobStatus
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * Get startTime
     *
     * @return \DateTime 
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set endTime
     *
     * @param \DateTime $endTime
     * @return JobStatus
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * Get endTime
     *
     * @return \DateTime 
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Set pid
     *
     * @param integer $pid
     * @return JobStatus
     */
    public function setPid($pid)
    {
        $this->pid = $pid;

        return $this;
    }

    /**
     * Get pid
     *
     * @return integer 
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return OrderStatus
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
     * Set state_text
     *
     * @param string $stateText
     * @return OrderStatus
     */
    public function setStateText($stateText)
    {
        $this->state_text = $stateText;

        return $this;
    }

    /**
     * Get state_text
     *
     * @return string 
     */
    public function getStateText()
    {
        return $this->state_text;
    }

    /**
     * Set updated
     *
     * @param integer $updated
     * @return OrderStatus
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return integer 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set crc
     *
     * @param string $crc
     * @return OrderStatus
     */
    public function setCrc($crc)
    {
        $this->crc = $crc;

        return $this;
    }

    /**
     * Get crc
     *
     * @return string 
     */
    public function getCrc()
    {
        return $this->crc;
    }

    /**
     * Set order
     *
     * @param \Arii\JOCBundle\Entity\Orders $order
     * @return OrderStatus
     */
    public function setOrder(\Arii\JOCBundle\Entity\Orders $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \Arii\JOCBundle\Entity\Orders 
     */
    public function getOrder()
    {
        return $this->order;
    }
}
