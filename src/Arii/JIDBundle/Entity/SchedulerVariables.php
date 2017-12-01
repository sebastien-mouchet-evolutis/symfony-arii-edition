<?php

namespace Arii\JIDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SchedulerVariables
 *
 * @ORM\Table(name="scheduler_variables")
 * @ORM\Entity(readOnly=true)
 */
class SchedulerVariables
{
    /**
     * @var string
     *
     * @ORM\Column(name="NAME", type="string", length=100, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="WERT", type="integer", nullable=true)
     */
    private $wert;

    /**
     * @var string
     *
     * @ORM\Column(name="TEXTWERT", type="string", length=250, nullable=true)
     */
    private $textwert;



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
     * Set wert
     *
     * @param integer $wert
     * @return SchedulerVariables
     */
    public function setWert($wert)
    {
        $this->wert = $wert;

        return $this;
    }

    /**
     * Get wert
     *
     * @return integer 
     */
    public function getWert()
    {
        return $this->wert;
    }

    /**
     * Set textwert
     *
     * @param string $textwert
     * @return SchedulerVariables
     */
    public function setTextwert($textwert)
    {
        $this->textwert = $textwert;

        return $this;
    }

    /**
     * Get textwert
     *
     * @return string 
     */
    public function getTextwert()
    {
        return $this->textwert;
    }
}
