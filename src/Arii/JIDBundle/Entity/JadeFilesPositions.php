<?php

namespace Arii\JIDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JadeFilesPositions
 *
 * @ORM\Table(name="jade_files_positions", uniqueConstraints={@ORM\UniqueConstraint(name="LOCAL_FILENAME", columns={"LOCAL_FILENAME"})})
 * @ORM\Entity(readOnly=true)
 */
class JadeFilesPositions
{
    /**
     * @var string
     *
     * @ORM\Column(name="HOST", type="string", length=128, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $host;

    /**
     * @var string
     *
     * @ORM\Column(name="REMOTE_DIR", type="string", length=255, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $remoteDir;

    /**
     * @var string
     *
     * @ORM\Column(name="REMOTE_FILENAME", type="string", length=255, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $remoteFilename;

    /**
     * @var string
     *
     * @ORM\Column(name="LOCAL_FILENAME", type="string", length=255, nullable=false)
     */
    private $localFilename;

    /**
     * @var integer
     *
     * @ORM\Column(name="FILE_SIZE", type="bigint", nullable=false)
     */
    private $fileSize;

    /**
     * @var integer
     *
     * @ORM\Column(name="POSITION", type="integer", nullable=false)
     */
    private $position;



    /**
     * Set host
     *
     * @param string $host
     * @return JadeFilesPositions
     */
    public function setHost($host)
    {
        $this->host = $host;

        return $this;
    }

    /**
     * Get host
     *
     * @return string 
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Set remoteDir
     *
     * @param string $remoteDir
     * @return JadeFilesPositions
     */
    public function setRemoteDir($remoteDir)
    {
        $this->remoteDir = $remoteDir;

        return $this;
    }

    /**
     * Get remoteDir
     *
     * @return string 
     */
    public function getRemoteDir()
    {
        return $this->remoteDir;
    }

    /**
     * Set remoteFilename
     *
     * @param string $remoteFilename
     * @return JadeFilesPositions
     */
    public function setRemoteFilename($remoteFilename)
    {
        $this->remoteFilename = $remoteFilename;

        return $this;
    }

    /**
     * Get remoteFilename
     *
     * @return string 
     */
    public function getRemoteFilename()
    {
        return $this->remoteFilename;
    }

    /**
     * Set localFilename
     *
     * @param string $localFilename
     * @return JadeFilesPositions
     */
    public function setLocalFilename($localFilename)
    {
        $this->localFilename = $localFilename;

        return $this;
    }

    /**
     * Get localFilename
     *
     * @return string 
     */
    public function getLocalFilename()
    {
        return $this->localFilename;
    }

    /**
     * Set fileSize
     *
     * @param integer $fileSize
     * @return JadeFilesPositions
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
     * Set position
     *
     * @param integer $position
     * @return JadeFilesPositions
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }
}
