<?php

namespace Arii\JOCBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RemoteSchedulers
 *
 * @ORM\Table(name="JOC_REMOTE_SCHEDULERS")
 * @ORM\Entity(repositoryClass="Arii\JOCBundle\Entity\RemoteSchedulersRepository")
 */
class RemoteSchedulers
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
     * @var boolean
     *
     * @ORM\Column(name="configuration_changed", type="boolean", nullable=true)
     */
    private $configuration_changed;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="configuration_changed_at", type="datetime", nullable=true)
     */
    private $configuration_changed_at;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="configuration_transfered_at", type="datetime", nullable=true)
     */
    private $configuration_transfered_at;

    /**
     * @var boolean
     *
     * @ORM\Column(name="connected", type="boolean")
     */
    private $connected;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="connected_at", type="datetime", nullable=true)
     */
    private $connected_at;

    /**
     * @var string
     *
     * @ORM\Column(name="hostname", type="string", length=128)
     */
    private $hostname;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=15)
     */
    private $ip;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=32)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="port", type="integer")
     */
    private $port;

    /**
     * @var string
     *
     * @ORM\Column(name="version", type="string", length=10)
     */
    private $version;

    /**
     * @var string
     *
     * @ORM\Column(name="error", type="string", length=128, nullable=true)
     */
    private $error;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="error_at", type="datetime", nullable=true)
     */
    private $error_at;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="disconnected_at", type="datetime", nullable=true)
     */
    private $disconnected_at;

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
     * Set configuration_changed
     *
     * @param boolean $configurationChanged
     * @return RemoteSchedulers
     */
    public function setConfigurationChanged($configurationChanged)
    {
        $this->configuration_changed = $configurationChanged;

        return $this;
    }

    /**
     * Get configuration_changed
     *
     * @return boolean 
     */
    public function getConfigurationChanged()
    {
        return $this->configuration_changed;
    }

    /**
     * Set configuration_changed_at
     *
     * @param \DateTime $configurationChangedAt
     * @return RemoteSchedulers
     */
    public function setConfigurationChangedAt($configurationChangedAt)
    {
        $this->configuration_changed_at = $configurationChangedAt;

        return $this;
    }

    /**
     * Get configuration_changed_at
     *
     * @return \DateTime 
     */
    public function getConfigurationChangedAt()
    {
        return $this->configuration_changed_at;
    }

    /**
     * Set configuration_transfered_at
     *
     * @param \DateTime $configurationTransferedAt
     * @return RemoteSchedulers
     */
    public function setConfigurationTransferedAt($configurationTransferedAt)
    {
        $this->configuration_transfered_at = $configurationTransferedAt;

        return $this;
    }

    /**
     * Get configuration_transfered_at
     *
     * @return \DateTime 
     */
    public function getConfigurationTransferedAt()
    {
        return $this->configuration_transfered_at;
    }

    /**
     * Set connected
     *
     * @param boolean $connected
     * @return RemoteSchedulers
     */
    public function setConnected($connected)
    {
        $this->connected = $connected;

        return $this;
    }

    /**
     * Get connected
     *
     * @return boolean 
     */
    public function getConnected()
    {
        return $this->connected;
    }

    /**
     * Set connectedAt
     *
     * @param \DateTime $connectedAt
     * @return RemoteSchedulers
     */
    public function setConnectedAt($connectedAt)
    {
        $this->connectedAt = $connectedAt;

        return $this;
    }

    /**
     * Get connectedAt
     *
     * @return \DateTime 
     */
    public function getConnectedAt()
    {
        return $this->connectedAt;
    }

    /**
     * Set hostname
     *
     * @param string $hostname
     * @return RemoteSchedulers
     */
    public function setHostname($hostname)
    {
        $this->hostname = $hostname;

        return $this;
    }

    /**
     * Get hostname
     *
     * @return string 
     */
    public function getHostname()
    {
        return $this->hostname;
    }

    /**
     * Set ip
     *
     * @param string $ip
     * @return RemoteSchedulers
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string 
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return RemoteSchedulers
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
     * Set port
     *
     * @param integer $tcpPort
     * @return RemoteSchedulers
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
     * Set version
     *
     * @param string $version
     * @return RemoteSchedulers
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return string 
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set error
     *
     * @param string $error
     * @return RemoteSchedulers
     */
    public function setError($error)
    {
        $this->error = $error;

        return $this;
    }

    /**
     * Get error
     *
     * @return string 
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Set error_at
     *
     * @param \DateTime $errorAt
     * @return RemoteSchedulers
     */
    public function setErrorAt($errorAt)
    {
        $this->error_at = $errorAt;

        return $this;
    }

    /**
     * Get error_at
     *
     * @return \DateTime 
     */
    public function getErrorAt()
    {
        return $this->error_at;
    }

    /**
     * Set disconnected_at
     *
     * @param \DateTime $disconnectedAt
     * @return RemoteSchedulers
     */
    public function setDisconnectedAt($disconnectedAt)
    {
        $this->disconnected_at = $disconnectedAt;

        return $this;
    }

    /**
     * Get disconnected_at
     *
     * @return \DateTime 
     */
    public function getDisconnectedAt()
    {
        return $this->disconnected_at;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return RemoteSchedulers
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
     * @return RemoteSchedulers
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
