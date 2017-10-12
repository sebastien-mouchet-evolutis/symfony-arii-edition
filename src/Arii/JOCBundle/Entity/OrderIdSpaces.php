<?php

namespace Arii\JOCBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * lock_use
 *
 * @ORM\Table(name="JOC_ORDER_ID_SPACES")
 * @ORM\Entity(repositoryClass="Arii\JOCBundle\Entity\OrderIdSpacesRepository")
 */
class OrderIdSpaces
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
     * @ORM\Column(name="name", type="string", length=32, nullable=true)
     **/
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Arii\JOCBundle\Entity\JobChains")
     * @ORM\JoinColumn(name="job_chain_id", onDelete="CASCADE")
     * 
     **/
    private $job_chain;

    /**
     * @var integer
     *
     * @ORM\Column(name="spooler_id", type="integer")
     */
    private $spooler_id;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="updated", type="integer")
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
     * Set name
     *
     * @param string $name
     * @return OrderIdSpaces
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
     * Set spooler_id
     *
     * @param integer $spoolerId
     * @return OrderIdSpaces
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
     * Set updated
     *
     * @param integer $updated
     * @return OrderIdSpaces
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return integer 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set job_chain
     *
     * @param \Arii\JOCBundle\Entity\JobChains $jobChain
     * @return OrderIdSpaces
     */
    public function setJobChain(\Arii\JOCBundle\Entity\JobChains $jobChain = null)
    {
        $this->job_chain = $jobChain;

        return $this;
    }

    /**
     * Get job_chain
     *
     * @return \Arii\JOCBundle\Entity\JobChains 
     */
    public function getJobChain()
    {
        return $this->job_chain;
    }
}
