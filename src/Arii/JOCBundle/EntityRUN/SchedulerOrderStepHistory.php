<?php

namespace Arii\JOCBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SchedulerOrderStepHistory
 *
 * @ORM\Table(name="JOC_ORDER_STEP_HISTORY")
 * @ORM\Entity(repositoryClass="Arii\CoreBundle\Entity\SchedulerOrderStepHistoryRepository")
 */
class SchedulerOrderStepHistory
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
     * @ORM\ManyToOne(targetEntity="Arii\JOCBundle\Entity\SchedulerOrderHistory")
     * @ORM\JoinColumn(nullable=true)
     **/
    private $ORDER;

    /**
     * @var integer
     *
     * @ORM\Column(name="SOURCE", type="integer")
     */
    private $SOURCE;

    /**
     * @var integer
     *
     * @ORM\Column(name="STEP", type="integer")
     */
    private $STEP;

    /**
     * @var string
     *
     * @ORM\Column(name="STATE", type="string", length=100)
     */
    private $STATE;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="START_TIME", type="datetime")
     */
    private $START_TIME;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="END_TIME", type="datetime")
     */
    private $END_TIME;

    /**
     * @var integer
     *
     * @ORM\Column(name="ERROR", type="integer")
     */
    private $ERROR;

    /**
     * @var string
     *
     * @ORM\Column(name="ERROR_CODE", type="string", length=50)
     */
    private $ERROR_CODE;

    /**
     * @var string
     *
     * @ORM\Column(name="ERROR_TEXT", type="string", length=250)
     */
    private $ERROR_TEXT;

    /**
     * @var string
     *
     * @ORM\Column(name="SPOOLER", type="string", length=100)
     */
    private $SPOOLER;

    /**
     * @var string
     *
     * @ORM\Column(name="CLUSTER_MEMBER", type="string", length=100)
     */
    private $CLUSTER_MEMBER;

    /**
     * @var string
     *
     * @ORM\Column(name="JOB_NAME", type="string", length=255)
     */
    private $JOB_NAME;

    /**
     * @var string
     *
     * @ORM\Column(name="CAUSE", type="string", length=50)
     */
    private $CAUSE;

    /**
     * @var integer
     *
     * @ORM\Column(name="STEPS", type="integer")
     */
    private $STEPS;

    /**
     * @var integer
     *
     * @ORM\Column(name="EXIT_CODE", type="integer")
     */
    private $EXIT_CODE;

    /**
     * @var string
     *
     * @ORM\Column(name="PARAMETERS", type="text")
     */
    private $PARAMETERS;

    /**
     * @var string
     *
     * @ORM\Column(name="ITEM_START", type="string", length=250)
     */
    private $ITEM_START;

    /**
     * @var string
     *
     * @ORM\Column(name="ITEM_STOP", type="string", length=250)
     */
    private $ITEM_STOP;

    /**
     * @var integer
     *
     * @ORM\Column(name="PID", type="integer")
     */
    private $PID;

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
     * @return Scheduler_order_step_history
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
     * Set STEP
     *
     * @param integer $sTEP
     * @return Scheduler_order_step_history
     */
    public function setSTEP($sTEP)
    {
        $this->STEP = $sTEP;
    
        return $this;
    }

    /**
     * Get STEP
     *
     * @return integer 
     */
    public function getSTEP()
    {
        return $this->STEP;
    }

    /**
     * Set TASK_ID
     *
     * @param integer $tASKID
     * @return Scheduler_order_step_history
     */
    public function setTASKID($tASKID)
    {
        $this->TASK_ID = $tASKID;
    
        return $this;
    }

    /**
     * Get TASK_ID
     *
     * @return integer 
     */
    public function getTASKID()
    {
        return $this->TASK_ID;
    }

    /**
     * Set STATE
     *
     * @param string $sTATE
     * @return Scheduler_order_step_history
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
     * Set START_TIME
     *
     * @param \DateTime $sTARTTIME
     * @return Scheduler_order_step_history
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
     * @return Scheduler_order_step_history
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
     * Set ERROR
     *
     * @param integer $eRROR
     * @return Scheduler_order_step_history
     */
    public function setERROR($eRROR)
    {
        $this->ERROR = $eRROR;
    
        return $this;
    }

    /**
     * Get ERROR
     *
     * @return integer 
     */
    public function getERROR()
    {
        return $this->ERROR;
    }

    /**
     * Set ERROR_CODE
     *
     * @param string $eRRORCODE
     * @return Scheduler_order_step_history
     */
    public function setERRORCODE($eRRORCODE)
    {
        $this->ERROR_CODE = $eRRORCODE;
    
        return $this;
    }

    /**
     * Get ERROR_CODE
     *
     * @return string 
     */
    public function getERRORCODE()
    {
        return $this->ERROR_CODE;
    }

    /**
     * Set ERROR_TEXT
     *
     * @param string $eRRORTEXT
     * @return Scheduler_order_step_history
     */
    public function setERRORTEXT($eRRORTEXT)
    {
        $this->ERROR_TEXT = $eRRORTEXT;
    
        return $this;
    }

    /**
     * Get ERROR_TEXT
     *
     * @return string 
     */
    public function getERRORTEXT()
    {
        return $this->ERROR_TEXT;
    }

    /**
     * Set SOURCE
     *
     * @param integer $sOURCE
     * @return SchedulerOrderStepHistory
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
     * Set SPOOLER
     *
     * @param string $sPOOLER
     * @return SchedulerOrderStepHistory
     */
    public function setSPOOLER($sPOOLER)
    {
        $this->SPOOLER = $sPOOLER;

        return $this;
    }

    /**
     * Get SPOOLER
     *
     * @return string 
     */
    public function getSPOOLER()
    {
        return $this->SPOOLER;
    }

    /**
     * Set CLUSTER_MEMBER
     *
     * @param string $cLUSTERMEMBER
     * @return SchedulerOrderStepHistory
     */
    public function setCLUSTERMEMBER($cLUSTERMEMBER)
    {
        $this->CLUSTER_MEMBER = $cLUSTERMEMBER;

        return $this;
    }

    /**
     * Get CLUSTER_MEMBER
     *
     * @return string 
     */
    public function getCLUSTERMEMBER()
    {
        return $this->CLUSTER_MEMBER;
    }

    /**
     * Set JOB_NAME
     *
     * @param string $jOBNAME
     * @return SchedulerOrderStepHistory
     */
    public function setJOBNAME($jOBNAME)
    {
        $this->JOB_NAME = $jOBNAME;

        return $this;
    }

    /**
     * Get JOB_NAME
     *
     * @return string 
     */
    public function getJOBNAME()
    {
        return $this->JOB_NAME;
    }

    /**
     * Set CAUSE
     *
     * @param string $cAUSE
     * @return SchedulerOrderStepHistory
     */
    public function setCAUSE($cAUSE)
    {
        $this->CAUSE = $cAUSE;

        return $this;
    }

    /**
     * Get CAUSE
     *
     * @return string 
     */
    public function getCAUSE()
    {
        return $this->CAUSE;
    }

    /**
     * Set STEPS
     *
     * @param integer $sTEPS
     * @return SchedulerOrderStepHistory
     */
    public function setSTEPS($sTEPS)
    {
        $this->STEPS = $sTEPS;

        return $this;
    }

    /**
     * Get STEPS
     *
     * @return integer 
     */
    public function getSTEPS()
    {
        return $this->STEPS;
    }

    /**
     * Set EXIT_CODE
     *
     * @param integer $eXITCODE
     * @return SchedulerOrderStepHistory
     */
    public function setEXITCODE($eXITCODE)
    {
        $this->EXIT_CODE = $eXITCODE;

        return $this;
    }

    /**
     * Get EXIT_CODE
     *
     * @return integer 
     */
    public function getEXITCODE()
    {
        return $this->EXIT_CODE;
    }

    /**
     * Set PARAMETERS
     *
     * @param string $pARAMETERS
     * @return SchedulerOrderStepHistory
     */
    public function setPARAMETERS($pARAMETERS)
    {
        $this->PARAMETERS = $pARAMETERS;

        return $this;
    }

    /**
     * Get PARAMETERS
     *
     * @return string 
     */
    public function getPARAMETERS()
    {
        return $this->PARAMETERS;
    }

    /**
     * Set ITEM_START
     *
     * @param string $iTEMSTART
     * @return SchedulerOrderStepHistory
     */
    public function setITEMSTART($iTEMSTART)
    {
        $this->ITEM_START = $iTEMSTART;

        return $this;
    }

    /**
     * Get ITEM_START
     *
     * @return string 
     */
    public function getITEMSTART()
    {
        return $this->ITEM_START;
    }

    /**
     * Set ITEM_STOP
     *
     * @param string $iTEMSTOP
     * @return SchedulerOrderStepHistory
     */
    public function setITEMSTOP($iTEMSTOP)
    {
        $this->ITEM_STOP = $iTEMSTOP;

        return $this;
    }

    /**
     * Get ITEM_STOP
     *
     * @return string 
     */
    public function getITEMSTOP()
    {
        return $this->ITEM_STOP;
    }

    /**
     * Set PID
     *
     * @param integer $pID
     * @return SchedulerOrderStepHistory
     */
    public function setPID($pID)
    {
        $this->PID = $pID;

        return $this;
    }

    /**
     * Get PID
     *
     * @return integer 
     */
    public function getPID()
    {
        return $this->PID;
    }

    /**
     * Set AVG_RUNTIME
     *
     * @param float $aVGRUNTIME
     * @return SchedulerOrderStepHistory
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
     * @return SchedulerOrderStepHistory
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
     * @return SchedulerOrderStepHistory
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
     * @return SchedulerOrderStepHistory
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
     * Set ORDER
     *
     * @param \Arii\JOCBundle\Entity\SchedulerOrderHistory $oRDER
     * @return SchedulerOrderStepHistory
     */
    public function setORDER(\Arii\JOCBundle\Entity\SchedulerOrderHistory $oRDER = null)
    {
        $this->ORDER = $oRDER;

        return $this;
    }

    /**
     * Get ORDER
     *
     * @return \Arii\JOCBundle\Entity\SchedulerOrderHistory 
     */
    public function getORDER()
    {
        return $this->ORDER;
    }
}
