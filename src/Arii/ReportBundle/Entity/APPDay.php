<?php

namespace Arii\ReportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Autosys
 *
 * @ORM\Table(name="REPORT_APP_DAY")
 * @ORM\Entity(repositoryClass="Arii\ReportBundle\Entity\APPDayRepository")
 */
class APPDay
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
     * @ORM\Column(name="app", type="string", length=64, nullable=true)
     */
    private $app;
    
    /**
     * @var string
     *
     * @ORM\Column(name="env", type="string", length=12, nullable=true)
     */
    private $env;
    
    /**
     * @var jobs
     *
     * @ORM\Column(name="jobs", type="integer" )
     */
    private $jobs;

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
     * Set app
     *
     * @param string $application
     * @return APPDay
     */
    public function setApp($app)
    {
        $this->app = $app;

        return $this;
    }

    /**
     * Get app
     *
     * @return string 
     */
    public function getApp()
    {
        return $this->app;
    }

    /**
     * Set env
     *
     * @param string $env
     * @return APPDay
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
     * Set jobs
     *
     * @param integer $jobs
     * @return APPDay
     */
    public function setJobs($jobs)
    {
        $this->jobs = $jobs;

        return $this;
    }

    /**
     * Get jobs
     *
     * @return integer 
     */
    public function getJobs()
    {
        return $this->jobs;
    }
}
