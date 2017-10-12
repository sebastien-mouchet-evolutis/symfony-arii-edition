<?php

namespace Arii\JOCBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Payloads
 *
 * @ORM\Table(name="JOC_PAYLOADS")
 * @ORM\Entity
 */
class Payloads
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
     * @ORM\ManyToOne(targetEntity="Arii\JOCBundle\Entity\Orders")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     **/
    private $order;

    /**
     * @var integer
     *
     * @ORM\Column(name="spooler_id", type="integer")
     */
    private $spooler_id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="text", nullable=true)
     */
    private $value;

    /**
     * @var datetime
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
     * Set spooler_id
     *
     * @param integer $spoolerId
     * @return Payloads
     */
    public function setSpoolerId($spoolerId)
    {
        $this->spooler_id = $spoolerId;

        return $this;
    }

    /**
     * Get spooler_id
     *
     * @return integer 
     */
    public function getSpoolerId()
    {
        return $this->spooler_id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Payloads
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
     * Set value
     *
     * @param string $value
     * @return Payloads
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Payloads
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
     * Set order
     *
     * @param \Arii\JOCBundle\Entity\Orders $order
     * @return Payloads
     */
    public function setOrder(\Arii\JOCBundle\Entity\Orders $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \Arii\JOCBundle\Entity\Orders 
     */
    public function getOrder()
    {
        return $this->order;
    }
}
