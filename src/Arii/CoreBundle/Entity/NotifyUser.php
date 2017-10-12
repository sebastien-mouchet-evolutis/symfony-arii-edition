<?php

namespace Arii\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NotifyUser
 *
 * @ORM\Table(name="ARII_NOTIFY__USER")
 * @ORM\Entity()
 */
class NotifyUser
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
     * @var string
     *
     * @ORM\Column(name="notify_use", type="string", length=16, nullable=true)
     */        
    private $notify_use;

    /**
     * @ORM\ManyToOne(targetEntity="Arii\CoreBundle\Entity\Notify")
     * @ORM\JoinColumn(nullable=false)
     **/
    private $notify;

    /**
     * @ORM\ManyToOne(targetEntity="Arii\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     **/
    private $user;


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
     * Set notify_use
     *
     * @param string $notifyUse
     * @return NotifyUser
     */
    public function setNotifyUse($notifyUse)
    {
        $this->notify_use = $notifyUse;

        return $this;
    }

    /**
     * Get notify_use
     *
     * @return string 
     */
    public function getNotifyUse()
    {
        return $this->notify_use;
    }

    /**
     * Set notify
     *
     * @param \Arii\CoreBundle\Entity\Notify $notify
     * @return NotifyUser
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
     * Set user
     *
     * @param \Arii\UserBundle\Entity\User $user
     * @return NotifyUser
     */
    public function setUser(\Arii\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Arii\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
