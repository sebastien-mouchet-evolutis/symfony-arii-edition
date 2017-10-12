<?php

namespace Arii\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Team_Right
 *
 * @ORM\Table(name="ARII_TEAM__FILTER")
 * @ORM\Entity
 */
class TeamFilter
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
     * @ORM\ManyToOne(targetEntity="Arii\CoreBundle\Entity\Team")
     * @ORM\JoinColumn(nullable=false)
     */
    private $team;

    /**
     * @ORM\ManyToOne(targetEntity="Arii\CoreBundle\Entity\Filter")
     * @ORM\JoinColumn(nullable=false)
     **/
    private $filter;
    
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=100, nullable=true)
     */
    private $title;
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;
 
    /**
     * @var boolean
     *
     * @ORM\Column(name="R", type="boolean")
     */
    private $R;

    /**
     * @var boolean
     *
     * @ORM\Column(name="W", type="boolean")
     */
    private $W;

    /**
     * @var boolean
     *
     * @ORM\Column(name="X", type="boolean")
     */
    private $X;


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
     * @return TeamFilter
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
     * @return TeamFilter
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
     * @return TeamFilter
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
     * Set R
     *
     * @param boolean $r
     * @return TeamFilter
     */
    public function setR($r)
    {
        $this->R = $r;

        return $this;
    }

    /**
     * Get R
     *
     * @return boolean 
     */
    public function getR()
    {
        return $this->R;
    }

    /**
     * Set W
     *
     * @param boolean $w
     * @return TeamFilter
     */
    public function setW($w)
    {
        $this->W = $w;

        return $this;
    }

    /**
     * Get W
     *
     * @return boolean 
     */
    public function getW()
    {
        return $this->W;
    }

    /**
     * Set X
     *
     * @param boolean $x
     * @return TeamFilter
     */
    public function setX($x)
    {
        $this->X = $x;

        return $this;
    }

    /**
     * Get X
     *
     * @return boolean 
     */
    public function getX()
    {
        return $this->X;
    }

    /**
     * Set team
     *
     * @param \Arii\CoreBundle\Entity\Team $team
     * @return TeamFilter
     */
    public function setTeam(\Arii\CoreBundle\Entity\Team $team = null)
    {
        $this->team = $team;

        return $this;
    }

    /**
     * Get team
     *
     * @return \Arii\CoreBundle\Entity\Team 
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Set filter
     *
     * @param \Arii\CoreBundle\Entity\Filter $filter
     * @return TeamFilter
     */
    public function setFilter(\Arii\CoreBundle\Entity\Filter $filter)
    {
        $this->filter = $filter;

        return $this;
    }

    /**
     * Get filter
     *
     * @return \Arii\CoreBundle\Entity\Filter 
     */
    public function getFilter()
    {
        return $this->filter;
    }
}
