<?php

namespace Arii\JOCBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JobRuntimes
 *
 * @ORM\Table(name="JOC_ORDER_STEP_RUNTIMES")
 * @ORM\Entity
 */
class OrderStepRuntimes
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
     * @ORM\OneToOne(targetEntity="Arii\JOCBundle\Entity\Orders")
     * @ORM\JoinColumn(nullable=true)
     **/
    private $order;

    /**
     * @ORM\OneToOne(targetEntity="Arii\JOCBundle\Entity\JobChainNodes")
     * @ORM\JoinColumn(nullable=true)
     **/
    private $job_chain_node;

    /**
     * @var integer
     *
     * @ORM\Column(name="history_id", type="integer")
     */
    private $historyId;

    /**
     * @var integer
     *
     * @ORM\Column(name="task_id", type="integer")
     */
    private $taskId;

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
     * Set taskId
     *
     * @param integer $taskId
     * @return OrderStepRuntimes
     */
    public function setTaskId($taskId)
    {
        $this->taskId = $taskId;

        return $this;
    }

    /**
     * Get taskId
     *
     * @return integer 
     */
    public function getTaskId()
    {
        return $this->taskId;
    }

    /**
     * Set runTime
     *
     * @param float $runTime
     * @return OrderStepRuntimes
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
     * @return OrderStepRuntimes
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
     * @return OrderStepRuntimes
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
     * @return OrderStepRuntimes
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
     * @return OrderStepRuntimes
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
     * Set order
     *
     * @param \Arii\JOCBundle\Entity\Orders $order
     * @return OrderStepRuntimes
     */
    public function setOrder(\Arii\JOCBundle\Entity\Orders $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \Arii\JOCBundle\Entity\Orders 
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set job_chain_node
     *
     * @param \Arii\JOCBundle\Entity\JobChainNodes $jobChainNode
     * @return OrderStepRuntimes
     */
    public function setJobChainNode(\Arii\JOCBundle\Entity\JobChainNodes $jobChainNode = null)
    {
        $this->job_chain_node = $jobChainNode;

        return $this;
    }

    /**
     * Get job_chain_node
     *
     * @return \Arii\JOCBundle\Entity\JobChainNodes 
     */
    public function getJobChainNode()
    {
        return $this->job_chain_node;
    }
}
