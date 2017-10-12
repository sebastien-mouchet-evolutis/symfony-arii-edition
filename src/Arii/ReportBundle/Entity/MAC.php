<?php

namespace Arii\ReportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Audit
 *
 * @ORM\Table(name="IMPORT_MAC")
 * @ORM\Entity(repositoryClass="Arii\ReportBundle\Entity\MACRepository")
 */
class MAC
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
     * @var string
     *
     * @ORM\Column(name="oui", type="string", length=8)
     */
    private $oui;

    /**
     * @var string
     *
     * @ORM\Column(name="vendor", type="string", length=128, nullable=true)
     */
    private $vendor;
    
    /**
     * @var string
     *
     * @ORM\Column(name="short", type="string", length=256, nullable=true)
     */
    private $short;
    

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
     * Set oui
     *
     * @param string $oui
     * @return MAC
     */
    public function setOui($oui)
    {
        $this->oui = $oui;

        return $this;
    }

    /**
     * Get oui
     *
     * @return string 
     */
    public function getOui()
    {
        return $this->oui;
    }

    /**
     * Set vendor
     *
     * @param string $vendor
     * @return MAC
     */
    public function setVendor($vendor)
    {
        $this->vendor = $vendor;

        return $this;
    }

    /**
     * Get vendor
     *
     * @return string 
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * Set short
     *
     * @param string $short
     * @return MAC
     */
    public function setShort($short)
    {
        $this->short = $short;

        return $this;
    }

    /**
     * Get short
     *
     * @return string 
     */
    public function getShort()
    {
        return $this->short;
    }
}
