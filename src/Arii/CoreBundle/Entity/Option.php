<?php

namespace Arii\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Audit
 *
 * @ORM\Table(name="ARII_OPTION")
 * @ORM\Entity
 */
class Option
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
    
    // a supprimer dans le futur
    /**
     * @var string
     *
     * @ORM\Column(name="domain", type="string", length=20)
     */
    private $domain;

    /**
     * @ORM\ManyToOne(targetEntity="Arii\CoreBundle\Entity\Option")
     * @ORM\JoinColumn(nullable=true)
     **/
    private $parent;

    /**
     * Set id
     *
     * @param integer $id
     * @return Choice
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

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
     * @return Choice
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
     * @return Choice
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
     * Set domain
     *
     * @param string $domain
     * @return Choice
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Get domain
     *
     * @return string 
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Set parent
     *
     * @param \Arii\CoreBundle\Entity\Option $parent
     * @return Option
     */
    public function setParent(\Arii\CoreBundle\Entity\Option $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Arii\CoreBundle\Entity\Option 
     */
    public function getParent()
    {
        return $this->parent;
    }
}
