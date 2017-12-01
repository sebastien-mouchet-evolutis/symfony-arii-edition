<?php

namespace Arii\JIDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JadeFiles
 *
 * @ORM\Table(name="jade_files", uniqueConstraints={@ORM\UniqueConstraint(name="MANDATOR", columns={"MANDATOR", "SOURCE_HOST", "SOURCE_HOST_IP", "SOURCE_DIR", "SOURCE_FILENAME", "SOURCE_USER", "MD5"})})
 * @ORM\Entity(readOnly=true)
 */
class JadeFiles
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
     * @var string
     *
     * @ORM\Column(name="MANDATOR", type="string", length=30, nullable=false)
     */
    private $mandator;

    /**
     * @var string
     *
     * @ORM\Column(name="SOURCE_HOST", type="string", length=128, nullable=false)
     */
    private $sourceHost;

    /**
     * @var string
     *
     * @ORM\Column(name="SOURCE_HOST_IP", type="string", length=30, nullable=false)
     */
    private $sourceHostIp;

    /**
     * @var string
     *
     * @ORM\Column(name="SOURCE_DIR", type="string", length=255, nullable=false)
     */
    private $sourceDir;

    /**
     * @var string
     *
     * @ORM\Column(name="SOURCE_FILENAME", type="string", length=255, nullable=false)
     */
    private $sourceFilename;

    /**
     * @var string
     *
     * @ORM\Column(name="SOURCE_USER", type="string", length=128, nullable=false)
     */
    private $sourceUser;

    /**
     * @var string
     *
     * @ORM\Column(name="MD5", type="string", length=50, nullable=false)
     */
    private $md5;

    /**
     * @var integer
     *
     * @ORM\Column(name="FILE_SIZE", type="bigint", nullable=false)
     */
    private $fileSize;

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
     * @var \DateTime
     *
     * @ORM\Column(name="MODIFICATION_DATE", type="datetime", nullable=true)
     */
    private $modificationDate;



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
     * Set mandator
     *
     * @param string $mandator
     * @return JadeFiles
     */
    public function setMandator($mandator)
    {
        $this->mandator = $mandator;

        return $this;
    }

    /**
     * Get mandator
     *
     * @return string 
     */
    public function getMandator()
    {
        return $this->mandator;
    }

    /**
     * Set sourceHost
     *
     * @param string $sourceHost
     * @return JadeFiles
     */
    public function setSourceHost($sourceHost)
    {
        $this->sourceHost = $sourceHost;

        return $this;
    }

    /**
     * Get sourceHost
     *
     * @return string 
     */
    public function getSourceHost()
    {
        return $this->sourceHost;
    }

    /**
     * Set sourceHostIp
     *
     * @param string $sourceHostIp
     * @return JadeFiles
     */
    public function setSourceHostIp($sourceHostIp)
    {
        $this->sourceHostIp = $sourceHostIp;

        return $this;
    }

    /**
     * Get sourceHostIp
     *
     * @return string 
     */
    public function getSourceHostIp()
    {
        return $this->sourceHostIp;
    }

    /**
     * Set sourceDir
     *
     * @param string $sourceDir
     * @return JadeFiles
     */
    public function setSourceDir($sourceDir)
    {
        $this->sourceDir = $sourceDir;

        return $this;
    }

    /**
     * Get sourceDir
     *
     * @return string 
     */
    public function getSourceDir()
    {
        return $this->sourceDir;
    }

    /**
     * Set sourceFilename
     *
     * @param string $sourceFilename
     * @return JadeFiles
     */
    public function setSourceFilename($sourceFilename)
    {
        $this->sourceFilename = $sourceFilename;

        return $this;
    }

    /**
     * Get sourceFilename
     *
     * @return string 
     */
    public function getSourceFilename()
    {
        return $this->sourceFilename;
    }

    /**
     * Set sourceUser
     *
     * @param string $sourceUser
     * @return JadeFiles
     */
    public function setSourceUser($sourceUser)
    {
        $this->sourceUser = $sourceUser;

        return $this;
    }

    /**
     * Get sourceUser
     *
     * @return string 
     */
    public function getSourceUser()
    {
        return $this->sourceUser;
    }

    /**
     * Set md5
     *
     * @param string $md5
     * @return JadeFiles
     */
    public function setMd5($md5)
    {
        $this->md5 = $md5;

        return $this;
    }

    /**
     * Get md5
     *
     * @return string 
     */
    public function getMd5()
    {
        return $this->md5;
    }

    /**
     * Set fileSize
     *
     * @param integer $fileSize
     * @return JadeFiles
     */
    public function setFileSize($fileSize)
    {
        $this->fileSize = $fileSize;

        return $this;
    }

    /**
     * Get fileSize
     *
     * @return integer 
     */
    public function getFileSize()
    {
        return $this->fileSize;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return JadeFiles
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
     * @return JadeFiles
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
     * @return JadeFiles
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
     * @return JadeFiles
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

    /**
     * Set modificationDate
     *
     * @param \DateTime $modificationDate
     * @return JadeFiles
     */
    public function setModificationDate($modificationDate)
    {
        $this->modificationDate = $modificationDate;

        return $this;
    }

    /**
     * Get modificationDate
     *
     * @return \DateTime 
     */
    public function getModificationDate()
    {
        return $this->modificationDate;
    }
}
