<?php

namespace Arii\JOCBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Periods
 *
 * @ORM\Table(name="JOC_PERIODS")
 * @ORM\Entity
 */
class Periods
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
     * @ORM\ManyToOne(targetEntity="Arii\JOCBundle\Entity\Schedules")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     **/
    private $schedule;

    /**
     * @var integer
     *
     * @ORM\Column(name="spooler_id", type="integer")
     */
    private $spooler_id;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_time", type="time", nullable=true)
     */
    private $start_time;

    /**
     * @var string
     *
     * @ORM\Column(name="start_type", type="string", length=15, nullable=true)
     */
    private $start_type;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="begin", type="time", nullable=true)
     */
    private $begin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end", type="time", nullable=true)
     */
    private $end;

    /**
     * @var string
     *
     * @ORM\Column(name="months", type="string", length=26, nullable=true)
     */
    private $months;
    
    /**
     * @var string
     *
     * @ORM\Column(name="day_type", type="string", length=12, nullable=true)
     */
    private $day_type;
    
    /**
     * @var string
     *
     * @ORM\Column(name="days", type="string", length=84, nullable=true)
     */
    private $days;

    /**
     * @var integer
     *
     * @ORM\Column(name="which", type="integer", nullable=true)
     */
    private $which;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=true)
     */
    private $date;
    
    /**
     * @var string
     *
     * @ORM\Column(name="when_holiday", type="string", length=25, nullable=true)
     */
    private $when_holiday;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="let_run", type="boolean", nullable=true)
     */
    private $let_run;

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
     * @return Periods
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
     * Set start_time
     *
     * @param \DateTime $startTime
     * @return Periods
     */
    public function setStartTime($startTime)
    {
        $this->start_time = $startTime;

        return $this;
    }

    /**
     * Get start_time
     *
     * @return \DateTime 
     */
    public function getStartTime()
    {
        return $this->start_time;
    }

    /**
     * Set start_type
     *
     * @param string $startType
     * @return Periods
     */
    public function setStartType($startType)
    {
        $this->start_type = $startType;

        return $this;
    }

    /**
     * Get start_type
     *
     * @return string 
     */
    public function getStartType()
    {
        return $this->start_type;
    }

    /**
     * Set begin
     *
     * @param \DateTime $begin
     * @return Periods
     */
    public function setBegin($begin)
    {
        $this->begin = $begin;

        return $this;
    }

    /**
     * Get begin
     *
     * @return \DateTime 
     */
    public function getBegin()
    {
        return $this->begin;
    }

    /**
     * Set end
     *
     * @param \DateTime $end
     * @return Periods
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Get end
     *
     * @return \DateTime 
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Set months
     *
     * @param string $months
     * @return Periods
     */
    public function setMonths($months)
    {
        $this->months = $months;

        return $this;
    }

    /**
     * Get months
     *
     * @return string 
     */
    public function getMonths()
    {
        return $this->months;
    }

    /**
     * Set day_type
     *
     * @param string $dayType
     * @return Periods
     */
    public function setDayType($dayType)
    {
        $this->day_type = $dayType;

        return $this;
    }

    /**
     * Get day_type
     *
     * @return string 
     */
    public function getDayType()
    {
        return $this->day_type;
    }

    /**
     * Set days
     *
     * @param string $days
     * @return Periods
     */
    public function setDays($days)
    {
        $this->days = $days;

        return $this;
    }

    /**
     * Get days
     *
     * @return string 
     */
    public function getDays()
    {
        return $this->days;
    }

    /**
     * Set which
     *
     * @param integer $which
     * @return Periods
     */
    public function setWhich($which)
    {
        $this->which = $which;

        return $this;
    }

    /**
     * Get which
     *
     * @return integer 
     */
    public function getWhich()
    {
        return $this->which;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Periods
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set when_holiday
     *
     * @param string $whenHoliday
     * @return Periods
     */
    public function setWhenHoliday($whenHoliday)
    {
        $this->when_holiday = $whenHoliday;

        return $this;
    }

    /**
     * Get when_holiday
     *
     * @return string 
     */
    public function getWhenHoliday()
    {
        return $this->when_holiday;
    }

    /**
     * Set let_run
     *
     * @param boolean $letRun
     * @return Periods
     */
    public function setLetRun($letRun)
    {
        $this->let_run = $letRun;

        return $this;
    }

    /**
     * Get let_run
     *
     * @return boolean 
     */
    public function getLetRun()
    {
        return $this->let_run;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Periods
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
     * Set schedule
     *
     * @param \Arii\JOCBundle\Entity\Schedules $schedule
     * @return Periods
     */
    public function setSchedule(\Arii\JOCBundle\Entity\Schedules $schedule = null)
    {
        $this->schedule = $schedule;

        return $this;
    }

    /**
     * Get schedule
     *
     * @return \Arii\JOCBundle\Entity\Schedules 
     */
    public function getSchedule()
    {
        return $this->schedule;
    }
}
