<?php

namespace Arii\ReportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Audit
 *
 * @ORM\Table(name="IMPORT_EZV")
 * @ORM\Entity()
 */
class EZV
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
     * @var integer
     *
     * @ORM\Column(name="asset_id", type="integer")
     */
    private $asset_id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="asset_tag", type="string", length=32, nullable=true)
     */
    private $asset_tag;

    /**
     * @var string
     *
     * @ORM\Column(name="network_identifier", type="string", length=64, nullable=true)
     */
    private $network_identifier;
    
    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=128, nullable=true)
     */
    private $role;
    
    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=64, nullable=true)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="status_ci", type="string", length=64, nullable=true)
     */
    private $status_ci;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_update", type="datetime", nullable=true)
     */
    private $last_update;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="installation", type="datetime", nullable=true)
     */
    private $installation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="removed", type="datetime", nullable=true)
     */
    private $removed;

    /**
     * @var string
     *
     * @ORM\Column(name="serial", type="string", length=64, nullable=true)
     */
    private $serial;

    /**
     * @var string
     *
     * @ORM\Column(name="classification", type="string", length=128, nullable=true)
     */
    private $classification;

    /**
     * @var string
     *
     * @ORM\Column(name="classification_path", type="string", length=255, nullable=true)
     */
    private $classification_path;
    
    /**
     * @var string
     *
     * @ORM\Column(name="rdi", type="string", length=64, nullable=true)
     */
    private $rdi;
        
    /**
     * @var string
     *
     * @ORM\Column(name="rda", type="string", length=64, nullable=true)
     */
    private $rda;

    /**
     * @var string
     *
     * @ORM\Column(name="rdm", type="string", length=64, nullable=true)
     */
    private $rdm;

    /**
     * @var string
     *
     * @ORM\Column(name="backup_status", type="string", length=128, nullable=true)
     */
    private $backup_status;
    
    /**
     * @var string
     *
     * @ORM\Column(name="backup_platform", type="string", length=64, nullable=true)
     */
    private $backup_platform;
    
    /**
     * @var string
     *
     * @ORM\Column(name="backup_type", type="string", length=64, nullable=true)
     */
    private $backup_type;

    /**
     * @var string
     *
     * @ORM\Column(name="backup_policy", type="string", length=64, nullable=true)
     */
    private $backup_policy;

    /**
     * @var string
     *
     * @ORM\Column(name="backup_agent", type="string", length=64, nullable=true)
     */
    private $backup_agent;

    /**
     * @var string
     *
     * @ORM\Column(name="backup_select", type="string", length=128, nullable=true)
     */
    private $backup_select;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="backup_date", type="datetime", nullable=true)
     */
    private $backup_date;

    /**
     * @var string
     *
     * @ORM\Column(name="backup_no", type="string", length=128, nullable=true)
     */
    private $backup_no;

    /**
     * @var string
     *
     * @ORM\Column(name="backup_alarm", type="string", length=64, nullable=true )
     */
    private $backup_alarm;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="backup_alarm_notify", type="integer", nullable=true )
     */
    private $backup_alarm_notify;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_ci", type="boolean", nullable=true)
     */
    private $is_ci;

    /**
     * @var boolean
     *
     * @ORM\Column(name="belongs_to_the_assets", type="boolean", nullable=true)
     */
    private $belongs_to_the_assets;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_stock_status", type="boolean", nullable=true)
     */
    private $is_stock_status;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    private $updated;

    /**
     * @var string
     *
     * @ORM\Column(name="os", type="string", length=128, nullable=true)
     */
    private $OS;

    /**
     * @var string
     *
     * @ORM\Column(name="component", type="string", length=128, nullable=true)
     */
    private $component;
    
    /**
     * @var string
     *
     * @ORM\Column(name="environment", type="string", length=128, nullable=true)
     */
    private $environment;

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
     * Set function
     *
     * @param string $function
     * @return EZV
     */
    public function setFunction($function)
    {
        $this->function = $function;

        return $this;
    }

    /**
     * Get function
     *
     * @return string 
     */
    public function getFunction()
    {
        return $this->function;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return EZV
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
     * Set last_update
     *
     * @param \DateTime $lastUpdate
     * @return EZV
     */
    public function setLastUpdate($lastUpdate)
    {
        $this->last_update = $lastUpdate;

        return $this;
    }

    /**
     * Get last_update
     *
     * @return \DateTime 
     */
    public function getLastUpdate()
    {
        return $this->last_update;
    }

    /**
     * Set installation
     *
     * @param \DateTime $installation
     * @return EZV
     */
    public function setInstallation($installation)
    {
        $this->installation = $installation;

        return $this;
    }

    /**
     * Get installation
     *
     * @return \DateTime 
     */
    public function getInstallation()
    {
        return $this->installation;
    }

    /**
     * Set removed
     *
     * @param \DateTime $removed
     * @return EZV
     */
    public function setRemoved($removed)
    {
        $this->removed = $removed;

        return $this;
    }

    /**
     * Get removed
     *
     * @return \DateTime 
     */
    public function getRemoved()
    {
        return $this->removed;
    }

    /**
     * Set serial
     *
     * @param string $serial
     * @return EZV
     */
    public function setSerial($serial)
    {
        $this->serial = $serial;

        return $this;
    }

    /**
     * Get serial
     *
     * @return string 
     */
    public function getSerial()
    {
        return $this->serial;
    }

    /**
     * Set rdi
     *
     * @param string $rdi
     * @return EZV
     */
    public function setRdi($rdi)
    {
        $this->rdi = $rdi;

        return $this;
    }

    /**
     * Get rdi
     *
     * @return string 
     */
    public function getRdi()
    {
        return $this->rdi;
    }

    /**
     * Set rda
     *
     * @param string $rda
     * @return EZV
     */
    public function setRda($rda)
    {
        $this->rda = $rda;

        return $this;
    }

    /**
     * Get rda
     *
     * @return string 
     */
    public function getRda()
    {
        return $this->rda;
    }

    /**
     * Set rdm
     *
     * @param string $rdm
     * @return EZV
     */
    public function setRdm($rdm)
    {
        $this->rdm = $rdm;

        return $this;
    }

    /**
     * Get rdm
     *
     * @return string 
     */
    public function getRdm()
    {
        return $this->rdm;
    }

    /**
     * Set backup_status
     *
     * @param string $backupStatus
     * @return EZV
     */
    public function setBackupStatus($backupStatus)
    {
        $this->backup_status = $backupStatus;

        return $this;
    }

    /**
     * Get backup_status
     *
     * @return string 
     */
    public function getBackupStatus()
    {
        return $this->backup_status;
    }

    /**
     * Set backup_platform
     *
     * @param string $backupPlatform
     * @return EZV
     */
    public function setBackupPlatform($backupPlatform)
    {
        $this->backup_platform = $backupPlatform;

        return $this;
    }

    /**
     * Get backup_platform
     *
     * @return string 
     */
    public function getBackupPlatform()
    {
        return $this->backup_platform;
    }

    /**
     * Set backup_type
     *
     * @param string $backupType
     * @return EZV
     */
    public function setBackupType($backupType)
    {
        $this->backup_type = $backupType;

        return $this;
    }

    /**
     * Get backup_type
     *
     * @return string 
     */
    public function getBackupType()
    {
        return $this->backup_type;
    }

    /**
     * Set backup_policy
     *
     * @param string $backupPolicy
     * @return EZV
     */
    public function setBackupPolicy($backupPolicy)
    {
        $this->backup_policy = $backupPolicy;

        return $this;
    }

    /**
     * Get backup_policy
     *
     * @return string 
     */
    public function getBackupPolicy()
    {
        return $this->backup_policy;
    }

    /**
     * Set backup_agent
     *
     * @param string $backupAgent
     * @return EZV
     */
    public function setBackupAgent($backupAgent)
    {
        $this->backup_agent = $backupAgent;

        return $this;
    }

    /**
     * Get backup_agent
     *
     * @return string 
     */
    public function getBackupAgent()
    {
        return $this->backup_agent;
    }

    /**
     * Set backup_select
     *
     * @param string $backupSelect
     * @return EZV
     */
    public function setBackupSelect($backupSelect)
    {
        $this->backup_select = $backupSelect;

        return $this;
    }

    /**
     * Get backup_select
     *
     * @return string 
     */
    public function getBackupSelect()
    {
        return $this->backup_select;
    }

    /**
     * Set backup_date
     *
     * @param string $backupDate
     * @return EZV
     */
    public function setBackupDate($backupDate)
    {
        $this->backup_date = $backupDate;

        return $this;
    }

    /**
     * Get backup_date
     *
     * @return string 
     */
    public function getBackupDate()
    {
        return $this->backup_date;
    }

    /**
     * Set backup_no
     *
     * @param string $backupNo
     * @return EZV
     */
    public function setBackupNo($backupNo)
    {
        $this->backup_no = $backupNo;

        return $this;
    }

    /**
     * Get backup_no
     *
     * @return string 
     */
    public function getBackupNo()
    {
        return $this->backup_no;
    }

    /**
     * Set backup_alarm
     *
     * @param integer $backupAlarm
     * @return EZV
     */
    public function setBackupAlarm($backupAlarm)
    {
        $this->backup_alarm = $backupAlarm;

        return $this;
    }

    /**
     * Get backup_alarm
     *
     * @return integer 
     */
    public function getBackupAlarm()
    {
        return $this->backup_alarm;
    }

    /**
     * Set backup_alarm
     *
     * @param integer $backupAlarm
     * @return EZV
     */
    public function setBackupAlarmNotify($backupAlarmNotify)
    {
        $this->backup_alarm_notify = $backupAlarmNotify;

        return $this;
    }

    /**
     * Get backup_alarm
     *
     * @return integer 
     */
    public function getBackupAlarmNotify()
    {
        return $this->backup_alarm_notify;
    }

    /**
     * Set role
     *
     * @param string $role
     * @return EZV
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string 
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return EZV
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
     * Set status_ci
     *
     * @param string $statusCi
     * @return EZV
     */
    public function setStatusCi($statusCi)
    {
        $this->status_ci = $statusCi;

        return $this;
    }

    /**
     * Get status_ci
     *
     * @return string 
     */
    public function getStatusCi()
    {
        return $this->status_ci;
    }
    
    /**
     * Set is_ci
     *
     * @param string $isCi
     * @return EZV
     */
    public function setIsCi($isCi)
    {
        $this->is_ci = $isCi;

        return $this;
    }

    /**
     * Get is_ci
     *
     * @return string 
     */
    public function getIsCi()
    {
        return $this->is_ci;
    }
    

    /**
     * Set classification
     *
     * @param string $classification
     * @return EZV
     */
    public function setClassification($classification)
    {
        $this->classification = $classification;

        return $this;
    }

    /**
     * Get classification
     *
     * @return string 
     */
    public function getClassification()
    {
        return $this->classification;
    }

    /**
     * Set classification_path
     *
     * @param string $classificationPath
     * @return EZV
     */
    public function setClassificationPath($classificationPath)
    {
        $this->classification_path = $classificationPath;

        return $this;
    }

    /**
     * Get classification_path
     *
     * @return string 
     */
    public function getClassificationPath()
    {
        return $this->classification_path;
    }

    /**
     * Set belongs_to_the_assets
     *
     * @param boolean $belongsToTheAssets
     * @return EZV
     */
    public function setBelongsToTheAssets($belongsToTheAssets)
    {
        $this->belongs_to_the_assets = $belongsToTheAssets;

        return $this;
    }

    /**
     * Get belongs_to_the_assets
     *
     * @return boolean 
     */
    public function getBelongsToTheAssets()
    {
        return $this->belongs_to_the_assets;
    }

    /**
     * Set is_stock_status
     *
     * @param boolean $isStockStatus
     * @return EZV
     */
    public function setIsStockStatus($isStockStatus)
    {
        $this->is_stock_status = $isStockStatus;

        return $this;
    }

    /**
     * Get is_stock_status
     *
     * @return boolean 
     */
    public function getIsStockStatus()
    {
        return $this->is_stock_status;
    }

    /**
     * Set network_identifier
     *
     * @param string $networkIdentifier
     * @return EZV
     */
    public function setNetworkIdentifier($networkIdentifier)
    {
        $this->network_identifier = $networkIdentifier;

        return $this;
    }

    /**
     * Get network_identifier
     *
     * @return string 
     */
    public function getNetworkIdentifier()
    {
        return $this->network_identifier;
    }

    /**
     * Set asset_id
     *
     * @param string $assetId
     * @return EZV
     */
    public function setAssetId($assetId)
    {
        $this->asset_id = $assetId;

        return $this;
    }

    /**
     * Get asset_id
     *
     * @return string 
     */
    public function getAssetId()
    {
        return $this->asset_id;
    }

    /**
     * Set asset_tag
     *
     * @param string $assetTag
     * @return EZV
     */
    public function setAssetTag($assetTag)
    {
        $this->asset_tag = $assetTag;

        return $this;
    }

    /**
     * Get asset_tag
     *
     * @return string 
     */
    public function getAssetTag()
    {
        return $this->asset_tag;
    }

    /**
     * Set OS
     *
     * @param string $oS
     * @return EZV
     */
    public function setOS($oS)
    {
        $this->OS = $oS;

        return $this;
    }

    /**
     * Get OS
     *
     * @return string 
     */
    public function getOS()
    {
        return $this->OS;
    }

    /**
     * Set component
     *
     * @param string $component
     * @return EZV
     */
    public function setComponent($component)
    {
        $this->component = $component;

        return $this;
    }

    /**
     * Get component
     *
     * @return string 
     */
    public function getComponent()
    {
        return $this->component;
    }

    /**
     * Set environment
     *
     * @param string $environment
     * @return EZV
     */
    public function setEnvironment($environment)
    {
        $this->environment = $environment;

        return $this;
    }

    /**
     * Get environment
     *
     * @return string 
     */
    public function getEnvironment()
    {
        return $this->environment;
    }
}
