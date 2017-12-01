<?php

namespace Arii\JIDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SchedulerMonSysnotifications
 *
 * @ORM\Table(name="scheduler_mon_sysnotifications", indexes={@ORM\Index(name="SCHEDULER_MSN_N_ID", columns={"NOTIFICATION_ID"}), @ORM\Index(name="SCHEDULER_MSN_C_ID", columns={"CHECK_ID"}), @ORM\Index(name="SCHEDULER_MSN_S_ID", columns={"SYSTEM_ID"}), @ORM\Index(name="SCHEDULER_MSN_S_N", columns={"SERVICE_NAME"}), @ORM\Index(name="SCHEDULER_MSN_O_T", columns={"OBJECT_TYPE"}), @ORM\Index(name="SCHEDULER_MSN_RC", columns={"RETURN_CODE_FROM", "RETURN_CODE_TO"}), @ORM\Index(name="SCHEDULER_MSN_STEP", columns={"STEP_FROM", "STEP_TO"})})
 * @ORM\Entity(readOnly=true)
 */
class SchedulerMonSysnotifications
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="NOTIFICATION_ID", type="integer", nullable=false)
     */
    private $notificationId;

    /**
     * @var integer
     *
     * @ORM\Column(name="CHECK_ID", type="integer", nullable=false)
     */
    private $checkId;

    /**
     * @var string
     *
     * @ORM\Column(name="SYSTEM_ID", type="string", length=255, nullable=false)
     */
    private $systemId;

    /**
     * @var string
     *
     * @ORM\Column(name="SERVICE_NAME", type="string", length=255, nullable=false)
     */
    private $serviceName;

    /**
     * @var integer
     *
     * @ORM\Column(name="OBJECT_TYPE", type="integer", nullable=false)
     */
    private $objectType;

    /**
     * @var string
     *
     * @ORM\Column(name="RETURN_CODE_FROM", type="string", length=100, nullable=false)
     */
    private $returnCodeFrom;

    /**
     * @var string
     *
     * @ORM\Column(name="RETURN_CODE_TO", type="string", length=100, nullable=false)
     */
    private $returnCodeTo;

    /**
     * @var string
     *
     * @ORM\Column(name="STEP_FROM", type="string", length=100, nullable=false)
     */
    private $stepFrom;

    /**
     * @var string
     *
     * @ORM\Column(name="STEP_TO", type="string", length=100, nullable=false)
     */
    private $stepTo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="STEP_FROM_START_TIME", type="datetime", nullable=true)
     */
    private $stepFromStartTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="STEP_TO_END_TIME", type="datetime", nullable=true)
     */
    private $stepToEndTime;

    /**
     * @var integer
     *
     * @ORM\Column(name="NOTIFICATIONS", type="integer", nullable=false)
     */
    private $notifications;

    /**
     * @var integer
     *
     * @ORM\Column(name="CURRENT_NOTIFICATION", type="integer", nullable=false)
     */
    private $currentNotification;

    /**
     * @var integer
     *
     * @ORM\Column(name="MAX_NOTIFICATIONS", type="integer", nullable=false)
     */
    private $maxNotifications;

    /**
     * @var integer
     *
     * @ORM\Column(name="ACKNOWLEDGED", type="integer", nullable=false)
     */
    private $acknowledged;

    /**
     * @var integer
     *
     * @ORM\Column(name="RECOVERED", type="integer", nullable=false)
     */
    private $recovered;

    /**
     * @var integer
     *
     * @ORM\Column(name="SUCCESS", type="integer", nullable=false)
     */
    private $success;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="CREATED", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="MODIFIED", type="datetime", nullable=false)
     */
    private $modified;



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
     * Set notificationId
     *
     * @param integer $notificationId
     * @return SchedulerMonSysnotifications
     */
    public function setNotificationId($notificationId)
    {
        $this->notificationId = $notificationId;

        return $this;
    }

    /**
     * Get notificationId
     *
     * @return integer 
     */
    public function getNotificationId()
    {
        return $this->notificationId;
    }

    /**
     * Set checkId
     *
     * @param integer $checkId
     * @return SchedulerMonSysnotifications
     */
    public function setCheckId($checkId)
    {
        $this->checkId = $checkId;

        return $this;
    }

    /**
     * Get checkId
     *
     * @return integer 
     */
    public function getCheckId()
    {
        return $this->checkId;
    }

    /**
     * Set systemId
     *
     * @param string $systemId
     * @return SchedulerMonSysnotifications
     */
    public function setSystemId($systemId)
    {
        $this->systemId = $systemId;

        return $this;
    }

    /**
     * Get systemId
     *
     * @return string 
     */
    public function getSystemId()
    {
        return $this->systemId;
    }

    /**
     * Set serviceName
     *
     * @param string $serviceName
     * @return SchedulerMonSysnotifications
     */
    public function setServiceName($serviceName)
    {
        $this->serviceName = $serviceName;

        return $this;
    }

    /**
     * Get serviceName
     *
     * @return string 
     */
    public function getServiceName()
    {
        return $this->serviceName;
    }

    /**
     * Set objectType
     *
     * @param integer $objectType
     * @return SchedulerMonSysnotifications
     */
    public function setObjectType($objectType)
    {
        $this->objectType = $objectType;

        return $this;
    }

    /**
     * Get objectType
     *
     * @return integer 
     */
    public function getObjectType()
    {
        return $this->objectType;
    }

    /**
     * Set returnCodeFrom
     *
     * @param string $returnCodeFrom
     * @return SchedulerMonSysnotifications
     */
    public function setReturnCodeFrom($returnCodeFrom)
    {
        $this->returnCodeFrom = $returnCodeFrom;

        return $this;
    }

    /**
     * Get returnCodeFrom
     *
     * @return string 
     */
    public function getReturnCodeFrom()
    {
        return $this->returnCodeFrom;
    }

    /**
     * Set returnCodeTo
     *
     * @param string $returnCodeTo
     * @return SchedulerMonSysnotifications
     */
    public function setReturnCodeTo($returnCodeTo)
    {
        $this->returnCodeTo = $returnCodeTo;

        return $this;
    }

    /**
     * Get returnCodeTo
     *
     * @return string 
     */
    public function getReturnCodeTo()
    {
        return $this->returnCodeTo;
    }

    /**
     * Set stepFrom
     *
     * @param string $stepFrom
     * @return SchedulerMonSysnotifications
     */
    public function setStepFrom($stepFrom)
    {
        $this->stepFrom = $stepFrom;

        return $this;
    }

    /**
     * Get stepFrom
     *
     * @return string 
     */
    public function getStepFrom()
    {
        return $this->stepFrom;
    }

    /**
     * Set stepTo
     *
     * @param string $stepTo
     * @return SchedulerMonSysnotifications
     */
    public function setStepTo($stepTo)
    {
        $this->stepTo = $stepTo;

        return $this;
    }

    /**
     * Get stepTo
     *
     * @return string 
     */
    public function getStepTo()
    {
        return $this->stepTo;
    }

    /**
     * Set stepFromStartTime
     *
     * @param \DateTime $stepFromStartTime
     * @return SchedulerMonSysnotifications
     */
    public function setStepFromStartTime($stepFromStartTime)
    {
        $this->stepFromStartTime = $stepFromStartTime;

        return $this;
    }

    /**
     * Get stepFromStartTime
     *
     * @return \DateTime 
     */
    public function getStepFromStartTime()
    {
        return $this->stepFromStartTime;
    }

    /**
     * Set stepToEndTime
     *
     * @param \DateTime $stepToEndTime
     * @return SchedulerMonSysnotifications
     */
    public function setStepToEndTime($stepToEndTime)
    {
        $this->stepToEndTime = $stepToEndTime;

        return $this;
    }

    /**
     * Get stepToEndTime
     *
     * @return \DateTime 
     */
    public function getStepToEndTime()
    {
        return $this->stepToEndTime;
    }

    /**
     * Set notifications
     *
     * @param integer $notifications
     * @return SchedulerMonSysnotifications
     */
    public function setNotifications($notifications)
    {
        $this->notifications = $notifications;

        return $this;
    }

    /**
     * Get notifications
     *
     * @return integer 
     */
    public function getNotifications()
    {
        return $this->notifications;
    }

    /**
     * Set currentNotification
     *
     * @param integer $currentNotification
     * @return SchedulerMonSysnotifications
     */
    public function setCurrentNotification($currentNotification)
    {
        $this->currentNotification = $currentNotification;

        return $this;
    }

    /**
     * Get currentNotification
     *
     * @return integer 
     */
    public function getCurrentNotification()
    {
        return $this->currentNotification;
    }

    /**
     * Set maxNotifications
     *
     * @param integer $maxNotifications
     * @return SchedulerMonSysnotifications
     */
    public function setMaxNotifications($maxNotifications)
    {
        $this->maxNotifications = $maxNotifications;

        return $this;
    }

    /**
     * Get maxNotifications
     *
     * @return integer 
     */
    public function getMaxNotifications()
    {
        return $this->maxNotifications;
    }

    /**
     * Set acknowledged
     *
     * @param integer $acknowledged
     * @return SchedulerMonSysnotifications
     */
    public function setAcknowledged($acknowledged)
    {
        $this->acknowledged = $acknowledged;

        return $this;
    }

    /**
     * Get acknowledged
     *
     * @return integer 
     */
    public function getAcknowledged()
    {
        return $this->acknowledged;
    }

    /**
     * Set recovered
     *
     * @param integer $recovered
     * @return SchedulerMonSysnotifications
     */
    public function setRecovered($recovered)
    {
        $this->recovered = $recovered;

        return $this;
    }

    /**
     * Get recovered
     *
     * @return integer 
     */
    public function getRecovered()
    {
        return $this->recovered;
    }

    /**
     * Set success
     *
     * @param integer $success
     * @return SchedulerMonSysnotifications
     */
    public function setSuccess($success)
    {
        $this->success = $success;

        return $this;
    }

    /**
     * Get success
     *
     * @return integer 
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return SchedulerMonSysnotifications
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set modified
     *
     * @param \DateTime $modified
     * @return SchedulerMonSysnotifications
     */
    public function setModified($modified)
    {
        $this->modified = $modified;

        return $this;
    }

    /**
     * Get modified
     *
     * @return \DateTime 
     */
    public function getModified()
    {
        return $this->modified;
    }
}
