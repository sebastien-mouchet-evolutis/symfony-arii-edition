<?php

namespace Arii\ReportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Audit
 *
 * @ORM\Table(name="REPORT_BOX")
 * @ORM\Entity(repositoryClass="Arii\ReportBundle\Entity\BOXRepository")
 */
class BOX
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
     * @ORM\Column(name="box_name", type="string", length=32)
     */
    private $box_name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

// organisation
    /**
     * @ORM\ManyToOne(targetEntity="Arii\ReportBundle\Entity\BOX")
     * @ORM\JoinColumn(nullable=true)
     **/
    private $box;
            
// heritage
    /**
     * @ORM\OneToOne(targetEntity="Arii\ReportBundle\Entity\JOB")
     * @ORM\JoinColumn(nullable=true)
     **/
    private $job;

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
     * Set box_name
     *
     * @param string $boxName
     * @return BOX
     */
    public function setBoxName($boxName)
    {
        $this->box_name = $boxName;

        return $this;
    }

    /**
     * Get box_name
     *
     * @return string 
     */
    public function getBoxName()
    {
        return $this->box_name;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return BOX
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set box
     *
     * @param \Arii\ReportBundle\Entity\BOX $box
     * @return BOX
     */
    public function setBox(\Arii\ReportBundle\Entity\BOX $box = null)
    {
        $this->box = $box;

        return $this;
    }

    /**
     * Get box
     *
     * @return \Arii\ReportBundle\Entity\BOX 
     */
    public function getBox()
    {
        return $this->box;
    }

    /**
     * Set job
     *
     * @param \Arii\ReportBundle\Entity\JOB $job
     * @return BOX
     */
    public function setJob(\Arii\ReportBundle\Entity\JOB $job = null)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Get job
     *
     * @return \Arii\ReportBundle\Entity\JOB 
     */
    public function getJob()
    {
        return $this->job;
    }
}
