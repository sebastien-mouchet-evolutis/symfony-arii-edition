<?php

namespace Arii\JIDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SosftpFilesHistory
 *
 * @ORM\Table(name="sosftp_files_history", indexes={@ORM\Index(name="SOSFTP_FH_SOSFTP_ID", columns={"SOSFTP_ID"}), @ORM\Index(name="SOSFTP_FH_OPERATION", columns={"OPERATION"}), @ORM\Index(name="SOSFTP_FH_TIMESTAMP", columns={"TRANSFER_TIMESTAMP"}), @ORM\Index(name="SOSFTP_FH_TARGET_HOST", columns={"TARGET_HOST"}), @ORM\Index(name="SOSFTP_FH_TARGET_FILENAME", columns={"TARGET_FILENAME"}), @ORM\Index(name="SOSFTP_FH_STATUS", columns={"STATUS"}), @ORM\Index(name="SOSFTP_FH_PROTOCOL", columns={"PROTOCOL"})})
 * @ORM\Entity(readOnly=true)
 */
class SosftpFilesHistory
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
     * @ORM\Column(name="SOSFTP_ID", type="integer", nullable=false)
     */
    private $sosftpId;

    /**
     * @var string
     *
     * @ORM\Column(name="OPERATION", type="string", length=30, nullable=false)
     */
    private $operation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="TRANSFER_TIMESTAMP", type="datetime", nullable=false)
     */
    private $transferTimestamp;

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
     * Set sosftpId
     *
     * @param integer $sosftpId
     * @return SosftpFilesHistory
     */
    public function setSosftpId($sosftpId)
    {
        $this->sosftpId = $sosftpId;

        return $this;
    }

    /**
     * Get sosftpId
     *
     * @return integer 
     */
    public function getSosftpId()
    {
        return $this->sosftpId;
    }

    /**
     * Set operation
     *
     * @param string $operation
     * @return SosftpFilesHistory
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
     * Set transferTimestamp
     *
     * @param \DateTime $transferTimestamp
     * @return SosftpFilesHistory
     */
    public function setTransferTimestamp($transferTimestamp)
    {
        $this->transferTimestamp = $transferTimestamp;

        return $this;
    }

    /**
     * Get transferTimestamp
     *
     * @return \DateTime 
     */
    public function getTransferTimestamp()
    {
        return $this->transferTimestamp;
    }

    /**
     * Set pid
     *
     * @param integer $pid
     * @return SosftpFilesHistory
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
     * @return SosftpFilesHistory
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
     * @return SosftpFilesHistory
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
     * @return SosftpFilesHistory
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
     * @return SosftpFilesHistory
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
     * @return SosftpFilesHistory
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
     * @return SosftpFilesHistory
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
     * @return SosftpFilesHistory
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
     * @return SosftpFilesHistory
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
     * @return SosftpFilesHistory
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
     * @return SosftpFilesHistory
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
     * @return SosftpFilesHistory
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
     * @return SosftpFilesHistory
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
     * @return SosftpFilesHistory
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
     * @return SosftpFilesHistory
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
     * @return SosftpFilesHistory
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
     * @return SosftpFilesHistory
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
     * @return SosftpFilesHistory
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
     * @return SosftpFilesHistory
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
     * @return SosftpFilesHistory
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
     * @return SosftpFilesHistory
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
