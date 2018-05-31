<?php

namespace Arii\ACKBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cron
 *
 * @ORM\Table(name="ARII_EVENT")
 * @ORM\Entity(repositoryClass="Arii\ACKBundle\Entity\EventRepository")
 */
class Event
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
     * @ORM\Column(name="name", type="string", length=64)
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
     * @ORM\Column(name="event", type="text", nullable=true )
     */        
    private $event;

     /**
     * @var string
     *
     * @ORM\Column(name="event_type", type="string", nullable=true )
     */        
    private $event_type;
    
    /**
     * @var datetime
     *
     * @ORM\Column(name="start_time", type="datetime", length=3, nullable=true )
     */        
    private $start_time;

    /**
     * @var datetime
     *
     * @ORM\Column(name="end_time", type="datetime", nullable=true )
     */        
    private $end_time;    

    /**
     * @ORM\ManyToOne(targetEntity="Arii\CoreBundle\Entity\Application")
     * @ORM\JoinColumn(nullable=true)
     **/
    private $application;
    
    /**
     * @ORM\ManyToOne(targetEntity="Arii\CoreBundle\Entity\Domain")
     * @ORM\JoinColumn(nullable=true)
     **/
    private $domain;

    /**
     * @var string
     *
     * @ORM\Column(name="applications", type="array", nullable=true)
     */
    private $applications;
    
    /**
     * @var string
     *
     * @ORM\Column(name="days", type="array", nullable=true)
     */
    private $days;
    
     /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=32, nullable=true)
     */        
    private $status;    

    
     /**
     * @var integer
     *
     * @ORM\Column(name="state", type="integer")
     */        
    private $state=0;    
    
     /**
     * @var string
     *
     * @ORM\Column(name="last_comment", type="text", nullable=true)
     */        
    private $last_comment;   
    
     /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=255, nullable=true)
     */        
    private $event_link;
    
    /**
     * @var datetime
     *
     * @ORM\Column(name="change_date", type="datetime", nullable=true )
     */        
    private $change_date;  
    
    /**
     * @var datetime
     *
     * @ORM\Column(name="change_start", type="datetime", nullable=true )
     */        
    private $change_start;  
    
    /**
     * @var datetime
     *
     * @ORM\Column(name="change_end", type="datetime", nullable=true )
     */        
    private $change_end;  

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
     * Set name
     *
     * @param string $name
     * @return Event
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
     * @return Event
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
     * @return Event
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
     * Set event
     *
     * @param string $event
     * @return Event
     */
    public function setEvent($event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return string 
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set event_type
     *
     * @param string $eventType
     * @return Event
     */
    public function setEventType($eventType)
    {
        $this->event_type = $eventType;

        return $this;
    }

    /**
     * Get event_type
     *
     * @return string 
     */
    public function getEventType()
    {
        return $this->event_type;
    }

    /**
     * Set start_time
     *
     * @param \DateTime $startTime
     * @return Event
     */
    public function setStartTime($startTime)
    {
        $this->start_time = $startTime;

        return $this;
    }

    /**
     * Get start_time
     *
     * @return \DateTime 
     */
    public function getStartTime()
    {
        return $this->start_time;
    }

    /**
     * Set end_time
     *
     * @param \DateTime $endTime
     * @return Event
     */
    public function setEndTime($endTime)
    {
        $this->end_time = $endTime;

        return $this;
    }

    /**
     * Get end_time
     *
     * @return \DateTime 
     */
    public function getEndTime()
    {
        return $this->end_time;
    }

    /**
     * Set applications
     *
     * @param array $applications
     * @return Event
     */
    public function setApplications($applications)
    {
        $this->applications = $applications;

        return $this;
    }

    /**
     * Get applications
     *
     * @return array 
     */
    public function getApplications()
    {
        return $this->applications;
    }

    /**
     * Set days
     *
     * @param array $days
     * @return Event
     */
    public function setDays($days)
    {
        $this->days = $days;

        return $this;
    }

    /**
     * Get days
     *
     * @return array 
     */
    public function getDays()
    {
        return $this->days;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Event
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set last_comment
     *
     * @param string $lastComment
     * @return Event
     */
    public function setLastComment($lastComment)
    {
        $this->last_comment = $lastComment;

        return $this;
    }

    /**
     * Get last_comment
     *
     * @return string 
     */
    public function getLastComment()
    {
        return $this->last_comment;
    }

    /**
     * Set event_link
     *
     * @param string $eventLink
     * @return Event
     */
    public function setEventLink($eventLink)
    {
        $this->event_link = $eventLink;

        return $this;
    }

    /**
     * Get event_link
     *
     * @return string 
     */
    public function getEventLink()
    {
        return $this->event_link;
    }

    /**
     * Set application
     *
     * @param \Arii\CoreBundle\Entity\Application $application
     * @return Event
     */
    public function setApplication(\Arii\CoreBundle\Entity\Application $application = null)
    {
        $this->application = $application;

        return $this;
    }

    /**
     * Get application
     *
     * @return \Arii\CoreBundle\Entity\Application 
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * Set domain
     *
     * @param \Arii\CoreBundle\Entity\Domain $domain
     * @return Event
     */
    public function setDomain(\Arii\CoreBundle\Entity\Domain $domain = null)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Get domain
     *
     * @return \Arii\CoreBundle\Entity\Domain 
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Set change_start
     *
     * @param \DateTime $changeStart
     * @return Event
     */
    public function setChangeStart($changeStart)
    {
        $this->change_start = $changeStart;

        return $this;
    }

    /**
     * Get change_start
     *
     * @return \DateTime 
     */
    public function getChangeStart()
    {
        return $this->change_start;
    }

    /**
     * Set change_end
     *
     * @param \DateTime $changeEnd
     * @return Event
     */
    public function setChangeEnd($changeEnd)
    {
        $this->change_end = $changeEnd;

        return $this;
    }

    /**
     * Get change_end
     *
     * @return \DateTime 
     */
    public function getChangeEnd()
    {
        return $this->change_end;
    }

    /**
     * Set change_date
     *
     * @param \DateTime $changeDate
     * @return Event
     */
    public function setChangeDate($changeDate)
    {
        $this->change_date = $changeDate;

        return $this;
    }

    /**
     * Get change_date
     *
     * @return \DateTime 
     */
    public function getChangeDate()
    {
        return $this->change_date;
    }

    /**
     * Set state
     *
     * @param integer $state
     * @return Event
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return integer 
     */
    public function getState()
    {
        return $this->state;
    }
}
