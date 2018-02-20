<?php

namespace Arii\JOCBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Connections
 *
 * @ORM\Table(name="JOC_CONNECTIONS")
 * @ORM\Entity
 */
class Connections
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
     * @ORM\ManyToOne(targetEntity="Arii\JOCBundle\Entity\Spoolers" )
     * @ORM\JoinColumn(nullable=true)
     **/
    private $spooler;

    /**
     * @var string
     *
     * @ORM\Column(name="operation_type", type="string", length=5,nullable=true)
     */
    private $operation_type;

    /**
     * @var integer
     *
     * @ORM\Column(name="responses", type="bigint")
     */
    private $responses;

    /**
     * @var integer
     *
     * @ORM\Column(name="received_bytes", type="bigint")
     */
    private $received_bytes;

    /**
     * @var integer
     *
     * @ORM\Column(name="sent_bytes", type="bigint")
     */
    private $sent_bytes;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=20)
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(name="host_ip", type="string", length=15)
     */
    private $host_ip;

    /**
     * @var integer
     *
     * @ORM\Column(name="port", type="integer")
     */
    private $port;

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
     * Set operation_type
     *
     * @param string $operationType
     * @return Connections
     */
    public function setOperationType($operationType)
    {
        $this->operation_type = $operationType;

        return $this;
    }

    /**
     * Get operation_type
     *
     * @return string 
     */
    public function getOperationType()
    {
        return $this->operation_type;
    }

    /**
     * Set responses
     *
     * @param integer $responses
     * @return Connections
     */
    public function setResponses($responses)
    {
        $this->responses = $responses;

        return $this;
    }

    /**
     * Get responses
     *
     * @return integer 
     */
    public function getResponses()
    {
        return $this->responses;
    }

    /**
     * Set received_bytes
     *
     * @param integer $receivedBytes
     * @return Connections
     */
    public function setReceivedBytes($receivedBytes)
    {
        $this->received_bytes = $receivedBytes;

        return $this;
    }

    /**
     * Get received_bytes
     *
     * @return integer 
     */
    public function getReceivedBytes()
    {
        return $this->received_bytes;
    }

    /**
     * Set sent_bytes
     *
     * @param integer $sentBytes
     * @return Connections
     */
    public function setSentBytes($sentBytes)
    {
        $this->sent_bytes = $sentBytes;

        return $this;
    }

    /**
     * Get sent_bytes
     *
     * @return integer 
     */
    public function getSentBytes()
    {
        return $this->sent_bytes;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return Connections
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
     * Set host_ip
     *
     * @param string $hostIp
     * @return Connections
     */
    public function setHostIp($hostIp)
    {
        $this->host_ip = $hostIp;

        return $this;
    }

    /**
     * Get host_ip
     *
     * @return string 
     */
    public function getHostIp()
    {
        return $this->host_ip;
    }

    /**
     * Set port
     *
     * @param integer $port
     * @return Connections
     */
    public function setPort($port)
    {
        $this->port = $port;

        return $this;
    }

    /**
     * Get port
     *
     * @return integer 
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Connections
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
     * @return Connections
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
