<?php

namespace Arii\JIDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JadeFilesHistory
 *
 * @ORM\Table(name="jade_files_history", indexes={@ORM\Index(name="JADE_FH_JADE_ID", columns={"JADE_ID"}), @ORM\Index(name="JADE_FH_OPERATION", columns={"OPERATION"}), @ORM\Index(name="JADE_FH_START", columns={"TRANSFER_START"}), @ORM\Index(name="JADE_FH_END", columns={"TRANSFER_END"}), @ORM\Index(name="JADE_FH_TARGET_HOST", columns={"TARGET_HOST"}), @ORM\Index(name="JADE_FH_TARGET_FILENAME", columns={"TARGET_FILENAME"}), @ORM\Index(name="JADE_FH_STATUS", columns={"STATUS"}), @ORM\Index(name="JADE_FH_PROTOCOL", columns={"PROTOCOL"})})
 * @ORM\Entity(readOnly=true)
 */
class JadeFilesHistory
{
    /**
     * @var string
     *
     * @ORM\Column(name="GUID", type="string", length=40, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $guid;

    /**
     * @var integer
     *
     * @ORM\Column(name="JADE_ID", type="integer", nullable=false)
     */
    private $jadeId;

    /**
     * @var string
     *
     * @ORM\Column(name="OPERATION", type="string", length=30, nullable=false)
     */
    private $operation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="TRANSFER_START", type="datetime", nullable=true)
     */
    private $transferStart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="TRANSFER_END", type="datetime", nullable=true)
     */
    private $transferEnd;

    /**
     * @var integer
     *
     * @ORM\Column(name="PID", type="integer", nullable=false)
     */
    private $pid;

    /**
     * @var integer
     *
     * @ORM\Column(name="PPID", type="integer", nullable=false)
     */
    private $ppid;

    /**
     * @var string
     *
     * @ORM\Column(name="TARGET_HOST", type="string", length=128, nullable=false)
     */
    private $targetHost;

    /**
     * @var string
     *
     * @ORM\Column(name="TARGET_HOST_IP", type="string", length=30, nullable=false)
     */
    private $targetHostIp;

    /**
     * @var string
     *
     * @ORM\Column(name="TARGET_USER", type="string", length=128, nullable=false)
     */
    private $targetUser;

    /**
     * @var string
     *
     * @ORM\Column(name="TARGET_DIR", type="string", length=255, nullable=false)
     */
    private $targetDir;

    /**
     * @var string
     *
     * @ORM\Column(name="TARGET_FILENAME", type="string", length=255, nullable=false)
     */
    private $targetFilename;

    /**
     * @var string
     *
     * @ORM\Column(name="PROTOCOL", type="string", length=10, nullable=false)
     */
    private $protocol;

    /**
     * @var integer
     *
     * @ORM\Column(name="PORT", type="integer", nullable=false)
     */
    private $port;

    /**
     * @var string
     *
     * @ORM\Column(name="STATUS", type="string", length=30, nullable=false)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="LAST_ERROR_MESSAGE", type="string", length=255, nullable=true)
     */
    private $lastErrorMessage;

    /**
     * @var string
     *
     * @ORM\Column(name="LOG_FILENAME", type="string", length=255, nullable=true)
     */
    private $logFilename;

    /**
     * @var string
     *
     * @ORM\Column(name="JUMP_HOST", type="string", length=128, nullable=true)
     */
    private $jumpHost;

    /**
     * @var string
     *
     * @ORM\Column(name="JUMP_HOST_IP", type="string", length=30, nullable=true)
     */
    private $jumpHostIp;

    /**
     * @var string
     *
     * @ORM\Column(name="JUMP_USER", type="string", length=128, nullable=true)
     */
    private $jumpUser;

    /**
     * @var string
     *
     * @ORM\Column(name="JUMP_PROTOCOL", type="string", length=10, nullable=true)
     */
    private $jumpProtocol;

    /**
     * @var integer
     *
     * @ORM\Column(name="JUMP_PORT", type="integer", nullable=true)
     */
    private $jumpPort;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="CREATED", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var string
     *
     * @ORM\Column(name="CREATED_BY", type="string", length=100, nullable=false)
     */
    private $createdBy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="MODIFIED", type="datetime", nullable=false)
     */
    private $modified;

    /**
     * @var string
     *
     * @ORM\Column(name="MODIFIED_BY", type="string", length=100, nullable=false)
     */
    private $modifiedBy;



    /**
     * Get guid
     *
     * @return string 
     */
    public function getGuid()
    {
        return $this->guid;
    }

    /**
     * Set jadeId
     *
     * @param integer $jadeId
     * @return JadeFilesHistory
     */
    public function setJadeId($jadeId)
    {
        $this->jadeId = $jadeId;

        return $this;
    }

    /**
     * Get jadeId
     *
     * @return integer 
     */
    public function getJadeId()
    {
        return $this->jadeId;
    }

    /**
     * Set operation
     *
     * @param string $operation
     * @return JadeFilesHistory
     */
    public function setOperation($operation)
    {
        $this->operation = $operation;

        return $this;
    }

    /**
     * Get operation
     *
     * @return string 
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * Set transferStart
     *
     * @param \DateTime $transferStart
     * @return JadeFilesHistory
     */
    public function setTransferStart($transferStart)
    {
        $this->transferStart = $transferStart;

        return $this;
    }

    /**
     * Get transferStart
     *
     * @return \DateTime 
     */
    public function getTransferStart()
    {
        return $this->transferStart;
    }

    /**
     * Set transferEnd
     *
     * @param \DateTime $transferEnd
     * @return JadeFilesHistory
     */
    public function setTransferEnd($transferEnd)
    {
        $this->transferEnd = $transferEnd;

        return $this;
    }

    /**
     * Get transferEnd
     *
     * @return \DateTime 
     */
    public function getTransferEnd()
    {
        return $this->transferEnd;
    }

    /**
     * Set pid
     *
     * @param integer $pid
     * @return JadeFilesHistory
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
     * Set ppid
     *
     * @param integer $ppid
     * @return JadeFilesHistory
     */
    public function setPpid($ppid)
    {
        $this->ppid = $ppid;

        return $this;
    }

    /**
     * Get ppid
     *
     * @return integer 
     */
    public function getPpid()
    {
        return $this->ppid;
    }

    /**
     * Set targetHost
     *
     * @param string $targetHost
     * @return JadeFilesHistory
     */
    public function setTargetHost($targetHost)
    {
        $this->targetHost = $targetHost;

        return $this;
    }

    /**
     * Get targetHost
     *
     * @return string 
     */
    public function getTargetHost()
    {
        return $this->targetHost;
    }

    /**
     * Set targetHostIp
     *
     * @param string $targetHostIp
     * @return JadeFilesHistory
     */
    public function setTargetHostIp($targetHostIp)
    {
        $this->targetHostIp = $targetHostIp;

        return $this;
    }

    /**
     * Get targetHostIp
     *
     * @return string 
     */
    public function getTargetHostIp()
    {
        return $this->targetHostIp;
    }

    /**
     * Set targetUser
     *
     * @param string $targetUser
     * @return JadeFilesHistory
     */
    public function setTargetUser($targetUser)
    {
        $this->targetUser = $targetUser;

        return $this;
    }

    /**
     * Get targetUser
     *
     * @return string 
     */
    public function getTargetUser()
    {
        return $this->targetUser;
    }

    /**
     * Set targetDir
     *
     * @param string $targetDir
     * @return JadeFilesHistory
     */
    public function setTargetDir($targetDir)
    {
        $this->targetDir = $targetDir;

        return $this;
    }

    /**
     * Get targetDir
     *
     * @return string 
     */
    public function getTargetDir()
    {
        return $this->targetDir;
    }

    /**
     * Set targetFilename
     *
     * @param string $targetFilename
     * @return JadeFilesHistory
     */
    public function setTargetFilename($targetFilename)
    {
        $this->targetFilename = $targetFilename;

        return $this;
    }

    /**
     * Get targetFilename
     *
     * @return string 
     */
    public function getTargetFilename()
    {
        return $this->targetFilename;
    }

    /**
     * Set protocol
     *
     * @param string $protocol
     * @return JadeFilesHistory
     */
    public function setProtocol($protocol)
    {
        $this->protocol = $protocol;

        return $this;
    }

    /**
     * Get protocol
     *
     * @return string 
     */
    public function getProtocol()
    {
        return $this->protocol;
    }

    /**
     * Set port
     *
     * @param integer $port
     * @return JadeFilesHistory
     */
    public function setPort($port)
    {
        $this->port = $port;

        return $this;
    }

    /**
     * Get port
     *
     * @return integer 
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return JadeFilesHistory
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
     * Set lastErrorMessage
     *
     * @param string $lastErrorMessage
     * @return JadeFilesHistory
     */
    public function setLastErrorMessage($lastErrorMessage)
    {
        $this->lastErrorMessage = $lastErrorMessage;

        return $this;
    }

    /**
     * Get lastErrorMessage
     *
     * @return string 
     */
    public function getLastErrorMessage()
    {
        return $this->lastErrorMessage;
    }

    /**
     * Set logFilename
     *
     * @param string $logFilename
     * @return JadeFilesHistory
     */
    public function setLogFilename($logFilename)
    {
        $this->logFilename = $logFilename;

        return $this;
    }

    /**
     * Get logFilename
     *
     * @return string 
     */
    public function getLogFilename()
    {
        return $this->logFilename;
    }

    /**
     * Set jumpHost
     *
     * @param string $jumpHost
     * @return JadeFilesHistory
     */
    public function setJumpHost($jumpHost)
    {
        $this->jumpHost = $jumpHost;

        return $this;
    }

    /**
     * Get jumpHost
     *
     * @return string 
     */
    public function getJumpHost()
    {
        return $this->jumpHost;
    }

    /**
     * Set jumpHostIp
     *
     * @param string $jumpHostIp
     * @return JadeFilesHistory
     */
    public function setJumpHostIp($jumpHostIp)
    {
        $this->jumpHostIp = $jumpHostIp;

        return $this;
    }

    /**
     * Get jumpHostIp
     *
     * @return string 
     */
    public function getJumpHostIp()
    {
        return $this->jumpHostIp;
    }

    /**
     * Set jumpUser
     *
     * @param string $jumpUser
     * @return JadeFilesHistory
     */
    public function setJumpUser($jumpUser)
    {
        $this->jumpUser = $jumpUser;

        return $this;
    }

    /**
     * Get jumpUser
     *
     * @return string 
     */
    public function getJumpUser()
    {
        return $this->jumpUser;
    }

    /**
     * Set jumpProtocol
     *
     * @param string $jumpProtocol
     * @return JadeFilesHistory
     */
    public function setJumpProtocol($jumpProtocol)
    {
        $this->jumpProtocol = $jumpProtocol;

        return $this;
    }

    /**
     * Get jumpProtocol
     *
     * @return string 
     */
    public function getJumpProtocol()
    {
        return $this->jumpProtocol;
    }

    /**
     * Set jumpPort
     *
     * @param integer $jumpPort
     * @return JadeFilesHistory
     */
    public function setJumpPort($jumpPort)
    {
        $this->jumpPort = $jumpPort;

        return $this;
    }

    /**
     * Get jumpPort
     *
     * @return integer 
     */
    public function getJumpPort()
    {
        return $this->jumpPort;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return JadeFilesHistory
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
     * Set createdBy
     *
     * @param string $createdBy
     * @return JadeFilesHistory
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return string 
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set modified
     *
     * @param \DateTime $modified
     * @return JadeFilesHistory
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
     * Set modifiedBy
     *
     * @param string $modifiedBy
     * @return JadeFilesHistory
     */
    public function setModifiedBy($modifiedBy)
    {
        $this->modifiedBy = $modifiedBy;

        return $this;
    }

    /**
     * Get modifiedBy
     *
     * @return string 
     */
    public function getModifiedBy()
    {
        return $this->modifiedBy;
    }
}
