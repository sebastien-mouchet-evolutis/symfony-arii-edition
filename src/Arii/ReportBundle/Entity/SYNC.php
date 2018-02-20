<?php

namespace Arii\ReportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SYNC
 *
 * @ORM\Table(name="REPORT_SYNC")
 * @ORM\Entity
 */
class SYNC
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
     * @ORM\Column(name="db_name", type="string", length=128)
     */
    private $name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="db_entity", type="string", length=64)
     */
    private $entity;

    /**
     * @var bigint
     *
     * @ORM\Column(name="last_id", type="bigint")
     */
    private $last_id;

    /**
     * @var datetime
     *
     * @ORM\Column(name="last_update", type="datetime")
     */
    private $last_update;
    

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
     * @return SYNC
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
     * Set entity
     *
     * @param string $entity
     * @return SYNC
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * Get entity
     *
     * @return string 
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Set last_id
     *
     * @param integer $lastId
     * @return SYNC
     */
    public function setLastId($lastId)
    {
        $this->last_id = $lastId;

        return $this;
    }

    /**
     * Get last_id
     *
     * @return integer 
     */
    public function getLastId()
    {
        return $this->last_id;
    }

    /**
     * Set last_update
     *
     * @param \DateTime $lastUpdate
     * @return SYNC
     */
    public function setLastUpdate($lastUpdate)
    {
        $this->last_update = $lastUpdate;

        return $this;
    }

    /**
     * Get last_update
     *
     * @return \DateTime 
     */
    public function getLastUpdate()
    {
        return $this->last_update;
    }
}
