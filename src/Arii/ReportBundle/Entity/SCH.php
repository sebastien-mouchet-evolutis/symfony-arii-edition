<?php

namespace Arii\ReportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Audit
 *
 * @ORM\Table(name="REPORT_SCH")
 * @ORM\Entity(repositoryClass="Arii\ReportBundle\Entity\SCHRepository")
 */
class SCH
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
     * @ORM\ManyToOne(targetEntity="Arii\ReportBundle\Entity\JOB")
     * @ORM\JoinColumn(nullable=true)
     **/
    private $job;
    
    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    // FORMAT CRON
    /**
     * @var string
     *
     * @ORM\Column(name="minutes", type="string", length=255)
     */
    private $minutes;

    /**
     * @var string
     *
     * @ORM\Column(name="hours", type="string", length=255)
     */
    private $hours;
    
    /**
     * @var string
     *
     * @ORM\Column(name="months", type="string", length=255)
     */
    private $months;    

    /**
     * @var string
     *
     * @ORM\Column(name="days_of_month", type="string", length=255)
     */
    private $days_of_month;
    
    /**
     * @var string
     *
     * @ORM\Column(name="days_of_week", type="string", length=255)
     */
    private $days_of_week;
        
    /**
     * @var string
     *
     * @ORM\Column(name="calendar", type="string", length=64)
     */
    private $calendar;

    /**
     * @var string
     *
     * @ORM\Column(name="holidays", type="string", length=64)
     */
    private $holidays;

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
     * Set path
     *
     * @param string $path
     * @return SCH
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set minutes
     *
     * @param string $minutes
     * @return SCH
     */
    public function setMinutes($minutes)
    {
        $this->minutes = $minutes;

        return $this;
    }

    /**
     * Get minutes
     *
     * @return string 
     */
    public function getMinutes()
    {
        return $this->minutes;
    }

    /**
     * Set hours
     *
     * @param string $hours
     * @return SCH
     */
    public function setHours($hours)
    {
        $this->hours = $hours;

        return $this;
    }

    /**
     * Get hours
     *
     * @return string 
     */
    public function getHours()
    {
        return $this->hours;
    }

    /**
     * Set months
     *
     * @param string $months
     * @return SCH
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
     * Set days_of_month
     *
     * @param string $daysOfMonth
     * @return SCH
     */
    public function setDaysOfMonth($daysOfMonth)
    {
        $this->days_of_month = $daysOfMonth;

        return $this;
    }

    /**
     * Get days_of_month
     *
     * @return string 
     */
    public function getDaysOfMonth()
    {
        return $this->days_of_month;
    }

    /**
     * Set days_of_week
     *
     * @param string $daysOfWeek
     * @return SCH
     */
    public function setDaysOfWeek($daysOfWeek)
    {
        $this->days_of_week = $daysOfWeek;

        return $this;
    }

    /**
     * Get days_of_week
     *
     * @return string 
     */
    public function getDaysOfWeek()
    {
        return $this->days_of_week;
    }

    /**
     * Set calendar
     *
     * @param string $calendar
     * @return SCH
     */
    public function setCalendar($calendar)
    {
        $this->calendar = $calendar;

        return $this;
    }

    /**
     * Get calendar
     *
     * @return string 
     */
    public function getCalendar()
    {
        return $this->calendar;
    }

    /**
     * Set holidays
     *
     * @param string $holidays
     * @return SCH
     */
    public function setHolidays($holidays)
    {
        $this->holidays = $holidays;

        return $this;
    }

    /**
     * Get holidays
     *
     * @return string 
     */
    public function getHolidays()
    {
        return $this->holidays;
    }

    /**
     * Set job
     *
     * @param \Arii\ReportBundle\Entity\JOB $job
     * @return SCH
     */
    public function setJob(\Arii\ReportBundle\Entity\JOB $job = null)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Get job
     *
     * @return \Arii\ReportBundle\Entity\JOB 
     */
    public function getJob()
    {
        return $this->job;
    }
}
