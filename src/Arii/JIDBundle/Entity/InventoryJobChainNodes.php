<?php

namespace Arii\JIDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InventoryJobChainNodes
 *
 * @ORM\Table(name="inventory_job_chain_nodes", indexes={@ORM\Index(name="REPORTING_IJCN_INST_ID", columns={"INSTANCE_ID"}), @ORM\Index(name="REPORTING_IJCN_JC_ID", columns={"JOB_CHAIN_ID"}), @ORM\Index(name="REPORTING_IJCN_JOB_NAME", columns={"JOB_NAME"})})
 * @ORM\Entity(readOnly=true)
 */
class InventoryJobChainNodes
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="INSTANCE_ID", type="integer", nullable=false)
     */
    private $instanceId;

    /**
     * @var integer
     *
     * @ORM\Column(name="JOB_CHAIN_ID", type="integer", nullable=false)
     */
    private $jobChainId;

    /**
     * @var string
     *
     * @ORM\Column(name="NAME", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="ORDERING", type="integer", nullable=false)
     */
    private $ordering;

    /**
     * @var string
     *
     * @ORM\Column(name="STATE", type="string", length=100, nullable=true)
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(name="NEXT_STATE", type="string", length=100, nullable=true)
     */
    private $nextState;

    /**
     * @var string
     *
     * @ORM\Column(name="ERROR_STATE", type="string", length=100, nullable=true)
     */
    private $errorState;

    /**
     * @var string
     *
     * @ORM\Column(name="JOB", type="string", length=255, nullable=true)
     */
    private $job;

    /**
     * @var string
     *
     * @ORM\Column(name="JOB_NAME", type="string", length=255, nullable=false)
     */
    private $jobName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="CREATED", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="MODIFIED", type="datetime", nullable=false)
     */
    private $modified;

    /**
     * @var integer
     *
     * @ORM\Column(name="JOB_ID", type="integer", nullable=false)
     */
    private $jobId;

    /**
     * @var string
     *
     * @ORM\Column(name="NESTED_JOB_CHAIN", type="string", length=255, nullable=true)
     */
    private $nestedJobChain;

    /**
     * @var string
     *
     * @ORM\Column(name="NESTED_JOB_CHAIN_NAME", type="string", length=255, nullable=false)
     */
    private $nestedJobChainName;

    /**
     * @var integer
     *
     * @ORM\Column(name="NESTED_JOB_CHAIN_ID", type="integer", nullable=false)
     */
    private $nestedJobChainId;

    /**
     * @var integer
     *
     * @ORM\Column(name="NODE_TYPE", type="integer", nullable=false)
     */
    private $nodeType;

    /**
     * @var string
     *
     * @ORM\Column(name="ON_ERROR", type="string", length=100, nullable=true)
     */
    private $onError;

    /**
     * @var integer
     *
     * @ORM\Column(name="DELAY", type="integer", nullable=true)
     */
    private $delay;

    /**
     * @var string
     *
     * @ORM\Column(name="DIRECTORY", type="string", length=255, nullable=true)
     */
    private $directory;

    /**
     * @var string
     *
     * @ORM\Column(name="REGEX", type="string", length=255, nullable=true)
     */
    private $regex;

    /**
     * @var integer
     *
     * @ORM\Column(name="FILE_SINK_OP", type="integer", nullable=true)
     */
    private $fileSinkOp;

    /**
     * @var string
     *
     * @ORM\Column(name="MOVE_PATH", type="string", length=255, nullable=true)
     */
    private $movePath;



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
     * Set instanceId
     *
     * @param integer $instanceId
     * @return InventoryJobChainNodes
     */
    public function setInstanceId($instanceId)
    {
        $this->instanceId = $instanceId;

        return $this;
    }

    /**
     * Get instanceId
     *
     * @return integer 
     */
    public function getInstanceId()
    {
        return $this->instanceId;
    }

    /**
     * Set jobChainId
     *
     * @param integer $jobChainId
     * @return InventoryJobChainNodes
     */
    public function setJobChainId($jobChainId)
    {
        $this->jobChainId = $jobChainId;

        return $this;
    }

    /**
     * Get jobChainId
     *
     * @return integer 
     */
    public function getJobChainId()
    {
        return $this->jobChainId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return InventoryJobChainNodes
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
     * Set ordering
     *
     * @param integer $ordering
     * @return InventoryJobChainNodes
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
     * Set state
     *
     * @param string $state
     * @return InventoryJobChainNodes
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
     * Set nextState
     *
     * @param string $nextState
     * @return InventoryJobChainNodes
     */
    public function setNextState($nextState)
    {
        $this->nextState = $nextState;

        return $this;
    }

    /**
     * Get nextState
     *
     * @return string 
     */
    public function getNextState()
    {
        return $this->nextState;
    }

    /**
     * Set errorState
     *
     * @param string $errorState
     * @return InventoryJobChainNodes
     */
    public function setErrorState($errorState)
    {
        $this->errorState = $errorState;

        return $this;
    }

    /**
     * Get errorState
     *
     * @return string 
     */
    public function getErrorState()
    {
        return $this->errorState;
    }

    /**
     * Set job
     *
     * @param string $job
     * @return InventoryJobChainNodes
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
     * Set jobName
     *
     * @param string $jobName
     * @return InventoryJobChainNodes
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
     * Set created
     *
     * @param \DateTime $created
     * @return InventoryJobChainNodes
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set modified
     *
     * @param \DateTime $modified
     * @return InventoryJobChainNodes
     */
    public function setModified($modified)
    {
        $this->modified = $modified;

        return $this;
    }

    /**
     * Get modified
     *
     * @return \DateTime 
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * Set jobId
     *
     * @param integer $jobId
     * @return InventoryJobChainNodes
     */
    public function setJobId($jobId)
    {
        $this->jobId = $jobId;

        return $this;
    }

    /**
     * Get jobId
     *
     * @return integer 
     */
    public function getJobId()
    {
        return $this->jobId;
    }

    /**
     * Set nestedJobChain
     *
     * @param string $nestedJobChain
     * @return InventoryJobChainNodes
     */
    public function setNestedJobChain($nestedJobChain)
    {
        $this->nestedJobChain = $nestedJobChain;

        return $this;
    }

    /**
     * Get nestedJobChain
     *
     * @return string 
     */
    public function getNestedJobChain()
    {
        return $this->nestedJobChain;
    }

    /**
     * Set nestedJobChainName
     *
     * @param string $nestedJobChainName
     * @return InventoryJobChainNodes
     */
    public function setNestedJobChainName($nestedJobChainName)
    {
        $this->nestedJobChainName = $nestedJobChainName;

        return $this;
    }

    /**
     * Get nestedJobChainName
     *
     * @return string 
     */
    public function getNestedJobChainName()
    {
        return $this->nestedJobChainName;
    }

    /**
     * Set nestedJobChainId
     *
     * @param integer $nestedJobChainId
     * @return InventoryJobChainNodes
     */
    public function setNestedJobChainId($nestedJobChainId)
    {
        $this->nestedJobChainId = $nestedJobChainId;

        return $this;
    }

    /**
     * Get nestedJobChainId
     *
     * @return integer 
     */
    public function getNestedJobChainId()
    {
        return $this->nestedJobChainId;
    }

    /**
     * Set nodeType
     *
     * @param integer $nodeType
     * @return InventoryJobChainNodes
     */
    public function setNodeType($nodeType)
    {
        $this->nodeType = $nodeType;

        return $this;
    }

    /**
     * Get nodeType
     *
     * @return integer 
     */
    public function getNodeType()
    {
        return $this->nodeType;
    }

    /**
     * Set onError
     *
     * @param string $onError
     * @return InventoryJobChainNodes
     */
    public function setOnError($onError)
    {
        $this->onError = $onError;

        return $this;
    }

    /**
     * Get onError
     *
     * @return string 
     */
    public function getOnError()
    {
        return $this->onError;
    }

    /**
     * Set delay
     *
     * @param integer $delay
     * @return InventoryJobChainNodes
     */
    public function setDelay($delay)
    {
        $this->delay = $delay;

        return $this;
    }

    /**
     * Get delay
     *
     * @return integer 
     */
    public function getDelay()
    {
        return $this->delay;
    }

    /**
     * Set directory
     *
     * @param string $directory
     * @return InventoryJobChainNodes
     */
    public function setDirectory($directory)
    {
        $this->directory = $directory;

        return $this;
    }

    /**
     * Get directory
     *
     * @return string 
     */
    public function getDirectory()
    {
        return $this->directory;
    }

    /**
     * Set regex
     *
     * @param string $regex
     * @return InventoryJobChainNodes
     */
    public function setRegex($regex)
    {
        $this->regex = $regex;

        return $this;
    }

    /**
     * Get regex
     *
     * @return string 
     */
    public function getRegex()
    {
        return $this->regex;
    }

    /**
     * Set fileSinkOp
     *
     * @param integer $fileSinkOp
     * @return InventoryJobChainNodes
     */
    public function setFileSinkOp($fileSinkOp)
    {
        $this->fileSinkOp = $fileSinkOp;

        return $this;
    }

    /**
     * Get fileSinkOp
     *
     * @return integer 
     */
    public function getFileSinkOp()
    {
        return $this->fileSinkOp;
    }

    /**
     * Set movePath
     *
     * @param string $movePath
     * @return InventoryJobChainNodes
     */
    public function setMovePath($movePath)
    {
        $this->movePath = $movePath;

        return $this;
    }

    /**
     * Get movePath
     *
     * @return string 
     */
    public function getMovePath()
    {
        return $this->movePath;
    }
}
