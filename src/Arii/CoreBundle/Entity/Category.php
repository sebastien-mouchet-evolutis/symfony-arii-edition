<?php

namespace Arii\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;

/**
 * Category
 *
 * @ORM\Table(name="ARII_CATEGORY")
 * @ORM\Entity
 * 
 * @SWG\Definition()
 */
class Category
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
     * @ORM\Column(name="name", type="string", length=24, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=128, nullable=true)
     */
    private $title;
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=128, nullable=true)
     */
    private $description;

    /**
    * @ORM\ManyToOne(targetEntity="Arii\CoreBundle\Entity\Category")
    * @ORM\JoinColumn(nullable=true)
    */
    private $category;

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
     * @return Category
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
     * Set description
     *
     * @param string $description
     * @return Category
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
     * Set category
     *
     * @param \Arii\CoreBundle\Entity\Category $category
     * @return Category
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
     * Set title
     *
     * @param string $title
     * @return Category
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
}
