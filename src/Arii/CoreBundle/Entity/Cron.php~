<?php

namespace Arii\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cron
 *
 * @ORM\Table(name="ARII_CRON")
 * @ORM\Entity(repositoryClass="Arii\CoreBundle\Entity\CronRepository")
 */
class Cron
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=64, unique=true)
     */        
    private $name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=128, nullable=true)
     */        
    private $title;
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */        
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="minutes",  type="string", length=64, nullable=true)
     */        
    private $minutes;

    /**
     * @var string
     *
     * @ORM\Column(name="hours",  type="string", length=64, nullable=true)
     */        
    private $hours;

    /**
     * @var string
     *
     * @ORM\Column(name="month_days",  type="string", length=64, nullable=true)
     */        
    private $month_days;

    /**
     * @var string
     *
     * @ORM\Column(name="week_days",  type="string", length=64, nullable=true)
     */        
    private $week_days;

    /**
     * @var string
     *
     * @ORM\Column(name="months",  type="string", length=64, nullable=true)
     */        
    private $months;

    /**
     * @var string
     *
     * @ORM\Column(name="years",  type="string", length=64, nullable=true)
     */        
    private $years;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */        
    private $url;

    /**
     * @var datetime
     *
     * @ORM\Column(name="next_run", type="datetime", nullable=true )
     */        
    private $next_run;
    
    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=16 )
     */        
    private $status;
    
    /**
     * @var datetime
     *
     * @ORM\Column(name="change_time", type="datetime", nullable=true )
     */        
    private $change_time;

    /**
     * @var datetime
     *
     * @ORM\Column(name="change_user",  type="string", length=64, nullable=true)
     */        
    private $change_user;    

    // Activer la cron
    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean" )
     */        
    private $active=1;
    
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
     * Set name
     *
     * @param string $name
     * @return Schedules
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Schedules
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set minutes
     *
     * @param string $minutes
     * @return Schedules
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
     * @return Schedules
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
     * Set month_days
     *
     * @param string $monthDays
     * @return Schedules
     */
    public function setMonthDays($monthDays)
    {
        $this->month_days = $monthDays;

        return $this;
    }

    /**
     * Get month_days
     *
     * @return string 
     */
    public function getMonthDays()
    {
        return $this->month_days;
    }

    /**
     * Set week_days
     *
     * @param string $weekDays
     * @return Schedules
     */
    public function setWeekDays($weekDays)
    {
        $this->week_days = $weekDays;

        return $this;
    }

    /**
     * Get week_days
     *
     * @return string 
     */
    public function getWeekDays()
    {
        return $this->week_days;
    }

    /**
     * Set years
     *
     * @param string $years
     * @return Schedules
     */
    public function setYears($years)
    {
        $this->years = $years;

        return $this;
    }

    /**
     * Get years
     *
     * @return string 
     */
    public function getYears()
    {
        return $this->years;
    }

    /**
     * Set change_time
     *
     * @param \DateTime $changeTime
     * @return Schedules
     */
    public function setChangeTime($changeTime)
    {
        $this->change_time = $changeTime;

        return $this;
    }

    /**
     * Get change_time
     *
     * @return \DateTime 
     */
    public function getChangeTime()
    {
        return $this->change_time;
    }

    /**
     * Set change_user
     *
     * @param string $changeUser
     * @return Schedules
     */
    public function setChangeUser($changeUser)
    {
        $this->change_user = $changeUser;

        return $this;
    }

    /**
     * Get change_user
     *
     * @return string 
     */
    public function getChangeUser()
    {
        return $this->change_user;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Cron
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set next_run
     *
     * @param \DateTime $nextRun
     * @return Cron
     */
    public function setNextRun($nextRun)
    {
        $this->next_run = $nextRun;

        return $this;
    }

    /**
     * Get next_run
     *
     * @return \DateTime 
     */
    public function getNextRun()
    {
        return $this->next_run;
    }

    /**
     * Set done
     *
     * @param \DateTime $done
     * @return Cron
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
     * @return Cron
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
     * Set months
     *
     * @param string $months
     * @return Cron
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
     * Set description
     *
     * @param string $description
     * @return Cron
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Alerts
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }
    
}
