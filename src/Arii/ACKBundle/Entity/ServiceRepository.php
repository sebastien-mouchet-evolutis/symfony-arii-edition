<?php

namespace Arii\ACKBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ServiceRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ServiceRepository extends EntityRepository
{
    public function listAll() {        
        $q = $this
        ->createQueryBuilder('e')
        ->select('e.id,e.name,e.title,e.obj_type,e.description')
        ->orderBy('e.name,e.obj_type','DESC')
        ->getQuery();
        return $q->getResult();
    }

    public function purge($date, $state='CLOSE') {        
        $q = $this
        ->createQueryBuilder('e')
        ->update()
        ->set('e.state', $state)
        ->where('e.state <> :state')
        ->andWhere('e.state_time < :date')
        ->setParameter('date', $date)
        ->setParameter('state', $state)
        ->getQuery();
        return $q->getResult();
    }
    
}
