<?php

namespace Arii\ReportBundle\Controller\Import;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
        
class OJSController extends Controller
{
 
    public function db_order_runsAction($db='',$limit=100) {

        if ($this->container->has('profiler'))
            $this->container->get('profiler')->disable();
        set_time_limit(3600);
        
        $em = $this->getDoctrine()->getManager();
        // On récupère l'id de la dernière synchro
        
        $Sync = $em->getRepository("AriiReportBundle:SYNC")->findOneBy([
            'name' => $db,
            'entity' => 'SchedulerOrderHistory'
        ]);
        
        if (!$Sync) {
            $Sync = new \Arii\ReportBundle\Entity\SYNC();
            $last_id = 0;
        }
        else {
            $last_id = $Sync->getLastId();
        }
        $Sync->setName($db);
        $Sync->setEntity('SchedulerOrderHistory');
    
        $ojs = $this->getDoctrine()->getManager($db);
        // On flush par partie et on appelle l'url régulièrement
        $new = $update = $n = $new_job = $upd_job = 0;
        $debut = time();
        
        $qb = $ojs->createQueryBuilder('o')
            ->select('o')
            ->from('AriiJIDBundle:SchedulerOrderHistory','o')
            ->where('o.history > :last_id')
            ->orderBy('o.history')
            ->setParameter('last_id', $last_id)
            ->setMaxResults($limit);
        
        $History = $qb->getQuery()->getResult();
        if (!$History) {
            // throw new \Exception($db);
            return new Response("$db [$last_id]"); 
        }
        
        foreach ($History as $Info) {
            
            // unicite par spooler/job/start
            $Run = $em->getRepository("AriiReportBundle:RUN")->findOneBy(
                    [   'spooler_name' => $Info->getSpoolerId(), 
                        'job_name'=> $Info->getJobChain(), 
                        'start_time'=> $Info->getStartTime()
                    ]);
/*            
print $Info->getSpoolerId();
print $Info->getJobChain();
print_r( $Info->getStartTime() );

print $Run->getJobName();
*/
            # Si le job n'existe pas, on le crée
            if (!$Run) {                
                $Run= new \Arii\ReportBundle\Entity\RUN();    
                $new++;
            }
            else {
                print ".".$Run->getId();
            }
            
            $Run->setSpoolerName($Info->getSpoolerId());
            $Run->setJobName($Info->getJobChain());
            $Run->setJobTrigger($Info->getOrderId());

            $Run->setStartTime($Info->getStartTime());
            if ($Info->getEndTime()!='')
                $Run->setEndTime($Info->getEndTime());
            else // on force la remise à null pour compléter avec le jour suivant si on fait une reprise.
                $Run->setEndTime(null);
            
            $Run->setStatus($Info->getState());
            $Run->setRun($Info->getHistory());
            $Run->setMessage($Info->getStateText());
            
           // Cas de l'update
            if ($Run->getJob()) {
                $Job = $Run->getJob();
            }
            else {
                // On rattache aux informations du job
                $Job = $em->getRepository("AriiReportBundle:JOB")->findOneBy(
                        array(
                            'spooler_name'=> $Info->getSpoolerId(),
                            'job_name'=> $Info->getJobChain()
                        ));
            }

            if (!$Job) { # sinon on cree le job
                print "+ ".$Info->getJobChain()."<br/>";

                $Job= new \Arii\ReportBundle\Entity\JOB();
                $Job->setCreated($Info->getStartTime());                    

                // On devrait pouvoir retrouver le spooler reference dans le portail, intérêt ?
                $Job->setSpoolerName($Info->getSpoolerId());

                $Job->setJobName($Info->getJobChain());
                $Job->setJobType('ORDER');

                $Job->setFirstExecution($Info->getStartTime());
                if ($Info->getEndTime()!='')
                    $Job->setLastExecution($Info->getEndTime());
                
                $Job->setUpdated(new \Datetime());

                $em->persist($Job);
                // on flush tout de suite
                $em->flush();
                
                $new_job++;
            }
            else {
                $flag=false;
                if ($Info->getEndTime()!='')
                    $End_time = $Info->getEndTime();
                else 
                    $End_time = new \Datetime('1970-01-01');
                if ((!$Job->getFirstExecution())                         
                    or ($Info->getStartTime()<$Job->getFirstExecution())) {
                    $Job->setFirstExecution($Info->getStartTime());
                    $flag = true;
                }
                if ((!$Job->getLastExecution())
                    or ($Info->getEndTime()>$Job->getLastExecution())) {
                    $Job->setLastExecution($Info->getEndTime());                    
                    $flag = true;
                }
                if ($flag)
                    $upd_job++;  
                
                $Job->setUpdated(new \Datetime());
                $em->persist($Job);                
            }

            $Run->setJob($Job);
            $em->persist($Run);
            
            $n++;
        }

        # flush final
        $new_id = $Info->getHistory();
        $Sync->setLastId($new_id);
        $Sync->setLastUpdate(new \Datetime());
        $em->persist($Sync);
        $em->flush();
        
        return new Response("[$last_id => $new_id] New ($new) Update (".($n-$new)." New job ($new_job) Upd job ($upd_job) ".(time() - $debut)."s");
    }    

    public function db_job_runsAction($db='',$limit=100) {

        if ($this->container->has('profiler'))
            $this->container->get('profiler')->disable();
        set_time_limit(3600);
        
        $em = $this->getDoctrine()->getManager();
        // On récupère l'id de la dernière synchro
        
        $Sync = $em->getRepository("AriiReportBundle:SYNC")->findOneBy([
            'name' => $db,
            'entity' => 'SchedulerHistory'
        ]);
        
        if (!$Sync) {
            $Sync = new \Arii\ReportBundle\Entity\SYNC();
            $last_id = 0;
        }
        else {
            $last_id = $Sync->getLastId();
        }
        $Sync->setName($db);
        $Sync->setEntity('SchedulerHistory');

        $ojs = $this->getDoctrine()->getManager($db);
        // On flush par partie et on appelle l'url régulièrement
        $new = $update = $n = $new_job = $upd_job = 0;
        $debut = time();
        
        $qb = $ojs->createQueryBuilder()
            ->Select('h')          
            ->from('AriiJIDBundle:SchedulerHistory','h')
            ->leftjoin('AriiJIDBundle:SchedulerOrderStepHistory','s',\Doctrine\ORM\Query\Expr\Join::WITH,'h = s.task')
            ->leftjoin('AriiJIDBundle:SchedulerOrderHistory','o',\Doctrine\ORM\Query\Expr\Join::WITH,'s.history = o.history')      
            ->addSelect('o.jobChain,o.orderId')
            ->where('h.id > :last_id')
            ->orderBy('h.id')
            ->setParameter('last_id', $last_id)
            ->setMaxResults($limit);
        
        $History = $qb->getQuery()->getResult();
        if (!$History) {
            // throw new \Exception("$db ?!");
            // Simplement rien a ajouter
            return new Response("$db [$last_id]");
            
        }
        
        foreach ($History as $I) {
            $Info = $I[0];

            // unicite par spooler/job/start
            $Run = $em->getRepository("AriiReportBundle:RUN")->findOneBy(
                    [   'spooler_name' => $Info->getSpoolerId(), 
                        'job_name'=> $Info->getJobName(), 
                        'start_time'=> $Info->getStartTime()
                    ]);

            # Si le job n'existe pas, on le crée
            if (!$Run) {                
                $Run= new \Arii\ReportBundle\Entity\RUN();    
                $new++;
            }
            else {
                # Ne doit pas arriver.
                print ".".$Run->getId();
            }
            
            $Run->setSpoolerName($Info->getSpoolerId());
            $Run->setJobName($Info->getJobName());
            
            # Standalone ou non 
            if ($I['jobChain']!='') {
                $job_chain = $I['jobChain'];
                # Job  lié
                $Link = $em->getRepository("AriiReportBundle:JOB")->findOneBy(
                array(
                    'spooler_name'=> $Info->getSpoolerId(),
                    'job_name'=> $job_chain
                ));                
                if ($Link) {
                    $Run->setJob($Link);
                    $Run->setJobTrigger($I['orderId']);
                }
            }
            
            $Run->setStartTime($Info->getStartTime());
            if ($Info->getEndTime()!='')
                $Run->setEndTime($Info->getEndTime());
            else // on force la remise à null pour compléter avec le jour suivant si on fait une reprise.
                $Run->setEndTime(null);
            
            if ($Info->getError()==1)
                $Run->setStatus('ERROR');
            else
                $Run->setStatus('SUCCESS');
            $Run->setRun($Info->getId());
            $Run->setTry($Info->getSteps());
            $Run->setMessage($Info->getErrorCode());
            $Run->setExitCode($Info->getExitCode());
            
           // Cas de l'update
            if ($Run->getJob()) {
                $Job = $Run->getJob();
            }
            else {
                // On rattache aux informations du job
                $Job = $em->getRepository("AriiReportBundle:JOB")->findOneBy(
                        array(
                            'spooler_name'=> $Info->getSpoolerId(),
                            'job_name'=> $Info->getJobName()
                        ));
            }

            if (!$Job) { # sinon on cree le job
                print "+ ".$Info->getJobName()."<br/>";

                $Job= new \Arii\ReportBundle\Entity\JOB();
                $Job->setCreated($Info->getStartTime());                    

                // On devrait pouvoir retrouver le spooler reference dans le portail, intérêt ?
                $Job->setSpoolerName($Info->getSpoolerId());

                $Job->setJobName($Info->getJobName());
                $Job->setJobType('JOB');

                $Job->setFirstExecution($Info->getStartTime());
                if ($Info->getEndTime()!='')
                    $Job->setLastExecution($Info->getEndTime());
                
                $Job->setUpdated(new \Datetime());
                $em->persist($Job);
                // on flush tout de suite
                $em->flush();
                
                $new_job++;
            }
            else {
                $flag=false;
                if ($Info->getEndTime()!='')
                    $End_time = $Info->getEndTime();
                else 
                    $End_time = new \Datetime('1970-01-01');
                if ((!$Job->getFirstExecution())                         
                    or ($Info->getStartTime()<$Job->getFirstExecution())) {
                    $Job->setFirstExecution($Info->getStartTime());
                    $flag = true;
                }
                if ((!$Job->getLastExecution())
                    or ($Info->getEndTime()>$Job->getLastExecution())) {
                    $Job->setLastExecution($Info->getEndTime());                    
                    $flag = true;
                }
                if ($flag)
                    $upd_job++;  

                $Job->setUpdated(new \Datetime());
                $em->persist($Job);                        
            }
            $Run->setJob($Job);
            $em->persist($Run);
            
            $n++;
        }

        # flush final
        $new_id = $Info->getId();
        $Sync->setLastId($new_id);
        $Sync->setLastUpdate(new \Datetime());
        $em->persist($Sync);
        $em->flush();
        
        return new Response("[$last_id => $new_id] New ($new) Update (".($n-$new)." New job ($new_job) Upd job ($upd_job) ".(time() - $debut)."s");
    }    
    
}

