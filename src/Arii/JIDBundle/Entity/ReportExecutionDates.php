<?php

namespace Arii\JIDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReportExecutionDates
 *
 * @ORM\Table(name="report_execution_dates", indexes={@ORM\Index(name="REPORTING_RED_REF", columns={"REFERENCE_ID", "REFERENCE_TYPE"})})
 * @ORM\Entity(readOnly=true)
 */
class ReportExecutionDates
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
     * @ORM\Column(name="REFERENCE_ID", type="integer", nullable=false)
     */
    private $referenceId;

    /**
     * @var integer
     *
     * @ORM\Column(name="REFERENCE_TYPE", type="integer", nullable=false)
     */
    private $referenceType;

    /**
     * @var boolean
     *
     * @ORM\Column(name="START_DAY", type="boolean", nullable=false)
     */
    private $startDay;

    /**
     * @var boolean
     *
     * @ORM\Column(name="START_WEEK", type="boolean", nullable=false)
     */
    private $startWeek;

    /**
     * @var boolean
     *
     * @ORM\Column(name="START_MONTH", type="boolean", nullable=false)
     */
    private $startMonth;

    /**
     * @var boolean
     *
     * @ORM\Column(name="START_QUARTER", type="boolean", nullable=false)
     */
    private $startQuarter;

    /**
     * @var integer
     *
     * @ORM\Column(name="START_YEAR", type="smallint", nullable=false)
     */
    private $startYear;

    /**
     * @var boolean
     *
     * @ORM\Column(name="END_DAY", type="boolean", nullable=false)
     */
    private $endDay;

    /**
     * @var boolean
     *
     * @ORM\Column(name="END_WEEK", type="boolean", nullable=false)
     */
    private $endWeek;

    /**
     * @var boolean
     *
     * @ORM\Column(name="END_MONTH", type="boolean", nullable=false)
     */
    private $endMonth;

    /**
     * @var boolean
     *
     * @ORM\Column(name="END_QUARTER", type="boolean", nullable=false)
     */
    private $endQuarter;

    /**
     * @var integer
     *
     * @ORM\Column(name="END_YEAR", type="smallint", nullable=false)
     */
    private $endYear;

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
     * @return ReportExecutionDates
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
     * @return ReportExecutionDates
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
     * Set referenceId
     *
     * @param integer $referenceId
     * @return ReportExecutionDates
     */
    public function setReferenceId($referenceId)
    {
        $this->referenceId = $referenceId;

        return $this;
    }

    /**
     * Get referenceId
     *
     * @return integer 
     */
    public function getReferenceId()
    {
        return $this->referenceId;
    }

    /**
     * Set referenceType
     *
     * @param integer $referenceType
     * @return ReportExecutionDates
     */
    public function setReferenceType($referenceType)
    {
        $this->referenceType = $referenceType;

        return $this;
    }

    /**
     * Get referenceType
     *
     * @return integer 
     */
    public function getReferenceType()
    {
        return $this->referenceType;
    }

    /**
     * Set startDay
     *
     * @param boolean $startDay
     * @return ReportExecutionDates
     */
    public function setStartDay($startDay)
    {
        $this->startDay = $startDay;

        return $this;
    }

    /**
     * Get startDay
     *
     * @return boolean 
     */
    public function getStartDay()
    {
        return $this->startDay;
    }

    /**
     * Set startWeek
     *
     * @param boolean $startWeek
     * @return ReportExecutionDates
     */
    public function setStartWeek($startWeek)
    {
        $this->startWeek = $startWeek;

        return $this;
    }

    /**
     * Get startWeek
     *
     * @return boolean 
     */
    public function getStartWeek()
    {
        return $this->startWeek;
    }

    /**
     * Set startMonth
     *
     * @param boolean $startMonth
     * @return ReportExecutionDates
     */
    public function setStartMonth($startMonth)
    {
        $this->startMonth = $startMonth;

        return $this;
    }

    /**
     * Get startMonth
     *
     * @return boolean 
     */
    public function getStartMonth()
    {
        return $this->startMonth;
    }

    /**
     * Set startQuarter
     *
     * @param boolean $startQuarter
     * @return ReportExecutionDates
     */
    public function setStartQuarter($startQuarter)
    {
        $this->startQuarter = $startQuarter;

        return $this;
    }

    /**
     * Get startQuarter
     *
     * @return boolean 
     */
    public function getStartQuarter()
    {
        return $this->startQuarter;
    }

    /**
     * Set startYear
     *
     * @param integer $startYear
     * @return ReportExecutionDates
     */
    public function setStartYear($startYear)
    {
        $this->startYear = $startYear;

        return $this;
    }

    /**
     * Get startYear
     *
     * @return integer 
     */
    public function getStartYear()
    {
        return $this->startYear;
    }

    /**
     * Set endDay
     *
     * @param boolean $endDay
     * @return ReportExecutionDates
     */
    public function setEndDay($endDay)
    {
        $this->endDay = $endDay;

        return $this;
    }

    /**
     * Get endDay
     *
     * @return boolean 
     */
    public function getEndDay()
    {
        return $this->endDay;
    }

    /**
     * Set endWeek
     *
     * @param boolean $endWeek
     * @return ReportExecutionDates
     */
    public function setEndWeek($endWeek)
    {
        $this->endWeek = $endWeek;

        return $this;
    }

    /**
     * Get endWeek
     *
     * @return boolean 
     */
    public function getEndWeek()
    {
        return $this->endWeek;
    }

    /**
     * Set endMonth
     *
     * @param boolean $endMonth
     * @return ReportExecutionDates
     */
    public function setEndMonth($endMonth)
    {
        $this->endMonth = $endMonth;

        return $this;
    }

    /**
     * Get endMonth
     *
     * @return boolean 
     */
    public function getEndMonth()
    {
        return $this->endMonth;
    }

    /**
     * Set endQuarter
     *
     * @param boolean $endQuarter
     * @return ReportExecutionDates
     */
    public function setEndQuarter($endQuarter)
    {
        $this->endQuarter = $endQuarter;

        return $this;
    }

    /**
     * Get endQuarter
     *
     * @return boolean 
     */
    public function getEndQuarter()
    {
        return $this->endQuarter;
    }

    /**
     * Set endYear
     *
     * @param integer $endYear
     * @return ReportExecutionDates
     */
    public function setEndYear($endYear)
    {
        $this->endYear = $endYear;

        return $this;
    }

    /**
     * Get endYear
     *
     * @return integer 
     */
    public function getEndYear()
    {
        return $this->endYear;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return ReportExecutionDates
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
     * @return ReportExecutionDates
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
