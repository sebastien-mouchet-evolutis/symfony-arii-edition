<?php

namespace Arii\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NodeConnection
 *
 * @ORM\Table(name="ARII_NODE__CONNECTION")
 * @ORM\Entity()
 */
class NodeConnection
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer"  )
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Arii\CoreBundle\Entity\Node")
     * @ORM\JoinColumn(nullable=false)
     **/
    private $node;
    
    /**
     * @ORM\ManyToOne(targetEntity="Arii\CoreBundle\Entity\Connection")
     * @ORM\JoinColumn(nullable=false)
     **/
    private $connection;
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="priority", type="integer")
     */
    private $priority=0;
        
    /**
     * @var string
     *
     * @ORM\Column(name="component", type="string", length=32, nullable=true)
     */
    private $component;
    
    /**
     * @var disabled
     *
     * @ORM\Column(name="disabled", type="boolean", nullable=true)
     */
    private $disabled=false;
    

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
     * Set description
     *
     * @param string $description
     * @return NodeConnection
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
     * Set priority
     *
     * @param integer $priority
     * @return NodeConnection
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get priority
     *
     * @return integer 
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set component
     *
     * @param string $component
     * @return NodeConnection
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
     * Set disabled
     *
     * @param boolean $disabled
     * @return NodeConnection
     */
    public function setDisabled($disabled)
    {
        $this->disabled = $disabled;

        return $this;
    }

    /**
     * Get disabled
     *
     * @return boolean 
     */
    public function getDisabled()
    {
        return $this->disabled;
    }

    /**
     * Set node
     *
     * @param \Arii\CoreBundle\Entity\Node $node
     * @return NodeConnection
     */
    public function setNode(\Arii\CoreBundle\Entity\Node $node)
    {
        $this->node = $node;

        return $this;
    }

    /**
     * Get node
     *
     * @return \Arii\CoreBundle\Entity\Node 
     */
    public function getNode()
    {
        return $this->node;
    }

    /**
     * Set connection
     *
     * @param \Arii\CoreBundle\Entity\Connection $connection
     * @return NodeConnection
     */
    public function setConnection(\Arii\CoreBundle\Entity\Connection $connection)
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
}
