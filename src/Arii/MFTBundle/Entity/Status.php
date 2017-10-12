<?php

namespace Arii\MFTBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Connections
 *
 * @ORM\Table(name="MFT_STATUS")
 * @ORM\Entity()
 */
class Status
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
    * @ORM\ManyToOne(targetEntity="Arii\MFTBundle\Entity\Transfers")
    * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
    */
    private $transfer;

    /**
    * @ORM\ManyToOne(targetEntity="Arii\MFTBundle\Entity\History")
    * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
    */
    private $history;

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
     * Set transfer
     *
     * @param \Arii\MFTBundle\Entity\Transfers $transfer
     * @return Status
     */
    public function setTransfer(\Arii\MFTBundle\Entity\Transfers $transfer = null)
    {
        $this->transfer = $transfer;

        return $this;
    }

    /**
     * Get transfer
     *
     * @return \Arii\MFTBundle\Entity\Transfers 
     */
    public function getTransfer()
    {
        return $this->transfer;
    }

    /**
     * Set history
     *
     * @param \Arii\MFTBundle\Entity\History $history
     * @return Status
     */
    public function setHistory(\Arii\MFTBundle\Entity\History $history = null)
    {
        $this->history = $history;

        return $this;
    }

    /**
     * Get history
     *
     * @return \Arii\MFTBundle\Entity\History 
     */
    public function getHistory()
    {
        return $this->history;
    }
}
