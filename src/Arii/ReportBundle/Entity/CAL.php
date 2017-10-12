<?php

namespace Arii\ReportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Audit
 *
 * @ORM\Table(name="REPORT_CAL")
 * @ORM\Entity(repositoryClass="Arii\ReportBundle\Entity\CALRepository")
 */
class CAL
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
     * @ORM\Column(name="spooler_name", type="string", length=20)
     */
    private $spooler_name;

    /**
     * @var string
     *
     * @ORM\Column(name="spooler_type", type="string", length=10)
     */
    private $spooler_type;
    
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var datetime
     *
     * @ORM\Column(name="day", type="datetime")
     */
    private $day;

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
     * Set spooler_name
     *
     * @param string $spoolerName
     * @return CAL
     */
    public function setSpoolerName($spoolerName)
    {
        $this->spooler_name = $spoolerName;

        return $this;
    }

    /**
     * Get spooler_name
     *
     * @return string 
     */
    public function getSpoolerName()
    {
        return $this->spooler_name;
    }

    /**
     * Set spooler_type
     *
     * @param string $spoolerType
     * @return CAL
     */
    public function setSpoolerType($spoolerType)
    {
        $this->spooler_type = $spoolerType;

        return $this;
    }

    /**
     * Get spooler_type
     *
     * @return string 
     */
    public function getSpoolerType()
    {
        return $this->spooler_type;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return CAL
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set day
     *
     * @param \DateTime $day
     * @return CAL
     */
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get day
     *
     * @return \DateTime 
     */
    public function getDay()
    {
        return $this->day;
    }
}
