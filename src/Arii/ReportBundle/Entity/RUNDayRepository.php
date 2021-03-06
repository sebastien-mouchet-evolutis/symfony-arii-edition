<?php

namespace Arii\ReportBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * RUNDayRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RUNDayRepository extends EntityRepository
{
   /* liste d'apps concernée par les excutions */
   public function findApps($start,$end,$env='*',$class='*',$sort='run.app',$order='ASC')
   {
        $qb = $this->createQueryBuilder('run')
            ->Select('run.app,sum(run.executions) as runs,sum(run.alarms) as alarms,(sum(run.alarms)/sum(run.executions)) as rate')
            ->where('run.date >= :start')
            ->andWhere('run.date <= :end')
            ->andWhere('run.executions > 0')
            ->groupBy('run.app')
            ->orderBy($sort,$order)
            ->setParameter('start', $start)
            ->setParameter('end', $end);

        if ($env!='*')
            $qb->andWhere('run.env = :env')
                 ->setParameter('env', $env);

        if ($class!='*')
            $qb->andWhere('run.job_class = :class')
                 ->setParameter('class', $class);        

        return $qb->getQuery()
            ->getResult();
   }

    
   public function findRunsByMonth(\DateTime $from, \DateTime $to)
   {
        $driver = $this->_em->getConnection()->getDriver()->getName();
        switch ($driver) {
            case 'oci8':
                $sql = "SELECT EXTRACT(YEAR FROM run.run_date) as run_year,EXTRACT(MONTH FROM run.run_date) as run_month,run.app,run.env,run.job_class,run.spooler_name,run.job_class,sum(run.executions) as runs,sum(run.warnings) as warnings,sum(run.alarms) as alarms,sum(run.acks) as acks
                        FROM REPORT_RUN_DAY run
                        WHERE run.run_date >= :from
                        AND run.run_date <= :to
                        GROUP BY EXTRACT(YEAR FROM run.run_date),EXTRACT(MONTH FROM run.run_date),run.app,run.env,run.spooler_name,run.job_class";

                $rsm = new ResultSetMapping();
                $rsm->addScalarResult('RUN_YEAR', 'run_year');
                $rsm->addScalarResult('RUN_MONTH', 'run_month');                
                $rsm->addScalarResult('APP', 'app');
                $rsm->addScalarResult('ENV', 'env');
                $rsm->addScalarResult('JOB_CLASS', 'job_class');
                $rsm->addScalarResult('SPOOLER_NAME', 'spooler_name');
                $rsm->addScalarResult('RUNS', 'runs');
                $rsm->addScalarResult('WARNINGS', 'warnings');                
                $rsm->addScalarResult('ALARMS', 'alarms');
                $rsm->addScalarResult('ACKS', 'acks');
                $query = $this->_em->createNativeQuery($sql, $rsm)
                        ->setParameter('from', $from )
                        ->setParameter('to', $to );                
                return $query->getResult();         
                break;
            default:
                return $this->createQueryBuilder('run')
                      ->Select('Year(run.date) as run_year,Month(run.date) as run_month,run.app,run.env,run.spooler_name,sum(run.executions) as runs,sum(run.alarms) as alarms,sum(run.acks) as acks')
                      ->groupBy('run_year,run_month,run.app,run.env,run.spooler_name')
                      ->getQuery()
                      ->getResult();
                break;
        }
   }

   public function findByDay($start,$end,$env='*',$app='*',$class='*',$detail=false) {
       
       // champs
       if ($detail) {
           $f = 'run.app,run.env,run.spooler.name,';
       }
       else {
           $f = '';
       }
       $g = '';
       // regroupement
       if ($app!='*')
           $g .= ',run.app';
       if ($env!='*')
           $g .= ',run.env';
       if ($class!='*')
           $g .= ',run.job_class';

        $qb = $this->createQueryBuilder('run')
            ->Select('run.date,'.$f.'sum(run.executions) as runs,sum(run.alarms) as alarms,sum(run.acks) as acks')
            ->where('run.date >= :start')
            ->andWhere('run.date <= :end')
            ->groupBy('run.date'.$g)
            ->orderBy('run.date'.$g)
            ->setParameter('start', $start)
            ->setParameter('end', $end);

        if ($env!='*')
            $qb->andWhere('run.env = :env')
                 ->setParameter('env', $env);
        if ($app!='*')
            $qb->andWhere('run.app = :app')
                 ->setParameter('app', $app);
        if ($class!='*')
            $qb->andWhere('run.job_class = :class')
                 ->setParameter('class', $class);
/*        
    $query = $qb->getQuery();
    print $query->getSQL();
    print_r($query->getParameters());
    exit();
*/           
        return $qb->getQuery()
            ->getResult();
}
   
   public function findAlarms($time, $app='%', $env='P')
   {
       if (($env=='*') or ($env=='')) {
            return $this->createQueryBuilder('run')
                ->Select('run.app','sum(run.alarms) as nb')
                ->where('run.date > :time')
                ->groupBy('run.app')
                ->orderBy('nb','DESC')
                ->setParameter('time', $time)
                ->getQuery()
                ->getResult();
       }
       else {
            return $this->createQueryBuilder('run')
                ->Select('run.app','run.env','sum(run.alarms) as nb')
                ->where('run.date > :time')
                ->andWhere('run.env = :env')
                ->groupBy('run.app','run.env')
                ->orderBy('nb','DESC')
                ->setParameter('time', $time)
                ->setParameter('env', $env)
                ->getQuery()
                ->getResult();
       }
   }

   public function findAcks($time, $app='%', $env='P')
   {
        return $this->createQueryBuilder('run')
            ->Select('run.app','run.env','sum(run.acks) as nb')
            ->where('run.date > :time')
            ->andWhere('run.env = :env')
            ->groupBy('run.app','run.env')
            ->orderBy('nb','DESC')
            ->setParameter('time', $time)
            ->setParameter('env', $env)
            ->getQuery()
            ->getResult();
   }
   
   public function findExecutions($start,$end, $env='P', $app='ALL')
   {
       if (($app=='*') and ($env=='*')) {
           return $this->createQueryBuilder('run')
                 ->Select('Year(run.date) as annee,Month(run.date) as mois,sum(run.warnings) as warnings,sum(run.alarms) as alarms,sum(run.acks) as acks,sum(run.executions) as executions')
                 ->where('run.date >= :start')
                 ->andWhere('run.date <= :end')
                 ->groupBy('annee,mois')
                 ->setParameter('start', $start)
                 ->setParameter('end', $end)
                 ->getQuery()
                 ->getResult();
       }
       elseif ($app=='*') {
            return $this->createQueryBuilder('run')
                 ->Select('Year(run.date) as annee,Month(run.date) as mois,run.env,sum(run.warnings) as warnings,sum(run.alarms) as alarms,sum(run.acks) as acks,sum(run.executions) as executions')
                 ->where('run.date >= :start')
                 ->andWhere('run.date <= :end')
                 ->andWhere('run.env = :env')
                 ->groupBy('annee,mois,run.env')
                 ->setParameter('start', $start)
                 ->setParameter('end', $end)
                 ->setParameter('env', $env)
                 ->getQuery()
                 ->getResult();
       }
       elseif ($env=='*') {
            return $this->createQueryBuilder('run')
                 ->Select('Year(run.date) as annee,Month(run.date) as mois,run.app,sum(run.warnings) as warnings,sum(run.alarms) as alarms,sum(run.acks) as acks,sum(run.executions) as executions')
                 ->where('run.date >= :start')
                 ->andWhere('run.date <= :end')
                 ->andWhere('run.app = :app')
                 ->groupBy('annee,mois,run.app')
                 ->setParameter('start', $start)
                 ->setParameter('end', $end)
                 ->setParameter('app', $app)
                 ->getQuery()
                 ->getResult();
       }
       else {
            return $this->createQueryBuilder('run')
                 ->Select('Year(run.date) as annee,Month(run.date) as mois,sum(run.warnings) as warnings,sum(run.alarms) as alarms,sum(run.acks) as acks,sum(run.executions) as executions')
                 ->where('run.date >= :start')
                 ->andWhere('run.date <= :end')
                 ->andWhere('run.env = :env')
                 ->andWhere('run.app = :app')
                 ->groupBy('annee,mois')
                 ->setParameter('start', $start)
                 ->setParameter('end', $end)
                 ->setParameter('env', $env)
                 ->setParameter('app', $app)
                 ->getQuery()
                 ->getResult();
       }
   }
   
   public function findExecutionsByApp($day,$env='*')
   {
        $query = $this->createQueryBuilder('run')
             ->Select('run.app,run.date,run.env,run.alarms,run.acks,run.executions')
             ->where('run.date = :day')
             ->orderBy('run.app')
             ->setParameter('day', $day);
        
        if ($env!='*')
            $query->andWhere('run.env = :env')
                ->setParameter('env', $env);
        
        return $query->getQuery()
             ->getResult(); 
   }
   
   public function findLast()
   {
        return $this->createQueryBuilder('run')
            ->Select('count(run) as NB,max(run.date) as lastUpdate')
            ->getQuery()
            ->getResult();
   }
   
}