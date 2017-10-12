<?php

namespace Arii\ReportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Autosys
 *
 * @ORM\Table(name="REPORT_LNK")
 * @ORM\Entity(repositoryClass="Arii\ReportBundle\Entity\CNDRepository")
 */
class LNK
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
     * @ORM\OneToOne(targetEntity="Arii\ReportBundle\Entity\JOB")
     * @ORM\JoinColumn(nullable=true)
     **/
    private $source;

    /**
     * @ORM\OneToOne(targetEntity="Arii\ReportBundle\Entity\JOB")
     * @ORM\JoinColumn(nullable=true)
     **/
    private $target;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="exit_code", type="integer", length=12, nullable=true)
     */
    private $exit_code;    
        
    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=20, nullable=true)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lookback", type="datetime", nullable=true)
     */
    private $lookback;    

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
     * Set exit_code
     *
     * @param integer $exitCode
     * @return LNK
     */
    public function setExitCode($exitCode)
    {
        $this->exit_code = $exitCode;

        return $this;
    }

    /**
     * Get exit_code
     *
     * @return integer 
     */
    public function getExitCode()
    {
        return $this->exit_code;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return LNK
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
     * Set lookback
     *
     * @param \DateTime $lookback
     * @return LNK
     */
    public function setLookback($lookback)
    {
        $this->lookback = $lookback;

        return $this;
    }

    /**
     * Get lookback
     *
     * @return \DateTime 
     */
    public function getLookback()
    {
        return $this->lookback;
    }

    /**
     * Set source
     *
     * @param \Arii\ReportBundle\Entity\JOB $source
     * @return LNK
     */
    public function setSource(\Arii\ReportBundle\Entity\JOB $source = null)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return \Arii\ReportBundle\Entity\JOB 
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set target
     *
     * @param \Arii\ReportBundle\Entity\JOB $target
     * @return LNK
     */
    public function setTarget(\Arii\ReportBundle\Entity\JOB $target = null)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * Get target
     *
     * @return \Arii\ReportBundle\Entity\JOB 
     */
    public function getTarget()
    {
        return $this->target;
    }
}
