<?php

namespace Arii\JIDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DaysSchedule
 *
 * @ORM\Table(name="days_schedule", indexes={@ORM\Index(name="DAYS_SCHEDULE_SCHEDULER_ID", columns={"SCHEDULER_ID"}), @ORM\Index(name="DAYS_SCHEDULE_JOB_CHAIN", columns={"JOB_CHAIN", "ORDER_ID"}), @ORM\Index(name="DAYS_SCHEDULE_PLANNED", columns={"SCHEDULE_PLANNED"}), @ORM\Index(name="DAYS_SCHEDULE_EXECUTED", columns={"SCHEDULE_EXECUTED"})})
 * @ORM\Entity(readOnly=true)
 */
class DaysSchedule
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
     * @ORM\Column(name="SCHEDULER_ID", type="string", length=255, nullable=true)
     */
    private $schedulerId;

    /**
     * @var integer
     *
     * @ORM\Column(name="SCHEDULER_HISTORY_ID", type="integer", nullable=true)
     */
    private $schedulerHistoryId;

    /**
     * @var integer
     *
     * @ORM\Column(name="SCHEDULER_ORDER_HISTORY_ID", type="integer", nullable=true)
     */
    private $schedulerOrderHistoryId;

    /**
     * @var string
     *
     * @ORM\Column(name="JOB", type="string", length=255, nullable=true)
     */
    private $job;

    /**
     * @var string
     *
     * @ORM\Column(name="JOB_CHAIN", type="string", length=255, nullable=true)
     */
    private $jobChain;

    /**
     * @var string
     *
     * @ORM\Column(name="ORDER_ID", type="string", length=255, nullable=true)
     */
    private $orderId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="SCHEDULE_PLANNED", type="datetime", nullable=true)
     */
    private $schedulePlanned;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="SCHEDULE_EXECUTED", type="datetime", nullable=true)
     */
    private $scheduleExecuted;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="PERIOD_BEGIN", type="datetime", nullable=true)
     */
    private $periodBegin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="PERIOD_END", type="datetime", nullable=true)
     */
    private $periodEnd;

    /**
     * @var integer
     *
     * @ORM\Column(name="IS_REPEAT", type="integer", nullable=true)
     */
    private $isRepeat;

    /**
     * @var integer
     *
     * @ORM\Column(name="START_START", type="integer", nullable=false)
     */
    private $startStart;

    /**
     * @var integer
     *
     * @ORM\Column(name="STATUS", type="integer", nullable=false)
     */
    private $status;

    /**
     * @var integer
     *
     * @ORM\Column(name="RESULT", type="integer", nullable=false)
     */
    private $result;

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
     * Set schedulerId
     *
     * @param string $schedulerId
     * @return DaysSchedule
     */
    public function setSchedulerId($schedulerId)
    {
        $this->schedulerId = $schedulerId;

        return $this;
    }

    /**
     * Get schedulerId
     *
     * @return string 
     */
    public function getSchedulerId()
    {
        return $this->schedulerId;
    }

    /**
     * Set schedulerHistoryId
     *
     * @param integer $schedulerHistoryId
     * @return DaysSchedule
     */
    public function setSchedulerHistoryId($schedulerHistoryId)
    {
        $this->schedulerHistoryId = $schedulerHistoryId;

        return $this;
    }

    /**
     * Get schedulerHistoryId
     *
     * @return integer 
     */
    public function getSchedulerHistoryId()
    {
        return $this->schedulerHistoryId;
    }

    /**
     * Set schedulerOrderHistoryId
     *
     * @param integer $schedulerOrderHistoryId
     * @return DaysSchedule
     */
    public function setSchedulerOrderHistoryId($schedulerOrderHistoryId)
    {
        $this->schedulerOrderHistoryId = $schedulerOrderHistoryId;

        return $this;
    }

    /**
     * Get schedulerOrderHistoryId
     *
     * @return integer 
     */
    public function getSchedulerOrderHistoryId()
    {
        return $this->schedulerOrderHistoryId;
    }

    /**
     * Set job
     *
     * @param string $job
     * @return DaysSchedule
     */
    public function setJob($job)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Get job
     *
     * @return string 
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Set jobChain
     *
     * @param string $jobChain
     * @return DaysSchedule
     */
    public function setJobChain($jobChain)
    {
        $this->jobChain = $jobChain;

        return $this;
    }

    /**
     * Get jobChain
     *
     * @return string 
     */
    public function getJobChain()
    {
        return $this->jobChain;
    }

    /**
     * Set orderId
     *
     * @param string $orderId
     * @return DaysSchedule
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * Get orderId
     *
     * @return string 
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * Set schedulePlanned
     *
     * @param \DateTime $schedulePlanned
     * @return DaysSchedule
     */
    public function setSchedulePlanned($schedulePlanned)
    {
        $this->schedulePlanned = $schedulePlanned;

        return $this;
    }

    /**
     * Get schedulePlanned
     *
     * @return \DateTime 
     */
    public function getSchedulePlanned()
    {
        return $this->schedulePlanned;
    }

    /**
     * Set scheduleExecuted
     *
     * @param \DateTime $scheduleExecuted
     * @return DaysSchedule
     */
    public function setScheduleExecuted($scheduleExecuted)
    {
        $this->scheduleExecuted = $scheduleExecuted;

        return $this;
    }

    /**
     * Get scheduleExecuted
     *
     * @return \DateTime 
     */
    public function getScheduleExecuted()
    {
        return $this->scheduleExecuted;
    }

    /**
     * Set periodBegin
     *
     * @param \DateTime $periodBegin
     * @return DaysSchedule
     */
    public function setPeriodBegin($periodBegin)
    {
        $this->periodBegin = $periodBegin;

        return $this;
    }

    /**
     * Get periodBegin
     *
     * @return \DateTime 
     */
    public function getPeriodBegin()
    {
        return $this->periodBegin;
    }

    /**
     * Set periodEnd
     *
     * @param \DateTime $periodEnd
     * @return DaysSchedule
     */
    public function setPeriodEnd($periodEnd)
    {
        $this->periodEnd = $periodEnd;

        return $this;
    }

    /**
     * Get periodEnd
     *
     * @return \DateTime 
     */
    public function getPeriodEnd()
    {
        return $this->periodEnd;
    }

    /**
     * Set isRepeat
     *
     * @param integer $isRepeat
     * @return DaysSchedule
     */
    public function setIsRepeat($isRepeat)
    {
        $this->isRepeat = $isRepeat;

        return $this;
    }

    /**
     * Get isRepeat
     *
     * @return integer 
     */
    public function getIsRepeat()
    {
        return $this->isRepeat;
    }

    /**
     * Set startStart
     *
     * @param integer $startStart
     * @return DaysSchedule
     */
    public function setStartStart($startStart)
    {
        $this->startStart = $startStart;

        return $this;
    }

    /**
     * Get startStart
     *
     * @return integer 
     */
    public function getStartStart()
    {
        return $this->startStart;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return DaysSchedule
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set result
     *
     * @param integer $result
     * @return DaysSchedule
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Get result
     *
     * @return integer 
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return DaysSchedule
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
     * @return DaysSchedule
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
