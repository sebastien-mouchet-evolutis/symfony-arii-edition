<?php

namespace Arii\JIDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InventoryFiles
 *
 * @ORM\Table(name="inventory_files", uniqueConstraints={@ORM\UniqueConstraint(name="INVENTORY_IF_UNIQUE", columns={"INSTANCE_ID", "FILE_NAME"})}, indexes={@ORM\Index(name="REPORTING_IF_INST_ID", columns={"INSTANCE_ID"})})
 * @ORM\Entity(readOnly=true)
 */
class InventoryFiles
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
     * @var string
     *
     * @ORM\Column(name="FILE_TYPE", type="string", length=50, nullable=false)
     */
    private $fileType;

    /**
     * @var string
     *
     * @ORM\Column(name="FILE_NAME", type="string", length=255, nullable=false)
     */
    private $fileName;

    /**
     * @var string
     *
     * @ORM\Column(name="FILE_BASENAME", type="string", length=255, nullable=false)
     */
    private $fileBasename;

    /**
     * @var string
     *
     * @ORM\Column(name="FILE_DIRECTORY", type="string", length=255, nullable=false)
     */
    private $fileDirectory;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="FILE_CREATED", type="datetime", nullable=true)
     */
    private $fileCreated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="FILE_MODIFIED", type="datetime", nullable=true)
     */
    private $fileModified;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="FILE_LOCAL_CREATED", type="datetime", nullable=true)
     */
    private $fileLocalCreated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="FILE_LOCAL_MODIFIED", type="datetime", nullable=true)
     */
    private $fileLocalModified;

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
     * @return InventoryFiles
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
     * Set fileType
     *
     * @param string $fileType
     * @return InventoryFiles
     */
    public function setFileType($fileType)
    {
        $this->fileType = $fileType;

        return $this;
    }

    /**
     * Get fileType
     *
     * @return string 
     */
    public function getFileType()
    {
        return $this->fileType;
    }

    /**
     * Set fileName
     *
     * @param string $fileName
     * @return InventoryFiles
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string 
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set fileBasename
     *
     * @param string $fileBasename
     * @return InventoryFiles
     */
    public function setFileBasename($fileBasename)
    {
        $this->fileBasename = $fileBasename;

        return $this;
    }

    /**
     * Get fileBasename
     *
     * @return string 
     */
    public function getFileBasename()
    {
        return $this->fileBasename;
    }

    /**
     * Set fileDirectory
     *
     * @param string $fileDirectory
     * @return InventoryFiles
     */
    public function setFileDirectory($fileDirectory)
    {
        $this->fileDirectory = $fileDirectory;

        return $this;
    }

    /**
     * Get fileDirectory
     *
     * @return string 
     */
    public function getFileDirectory()
    {
        return $this->fileDirectory;
    }

    /**
     * Set fileCreated
     *
     * @param \DateTime $fileCreated
     * @return InventoryFiles
     */
    public function setFileCreated($fileCreated)
    {
        $this->fileCreated = $fileCreated;

        return $this;
    }

    /**
     * Get fileCreated
     *
     * @return \DateTime 
     */
    public function getFileCreated()
    {
        return $this->fileCreated;
    }

    /**
     * Set fileModified
     *
     * @param \DateTime $fileModified
     * @return InventoryFiles
     */
    public function setFileModified($fileModified)
    {
        $this->fileModified = $fileModified;

        return $this;
    }

    /**
     * Get fileModified
     *
     * @return \DateTime 
     */
    public function getFileModified()
    {
        return $this->fileModified;
    }

    /**
     * Set fileLocalCreated
     *
     * @param \DateTime $fileLocalCreated
     * @return InventoryFiles
     */
    public function setFileLocalCreated($fileLocalCreated)
    {
        $this->fileLocalCreated = $fileLocalCreated;

        return $this;
    }

    /**
     * Get fileLocalCreated
     *
     * @return \DateTime 
     */
    public function getFileLocalCreated()
    {
        return $this->fileLocalCreated;
    }

    /**
     * Set fileLocalModified
     *
     * @param \DateTime $fileLocalModified
     * @return InventoryFiles
     */
    public function setFileLocalModified($fileLocalModified)
    {
        $this->fileLocalModified = $fileLocalModified;

        return $this;
    }

    /**
     * Get fileLocalModified
     *
     * @return \DateTime 
     */
    public function getFileLocalModified()
    {
        return $this->fileLocalModified;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return InventoryFiles
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
     * @return InventoryFiles
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
}
