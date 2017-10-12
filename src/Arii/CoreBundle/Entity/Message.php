<?php

namespace Arii\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notify
 *
 * @ORM\Table(name="ARII_MESSAGE")
 * @ORM\Entity(repositoryClass="Arii\CoreBundle\Entity\MessageRepository")
 */
class Message
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
     * @ORM\Column(name="msg_source", type="string", length=24)
     */        
    private $msg_source;

    /**
     * @var string
     *
     * @ORM\Column(name="msg_type", type="string", length=1)
     */
    private $msg_type;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text", nullable=true )
     */
    private $msg_text;
    
    /**
     * @ORM\ManyToOne(targetEntity="Arii\UserBundle\Entity\User")
     **/
    private $msg_from;

    /**
     * @ORM\ManyToOne(targetEntity="Arii\UserBundle\Entity\User")
     **/
    private $msg_to;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="msg_sent", type="datetime")
     */
    private $msg_sent;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="msg_read", type="datetime", nullable=true)
     */
    private $msg_read;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="msg_ack", type="datetime", nullable=true)
     */
    private $msg_ack;
    

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
     * Set title
     *
     * @param string $title
     * @return Message
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
     * @return Message
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
     * Set msg_source
     *
     * @param string $msgSource
     * @return Message
     */
    public function setMsgSource($msgSource)
    {
        $this->msg_source = $msgSource;

        return $this;
    }

    /**
     * Get msg_source
     *
     * @return string 
     */
    public function getMsgSource()
    {
        return $this->msg_source;
    }

    /**
     * Set msg_type
     *
     * @param string $msgType
     * @return Message
     */
    public function setMsgType($msgType)
    {
        $this->msg_type = $msgType;

        return $this;
    }

    /**
     * Get msg_type
     *
     * @return string 
     */
    public function getMsgType()
    {
        return $this->msg_type;
    }

    /**
     * Set msg_text
     *
     * @param string $msgText
     * @return Message
     */
    public function setMsgText($msgText)
    {
        $this->msg_text = $msgText;

        return $this;
    }

    /**
     * Get msg_text
     *
     * @return string 
     */
    public function getMsgText()
    {
        return $this->msg_text;
    }

    /**
     * Set msg_sent
     *
     * @param \DateTime $msgSent
     * @return Message
     */
    public function setMsgSent($msgSent)
    {
        $this->msg_sent = $msgSent;

        return $this;
    }

    /**
     * Get msg_sent
     *
     * @return \DateTime 
     */
    public function getMsgSent()
    {
        return $this->msg_sent;
    }

    /**
     * Set msg_read
     *
     * @param \DateTime $msgRead
     * @return Message
     */
    public function setMsgRead($msgRead)
    {
        $this->msg_read = $msgRead;

        return $this;
    }

    /**
     * Get msg_read
     *
     * @return \DateTime 
     */
    public function getMsgRead()
    {
        return $this->msg_read;
    }

    /**
     * Set msg_ack
     *
     * @param \DateTime $msgAck
     * @return Message
     */
    public function setMsgAck($msgAck)
    {
        $this->msg_ack = $msgAck;

        return $this;
    }

    /**
     * Get msg_ack
     *
     * @return \DateTime 
     */
    public function getMsgAck()
    {
        return $this->msg_ack;
    }

    /**
     * Set msg_from
     *
     * @param \Arii\UserBundle\Entity\User $msgFrom
     * @return Message
     */
    public function setMsgFrom(\Arii\UserBundle\Entity\User $msgFrom = null)
    {
        $this->msg_from = $msgFrom;

        return $this;
    }

    /**
     * Get msg_from
     *
     * @return \Arii\UserBundle\Entity\User 
     */
    public function getMsgFrom()
    {
        return $this->msg_from;
    }

    /**
     * Set msg_to
     *
     * @param \Arii\UserBundle\Entity\User $msgTo
     * @return Message
     */
    public function setMsgTo(\Arii\UserBundle\Entity\User $msgTo = null)
    {
        $this->msg_to = $msgTo;

        return $this;
    }

    /**
     * Get msg_to
     *
     * @return \Arii\UserBundle\Entity\User 
     */
    public function getMsgTo()
    {
        return $this->msg_to;
    }
}
