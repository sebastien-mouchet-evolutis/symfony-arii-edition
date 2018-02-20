<?php

namespace Arii\JOCBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SchedulerOrderHistory
 *
 * @ORM\Table(name="JOC_ORDER_HISTORY")
 * @ORM\Entity(repositoryClass="Arii\CoreBundle\Entity\SchedulerOrderHistoryRepository")
 */
class SchedulerOrderHistory
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Arii\JOCBundle\Entity\Spoolers")
     * @ORM\JoinColumn(nullable=true)
     **/
    private $SPOOLER;

    /**
     * @var integer
     *
     * @ORM\Column(name="SOURCE", type="integer")
     */
    private $SOURCE;

    /**
     * @var string
     *
     * @ORM\Column(name="JOB_CHAIN", type="string", length=255)
     */
    private $JOB_CHAIN;

    /**
     * @var string
     *
     * @ORM\Column(name="ORDER_ID", type="string", length=255)
     */
    private $ORDER_ID;

    /**
     * @var string
     *
     * @ORM\Column(name="SCHEDULER", type="string", length=100)
     */
    private $SCHEDULER;

    /**
     * @var string
     *
     * @ORM\Column(name="TITLE", type="string", length=200)
     */
    private $TITLE;

    /**
     * @var string
     *
     * @ORM\Column(name="STATE", type="string", length=100)
     */
    private $STATE;

    /**
     * @var string
     *
     * @ORM\Column(name="STATE_TEXT", type="string", length=100)
     */
    private $STATE_TEXT;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="START_TIME", type="datetime")
     */
    private $START_TIME;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="END_TIME", type="datetime", nullable=true)
     */
    private $END_TIME;

     /**
     * @var float
     *
     * @ORM\Column(name="AVG_RUNTIME", type="float")
     */
    private $AVG_RUNTIME;

     /**
     * @var float
     *
     * @ORM\Column(name="MIN_RUNTIME", type="float")
     */
    private $MIN_RUNTIME;

     /**
     * @var float
     *
     * @ORM\Column(name="MAX_RUNTIME", type="float")
     */
    private $MAX_RUNTIME;

    /**
     * @var integer
     *
     * @ORM\Column(name="RUN_COUNT", type="integer")
     */
    private $RUN_COUNT;
    
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
     * Set HISTORY_ID
     *
     * @param integer $hISTORYID
     * @return Scheduler_order_history
     */
    public function setHISTORYID($hISTORYID)
    {
        $this->HISTORY_ID = $hISTORYID;
    
        return $this;
    }

    /**
     * Get HISTORY_ID
     *
     * @return integer 
     */
    public function getHISTORYID()
    {
        return $this->HISTORY_ID;
    }

    /**
     * Set JOB_CHAIN
     *
     * @param string $jOBCHAIN
     * @return Scheduler_order_history
     */
    public function setJOBCHAIN($jOBCHAIN)
    {
        $this->JOB_CHAIN = $jOBCHAIN;
    
        return $this;
    }

    /**
     * Get JOB_CHAIN
     *
     * @return string 
     */
    public function getJOBCHAIN()
    {
        return $this->JOB_CHAIN;
    }

    /**
     * Set ORDER_ID
     *
     * @param string $oRDERID
     * @return Scheduler_order_history
     */
    public function setORDERID($oRDERID)
    {
        $this->ORDER_ID = $oRDERID;
    
        return $this;
    }

    /**
     * Get ORDER_ID
     *
     * @return string 
     */
    public function getORDERID()
    {
        return $this->ORDER_ID;
    }

    /**
     * Set SPOOLER_ID
     *
     * @param string $sPOOLERID
     * @return Scheduler_order_history
     */
    public function setSPOOLERID($sPOOLERID)
    {
        $this->SPOOLER_ID = $sPOOLERID;
    
        return $this;
    }

    /**
     * Get SPOOLER_ID
     *
     * @return string 
     */
    public function getSPOOLERID()
    {
        return $this->SPOOLER_ID;
    }

    /**
     * Set TITLE
     *
     * @param string $tITLE
     * @return Scheduler_order_history
     */
    public function setTITLE($tITLE)
    {
        $this->TITLE = $tITLE;
    
        return $this;
    }

    /**
     * Get TITLE
     *
     * @return string 
     */
    public function getTITLE()
    {
        return $this->TITLE;
    }

    /**
     * Set STATE
     *
     * @param string $sTATE
     * @return Scheduler_order_history
     */
    public function setSTATE($sTATE)
    {
        $this->STATE = $sTATE;
    
        return $this;
    }

    /**
     * Get STATE
     *
     * @return string 
     */
    public function getSTATE()
    {
        return $this->STATE;
    }

    /**
     * Set STATE_TEXT
     *
     * @param string $sTATETEXT
     * @return Scheduler_order_history
     */
    public function setSTATETEXT($sTATETEXT)
    {
        $this->STATE_TEXT = $sTATETEXT;
    
        return $this;
    }

    /**
     * Get STATE_TEXT
     *
     * @return string 
     */
    public function getSTATETEXT()
    {
        return $this->STATE_TEXT;
    }

    /**
     * Set START_TIME
     *
     * @param \DateTime $sTARTTIME
     * @return Scheduler_order_history
     */
    public function setSTARTTIME($sTARTTIME)
    {
        $this->START_TIME = $sTARTTIME;
    
        return $this;
    }

    /**
     * Get START_TIME
     *
     * @return \DateTime 
     */
    public function getSTARTTIME()
    {
        return $this->START_TIME;
    }

    /**
     * Set END_TIME
     *
     * @param \DateTime $eNDTIME
     * @return Scheduler_order_history
     */
    public function setENDTIME($eNDTIME)
    {
        $this->END_TIME = $eNDTIME;
    
        return $this;
    }

    /**
     * Get END_TIME
     *
     * @return \DateTime 
     */
    public function getENDTIME()
    {
        return $this->END_TIME;
    }

    /**
     * Set LOG
     *
     * @param string $lOG
     * @return Scheduler_order_history
     */
    public function setLOG($lOG)
    {
        $this->LOG = $lOG;
    
        return $this;
    }

    /**
     * Get LOG
     *
     * @return string 
     */
    public function getLOG()
    {
        return $this->LOG;
    }

    /**
     * Set SOURCE
     *
     * @param integer $sOURCE
     * @return SchedulerOrderHistory
     */
    public function setSOURCE($sOURCE)
    {
        $this->SOURCE = $sOURCE;

        return $this;
    }

    /**
     * Get SOURCE
     *
     * @return integer 
     */
    public function getSOURCE()
    {
        return $this->SOURCE;
    }

    /**
     * Set SCHEDULER
     *
     * @param string $sCHEDULER
     * @return SchedulerOrderHistory
     */
    public function setSCHEDULER($sCHEDULER)
    {
        $this->SCHEDULER = $sCHEDULER;

        return $this;
    }

    /**
     * Get SCHEDULER
     *
     * @return string 
     */
    public function getSCHEDULER()
    {
        return $this->SCHEDULER;
    }

    /**
     * Set AVG_RUNTIME
     *
     * @param float $aVGRUNTIME
     * @return SchedulerOrderHistory
     */
    public function setAVGRUNTIME($aVGRUNTIME)
    {
        $this->AVG_RUNTIME = $aVGRUNTIME;

        return $this;
    }

    /**
     * Get AVG_RUNTIME
     *
     * @return float 
     */
    public function getAVGRUNTIME()
    {
        return $this->AVG_RUNTIME;
    }

    /**
     * Set MIN_RUNTIME
     *
     * @param float $mINRUNTIME
     * @return SchedulerOrderHistory
     */
    public function setMINRUNTIME($mINRUNTIME)
    {
        $this->MIN_RUNTIME = $mINRUNTIME;

        return $this;
    }

    /**
     * Get MIN_RUNTIME
     *
     * @return float 
     */
    public function getMINRUNTIME()
    {
        return $this->MIN_RUNTIME;
    }

    /**
     * Set MAX_RUNTIME
     *
     * @param float $mAXRUNTIME
     * @return SchedulerOrderHistory
     */
    public function setMAXRUNTIME($mAXRUNTIME)
    {
        $this->MAX_RUNTIME = $mAXRUNTIME;

        return $this;
    }

    /**
     * Get MAX_RUNTIME
     *
     * @return float 
     */
    public function getMAXRUNTIME()
    {
        return $this->MAX_RUNTIME;
    }

    /**
     * Set RUN_COUNT
     *
     * @param integer $rUNCOUNT
     * @return SchedulerOrderHistory
     */
    public function setRUNCOUNT($rUNCOUNT)
    {
        $this->RUN_COUNT = $rUNCOUNT;

        return $this;
    }

    /**
     * Get RUN_COUNT
     *
     * @return integer 
     */
    public function getRUNCOUNT()
    {
        return $this->RUN_COUNT;
    }

    /**
     * Set REPOSITORY
     *
     * @param \Arii\CoreBundle\Entity\Repository $rEPOSITORY
     * @return SchedulerOrderHistory
     */
    public function setREPOSITORY(\Arii\CoreBundle\Entity\Repository $rEPOSITORY = null)
    {
        $this->REPOSITORY = $rEPOSITORY;

        return $this;
    }

    /**
     * Get REPOSITORY
     *
     * @return \Arii\CoreBundle\Entity\Repository 
     */
    public function getREPOSITORY()
    {
        return $this->REPOSITORY;
    }

    /**
     * Set SPOOLER
     *
     * @param \Arii\CoreBundle\Entity\Spooler $sPOOLER
     * @return SchedulerOrderHistory
     */
    public function setSPOOLER(\Arii\CoreBundle\Entity\Spooler $sPOOLER = null)
    {
        $this->SPOOLER = $sPOOLER;

        return $this;
    }

    /**
     * Get SPOOLER
     *
     * @return \Arii\CoreBundle\Entity\Spooler 
     */
    public function getSPOOLER()
    {
        return $this->SPOOLER;
    }
}
