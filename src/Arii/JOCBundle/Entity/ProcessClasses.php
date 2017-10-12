<?php

namespace Arii\JOCBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * state_process_classes
 *
 * @ORM\Table(name="JOC_PROCESS_CLASSES")
 * @ORM\Entity(repositoryClass="Arii\JOCBundle\Entity\ProcessClassesRepository")
 */
class ProcessClasses
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
     * @ORM\ManyToOne(targetEntity="Arii\JOCBundle\Entity\Spoolers")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     **/
    private $spooler;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * @var integer
     *
     * @ORM\Column(name="max_processes", type="integer")
     */
    private $max_processes;

    /**
     * @var string
     *
     * @ORM\Column(name="remote_scheduler", type="string", length=255, nullable=true)
     */
    private $remote_scheduler;

    /**
     * @var integer
     *
     * @ORM\Column(name="processes", type="integer")
     */
    private $processes;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=100, nullable=true)
     */
    private $state;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_write_time", type="datetime", nullable=true)
     */
    private $last_write_time;

    /**
     * @var string
     *
     * @ORM\Column(name="error", type="string", length=128, nullable=true)
     */
    private $error;

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
     * Set name
     *
     * @param string $name
     * @return ProcessClasses
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
     * Set path
     *
     * @param string $path
     * @return ProcessClasses
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
     * Set max_processes
     *
     * @param integer $maxProcesses
     * @return ProcessClasses
     */
    public function setMaxProcesses($maxProcesses)
    {
        $this->max_processes = $maxProcesses;

        return $this;
    }

    /**
     * Get max_processes
     *
     * @return integer 
     */
    public function getMaxProcesses()
    {
        return $this->max_processes;
    }

    /**
     * Set remote_scheduler
     *
     * @param string $remoteScheduler
     * @return ProcessClasses
     */
    public function setRemoteScheduler($remoteScheduler)
    {
        $this->remote_scheduler = $remoteScheduler;

        return $this;
    }

    /**
     * Get remote_scheduler
     *
     * @return string 
     */
    public function getRemoteScheduler()
    {
        return $this->remote_scheduler;
    }

    /**
     * Set processes
     *
     * @param integer $processes
     * @return ProcessClasses
     */
    public function setProcesses($processes)
    {
        $this->processes = $processes;

        return $this;
    }

    /**
     * Get processes
     *
     * @return integer 
     */
    public function getProcesses()
    {
        return $this->processes;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return ProcessClasses
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
     * Set last_write_time
     *
     * @param \DateTime $lastWriteTime
     * @return ProcessClasses
     */
    public function setLastWriteTime($lastWriteTime)
    {
        $this->last_write_time = $lastWriteTime;

        return $this;
    }

    /**
     * Get last_write_time
     *
     * @return \DateTime 
     */
    public function getLastWriteTime()
    {
        return $this->last_write_time;
    }

    /**
     * Set error
     *
     * @param string $error
     * @return ProcessClasses
     */
    public function setError($error)
    {
        $this->error = $error;

        return $this;
    }

    /**
     * Get error
     *
     * @return string 
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return ProcessClasses
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
     * Set spooler
     *
     * @param \Arii\JOCBundle\Entity\Spoolers $spooler
     * @return ProcessClasses
     */
    public function setSpooler(\Arii\JOCBundle\Entity\Spoolers $spooler = null)
    {
        $this->spooler = $spooler;

        return $this;
    }

    /**
     * Get spooler
     *
     * @return \Arii\JOCBundle\Entity\Spoolers 
     */
    public function getSpooler()
    {
        return $this->spooler;
    }
}
