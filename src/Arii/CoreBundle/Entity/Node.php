<?php

namespace Arii\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Node
 *
 * @ORM\Table(name="ARII_NODE")
 * @ORM\Entity(repositoryClass="Arii\CoreBundle\Entity\NodeRepository")
 */
class Node
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
     * @ORM\Column(name="title", type="string", length=128)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="Arii\CoreBundle\Entity\Category")
     * @ORM\JoinColumn(nullable=true)
     **/
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;
    
    /**
     * @var string
     *
     * @ORM\Column(name="component", type="string", length=32, nullable=true)
     */
    private $component;

    /**
     * @var string
     *
     * @ORM\Column(name="vendor", type="string", length=32, nullable=true)
     */
    private $vendor;
    
    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=255, nullable=true)
     * @ORM\JoinColumn(nullable=true)
     */
    private $role;

    /**
     * @ORM\ManyToOne(targetEntity="Arii\CoreBundle\Entity\Site")
     * @ORM\JoinColumn(nullable=true)
     *      
     */
    private $site;

    /**
     * @var string
     *
     * @ORM\Column(name="status_date", type="datetime" )
     */
    private $status_date;
    
    /**
     * @var status
     *
     * @ORM\Column(name="status", type="string", length=16)
     */
    private $status;    

    /**
     * @ORM\ManyToOne(targetEntity="Arii\CoreBundle\Entity\Cluster")
     * @ORM\JoinColumn(nullable=true)
     **/
    private $cluster;
    

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
     * @return Node
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
     * Set title
     *
     * @param string $title
     * @return Node
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Node
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
     * Set component
     *
     * @param string $component
     * @return Node
     */
    public function setComponent($component)
    {
        $this->component = $component;

        return $this;
    }

    /**
     * Get component
     *
     * @return string 
     */
    public function getComponent()
    {
        return $this->component;
    }

    /**
     * Set vendor
     *
     * @param string $vendor
     * @return Node
     */
    public function setVendor($vendor)
    {
        $this->vendor = $vendor;

        return $this;
    }

    /**
     * Get vendor
     *
     * @return string 
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * Set role
     *
     * @param string $role
     * @return Node
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
     * Set status_date
     *
     * @param \DateTime $statusDate
     * @return Node
     */
    public function setStatusDate($statusDate)
    {
        $this->status_date = $statusDate;

        return $this;
    }

    /**
     * Get status_date
     *
     * @return \DateTime 
     */
    public function getStatusDate()
    {
        return $this->status_date;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Node
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
     * Set category
     *
     * @param \Arii\CoreBundle\Entity\Category $category
     * @return Node
     */
    public function setCategory(\Arii\CoreBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Arii\CoreBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set site
     *
     * @param \Arii\CoreBundle\Entity\Site $site
     * @return Node
     */
    public function setSite(\Arii\CoreBundle\Entity\Site $site = null)
    {
        $this->site = $site;

        return $this;
    }

    /**
     * Get site
     *
     * @return \Arii\CoreBundle\Entity\Site 
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Set cluster
     *
     * @param \Arii\CoreBundle\Entity\Cluster $cluster
     * @return Node
     */
    public function setCluster(\Arii\CoreBundle\Entity\Cluster $cluster = null)
    {
        $this->cluster = $cluster;

        return $this;
    }

    /**
     * Get cluster
     *
     * @return \Arii\CoreBundle\Entity\Cluster 
     */
    public function getCluster()
    {
        return $this->cluster;
    }
}
