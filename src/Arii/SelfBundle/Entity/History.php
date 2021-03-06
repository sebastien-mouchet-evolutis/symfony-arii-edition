<?php

namespace Arii\SelfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Self-Service
 *
 * @ORM\Table(name="SELF_HISTORY")
 * @ORM\Entity(repositoryClass="Arii\SelfBundle\Entity\HistoryRepository")
 */
class History
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
     * @ORM\ManyToOne(targetEntity="Arii\SelfBundle\Entity\Request", cascade={"persist", "remove"})
     */
    private $request;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="run_exit", type="integer",nullable=true)
     */
    private $run_exit;

    /**
     * @var text
     *
     * @ORM\Column(name="run_log", type="text",nullable=true)
     */
    private $run_log;

    /**
     * @var string
     *
     * @ORM\Column(name="run_status", type="string", length=32,nullable=true)
     */
    private $run_status;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="started", type="datetime", nullable=true)
     */
    private $started;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="processed", type="datetime", nullable=true)
     */
    private $processed;

    /**
     * @var string
     *
     * @ORM\Column(name="client_ip", type="string", length=15, nullable=true)
     */
    private $client_ip;

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
     * Set run_exit
     *
     * @param integer $runExit
     * @return History
     */
    public function setRunExit($runExit)
    {
        $this->run_exit = $runExit;

        return $this;
    }

    /**
     * Get run_exit
     *
     * @return integer 
     */
    public function getRunExit()
    {
        return $this->run_exit;
    }

    /**
     * Set run_log
     *
     * @param string $runLog
     * @return History
     */
    public function setRunLog($runLog)
    {
        $this->run_log = $runLog;

        return $this;
    }

    /**
     * Get run_log
     *
     * @return string 
     */
    public function getRunLog()
    {
        return $this->run_log;
    }

    /**
     * Set run_status
     *
     * @param string $runStatus
     * @return History
     */
    public function setRunStatus($runStatus)
    {
        $this->run_status = $runStatus;

        return $this;
    }

    /**
     * Get run_status
     *
     * @return string 
     */
    public function getRunStatus()
    {
        return $this->run_status;
    }

    /**
     * Set started
     *
     * @param \DateTime $started
     * @return History
     */
    public function setStarted($started)
    {
        $this->started = $started;

        return $this;
    }

    /**
     * Get started
     *
     * @return \DateTime 
     */
    public function getStarted()
    {
        return $this->started;
    }

    /**
     * Set processed
     *
     * @param \DateTime $processed
     * @return History
     */
    public function setProcessed($processed)
    {
        $this->processed = $processed;

        return $this;
    }

    /**
     * Get processed
     *
     * @return \DateTime 
     */
    public function getProcessed()
    {
        return $this->processed;
    }

    /**
     * Set client_ip
     *
     * @param string $clientIp
     * @return History
     */
    public function setClientIp($clientIp)
    {
        $this->client_ip = $clientIp;

        return $this;
    }

    /**
     * Get client_ip
     *
     * @return string 
     */
    public function getClientIp()
    {
        return $this->client_ip;
    }

    /**
     * Set request
     *
     * @param \Arii\SelfBundle\Entity\Request $request
     * @return History
     */
    public function setRequest(\Arii\SelfBundle\Entity\Request $request = null)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Get request
     *
     * @return \Arii\SelfBundle\Entity\Request 
     */
    public function getRequest()
    {
        return $this->request;
    }
}
