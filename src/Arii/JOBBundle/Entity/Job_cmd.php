<?php

namespace Arii\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cron
 *
 * @ORM\Table(name="JOB_DEF_CMD")
 * @ORM\Entity(repositoryClass="Arii\JOBBundle\Entity\RequestsRepository")
 */
class JobCmd
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
     * @ORM\Column(name="name", type="string", length=64, nullable=true)
     */        
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="app_name", type="string", length=64, nullable=true)
     */        
    private $app_name;

    /**
     * @var string
     *
     * @ORM\Column(name="group_name", type="string", length=64, nullable=true)
     */        
    private $group_name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=64, nullable=true)
     */        
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="command_type", type="string", length=64, nullable=true)
     */        
    private $command_type;
    
}
