<?php

namespace Arii\ReportBundle\Controller\Import;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class MIGController extends Controller
{

    function JOBAction() {

        set_time_limit(10000);
        ini_set('memory_limit','-1');
        if ($this->container->has('profiler')) {
            $this->container->get('profiler')->disable();
        }              
        $portal = $this->container->get('arii_core.portal');        
        include($portal->getWorkspace().'/Report/Import/MIG/report_job.php');
        
        $time = time();
        $em = $this->getDoctrine()->getManager();
        
        $n = $new = $upd = $nochange = 0;
        foreach ($report_job as $Info) {
            
            # Est-ce qu'il existe ?
            # Pour Autosys, un job est unique dans une meme instance
            $Job = $em->getRepository("AriiReportBundle:JOB")->findOneBy(
                array( 
                    'job_name'=> $Info['job_name'], 
                    'spooler_name'=>  $Info['spooler_name']
                )
            );
            
            if ($Job) {                
                $upd++;
            }
            else { # Nouveau JOB
                $Job= new \Arii\ReportBundle\Entity\JOB();
                $Job->setCreated(new \Datetime());               
                $new++;
            }
            
            $Job->setLastChange(new \Datetime());

            // On devrait pouvoir retrouver le spooler reference dans le portail, intérêt ?
            $Job->setSpoolerName($Info['spooler_name']);
            $Job->setSpoolerType('ATS');

            $Job->setJobName($Info['job_name']);
            $Job->setJobType($Info['job_type']);
            
            $Job->setBoxName($Info['job_name']);
            
            $Job->setCommand($Info['command']);
            $Job->setUser($Info['user']);
            $Job->setMachine($Info['machine']);
            $Job->setApplication($Info['app']);
            $Job->setEnv($Info['env']);

            $Job->setFirstExecution(new \DateTime($Info['first_execution']));
            $Job->setLastExecution(new \DateTime($Info['last_execution']));
            $Job->setCreated(new \DateTime($Info['last_execution']));            
            $Job->setDeleted(new \DateTime($Info['deleted']));            
            $Job->setUpdated(new \DateTime($Info['updated']));
            
            if (isset($Info['watch_file']))
                $Job->setWatchFile($Info['watch_file']);

            $em->persist($Job);
            
            $n++;
            if ($n % 1000 == 0)
                print "New ($new) Update ($upd) [".(time() - $time)."s]\t";
                $em->flush(); 
        }

        $em->flush();    
        print "New ($new) Update ($upd) [".(time() - $time)."s]\t";
        exit();
        // return new Response("New ($new) Update ($upd) [".(time() - $time)."s]");
    }

    public function RUNAction()
    {
        set_time_limit(10000);
        ini_set('memory_limit','-1');
        if ($this->container->has('profiler')) {
            $this->container->get('profiler')->disable();
        }             
        $portal = $this->container->get('arii_core.portal');        
        include($portal->getWorkspace().'/Report/Import/MIG/report_run.php');
                
        $debut = time();
        
        $em = $this->getDoctrine()->getManager();
        
        $n = $new = $new_job = $upd_job = 0;
        // On met a jour les first_execuctions et last_execution
        foreach ($report_run as $Info) {

            if (($Info['start_time']=='') || ($Info['spooler_name']=='') || ($Info['job_name']=='')) continue;
                
            $Start_time = new \Datetime($Info['start']);            
            $Run = $em->getRepository("AriiReportBundle:RUN")->findOneBy(
                    array(  'spooler_name' => $Info['spooler_name'], 
                            'job_name'=> $Info['job_name'], 
                            'start_time'=> $Start_time));               

            # Si le job n'existe pas, on le crée            
            if (!$Run) {
                $Run= new \Arii\ReportBundle\Entity\RUN();    
                $new++;
            }
            
            $Run->setSpoolerName($Info['spooler_name']);
            $Run->setJobName($Info['job_name']);

            $Run->setStartTime($Start_time);   
            if ($Info['end']!='')
                $Run->setEndTime(new \Datetime($Info['end']));

            $Run->setStatus($Info['status']);
            $Run->setExitCode($Info['exit']);
            $Run->setMachine($Info['machine']);
            $Run->setRun($Info['run']);
            $Run->setTry($Info['try']);

            if ($Info['alarm_time']!='') {
                $Run->setAlarm($Info['alarm']);
                $Run->setAlarmTime(new \Datetime($Info['alarm_time']));
            }
            if ($Info['ack_time']!='') {
                $Run->setAck($Info['ack']);
                $Run->setAckTime(new \Datetime($Info['ack_time']));
            }

            // Cas de l'update
            if ($Run->getJob()) {
                $Job = $Run->getJob();
            }
            else {
                // On rattache aux informations du job
                $Job = $em->getRepository("AriiReportBundle:JOB")->findOneBy(
                        array(
                            'spooler_name'=> $Info['spooler_name'],
                            'job_name'=> $Info['job_name']
                        ));
                $Run->setJob($Job);
            }

            $em->persist($Run);
            
            $n++;
            if ($n % 1000 == 0) {
                print "New ($new) Update (".($n-$new)." [".(time() - $debut)."s]";
                $em->flush();
            }
        }
        
        $em->flush();   
        print "New ($new) Update (".($n-$new)." [".(time() - $debut)."s]";
        exit();
        // return new Response("New ($new) Update (".($n-$new)." [".(time() - $debut)."s]");
    }
    
}

