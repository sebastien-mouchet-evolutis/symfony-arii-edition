<?php

namespace Arii\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NodeConnection
 *
 * @ORM\Table(name="ARII_NOTIFY__FILE")
 * @ORM\Entity()
 */
class NotifyFile
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
     * @ORM\ManyToOne(targetEntity="Arii\CoreBundle\Entity\Notify")
     * @ORM\JoinColumn(nullable=false)
     **/
    private $notify;
    
    /**
     * @ORM\ManyToOne(targetEntity="Arii\CoreBundle\Entity\File")
     * @ORM\JoinColumn(nullable=false)
     **/
    private $notify_file;    

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
     * Set notify
     *
     * @param \Arii\CoreBundle\Entity\Notify $notify
     * @return NotifyFile
     */
    public function setNotify(\Arii\CoreBundle\Entity\Notify $notify)
    {
        $this->notify = $notify;

        return $this;
    }

    /**
     * Get notify
     *
     * @return \Arii\CoreBundle\Entity\Notify 
     */
    public function getNotify()
    {
        return $this->notify;
    }

    /**
     * Set notify_file
     *
     * @param \Arii\CoreBundle\Entity\File $notifyFile
     * @return NotifyFile
     */
    public function setNotifyFile(\Arii\CoreBundle\Entity\File $notifyFile)
    {
        $this->notify_file = $notifyFile;

        return $this;
    }

    /**
     * Get notify_file
     *
     * @return \Arii\CoreBundle\Entity\File 
     */
    public function getNotifyFile()
    {
        return $this->notify_file;
    }
}
