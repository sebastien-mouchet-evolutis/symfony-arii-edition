<?php

namespace Arii\ACKBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ObjectRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ObjectRepository extends EntityRepository
{
    public function findHosts($object = 'HOST') {        
        $q = $this
        ->createQueryBuilder('e')
        ->select('e.id,e.name,e.title,e.description')
        ->orderBy('e.name,e.obj_type','DESC')
        ->where('e.obj_type = :object')
        ->orderBy('e.name')
        ->setParameter('object', $object )
        ->getQuery();
        return $q->getResult();
    }
}
