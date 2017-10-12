<?php

namespace Arii\ReportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Autosys
 *
 * @ORM\Table(name="REPORT_RUN_MONTH")
 * @ORM\Entity(repositoryClass="Arii\ReportBundle\Entity\RUNMonthRepository")
 */
class RUNMonth
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
     * @ORM\Column(name="application", type="string", length=64, nullable=true)
     */
    private $application;
    
    /**
     * @var string
     *
     * @ORM\Column(name="env", type="string", length=12, nullable=true)
     */
    private $env;

    /**
     * @var string
     *
     * @ORM\Column(name="run_year", type="integer" )
     */
    private $year;
    
    /**
     * @var string
     *
     * @ORM\Column(name="run_month", type="integer" )
     */
    private $month;
        
    /**
     * @var string
     *
     * @ORM\Column(name="spooler_name", type="string", length=32, nullable=true)
     */
    private $spooler_name;
    
    // Instance ou Id du spooler
    /**
     * @var string
     *
     * @ORM\Column(name="spooler_type", type="string", length=12, nullable=true)
     */
    private $spooler_type;
    
    /**
     * @var string
     *
     * @ORM\Column(name="executions", type="integer")
     */
    private $executions=0;

    /**
     * @var integer
     *
     * @ORM\Column(name="warnings", type="integer")
     */
    private $warnings=0;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="alarms", type="integer")
     */
    private $alarms=0;

    /**
     * @var integer
     *
     * @ORM\Column(name="acks", type="integer")
     */
    private $acks=0;

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
     * Set application
     *
     * @param string $application
     * @return RUNDay
     */
    public function setApplication($application)
    {
        $this->application = $application;

        return $this;
    }

    /**
     * Get application
     *
     * @return string 
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * Set env
     *
     * @param string $env
     * @return RUNDay
     */
    public function setEnv($env)
    {
        $this->env = $env;

        return $this;
    }

    /**
     * Get env
     *
     * @return string 
     */
    public function getEnv()
    {
        return $this->env;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return RUNDay
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
     * Set spooler_name
     *
     * @param string $spoolerName
     * @return RUNDay
     */
    public function setSpoolerName($spoolerName)
    {
        $this->spooler_name = $spoolerName;

        return $this;
    }

    /**
     * Get spooler_name
     *
     * @return string 
     */
    public function getSpoolerName()
    {
        return $this->spooler_name;
    }

    /**
     * Set spooler_type
     *
     * @param string $spoolerType
     * @return RUNDay
     */
    public function setSpoolerType($spoolerType)
    {
        $this->spooler_type = $spoolerType;

        return $this;
    }

    /**
     * Get spooler_type
     *
     * @return string 
     */
    public function getSpoolerType()
    {
        return $this->spooler_type;
    }

    /**
     * Set executions
     *
     * @param string $executions
     * @return RUNDay
     */
    public function setExecutions($executions)
    {
        $this->executions = $executions;

        return $this;
    }

    /**
     * Get executions
     *
     * @return string 
     */
    public function getExecutions()
    {
        return $this->executions;
    }

    /**
     * Set warnings
     *
     * @param integer $warnings
     * @return RUNDay
     */
    public function setWarnings($warnings)
    {
        $this->warnings = $warnings;

        return $this;
    }

    /**
     * Get warnings
     *
     * @return integer 
     */
    public function getWarnings()
    {
        return $this->warnings;
    }

    /**
     * Set alarms
     *
     * @param integer $alarms
     * @return RUNDay
     */
    public function setAlarms($alarms)
    {
        $this->alarms = $alarms;

        return $this;
    }

    /**
     * Get alarms
     *
     * @return integer 
     */
    public function getAlarms()
    {
        return $this->alarms;
    }

    /**
     * Set acks
     *
     * @param integer $acks
     * @return RUNDay
     */
    public function setAcks($acks)
    {
        $this->acks = $acks;

        return $this;
    }

    /**
     * Get acks
     *
     * @return integer 
     */
    public function getAcks()
    {
        return $this->acks;
    }

    /**
     * Set year
     *
     * @param integer $year
     * @return Year
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer 
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set month
     *
     * @param integer $month
     * @return Month
     */
    public function setMonth($month)
    {
        $this->month = $month;

        return $this;
    }

    /**
     * Get month
     *
     * @return integer 
     */
    public function getMonth()
    {
        return $this->month;
    }
}
