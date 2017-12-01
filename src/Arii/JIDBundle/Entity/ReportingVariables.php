<?php

namespace Arii\JIDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReportingVariables
 *
 * @ORM\Table(name="reporting_variables")
 * @ORM\Entity(readOnly=true)
 */
class ReportingVariables
{
    /**
     * @var string
     *
     * @ORM\Column(name="NAME", type="string", length=255, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="NUMERIC_VALUE", type="integer", nullable=true)
     */
    private $numericValue;

    /**
     * @var string
     *
     * @ORM\Column(name="TEXT_VALUE", type="string", length=255, nullable=true)
     */
    private $textValue;

    /**
     * @var integer
     *
     * @ORM\Column(name="LOCK_VERSION", type="integer", nullable=false)
     */
    private $lockVersion;



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
     * Set numericValue
     *
     * @param integer $numericValue
     * @return ReportingVariables
     */
    public function setNumericValue($numericValue)
    {
        $this->numericValue = $numericValue;

        return $this;
    }

    /**
     * Get numericValue
     *
     * @return integer 
     */
    public function getNumericValue()
    {
        return $this->numericValue;
    }

    /**
     * Set textValue
     *
     * @param string $textValue
     * @return ReportingVariables
     */
    public function setTextValue($textValue)
    {
        $this->textValue = $textValue;

        return $this;
    }

    /**
     * Get textValue
     *
     * @return string 
     */
    public function getTextValue()
    {
        return $this->textValue;
    }

    /**
     * Set lockVersion
     *
     * @param integer $lockVersion
     * @return ReportingVariables
     */
    public function setLockVersion($lockVersion)
    {
        $this->lockVersion = $lockVersion;

        return $this;
    }

    /**
     * Get lockVersion
     *
     * @return integer 
     */
    public function getLockVersion()
    {
        return $this->lockVersion;
    }
}
