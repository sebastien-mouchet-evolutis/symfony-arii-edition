<?php

namespace Arii\JIDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SchedulerMonChecks
 *
 * @ORM\Table(name="scheduler_mon_checks", indexes={@ORM\Index(name="SCHEDULER_MC_N_ID", columns={"NOTIFICATION_ID"}), @ORM\Index(name="SCHEDULER_MC_NAME", columns={"NAME"}), @ORM\Index(name="SCHEDULER_MC_STEP", columns={"STEP_FROM", "STEP_TO"}), @ORM\Index(name="SCHEDULER_MC_CHECK", columns={"CHECKED"})})
 * @ORM\Entity(readOnly=true)
 */
class SchedulerMonChecks
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
     * @var string
     *
     * @ORM\Column(name="NAME", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="OBJECT_TYPE", type="integer", nullable=false)
     */
    private $objectType;

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
     * @var string
     *
     * @ORM\Column(name="RESULT_IDS", type="string", length=255, nullable=true)
     */
    private $resultIds;

    /**
     * @var integer
     *
     * @ORM\Column(name="CHECKED", type="integer", nullable=false)
     */
    private $checked;

    /**
     * @var string
     *
     * @ORM\Column(name="CHECK_TEXT", type="string", length=255, nullable=true)
     */
    private $checkText;

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
     * @return SchedulerMonChecks
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
     * Set name
     *
     * @param string $name
     * @return SchedulerMonChecks
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
     * Set objectType
     *
     * @param integer $objectType
     * @return SchedulerMonChecks
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
     * Set stepFrom
     *
     * @param string $stepFrom
     * @return SchedulerMonChecks
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
     * @return SchedulerMonChecks
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
     * @return SchedulerMonChecks
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
     * @return SchedulerMonChecks
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
     * Set resultIds
     *
     * @param string $resultIds
     * @return SchedulerMonChecks
     */
    public function setResultIds($resultIds)
    {
        $this->resultIds = $resultIds;

        return $this;
    }

    /**
     * Get resultIds
     *
     * @return string 
     */
    public function getResultIds()
    {
        return $this->resultIds;
    }

    /**
     * Set checked
     *
     * @param integer $checked
     * @return SchedulerMonChecks
     */
    public function setChecked($checked)
    {
        $this->checked = $checked;

        return $this;
    }

    /**
     * Get checked
     *
     * @return integer 
     */
    public function getChecked()
    {
        return $this->checked;
    }

    /**
     * Set checkText
     *
     * @param string $checkText
     * @return SchedulerMonChecks
     */
    public function setCheckText($checkText)
    {
        $this->checkText = $checkText;

        return $this;
    }

    /**
     * Get checkText
     *
     * @return string 
     */
    public function getCheckText()
    {
        return $this->checkText;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return SchedulerMonChecks
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
     * @return SchedulerMonChecks
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
