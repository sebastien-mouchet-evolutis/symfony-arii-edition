<?php

namespace Arii\JOCBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * state_job_chains
 *
 * @ORM\Table(name="JOC_JOB_CHAINS")
 * @ORM\Entity
 */
class JobChains
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
     * @ORM\ManyToOne(targetEntity="Arii\JOCBundle\Entity\Spoolers")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     **/
    private $spooler;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=100, nullable=true)
     */
    private $state;
    
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="order_id_space", type="string", length=32, nullable=true)
     */
    private $order_id_space;

    /**
     * @var integer
     *
     * @ORM\Column(name="orders_recoverable", type="boolean", nullable=true)
     */
    private $orders_recoverable;

    /**
     * @var smallint
     *
     * @ORM\Column(name="running_orders", type="smallint", nullable=true)
     */
    private $running_orders;

    /**
     * @var smallint
     *
     * @ORM\Column(name="max_orders", type="smallint", nullable=true)
     */
    private $max_orders;

    /**
     * @var smallint
     *
     * @ORM\Column(name="orders", type="smallint", nullable=true)
     */
    private $orders;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_write_time", type="datetime", nullable=true)
     */
    private $last_write_time;

    /**
     * @var datetime
     *
     * @ORM\Column(name="updated", type="datetime")
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
     * @return JobChains
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
     * Set path
     *
     * @param string $path
     * @return JobChains
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return JobChains
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return JobChains
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
     * Set order_id_space
     *
     * @param string $orderIdSpace
     * @return JobChains
     */
    public function setOrderIdSpace($orderIdSpace)
    {
        $this->order_id_space = $orderIdSpace;

        return $this;
    }

    /**
     * Get order_id_space
     *
     * @return string 
     */
    public function getOrderIdSpace()
    {
        return $this->order_id_space;
    }

    /**
     * Set orders_recoverable
     *
     * @param boolean $ordersRecoverable
     * @return JobChains
     */
    public function setOrdersRecoverable($ordersRecoverable)
    {
        $this->orders_recoverable = $ordersRecoverable;

        return $this;
    }

    /**
     * Get orders_recoverable
     *
     * @return boolean 
     */
    public function getOrdersRecoverable()
    {
        return $this->orders_recoverable;
    }

    /**
     * Set running_orders
     *
     * @param integer $runningOrders
     * @return JobChains
     */
    public function setRunningOrders($runningOrders)
    {
        $this->running_orders = $runningOrders;

        return $this;
    }

    /**
     * Get running_orders
     *
     * @return integer 
     */
    public function getRunningOrders()
    {
        return $this->running_orders;
    }

    /**
     * Set max_orders
     *
     * @param integer $maxOrders
     * @return JobChains
     */
    public function setMaxOrders($maxOrders)
    {
        $this->max_orders = $maxOrders;

        return $this;
    }

    /**
     * Get max_orders
     *
     * @return integer 
     */
    public function getMaxOrders()
    {
        return $this->max_orders;
    }

    /**
     * Set orders
     *
     * @param integer $orders
     * @return JobChains
     */
    public function setOrders($orders)
    {
        $this->orders = $orders;

        return $this;
    }

    /**
     * Get orders
     *
     * @return integer 
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * Set last_write_time
     *
     * @param \DateTime $lastWriteTime
     * @return JobChains
     */
    public function setLastWriteTime($lastWriteTime)
    {
        $this->last_write_time = $lastWriteTime;

        return $this;
    }

    /**
     * Get last_write_time
     *
     * @return \DateTime 
     */
    public function getLastWriteTime()
    {
        return $this->last_write_time;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return JobChains
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
     * Set spooler
     *
     * @param \Arii\JOCBundle\Entity\Spoolers $spooler
     * @return JobChains
     */
    public function setSpooler(\Arii\JOCBundle\Entity\Spoolers $spooler = null)
    {
        $this->spooler = $spooler;

        return $this;
    }

    /**
     * Get spooler
     *
     * @return \Arii\JOCBundle\Entity\Spoolers 
     */
    public function getSpooler()
    {
        return $this->spooler;
    }
}
