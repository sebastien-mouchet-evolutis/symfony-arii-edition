<?php

namespace Arii\ReportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Audit
 *
 * @ORM\Table(name="REPORT_BKP_ARC")
 * @ORM\Entity(repositoryClass="Arii\ReportBundle\Entity\BKP_ARCRepository")
 */
class BKP_ARC
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
     * @ORM\ManyToOne(targetEntity="Arii\ReportBundle\Entity\BKP_BAK",cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     **/
    private $bkp_bak;

    /**
     * @var string
     *
     * @ORM\Column(name="id_archive", type="string", length=32)
     */
    private $id_archive;
    
    /**
     * @var bigint
     *
     * @ORM\Column(name="arc_size", type="bigint" )
     */
    private $arc_size;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="copytime", type="integer", nullable=true )
     */
    private $copytime;
    
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
     * Set copytime
     *
     * @param integer $copytime
     * @return BKP_ARC
     */
    public function setCopytime($copytime)
    {
        $this->copytime = $copytime;

        return $this;
    }

    /**
     * Get copytime
     *
     * @return integer 
     */
    public function getCopytime()
    {
        return $this->copytime;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return BKP_ARC
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
     * @return BKP_ARC
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
     * Set updated
     *
     * @param \DateTime $updated
     * @return BKP_ARC
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
     * @return BKP_REF
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

    /**
     * Set bkp_bak
     *
     * @param \Arii\ReportBundle\Entity\BKP_BAK $bkpBak
     * @return BKP_ARC
     */
    public function setBkpBak(\Arii\ReportBundle\Entity\BKP_BAK $bkpBak = null)
    {
        $this->bkp_bak = $bkpBak;

        return $this;
    }

    /**
     * Get bkp_bak
     *
     * @return \Arii\ReportBundle\Entity\BKP_BAK 
     */
    public function getBkpBak()
    {
        return $this->bkp_bak;
    }

    /**
     * Set arc_size
     *
     * @param integer $arcSize
     * @return BKP_ARC
     */
    public function setArcSize($arcSize)
    {
        $this->arc_size = $arcSize;

        return $this;
    }

    /**
     * Get arc_size
     *
     * @return integer 
     */
    public function getArcSize()
    {
        return $this->arc_size;
    }

    /**
     * Set id_archive
     *
     * @param string $idArchive
     * @return BKP_ARC
     */
    public function setIdArchive($idArchive)
    {
        $this->id_archive = $idArchive;

        return $this;
    }

    /**
     * Get id_archive
     *
     * @return string 
     */
    public function getIdArchive()
    {
        return $this->id_archive;
    }
}
