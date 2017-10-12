<?php

namespace Arii\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rule
 *
 * @ORM\Table(name="ARII_RULE")
 * @ORM\Entity()
 */
class Rule
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
     * @ORM\Column(name="in_job", type="string", length=128)
     */
    private $in_job;
    
    /**
     * @var string
     *
     * @ORM\Column(name="out_app", type="string", length=128)
     */
    private $out_app;
    
    /**
     * @var string
     *
     * @ORM\Column(name="out_env", type="string", length=128)
     */
    private $out_env;
    

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
     * Set in_job
     *
     * @param string $inJob
     * @return RUL
     */
    public function setInJob($inJob)
    {
        $this->in_job = $inJob;

        return $this;
    }

    /**
     * Get in_job
     *
     * @return string 
     */
    public function getInJob()
    {
        return $this->in_job;
    }

    /**
     * Set out_app
     *
     * @param string $outApp
     * @return RUL
     */
    public function setOutApp($outApp)
    {
        $this->out_app = $outApp;

        return $this;
    }

    /**
     * Get out_app
     *
     * @return string 
     */
    public function getOutApp()
    {
        return $this->out_app;
    }

    /**
     * Set out_env
     *
     * @param string $outEnv
     * @return RUL
     */
    public function setOutEnv($outEnv)
    {
        $this->out_env = $outEnv;

        return $this;
    }

    /**
     * Get out_env
     *
     * @return string 
     */
    public function getOutEnv()
    {
        return $this->out_env;
    }
}
