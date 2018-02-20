<?php

namespace Arii\JOCBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JobRuntimes
 *
 * @ORM\Table(name="JOC_JOB_RUNTIMES")
 * @ORM\Entity
 */
class JobRuntimes
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
     * @ORM\OneToOne(targetEntity="Arii\JOCBundle\Entity\Jobs")
     * @ORM\JoinColumn(nullable=true)
     **/
    private $job;

    /**
     * @var integer
     *
     * @ORM\Column(name="history_id", type="integer")
     */
    private $historyId;

    /**
     * @var float
     *
     * @ORM\Column(name="run_time", type="float")
     */
    private $runTime;

    /**
     * @var float
     *
     * @ORM\Column(name="runs", type="integer")
     */
    private $runs;
    
    /**
     * @var float
     *
     * @ORM\Column(name="diff", type="float")
     */
    private $diff;

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
     * @return JobRuntimes
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
     * Set spooler
     *
     * @param string $spooler
     * @return JobRuntimes
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
     * Set jobName
     *
     * @param string $jobName
     * @return JobRuntimes
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
     * Set avgRuntime
     *
     * @param float $avgRuntime
     * @return JobRuntimes
     */
    public function setAvgRuntime($avgRuntime)
    {
        $this->avgRuntime = $avgRuntime;

        return $this;
    }

    /**
     * Get avgRuntime
     *
     * @return float 
     */
    public function getAvgRuntime()
    {
        return $this->avgRuntime;
    }

    /**
     * Set runTime
     *
     * @param float $runTime
     * @return JobRuntimes
     */
    public function setRunTime($runTime)
    {
        $this->runTime = $runTime;

        return $this;
    }

    /**
     * Get runTime
     *
     * @return float 
     */
    public function getRunTime()
    {
        return $this->runTime;
    }

    /**
     * Set runs
     *
     * @param integer $runs
     * @return JobRuntimes
     */
    public function setRuns($runs)
    {
        $this->runs = $runs;

        return $this;
    }

    /**
     * Get runs
     *
     * @return integer 
     */
    public function getRuns()
    {
        return $this->runs;
    }

    /**
     * Set diff
     *
     * @param float $diff
     * @return JobRuntimes
     */
    public function setDiff($diff)
    {
        $this->diff = $diff;

        return $this;
    }

    /**
     * Get diff
     *
     * @return float 
     */
    public function getDiff()
    {
        return $this->diff;
    }

    /**
     * Set updated
     *
     * @param integer $updated
     * @return JobRuntimes
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
     * @return JobRuntimes
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
     * Set job
     *
     * @param \Arii\JOCBundle\Entity\Jobs $job
     * @return JobRuntimes
     */
    public function setJob(\Arii\JOCBundle\Entity\Jobs $job = null)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Get job
     *
     * @return \Arii\JOCBundle\Entity\Jobs 
     */
    public function getJob()
    {
        return $this->job;
    }
}
