<?php

namespace Arii\ReportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Audit
 *
 * @ORM\Table(name="REPORT_BKP_REF")
 * @ORM\Entity(repositoryClass="Arii\ReportBundle\Entity\BKP_REFRepository")
 */
class BKP_REF
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
     * @ORM\Column(name="db_env", type="string", length=32)
     */
    private $db_env;
    
    /**
     * @var string
     *
     * @ORM\Column(name="db_type", type="string", length=32)
     */
    private $db_type;

    /**
     * @var string
     *
     * @ORM\Column(name="db_system", type="boolean")
     */
    private $db_system;

    /**
     * @var string
     *
     * @ORM\Column(name="db_name", type="string", length=64)
     */
    private $db_name;

    /**
     * @var string
     *
     * @ORM\Column(name="db_instance", type="string", length=32)
     */
    private $db_instance;

    /**
     * @var string
     *
     * @ORM\Column(name="db_group", type="string", length=10)
     */
    private $db_group;
    
    /**
     * @var string
     *
     * @ORM\Column(name="path_source", type="string", length=255)
     */
    private $path_source;
    
    /**
     * @var string
     *
     * @ORM\Column(name="path_destination", type="string", length=255, nullable=true)
     */
    private $path_destination;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deleted", type="datetime", nullable=true)
     */
    private $deleted;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="sinked", type="datetime", nullable=true)
     */
    private $sinked;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime")
     */
    private $updated;
    
    /**
     * @var string
     *
     * @ORM\Column(name="db_desc", type="string", length=1024, nullable=true)
     */
    private $db_desc;
        
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
     * Set db_type
     *
     * @param string $dbType
     * @return BKP_REF
     */
    public function setDbType($dbType)
    {
        $this->db_type = $dbType;

        return $this;
    }

    /**
     * Get db_type
     *
     * @return string 
     */
    public function getDbType()
    {
        return $this->db_type;
    }

    /**
     * Set db_name
     *
     * @param string $dbName
     * @return BKP_REF
     */
    public function setDbName($dbName)
    {
        $this->db_name = $dbName;

        return $this;
    }

    /**
     * Get db_name
     *
     * @return string 
     */
    public function getDbName()
    {
        return $this->db_name;
    }

    /**
     * Set db_instance
     *
     * @param string $dbInstance
     * @return BKP_REF
     */
    public function setDbInstance($dbInstance)
    {
        $this->db_instance = $dbInstance;

        return $this;
    }

    /**
     * Get db_instance
     *
     * @return string 
     */
    public function getDbInstance()
    {
        return $this->db_instance;
    }

    /**
     * Set db_group
     *
     * @param string $dbGroup
     * @return BKP_REF
     */
    public function setDbGroup($dbGroup)
    {
        $this->db_group = $dbGroup;

        return $this;
    }

    /**
     * Get db_group
     *
     * @return string 
     */
    public function getDbGroup()
    {
        return $this->db_group;
    }

    /**
     * Set path_source
     *
     * @param string $pathSource
     * @return BKP_REF
     */
    public function setPathSource($pathSource)
    {
        $this->path_source = $pathSource;

        return $this;
    }

    /**
     * Get path_source
     *
     * @return string 
     */
    public function getPathSource()
    {
        return $this->path_source;
    }

    /**
     * Set path_destination
     *
     * @param string $pathDestination
     * @return BKP_REF
     */
    public function setPathDestination($pathDestination)
    {
        $this->path_destination = $pathDestination;

        return $this;
    }

    /**
     * Get path_destination
     *
     * @return string 
     */
    public function getPathDestination()
    {
        return $this->path_destination;
    }

    /**
     * Set deleted
     *
     * @param \DateTime $deleted
     * @return BKP_REF
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return \DateTime 
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return BKP_REF
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
     * Set db_system
     *
     * @param boolean $dbSystem
     * @return BKP_REF
     */
    public function setDbSystem($dbSystem)
    {
        $this->db_system = $dbSystem;

        return $this;
    }

    /**
     * Get db_system
     *
     * @return boolean 
     */
    public function getDbSystem()
    {
        return $this->db_system;
    }

    /**
     * Set db_env
     *
     * @param string $dbEnv
     * @return BKP_REF
     */
    public function setDbEnv($dbEnv)
    {
        $this->db_env = $dbEnv;

        return $this;
    }

    /**
     * Get db_env
     *
     * @return string 
     */
    public function getDbEnv()
    {
        return $this->db_env;
    }

    /**
     * Set db_desc
     *
     * @param string $dbDesc
     * @return BKP_REF
     */
    public function setDbDesc($dbDesc)
    {
        $this->db_desc = $dbDesc;

        return $this;
    }

    /**
     * Get db_desc
     *
     * @return string 
     */
    public function getDbDesc()
    {
        return $this->db_desc;
    }

    /**
     * Set sinked
     *
     * @param \DateTime $sinked
     * @return BKP_REF
     */
    public function setSinked($sinked)
    {
        $this->sinked = $sinked;

        return $this;
    }

    /**
     * Get sinked
     *
     * @return \DateTime 
     */
    public function getSinked()
    {
        return $this->sinked;
    }

}
