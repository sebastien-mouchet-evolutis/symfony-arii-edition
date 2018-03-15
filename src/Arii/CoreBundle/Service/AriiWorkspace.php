<?php
namespace Arii\CoreBundle\Service;

use Doctrine\ORM\EntityManager;

# Gestion des requêtes
class AriiWorkspace
{
    protected $portal;
    protected $doctrine;

    # Contexte du portail
    public function __construct(AriiPortal $portal, $doctrine )
    {
        $this->portal = $portal;
        $this->doctrine = $doctrine;
    }
    
}
