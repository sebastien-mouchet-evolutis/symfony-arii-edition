<?php

namespace Arii\JIDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SchedulerOrderStepHistory
 *
 * @ORM\Table(name="scheduler_order_step_history", indexes={@ORM\Index(name="SCHEDULER_OSH_TASK_ID", columns={"TASK_ID"})})
 * @ORM\Entity(readOnly=true)
 */
class SchedulerOrderStepHistory
{
    /**
     * @var integer
     *
     * @ORM\Column(name="HISTORY_ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $historyId;

    /**
     * @var integer
     *
     * @ORM\Column(name="STEP", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $step;

    /**
     * @var integer
     *
     * @ORM\Column(name="TASK_ID", type="integer", nullable=false)
     */
    private $taskId;

    /**
     * @var string
     *
     * @ORM\Column(name="STATE", type="string", length=100, nullable=true)
     */
    private $state;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="START_TIME", type="datetime", nullable=false)
     */
    private $startTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="END_TIME", type="datetime", nullable=true)
     */
    private $endTime;

    /**
     * @var integer
     *
     * @ORM\Column(name="ERROR", type="integer", nullable=true)
     */
    private $error;

    /**
     * @var string
     *
     * @ORM\Column(name="ERROR_CODE", type="string", length=50, nullable=true)
     */
    private $errorCode;

    /**
     * @var string
     *
     * @ORM\Column(name="ERROR_TEXT", type="string", length=250, nullable=true)
     */
    private $errorText;



    /**
     * Set historyId
     *
     * @param integer $historyId
     * @return SchedulerOrderStepHistory
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
     * Set step
     *
     * @param integer $step
     * @return SchedulerOrderStepHistory
     */
    public function setStep($step)
    {
        $this->step = $step;

        return $this;
    }

    /**
     * Get step
     *
     * @return integer 
     */
    public function getStep()
    {
        return $this->step;
    }

    /**
     * Set taskId
     *
     * @param integer $taskId
     * @return SchedulerOrderStepHistory
     */
    public function setTaskId($taskId)
    {
        $this->taskId = $taskId;

        return $this;
    }

    /**
     * Get taskId
     *
     * @return integer 
     */
    public function getTaskId()
    {
        return $this->taskId;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return SchedulerOrderStepHistory
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
     * Set startTime
     *
     * @param \DateTime $startTime
     * @return SchedulerOrderStepHistory
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
     * @return SchedulerOrderStepHistory
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
     * Set error
     *
     * @param integer $error
     * @return SchedulerOrderStepHistory
     */
    public function setError($error)
    {
        $this->error = $error;

        return $this;
    }

    /**
     * Get error
     *
     * @return integer 
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Set errorCode
     *
     * @param string $errorCode
     * @return SchedulerOrderStepHistory
     */
    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;

        return $this;
    }

    /**
     * Get errorCode
     *
     * @return string 
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * Set errorText
     *
     * @param string $errorText
     * @return SchedulerOrderStepHistory
     */
    public function setErrorText($errorText)
    {
        $this->errorText = $errorText;

        return $this;
    }

    /**
     * Get errorText
     *
     * @return string 
     */
    public function getErrorText()
    {
        return $this->errorText;
    }
}
