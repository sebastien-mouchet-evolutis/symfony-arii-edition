<?php

namespace Arii\ReportBundle\Controller\Import;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class OJSController extends Controller
{
 
    public function dbAction($db='',$limit=1) {
        
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
            ->where('o.historyId > :last_id')
            ->orderBy('o.historyId')
            ->setParameter('last_id', $last_id)
            ->setMaxResults($limit);
        
        $History = $qb->getQuery()->getResult();
        if (!$History) {
            return new \Exception($db);
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
            
            $Run->setSpoolerName($Info->getSpoolerId());
            $Run->setJobName($Info->getJobChain());
            $Run->setJobTrigger($Info->getOrderId());

            $Run->setStartTime($Info->getStartTime());
            if ($Info->getEndTime()!='')
                $Run->setEndTime($Info->getEndTime());
            else // on force la remise à null pour compléter avec le jour suivant si on fait une reprise.
                $Run->setEndTime(null);
            
            $Run->setStatus($Info->getState());
            $Run->setRun($Info->getHistoryId());
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
                if ($flag)  {
                    $em->persist($Job);                        
                    $upd_job++;  
                }
            }

            $Run->setJob($Job);
            $em->persist($Run);
            
            $n++;
        }

        # flush final
        $new_id = $Info->getHistoryId();
        $Sync->setLastId($new_id);
        $Sync->setLastUpdate(new \Datetime());
        $em->persist($Sync);
        $em->flush();
        
        return new Response("[$last_id => $new_id] New ($new) Update (".($n-$new)." New job ($new_job) Upd job ($upd_job) ".(time() - $debut)."s");
    }    
    
}

