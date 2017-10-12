<?php

namespace Arii\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notify
 *
 * @ORM\Table(name="ARII_NOTIFY")
 * @ORM\Entity(repositoryClass="Arii\CoreBundle\Entity\NotifyRepository")
 */
class Notify
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
     * @ORM\Column(name="name", type="string", length=512)
     */        
    private $name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */        
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="notify_type", type="string", length=16)
     */
    private $notify_type;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text" )
     */
    private $message;

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
     * Set notify_type
     *
     * @param string $notifyType
     * @return Notify
     */
    public function setNotifyType($notifyType)
    {
        $this->notify_type = $notifyType;

        return $this;
    }

    /**
     * Get notify_type
     *
     * @return string 
     */
    public function getNotifyType()
    {
        return $this->notify_type;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return Notify
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Notify
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
     * @return Notify
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
     * @return Notify
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
}
