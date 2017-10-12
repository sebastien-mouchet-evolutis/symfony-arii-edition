<?php

namespace Arii\ReportBundle\Controller\Import;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class JOBController extends Controller
{
        
    /* Agrégation des jobs par applications et par jours */
    public function JobDayAction()
    {       
        set_time_limit(3600);        
        ini_set('memory_limit','-1');
        if ($this->container->has('profiler')) {
            $this->container->get('profiler')->disable();
        }             

        $debut = time();
        
        $em = $this->getDoctrine()->getManager();
        // Il faut reparser tous les jobs
        // limiter par spooler ? 
        $Jobs = $em->getRepository("AriiReportBundle:JOB")->findAll();
        $upd_job = 0;
        foreach ($Jobs as $Job) {
            
            $update = 0;
            
            $created =  $Job->getCreated();
            $first_execution = $Job->getFirstExecution();

            // on supprime les jobs executés une seule fois           
            // if ($first_execution==$Job->getLastExecution()) continue;
            
            // correction
            if ($first_execution and ($first_execution<$created)) {
                $Job->setCreated($first_execution);
                $start = $first_execution;
                $update++;
            }
            else {
                $start = $created;
            }
            // calcul de la fin
            $deleted =  $Job->getDeleted();
            $last_execution = $Job->getLastExecution();
            $end = new \DateTime(); 
            if ($deleted) {
                if ($last_execution and ($last_execution>$deleted)) {
                    // il n'est finalement pas supprimé
                    $Job->setDeleted(null);
                    $update++;
                }
                else {
                    $end = $deleted; 
                }
            }
           
            // la fin est la derniere mise a jour
            $interval = \DateInterval::createFromDateString('1 day');
            if (!$start) {
                print $Job->getJobName();
            }
            
            if ($start <'2016-01-01')
                $start = new \DateTime('2016-01-01');
            
            $period = new \DatePeriod($start, $interval, $end);

            // Preparation des données
            $app = $Job->getApp();
            $env = $Job->getEnv();
            $id = "$app#$env#".$Job->getSpoolerType().'#'.$Job->getSpoolerName();
            
            // on ajoute directement le created
            $id_created = $id.'#'.$Job->getCreated()->format("Y-m-d");            
            if (isset($Created[$id_created]))
                $Created[$id_created]++;
            else
                $Created[$id_created]=1;
            
            // eventuellement le delete
            if ($Job->getDeleted()) {
                $id_deleted = $id.'#'.$Job->getDeleted()->format("Y-m-d");            
                if (isset($Deleted[$id_deleted]))
                    $Deleted[$id_deleted]++;
                else
                    $Deleted[$id_deleted]=1;                
            }                

            foreach ( $period as $dt ) {
                $date = $dt->format( "Y-m-d" );
                $id_date = $id.'#'.$date;
                if (isset($Exist[$id_date]))
                    $Exist[$id_date]++;
                else 
                    $Exist[$id_date]=1;                
            }
            
            // On ajoute ce job sur tous les mois concernés
            if ($update>0) {
                $upd_job++;
                $em->persist($Job);                
            }
        }
        
        // flush des mises à jour
        // si il y en a regulierement, c'est un problème.
        if ($upd_job>0) {
            print "{UPDATE JOB ($upd_job)}";
            $em->flush();
        }
       
        $new = 0;
        foreach ($Exist as $k=>$jobs) {
            
            list($app,$env,$spooler_type,$spooler_name,$date) = explode('#',$k);
            // truncate ?! si on truncate on perd l'historique
            $JobDay = $em->getRepository("AriiReportBundle:JOBDay")->findOneBy(array('application'=>$app,'env' =>$env,'date'=>new \DateTime($date)));

            if (!$JobDay) {
                $JobDay = new \Arii\ReportBundle\Entity\JOBDay();
                $new++;
            }
            
            $JobDay->setApplication($app);            
            $JobDay->setEnv($env);
            $JobDay->setDate(new \DateTime($date));
            
            $JobDay->setSpoolerType($spooler_type);
            $JobDay->setSpoolerName($spooler_name);
            
            $JobDay->setJobs($jobs);
            
            $id = "$app#$env#$date";
            if (isset($Created[$id]))
                $JobDay->setCreated($Created[$id]);
            if (isset($Deleted[$id]))
                $JobDay->setDeleted($Deleted[$id]);
            
            $em->persist($JobDay);        
        }        
        $em->flush();        

        return new Response("JobDays ($new) [".(time()-$debut)."]");
    }
    
    /* Agrégation des jobs par mois */
    public function JobMonthAction()
    {       
        set_time_limit(3600);        
        ini_set('memory_limit','-1');
        
        if ($this->container->has('profiler')) {
            $this->container->get('profiler')->disable();
        }             

        $debut = time();
        
        $em = $this->getDoctrine()->getManager();
        // Il faut reparser tous les jobs
        // limiter par spooler ? 
        $Jobs = $em->getRepository("AriiReportBundle:JOBDay")->findJobsMonth();
        $new = $upd = 0;
        foreach ($Jobs as $Job) {
            
            $app = $Job['application'];
            $env = $Job['env'];
            $month = $Job['month'];
            $year = $Job['year'];
            $spooler_type = $Job['spooler_type'];
            $spooler_name = $Job['spooler_name'];
            $jobs = $Job['jobs'];
            $created = $Job['created'];
            $deleted = $Job['deleted'];
            
            // truncate ?! si on truncate on perd l'historique
            $JobMonth = $em->getRepository("AriiReportBundle:JOBMonth")->findOneBy(
                array('application'=>$app,'env' =>$env, 'spooler_type' => $spooler_type, 'spooler_name' => $spooler_name, 'month' => $month, 'year' => $year
            ));

            if (!$JobMonth) {
                $JobMonth = new \Arii\ReportBundle\Entity\JOBMonth();
                $new++;
            }
            else {
                $upd++;
            }
            
            $JobMonth->setApplication($app);            
            $JobMonth->setEnv($env);
            $JobMonth->setMonth($month);
            $JobMonth->setYear($year);
            
            $JobMonth->setSpoolerType($spooler_type);
            $JobMonth->setSpoolerName($spooler_name);
            
            $JobMonth->setJobs($jobs);
            $JobMonth->setCreated($created);
            $JobMonth->setDeleted($deleted);
            
            $em->persist($JobMonth);        
        }        
        $em->flush();        

        return new Response("JobMonths new($new) update($upd) [".(time()-$debut)."]");
    }
    
    /* COMPLEMENTS */
    public function RulesAction()
    {
        $debut=time();
        set_time_limit(3600);
        if ($this->container->has('profiler'))
            $this->container->get('profiler')->disable();        
        
        $portal = $this->container->get('arii_core.portal');
        $Rules = $portal->getRules();        

        $em = $this->getDoctrine()->getManager();
        foreach ($Rules as $job=>$Values) {            
            print "$job: ".$em->getRepository("AriiReportBundle:JOB")->UpdateAppEnv($job,$Values['OutApp'],$Values['OutEnv'])."\n";
        }
        return new Response("Ok!");
    }
}

