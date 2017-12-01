<?php

namespace Arii\JIDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReportTriggerResults
 *
 * @ORM\Table(name="report_trigger_results", indexes={@ORM\Index(name="REPORTING_RTR_TID", columns={"TRIGGER_ID"})})
 * @ORM\Entity(readOnly=true)
 */
class ReportTriggerResults
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
     * @ORM\Column(name="SCHEDULER_ID", type="string", length=100, nullable=false)
     */
    private $schedulerId;

    /**
     * @var integer
     *
     * @ORM\Column(name="HISTORY_ID", type="integer", nullable=false)
     */
    private $historyId;

    /**
     * @var integer
     *
     * @ORM\Column(name="TRIGGER_ID", type="integer", nullable=false)
     */
    private $triggerId;

    /**
     * @var string
     *
     * @ORM\Column(name="START_CAUSE", type="string", length=50, nullable=false)
     */
    private $startCause;

    /**
     * @var integer
     *
     * @ORM\Column(name="STEPS", type="integer", nullable=false)
     */
    private $steps;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ERROR", type="boolean", nullable=false)
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
     * @ORM\Column(name="ERROR_TEXT", type="string", length=255, nullable=true)
     */
    private $errorText;

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
     * @return ReportTriggerResults
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
     * Set historyId
     *
     * @param integer $historyId
     * @return ReportTriggerResults
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
     * Set triggerId
     *
     * @param integer $triggerId
     * @return ReportTriggerResults
     */
    public function setTriggerId($triggerId)
    {
        $this->triggerId = $triggerId;

        return $this;
    }

    /**
     * Get triggerId
     *
     * @return integer 
     */
    public function getTriggerId()
    {
        return $this->triggerId;
    }

    /**
     * Set startCause
     *
     * @param string $startCause
     * @return ReportTriggerResults
     */
    public function setStartCause($startCause)
    {
        $this->startCause = $startCause;

        return $this;
    }

    /**
     * Get startCause
     *
     * @return string 
     */
    public function getStartCause()
    {
        return $this->startCause;
    }

    /**
     * Set steps
     *
     * @param integer $steps
     * @return ReportTriggerResults
     */
    public function setSteps($steps)
    {
        $this->steps = $steps;

        return $this;
    }

    /**
     * Get steps
     *
     * @return integer 
     */
    public function getSteps()
    {
        return $this->steps;
    }

    /**
     * Set error
     *
     * @param boolean $error
     * @return ReportTriggerResults
     */
    public function setError($error)
    {
        $this->error = $error;

        return $this;
    }

    /**
     * Get error
     *
     * @return boolean 
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Set errorCode
     *
     * @param string $errorCode
     * @return ReportTriggerResults
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
     * @return ReportTriggerResults
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

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return ReportTriggerResults
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
     * @return ReportTriggerResults
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
