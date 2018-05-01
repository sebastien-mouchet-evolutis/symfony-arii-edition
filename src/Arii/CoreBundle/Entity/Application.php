<?php
namespace Arii\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Autosys
 *
 * @ORM\Table(name="ARII_APPLICATION")
 * @ORM\Entity(repositoryClass="Arii\CoreBundle\Entity\ApplicationRepository")
 * 
 *
 * @SWG\Definition()
 * 
 */
class Application
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    private $id;

    /**
     * Nom court ou code de l'application
     * @var string
     * @SWG\Property(description="The product short name")
     *
     * @ORM\Column(name="name", type="string", length=12, unique=true)
     * 
     * @Assert\NotBlank(groups={"Create"})
     */
    private $name;

    /**
     * Titre de l'application
     * @var string
     * @SWG\Property(description="The product short description")
     *
     * @ORM\Column(name="title", type="string", length=64, nullable=true)
     * 
     */
    private $title;

    /**
     * Description de l'application
     * 
     * @var string
     * @SWG\Property(description="The application description")
     *
     * @ORM\Column(name="description", type="string", length=1024, nullable=true)
     */
    private $description;

    /**
     * Catégorie de l'application
     * 
     * @var string
     * @SWG\Property(description="The application category")
     *
     * @ORM\ManyToOne(targetEntity="Arii\CoreBundle\Entity\Category")
     * @ORM\JoinColumn(nullable=true)
     **/
    private $category;

    /**
     * Contacts
     * 
     * @var string
     * @SWG\Property(description="List of contacts.")
     *
     * @ORM\Column(name="contact", type="string", length=255, nullable=true)
     */
    private $contact;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=true)
     */
    private $created;

    /**
     * @var boolean
     * @SWG\Property(description="Applivation activated or not")
     *
     * @ORM\Column(name="active", type="boolean", nullable=true )
     */        
    private $active=1;
    
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
     * @return APP
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
     * @return APP
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
     * Set contact
     *
     * @param string $description
     * @return APP
     */
    public function setContact($contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return string 
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return APP
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
     * Set created
     *
     * @param \DateTime $created
     * @return APP
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
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
     * Set active
     *
     * @param boolean $active
     * @return Alerts
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    
}
