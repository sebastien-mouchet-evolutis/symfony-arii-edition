<?php

namespace Arii\JOCBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JobStatus
 *
 * @ORM\Table(name="JOC_JOB_STATUS")
 * @ORM\Entity(repositoryClass="Arii\JOCBundle\Entity\JobStatusRepository")
 */
class JobStatus
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
     * @var \DateTime
     *
     * @ORM\Column(name="start_time", type="datetimetz")
     */
    private $startTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_time", type="datetimetz",nullable=true)
     */
    private $endTime;

    /**
     * @var integer
     *
     * @ORM\Column(name="error", type="integer", nullable=true)
     */
    private $error;
    
    /**
     * @var string
     *
     * @ORM\Column(name="error_text", type="string", length=255, nullable=true)
     */
    private $error_text;

    /**
     * @var string
     *
     * @ORM\Column(name="cause", type="string", length=50, nullable=true)
     */
    private $cause;

    /**
     * @var integer
     *
     * @ORM\Column(name="exit_code", type="integer", nullable=true)
     */
    private $exitCode;

    /**
     * @var integer
     *
     * @ORM\Column(name="pid", type="integer", nullable=true)
     */
    private $pid;

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
     * @return JobStatus
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
     * Set jobName
     *
     * @param string $jobName
     * @return JobStatus
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
     * Set spooler
     *
     * @param string $spooler
     * @return JobStatus
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
     * Set startTime
     *
     * @param \DateTime $startTime
     * @return JobStatus
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
     * @return JobStatus
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
     * Set pid
     *
     * @param integer $pid
     * @return JobStatus
     */
    public function setPid($pid)
    {
        $this->pid = $pid;

        return $this;
    }

    /**
     * Get pid
     *
     * @return integer 
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * Set error
     *
     * @param integer $error
     * @return JobStatus
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
     * Set error_text
     *
     * @param string $errorText
     * @return JobStatus
     */
    public function setErrorText($errorText)
    {
        $this->error_text = $errorText;

        return $this;
    }

    /**
     * Get error_text
     *
     * @return string 
     */
    public function getErrorText()
    {
        return $this->error_text;
    }

    /**
     * Set cause
     *
     * @param string $cause
     * @return JobStatus
     */
    public function setCause($cause)
    {
        $this->cause = $cause;

        return $this;
    }

    /**
     * Get cause
     *
     * @return string 
     */
    public function getCause()
    {
        return $this->cause;
    }

    /**
     * Set exitCode
     *
     * @param integer $exitCode
     * @return JobStatus
     */
    public function setExitCode($exitCode)
    {
        $this->exitCode = $exitCode;

        return $this;
    }

    /**
     * Get exitCode
     *
     * @return integer 
     */
    public function getExitCode()
    {
        return $this->exitCode;
    }

    /**
     * Set updated
     *
     * @param integer $updated
     * @return JobStatus
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
     * @return JobStatus
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
     * @return JobStatus
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
