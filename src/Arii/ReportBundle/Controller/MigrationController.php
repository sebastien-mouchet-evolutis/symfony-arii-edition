<?php

namespace Arii\ReportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class MigrationController extends Controller
{
    public function indexAction()
    {
        return $this->render('AriiReportBundle:Migration:index.html.twig' );
    }

    /* Migration des Jobs */
    public function JobAction()
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
        $Jobs = $em->getRepository("AriiReportBundle:JOB","local")->findAll();
        $n = $upd = 0;
        foreach ($Jobs as $Job) {
            $New = $em->getRepository("AriiReportBundle:JOB")->findOneBy(
                    array(  'spooler_name' => $Job->getSpoolerName(), 
                            'job_name' => $Job->getJobName() ));
            if (!$New)
                $New = new \Arii\ReportBundle\Entity\JOB();  
            else
                $upd++;
            $New = $Job;
            $em->persist($New);                        
            $n++;
            if ($n % 100 == 0)
                $em->flush();             
        }        
        $em->flush();                  
        return new Response("Job New(".($n-$upd)." Upd($upd) [".(time()-$debut)."]");
    }
    
    public function RunAction()
    {       
        set_time_limit(36000);
        
        // dangereux
        ini_set('memory_limit','-1');
        if ($this->container->has('profiler')) {
            $this->container->get('profiler')->disable();
        }             

        $debut = time();        
        $em = $this->getDoctrine()->getManager();
        // Il faut reparser tous les jobs
        // limiter par spooler ? 
        $Runs = $em->getRepository("AriiReportBundle:RUN","local")->findRunsToMigrate(new \Datetime('2016-01-01'),new \Datetime('2016-02-01'));
        $n = $upd = 0;
        foreach ($Runs as $Run) {
            $New = $em->getRepository("AriiReportBundle:RUN")->findOneBy(
                    array(  'spooler_name' => $Run->getSpoolerName(), 
                            'job_name' => $Run->getJobName(),
                            'start_time' => $Run->getStartTime () ));
            if (!$New)
                $New = new \Arii\ReportBundle\Entity\RUN();  
            else
                $upd++;
            $New = $Run;
            $em->persist($New);                        
            $n++;
            if ($n % 100 == 0)
                $em->flush();             
        }        
        $em->flush();                  
        return new Response("Run New(".($n-$upd)." Upd($upd) [".(time()-$debut)."]");
    }
    
}

