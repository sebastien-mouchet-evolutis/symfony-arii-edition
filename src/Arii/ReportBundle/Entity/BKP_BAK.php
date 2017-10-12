<?php

namespace Arii\ReportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Audit
 *
 * @ORM\Table(name="REPORT_BKP_BAK")
 * @ORM\Entity(repositoryClass="Arii\ReportBundle\Entity\BKP_BAKRepository")
 */
class BKP_BAK
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
     * @ORM\ManyToOne(targetEntity="Arii\ReportBundle\Entity\BKP_REF",cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     **/
    private $bkp_ref;
    
    /**
     * @var string
     *
     * @ORM\Column(name="file_name", type="string", length=128)
     */
    private $file_name;

    /**
     * @var string
     *
     * @ORM\Column(name="log_file", type="string", length=255)
     */
    private $log_file;

    /**
     * @var bigint
     *
     * @ORM\Column(name="bkp_size", type="bigint" )
     */
    private $bkp_size;

    /**
     * @var float
     *
     * @ORM\Column(name="bkp_duration", type="float" )
     */
    private $bkp_duration;

    /**
     * @var integer
     *
     * @ORM\Column(name="bkp_pages", type="integer" )
     */
    private $bkp_pages;
    
    /**
     * @var float
     *
     * @ORM\Column(name="bkp_speed", type="float" )
     */
    private $bkp_speed;

    /**
     * @var boolean
     *
     * @ORM\Column(name="valid", type="boolean")
     */
    private $valid;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deleted", type="datetime", nullable=true)
     */
    private $deleted;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="archived", type="boolean", nullable=true)
     */
    private $archived;

    /**
     * @var \DateTime
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
     * Set file_name
     *
     * @param string $fileName
     * @return BKP_BAK
     */
    public function setFileName($fileName)
    {
        $this->file_name = $fileName;

        return $this;
    }

    /**
     * Get file_name
     *
     * @return string 
     */
    public function getFileName()
    {
        return $this->file_name;
    }

    /**
     * Set log_file
     *
     * @param string $logFile
     * @return BKP_BAK
     */
    public function setLogFile($logFile)
    {
        $this->log_file = $logFile;

        return $this;
    }

    /**
     * Get log_file
     *
     * @return string 
     */
    public function getLogFile()
    {
        return $this->log_file;
    }

    /**
     * Set bkp_size
     *
     * @param integer $bkpSize
     * @return BKP_BAK
     */
    public function setBkpSize($bkpSize)
    {
        $this->bkp_size = $bkpSize;

        return $this;
    }

    /**
     * Get bkp_size
     *
     * @return integer 
     */
    public function getBkpSize()
    {
        return $this->bkp_size;
    }

    /**
     * Set bkp_duration
     *
     * @param integer $bkpDuration
     * @return BKP_BAK
     */
    public function setBkpDuration($bkpDuration)
    {
        $this->bkp_duration = $bkpDuration;

        return $this;
    }

    /**
     * Get bkp_duration
     *
     * @return integer 
     */
    public function getBkpDuration()
    {
        return $this->bkp_duration;
    }

    /**
     * Set bkp_pages
     *
     * @param integer $bkpPages
     * @return BKP_BAK
     */
    public function setBkpPages($bkpPages)
    {
        $this->bkp_pages = $bkpPages;

        return $this;
    }

    /**
     * Get bkp_pages
     *
     * @return integer 
     */
    public function getBkpPages()
    {
        return $this->bkp_pages;
    }

    /**
     * Set bkp_speed
     *
     * @param integer $bkpSpeed
     * @return BKP_BAK
     */
    public function setBkpSpeed($bkpSpeed)
    {
        $this->bkp_speed = $bkpSpeed;

        return $this;
    }

    /**
     * Get bkp_speed
     *
     * @return integer 
     */
    public function getBkpSpeed()
    {
        return $this->bkp_speed;
    }

    /**
     * Set valid
     *
     * @param boolean $valid
     * @return BKP_BAK
     */
    public function setValid($valid)
    {
        $this->valid = $valid;

        return $this;
    }

    /**
     * Get valid
     *
     * @return boolean 
     */
    public function getValid()
    {
        return $this->valid;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return BKP_BAK
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
     * Set deleted
     *
     * @param \DateTime $deleted
     * @return BKP_BAK
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return \DateTime 
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set archived
     *
     * @param boolean $archived
     * @return BKP_BAK
     */
    public function setArchived($archived)
    {
        $this->archived = $archived;

        return $this;
    }

    /**
     * Get archived
     *
     * @return boolean 
     */
    public function getArchived()
    {
        return $this->archived;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return BKP_BAK
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
     * Set bkp_ref
     *
     * @param \Arii\ReportBundle\Entity\BKP_REF $bkpRef
     * @return BKP_BAK
     */
    public function setBkpRef(\Arii\ReportBundle\Entity\BKP_REF $bkpRef = null)
    {
        $this->bkp_ref = $bkpRef;

        return $this;
    }

    /**
     * Get bkp_ref
     *
     * @return \Arii\ReportBundle\Entity\BKP_REF 
     */
    public function getBkpRef()
    {
        return $this->bkp_ref;
    }
}
