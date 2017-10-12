<?php
// src/Arii/UserBundle/Entity/User.php

namespace Arii\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="ARII_USER")
*/
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
    * @var string $last_name
    *
    * @ORM\Column(name="last_name", type="string", length=255)
    */
    private $last_name;

    /**
     ** @var string $first_name
    *
    * @ORM\Column(name="first_name", type="string", length=255)
    */
    private $first_name;

    /**
     ** @var string $first_name
    *
    * @ORM\Column(name="phone_number", type="string", length=20)
    */
    private $phone_number;
    
    /**
     ** @var string $first_name
    *
    * @ORM\Column(name="sms", type="string", length=64)
    */
    private $sms;

    /**
     ** @var string $pushbullet_token
    *
    * @ORM\Column(name="pushbullet_token", type="string", length=64)
    */
    private $pushbullet_token;

    /**
     ** @var string $pushbullet_devices
    *
    * @ORM\Column(name="pushbullet_devices", type="string", length=255)
    */
    private $pushbullet_devices;

    /**
     ** @var string $notify_info
    *
    * @ORM\Column(name="notify_info", type="string", length=255)
    */
    private $notify_info;

    /**
     ** @var string $notify_warning
    *
    * @ORM\Column(name="notify_warning", type="string", length=255)
    */
    private $notify_warning;

    /**
     ** @var string $notify_alert
    *
    * @ORM\Column(name="notify_alert", type="string", length=255)
    */
    private $notify_alert;    
    
    /**
     * @ORM\ManyToOne(targetEntity="Arii\CoreBundle\Entity\Team")
     * @ORM\JoinColumn(nullable=true)
     *      
     */
    private $team;

    /**
     * Set first_name
     *
     * @param string $first_name
     * @return User
     */
    
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    
        return $this;
    }

    /**
     * Get first_name
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set last_name
     *
     * @param string $last_name
     * @return User
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    
        return $this;
    }

    /**
     * Get last_name
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->last_name;
    }

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
     * Set team
     *
     * @param \Arii\CoreBundle\Entity\Team $team
     * @return User
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
     * Set phone_number
     *
     * @param string $phoneNumber
     * @return User
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phone_number = $phoneNumber;

        return $this;
    }

    /**
     * Get phone_number
     *
     * @return string 
     */
    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    /**
     * Set pushbullet_token
     *
     * @param string $pushbulletToken
     * @return User
     */
    public function setPushbulletToken($pushbulletToken)
    {
        $this->pushbullet_token = $pushbulletToken;

        return $this;
    }

    /**
     * Get pushbullet_token
     *
     * @return string 
     */
    public function getPushbulletToken()
    {
        return $this->pushbullet_token;
    }

    /**
     * Set pushbullet_devices
     *
     * @param string $pushbulletDevices
     * @return User
     */
    public function setPushbulletDevices($pushbulletDevices)
    {
        $this->pushbullet_devices = $pushbulletDevices;

        return $this;
    }

    /**
     * Get pushbullet_devices
     *
     * @return string 
     */
    public function getPushbulletDevices()
    {
        return $this->pushbullet_devices;
    }

    /**
     * Set notify_info
     *
     * @param string $notifyInfo
     * @return User
     */
    public function setNotifyInfo($notifyInfo)
    {
        $this->notify_info = $notifyInfo;

        return $this;
    }

    /**
     * Get notify_info
     *
     * @return string 
     */
    public function getNotifyInfo()
    {
        return $this->notify_info;
    }

    /**
     * Set notify_warning
     *
     * @param string $notifyWarning
     * @return User
     */
    public function setNotifyWarning($notifyWarning)
    {
        $this->notify_warning = $notifyWarning;

        return $this;
    }

    /**
     * Get notify_warning
     *
     * @return string 
     */
    public function getNotifyWarning()
    {
        return $this->notify_warning;
    }

    /**
     * Set notify_alert
     *
     * @param string $notifyAlert
     * @return User
     */
    public function setNotifyAlert($notifyAlert)
    {
        $this->notify_alert = $notifyAlert;

        return $this;
    }

    /**
     * Get notify_alert
     *
     * @return string 
     */
    public function getNotifyAlert()
    {
        return $this->notify_alert;
    }
}
