<?php

namespace Arii\JIDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReportMapCauses
 *
 * @ORM\Table(name="report_map_causes", indexes={@ORM\Index(name="REPORTING_RMC", columns={"CAUSE"})})
 * @ORM\Entity(readOnly=true)
 */
class ReportMapCauses
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
     * @ORM\Column(name="CAUSE", type="string", length=100, nullable=false)
     */
    private $cause;

    /**
     * @var string
     *
     * @ORM\Column(name="MAPPED_CAUSE", type="string", length=255, nullable=false)
     */
    private $mappedCause;

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
     * Set cause
     *
     * @param string $cause
     * @return ReportMapCauses
     */
    public function setCause($cause)
    {
        $this->cause = $cause;

        return $this;
    }

    /**
     * Get cause
     *
     * @return string 
     */
    public function getCause()
    {
        return $this->cause;
    }

    /**
     * Set mappedCause
     *
     * @param string $mappedCause
     * @return ReportMapCauses
     */
    public function setMappedCause($mappedCause)
    {
        $this->mappedCause = $mappedCause;

        return $this;
    }

    /**
     * Get mappedCause
     *
     * @return string 
     */
    public function getMappedCause()
    {
        return $this->mappedCause;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return ReportMapCauses
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
     * @return ReportMapCauses
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
