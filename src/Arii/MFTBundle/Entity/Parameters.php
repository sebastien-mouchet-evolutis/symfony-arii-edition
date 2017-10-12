<?php

namespace Arii\MFTBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Connections
 *
 * @ORM\Table(name="MFT_PARAMETERS")
 * @ORM\Entity()
 */
class Parameters
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
     * @ORM\Column(name="name", type="string", length=64 )
     */        
    private $name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=128, nullable=true)
     */        
    private $title;
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=512, nullable=true)
     */        
    private $description;

    /**
     * @var remove
     *
     * @ORM\Column(name="recursive", type="boolean", nullable=true )
     */        
    private $recursive;

    /**
     * @var errorwhennofiles
     *
     * @ORM\Column(name="error_when_no_files", type="boolean", nullable=true )
     */        
    private $error_when_no_files;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="overwrite_files", type="boolean", nullable=true )
     */        
    private $overwrite_files;
        
    /**
     * @var boolean
     *
     * @ORM\Column(name="append_files", type="boolean", nullable=true )
     */        
    private $append_files;
        
    /**
     * @var boolean
     *
     * @ORM\Column(name="transactional", type="boolean", nullable=true  )
     */        
    private $transactional;

    /**
     * @var string
     *
     * @ORM\Column(name="atomic_prefix", type="string", length=32, nullable=true  )
     */        
    private $atomic_prefix;
    
    /**
     * @var string
     *
     * @ORM\Column(name="atomic_suffix", type="string", length=32, nullable=true  )
     */        
    private $atomic_suffix;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="concurrent_transfer", type="boolean", nullable=true )
     */        
    private $concurrent_transfer;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="max_concurrent_transfers", type="integer", nullable=true )
     */        
    private $max_concurrent_transfers;

    /**
     * @var boolean
     *
     * @ORM\Column(name="zero_byte_transfer", type="boolean", nullable=true )
     */        
    private $zero_byte_transfer;

    /**
     * @var boolean
     *
     * @ORM\Column(name="force_files", type="boolean", nullable=true )
     */        
    private $force_files;

    /**
     * @var boolean
     *
     * @ORM\Column(name="remove_files", type="boolean", nullable=true )
     */        
    private $remove_files;

    /**
     * @var boolean
     *
     * @ORM\Column(name="compress_files", type="boolean", nullable=true  )
     */        
    private $compress_files;

    /**
     * @var string
     *
     * @ORM\Column(name="compressed_file_extension", type="string", length=5, nullable=true  )
     */        
    private $compressed_file_extension;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="source_replace", type="boolean", nullable=true)
     */        
    private $source_replace;
    
    /**
     * @var string
     *
     * @ORM\Column(name="source_replacing", type="string", length=512, nullable=true)
     */        
    private $source_replacing;

    /**
     * @var string
     *
     * @ORM\Column(name="source_replacement", type="string", length=512, nullable=true)
     */        
    private $source_replacement;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="target_replace", type="boolean", nullable=true)
     */        
    private $target_replace;
    
    /**
     * @var string
     *
     * @ORM\Column(name="target_replacing", type="string", length=512, nullable=true)
     */        
    private $target_replacing;

    /**
     * @var string
     *
     * @ORM\Column(name="target_replacement", type="string", length=512, nullable=true)
     */        
    private $target_replacement;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="polling", type="boolean", nullable=true  )
     */        
    private $polling;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="poll_interval", type="integer", nullable=true  )
     */        
    private $poll_interval;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="poll_timeout", type="integer", nullable=true  )
     */        
    private $poll_timeout;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="pre_command", type="boolean", nullable=true)
     */        
    private $pre_command;
    
    /**
     * @var string
     *
     * @ORM\Column(name="pre_command_str", type="string", length=512, nullable=true)
     */        
    private $pre_command_str;

    /**
     * @var boolean
     *
     * @ORM\Column(name="post_command", type="boolean", nullable=true)
     */        
    private $post_command;

    /**
     * @var string
     *
     * @ORM\Column(name="post_command_str", type="string", length=512, nullable=true)
     */        
    private $post_command_str;

    /**
     * @var boolean
     *
     * @ORM\Column(name="mail_on_error", type="boolean", nullable=true  )
     */        
    private $mail_on_error;

    /**
     * @var string
     *
     * @ORM\Column(name="mail_on_error_to", type="string", length=512, nullable=true  )
     */        
    private $mail_on_error_to;

    /**
     * @var string
     *
     * @ORM\Column(name="mail_on_error_subject", type="string", length=512, nullable=true  )
     */        
    private $mail_on_error_subject;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="mail_on_success", type="boolean", nullable=true  )
     */        
    private $mail_on_success;

    /**
     * @var string
     *
     * @ORM\Column(name="mail_on_success_to", type="string", length=512, nullable=true  )
     */        
    private $mail_on_success_to;

    /**
     * @var string
     *
     * @ORM\Column(name="mail_on_success_subject", type="string", length=512, nullable=true  )
     */        
    private $mail_on_success_subject;
    
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
     * @return Parameters
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
     * @return Parameters
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
     * @return Parameters
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
     * Set recursive
     *
     * @param boolean $recursive
     * @return Parameters
     */
    public function setRecursive($recursive)
    {
        $this->recursive = $recursive;

        return $this;
    }

    /**
     * Get recursive
     *
     * @return boolean 
     */
    public function getRecursive()
    {
        return $this->recursive;
    }

    /**
     * Set error_when_no_files
     *
     * @param boolean $errorWhenNoFiles
     * @return Parameters
     */
    public function setErrorWhenNoFiles($errorWhenNoFiles)
    {
        $this->error_when_no_files = $errorWhenNoFiles;

        return $this;
    }

    /**
     * Get error_when_no_files
     *
     * @return boolean 
     */
    public function getErrorWhenNoFiles()
    {
        return $this->error_when_no_files;
    }

    /**
     * Set overwrite_files
     *
     * @param boolean $overwriteFiles
     * @return Parameters
     */
    public function setOverwriteFiles($overwriteFiles)
    {
        $this->overwrite_files = $overwriteFiles;

        return $this;
    }

    /**
     * Get overwrite_files
     *
     * @return boolean 
     */
    public function getOverwriteFiles()
    {
        return $this->overwrite_files;
    }

    /**
     * Set transactional
     *
     * @param boolean $transactional
     * @return Parameters
     */
    public function setTransactional($transactional)
    {
        $this->transactional = $transactional;

        return $this;
    }

    /**
     * Get transactional
     *
     * @return boolean 
     */
    public function getTransactional()
    {
        return $this->transactional;
    }

    /**
     * Set atomic_transfer
     *
     * @param boolean $atomicTransfer
     * @return Parameters
     */
    public function setAtomicTransfer($atomicTransfer)
    {
        $this->atomic_transfer = $atomicTransfer;

        return $this;
    }

    /**
     * Get atomic_transfer
     *
     * @return boolean 
     */
    public function getAtomicTransfer()
    {
        return $this->atomic_transfer;
    }

    /**
     * Set concurrent_transfer
     *
     * @param boolean $concurrentTransfer
     * @return Parameters
     */
    public function setConcurrentTransfer($concurrentTransfer)
    {
        $this->concurrent_transfer = $concurrentTransfer;

        return $this;
    }

    /**
     * Get concurrent_transfer
     *
     * @return boolean 
     */
    public function getConcurrentTransfer()
    {
        return $this->concurrent_transfer;
    }

    /**
     * Set zero_byte_transfer
     *
     * @param boolean $zeroByteTransfer
     * @return Parameters
     */
    public function setZeroByteTransfer($zeroByteTransfer)
    {
        $this->zero_byte_transfer = $zeroByteTransfer;

        return $this;
    }

    /**
     * Get zero_byte_transfer
     *
     * @return boolean 
     */
    public function getZeroByteTransfer()
    {
        return $this->zero_byte_transfer;
    }

    /**
     * Set force_files
     *
     * @param boolean $forceFiles
     * @return Parameters
     */
    public function setForceFiles($forceFiles)
    {
        $this->force_files = $forceFiles;

        return $this;
    }

    /**
     * Get force_files
     *
     * @return boolean 
     */
    public function getForceFiles()
    {
        return $this->force_files;
    }

    /**
     * Set remove_files
     *
     * @param boolean $removeFiles
     * @return Parameters
     */
    public function setRemoveFiles($removeFiles)
    {
        $this->remove_files = $removeFiles;

        return $this;
    }

    /**
     * Get remove_files
     *
     * @return boolean 
     */
    public function getRemoveFiles()
    {
        return $this->remove_files;
    }

    /**
     * Set compress_files
     *
     * @param boolean $compressFiles
     * @return Parameters
     */
    public function setCompressFiles($compressFiles)
    {
        $this->compress_files = $compressFiles;

        return $this;
    }

    /**
     * Get compress_files
     *
     * @return boolean 
     */
    public function getCompressFiles()
    {
        return $this->compress_files;
    }

    /**
     * Set poll_interval
     *
     * @param integer $pollInterval
     * @return Parameters
     */
    public function setPollInterval($pollInterval)
    {
        $this->poll_interval = $pollInterval;

        return $this;
    }

    /**
     * Get poll_interval
     *
     * @return integer 
     */
    public function getPollInterval()
    {
        return $this->poll_interval;
    }

    /**
     * Set poll_timeout
     *
     * @param integer $pollTimeout
     * @return Parameters
     */
    public function setPollTimeout($pollTimeout)
    {
        $this->poll_timeout = $pollTimeout;

        return $this;
    }

    /**
     * Get poll_timeout
     *
     * @return integer 
     */
    public function getPollTimeout()
    {
        return $this->poll_timeout;
    }

    /**
     * Set pre_command
     *
     * @param string $preCommand
     * @return Parameters
     */
    public function setPreCommand($preCommand)
    {
        $this->pre_command = $preCommand;

        return $this;
    }

    /**
     * Get pre_command
     *
     * @return string 
     */
    public function getPreCommand()
    {
        return $this->pre_command;
    }

    /**
     * Set post_command
     *
     * @param string $postCommand
     * @return Parameters
     */
    public function setPostCommand($postCommand)
    {
        $this->post_command = $postCommand;

        return $this;
    }

    /**
     * Get post_command
     *
     * @return string 
     */
    public function getPostCommand()
    {
        return $this->post_command;
    }

    /**
     * Set mail_on_error
     *
     * @param boolean $mailOnError
     * @return Parameters
     */
    public function setMailOnError($mailOnError)
    {
        $this->mail_on_error = $mailOnError;

        return $this;
    }

    /**
     * Get mail_on_error
     *
     * @return boolean 
     */
    public function getMailOnError()
    {
        return $this->mail_on_error;
    }

    /**
     * Set mail_on_error_to
     *
     * @param string $mailOnErrorTo
     * @return Parameters
     */
    public function setMailOnErrorTo($mailOnErrorTo)
    {
        $this->mail_on_error_to = $mailOnErrorTo;

        return $this;
    }

    /**
     * Get mail_on_error_to
     *
     * @return string 
     */
    public function getMailOnErrorTo()
    {
        return $this->mail_on_error_to;
    }

    /**
     * Set mail_on_error_subject
     *
     * @param string $mailOnErrorSubject
     * @return Parameters
     */
    public function setMailOnErrorSubject($mailOnErrorSubject)
    {
        $this->mail_on_error_subject = $mailOnErrorSubject;

        return $this;
    }

    /**
     * Get mail_on_error_subject
     *
     * @return string 
     */
    public function getMailOnErrorSubject()
    {
        return $this->mail_on_error_subject;
    }

    /**
     * Set atomic_prefix
     *
     * @param string $atomicPrefix
     * @return Parameters
     */
    public function setAtomicPrefix($atomicPrefix)
    {
        $this->atomic_prefix = $atomicPrefix;

        return $this;
    }

    /**
     * Get atomic_prefix
     *
     * @return string 
     */
    public function getAtomicPrefix()
    {
        return $this->atomic_prefix;
    }

    /**
     * Set atomic_suffix
     *
     * @param string $atomicSuffix
     * @return Parameters
     */
    public function setAtomicSuffix($atomicSuffix)
    {
        $this->atomic_suffix = $atomicSuffix;

        return $this;
    }

    /**
     * Get atomic_suffix
     *
     * @return string 
     */
    public function getAtomicSuffix()
    {
        return $this->atomic_suffix;
    }

    /**
     * Set source_replacing
     *
     * @param string $sourceReplacing
     * @return Parameters
     */
    public function setSourceReplacing($sourceReplacing)
    {
        $this->source_replacing = $sourceReplacing;

        return $this;
    }

    /**
     * Get source_replacing
     *
     * @return string 
     */
    public function getSourceReplacing()
    {
        return $this->source_replacing;
    }

    /**
     * Set source_replacement
     *
     * @param string $sourceReplacement
     * @return Parameters
     */
    public function setSourceReplacement($sourceReplacement)
    {
        $this->source_replacement = $sourceReplacement;

        return $this;
    }

    /**
     * Get source_replacement
     *
     * @return string 
     */
    public function getSourceReplacement()
    {
        return $this->source_replacement;
    }

    /**
     * Set target_replacing
     *
     * @param string $targetReplacing
     * @return Parameters
     */
    public function setTargetReplacing($targetReplacing)
    {
        $this->target_replacing = $targetReplacing;

        return $this;
    }

    /**
     * Get target_replacing
     *
     * @return string 
     */
    public function getTargetReplacing()
    {
        return $this->target_replacing;
    }

    /**
     * Set target_replacement
     *
     * @param string $targetReplacement
     * @return Parameters
     */
    public function setTargetReplacement($targetReplacement)
    {
        $this->target_replacement = $targetReplacement;

        return $this;
    }

    /**
     * Get target_replacement
     *
     * @return string 
     */
    public function getTargetReplacement()
    {
        return $this->target_replacement;
    }

    /**
     * Set append_files
     *
     * @param boolean $appendFiles
     * @return Parameters
     */
    public function setAppendFiles($appendFiles)
    {
        $this->append_files = $appendFiles;

        return $this;
    }

    /**
     * Get append_files
     *
     * @return boolean 
     */
    public function getAppendFiles()
    {
        return $this->append_files;
    }

    /**
     * Set compressed_file_extension
     *
     * @param string $compressedFileExtension
     * @return Parameters
     */
    public function setCompressedFileExtension($compressedFileExtension)
    {
        $this->compressed_file_extension = $compressedFileExtension;

        return $this;
    }

    /**
     * Get compressed_file_extension
     *
     * @return string 
     */
    public function getCompressedFileExtension()
    {
        return $this->compressed_file_extension;
    }

    /**
     * Set pre_command_str
     *
     * @param string $preCommandStr
     * @return Parameters
     */
    public function setPreCommandStr($preCommandStr)
    {
        $this->pre_command_str = $preCommandStr;

        return $this;
    }

    /**
     * Get pre_command_str
     *
     * @return string 
     */
    public function getPreCommandStr()
    {
        return $this->pre_command_str;
    }

    /**
     * Set post_command_str
     *
     * @param string $postCommandStr
     * @return Parameters
     */
    public function setPostCommandStr($postCommandStr)
    {
        $this->post_command_str = $postCommandStr;

        return $this;
    }

    /**
     * Get post_command_str
     *
     * @return string 
     */
    public function getPostCommandStr()
    {
        return $this->post_command_str;
    }

    /**
     * Set max_concurrent_transfers
     *
     * @param integer $maxConcurrentTransfers
     * @return Parameters
     */
    public function setMaxConcurrentTransfers($maxConcurrentTransfers)
    {
        $this->max_concurrent_transfers = $maxConcurrentTransfers;

        return $this;
    }

    /**
     * Get max_concurrent_transfers
     *
     * @return integer 
     */
    public function getMaxConcurrentTransfers()
    {
        return $this->max_concurrent_transfers;
    }

    /**
     * Set source_replace
     *
     * @param boolean $sourceReplace
     * @return Parameters
     */
    public function setSourceReplace($sourceReplace)
    {
        $this->source_replace = $sourceReplace;

        return $this;
    }

    /**
     * Get source_replace
     *
     * @return boolean 
     */
    public function getSourceReplace()
    {
        return $this->source_replace;
    }

    /**
     * Set target_replace
     *
     * @param boolean $targetReplace
     * @return Parameters
     */
    public function setTargetReplace($targetReplace)
    {
        $this->target_replace = $targetReplace;

        return $this;
    }

    /**
     * Get target_replace
     *
     * @return boolean 
     */
    public function getTargetReplace()
    {
        return $this->target_replace;
    }

    /**
     * Set mail_on_success
     *
     * @param boolean $mailOnSuccess
     * @return Parameters
     */
    public function setMailOnSuccess($mailOnSuccess)
    {
        $this->mail_on_success = $mailOnSuccess;

        return $this;
    }

    /**
     * Get mail_on_success
     *
     * @return boolean 
     */
    public function getMailOnSuccess()
    {
        return $this->mail_on_success;
    }

    /**
     * Set mail_on_success_to
     *
     * @param string $mailOnSuccessTo
     * @return Parameters
     */
    public function setMailOnSuccessTo($mailOnSuccessTo)
    {
        $this->mail_on_success_to = $mailOnSuccessTo;

        return $this;
    }

    /**
     * Get mail_on_success_to
     *
     * @return string 
     */
    public function getMailOnSuccessTo()
    {
        return $this->mail_on_success_to;
    }

    /**
     * Set mail_on_success_subject
     *
     * @param string $mailOnSuccessSubject
     * @return Parameters
     */
    public function setMailOnSuccessSubject($mailOnSuccessSubject)
    {
        $this->mail_on_success_subject = $mailOnSuccessSubject;

        return $this;
    }

    /**
     * Get mail_on_success_subject
     *
     * @return string 
     */
    public function getMailOnSuccessSubject()
    {
        return $this->mail_on_success_subject;
    }

    /**
     * Set polling
     *
     * @param boolean $polling
     * @return Parameters
     */
    public function setPolling($polling)
    {
        $this->polling = $polling;

        return $this;
    }

    /**
     * Get polling
     *
     * @return boolean 
     */
    public function getPolling()
    {
        return $this->polling;
    }
}
