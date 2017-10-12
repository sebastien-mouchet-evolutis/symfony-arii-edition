<?php

namespace Arii\JOCBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * state_job_chain_nodes
 *
 * @ORM\Table(name="JOC_JOB_CHAIN_NODES")
 * @ORM\Entity(repositoryClass="Arii\JOCBundle\Entity\JobChainNodesRepository")
 */
class JobChainNodes
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
     * @ORM\ManyToOne(targetEntity="Arii\JOCBundle\Entity\JobChains")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $job_chain;

    /**
     * @var integer
     *
     * @ORM\Column(name="spooler_id", type="integer")
     */
    private $spooler_id;
        
    /**
     * @var string
     *
     * @ORM\Column(name="job", type="string", length=255, nullable=true)
     */
    private $job;

    /**
     * @var string
     *
     * @ORM\Column(name="chain", type="string", length=255, nullable=true)
     */
    private $chain;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=100)
     */
    private $state;

    /**
     * @var integer
     *
     * @ORM\Column(name="ordering", type="integer" )
     */
    private $ordering;
    
    /**
     * @var string
     *
     * @ORM\Column(name="next_state", type="string", length=100, nullable=true)
     */
    private $next_state;

    /**
     * @var string
     *
     * @ORM\Column(name="error_state", type="string", length=100, nullable=true)
     */
    private $error_state;

    /**
     * @var string
     *
     * @ORM\Column(name="action", type="string", length=32, nullable=true)
     */
    private $action;

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
     * @return JobChainNodes
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
     * Set job
     *
     * @param string $job
     * @return JobChainNodes
     */
    public function setJob($job)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Get job
     *
     * @return string 
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Set chain
     *
     * @param string $chain
     * @return JobChainNodes
     */
    public function setChain($chain)
    {
        $this->chain = $chain;

        return $this;
    }

    /**
     * Get chain
     *
     * @return string 
     */
    public function getChain()
    {
        return $this->chain;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return JobChainNodes
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
     * Set ordering
     *
     * @param integer $ordering
     * @return JobChainNodes
     */
    public function setOrdering($ordering)
    {
        $this->ordering = $ordering;

        return $this;
    }

    /**
     * Get ordering
     *
     * @return integer 
     */
    public function getOrdering()
    {
        return $this->ordering;
    }

    /**
     * Set next_state
     *
     * @param string $nextState
     * @return JobChainNodes
     */
    public function setNextState($nextState)
    {
        $this->next_state = $nextState;

        return $this;
    }

    /**
     * Get next_state
     *
     * @return string 
     */
    public function getNextState()
    {
        return $this->next_state;
    }

    /**
     * Set error_state
     *
     * @param string $errorState
     * @return JobChainNodes
     */
    public function setErrorState($errorState)
    {
        $this->error_state = $errorState;

        return $this;
    }

    /**
     * Get error_state
     *
     * @return string 
     */
    public function getErrorState()
    {
        return $this->error_state;
    }

    /**
     * Set action
     *
     * @param string $action
     * @return JobChainNodes
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return string 
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return JobChainNodes
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
     * Set job_chain
     *
     * @param \Arii\JOCBundle\Entity\JobChains $jobChain
     * @return JobChainNodes
     */
    public function setJobChain(\Arii\JOCBundle\Entity\JobChains $jobChain = null)
    {
        $this->job_chain = $jobChain;

        return $this;
    }

    /**
     * Get job_chain
     *
     * @return \Arii\JOCBundle\Entity\JobChains 
     */
    public function getJobChain()
    {
        return $this->job_chain;
    }
}
