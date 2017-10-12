<?php

namespace Arii\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="ARII_DATABASE")
 * @ORM\Entity(repositoryClass="Arii\CoreBundle\Entity\DatabaseRepository")
 */
class Database
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
     * @ORM\Column(name="name", type="string", length=32, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=16)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=128,nullable=true)
     */
    private $role;

    /**
     * @var string
     *
     * @ORM\Column(name="driver", type="string", length=16)
     */
    private $driver;

    /**
     * @var string
     *
     * @ORM\Column(name="dbname", type="string", length=32,nullable=true)
     */
    private $dbname;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255,nullable=true)
     */
    private $description;

    /**
    * @ORM\OneToOne(targetEntity="Arii\CoreBundle\Entity\Connection")
    * @ORM\JoinColumn(nullable=true)
    */
    private $connection;

    /**
    * @ORM\OneToOne(targetEntity="Arii\CoreBundle\Entity\Database")
    * @ORM\JoinColumn(nullable=true)
    */
    private $backup;


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
     * @return Database
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
     * Set type
     *
     * @param string $type
     * @return Database
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set role
     *
     * @param string $role
     * @return Database
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string 
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set driver
     *
     * @param string $driver
     * @return Database
     */
    public function setDriver($driver)
    {
        $this->driver = $driver;

        return $this;
    }

    /**
     * Get driver
     *
     * @return string 
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * Set dbname
     *
     * @param string $dbname
     * @return Database
     */
    public function setDbname($dbname)
    {
        $this->dbname = $dbname;

        return $this;
    }

    /**
     * Get dbname
     *
     * @return string 
     */
    public function getDbname()
    {
        return $this->dbname;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Database
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set connection
     *
     * @param \Arii\CoreBundle\Entity\Connection $connection
     * @return Database
     */
    public function setConnection(\Arii\CoreBundle\Entity\Connection $connection = null)
    {
        $this->connection = $connection;

        return $this;
    }

    /**
     * Get connection
     *
     * @return \Arii\CoreBundle\Entity\Connection 
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Set backup
     *
     * @param \Arii\CoreBundle\Entity\Database $backup
     * @return Database
     */
    public function setBackup(\Arii\CoreBundle\Entity\Database $backup = null)
    {
        $this->backup = $backup;

        return $this;
    }

    /**
     * Get backup
     *
     * @return \Arii\CoreBundle\Entity\Database 
     */
    public function getBackup()
    {
        return $this->backup;
    }
}
