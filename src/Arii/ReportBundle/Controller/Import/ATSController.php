<?php

namespace Arii\ReportBundle\Controller\Import;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ATSController extends Controller
{
 
    public function getLog($file) {
        
        if (isset($_FILES['log']['tmp_name']))
            if ($_FILES['log']['error']>0) {
                print "UPLOAD ERROR ".$_FILES['log']['error'];
                exit();
            }
            else {
                $filename = $_FILES['log']['tmp_name'];
                return @file_get_contents($filename);
            }            
        else {
            $portal = $this->container->get('arii_core.portal');        
            $dir = $portal->getWorkspace().'/Report/Import/ATS';    
            $filename = "$dir/$file";
            $content = @file_get_contents($filename);
            if ($content=='') {
                print "EMPTY FILE !";
                exit();
            }
        }
                
        return $content;
    }    
    
    public function event_demonAction()
    {
        if ($this->container->has('profiler'))
            $this->container->get('profiler')->disable();
        
        $debut = time();
        
        $Infos = $Files = $File = array();

        // On traite le log
        $log = $this->getLog('event_demon.csv');

        $Log = explode("\n",$log);
        $Header = explode("\t",trim(array_shift($Log)));

        set_time_limit(3600);
        $em = $this->getDoctrine()->getManager();
        
        $n = $new = $new_job = $upd_job = 0;
        // On met a jour les first_execuctions et last_execution
        foreach ($Log as $l) {
            $Infos = explode("\t",trim($l));
            $i=0;
            foreach ($Header as $h) {
                if (isset($Infos[$i])) {
                    $Info[$h] = trim($Infos[$i]);
                }
                else {
                    $Info[$h] = '';                
                }
                $i++;
            }

            # Ligne vide ?
            if ($Info['job_name']=='')
                continue;
            
            # On n'importe pas les -99 qui n'ont pas d'heure de debut (sendevent)
            if (($Info['start']=='') and ($Info['exit']=='-99'))
                continue;
            
            # est ce qu'il existe
            # Cas ou il n'y a pas de start ?       
            // par defaut 
            $Start_time = new \Datetime($Info['start']);
            
            if ($Info['start']=='') {
                // le start est deja dans la base, et il y a une machine, il doit y avoir un start sans end dans la base de données
                // donc en RUNNING ?
                if (($Info['machine']=='') and ($Info['end']!='')) { // Juste un sendevent
                    $Info['start'] = $Info['end'];
                    
                    // on cherche si il y a un RUN associé
                    $Start_time = new \Datetime($Info['start']);            
                    $Run = $em->getRepository("AriiReportBundle:RUN")->findOneBy(
                            array(  'spooler_name'=> $Info['spooler_name'], 
                                    'job_name'=> $Info['job_name'], 
                                    'start_time'=> $Start_time
                            ));
                    
                    if(!$Run) {
                        # print "+++ ".$Info['spooler_name']." ".$Info['job_name']." ".$Info['start'].")";
                        # on cree nu nouveau run
                    }
                }
                else {
                    print "END (".$Info['start'].") (".$Info['end'].") ".$Info['job_name']." ".$Info['status']."<br/>";
                    
                    // on cherche le dernier run sans end ? il doit etre dans un log anterieur.
                    $Run = $em->getRepository("AriiReportBundle:RUN")->findOneBy( 
                            array(  'spooler_name' => $Info['spooler_name'], 
                                    'job_name' => $Info['job_name'], 
                                    'end_time' => new \DateTime($Info['end']))
                            );
                    if($Run) {
                        $Start_time = $Run->getStartTime();
                    }
                }
            }
            elseif ($Info['end']=='') { // pas de fin, on cree et on attend la fin dans les logs suivants
                // si c'est un running, il est inutile de le prendre en compte
                if ($Info['status']=='RUNNING') {
                    // print "RUNNING ".$Info['start']." ".$Info['job_name']." ".$Info['status'];
                }
                else {
                    // print "START ".$Info['start']." ".$Info['job_name']." ".$Info['status'];
                }
                
            }
            else {
                $Run = $em->getRepository("AriiReportBundle:RUN")->findOneBy(
                        array(  'spooler_name' => $Info['spooler_name'], 
                                'job_name'=> $Info['job_name'], 
                                'start_time'=> $Start_time));               
                # On tente par la fin
                if (!$Run) {
                    $Run = $em->getRepository("AriiReportBundle:RUN")->findOneBy(
                            array(  'spooler_name' => $Info['spooler_name'], 
                                    'job_name'=> $Info['job_name'], 
                                    'end_time'=> new \Datetime($Info['end'])));
                }
                
            }

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
            else // on force la remise à null pour compléter avec le jour suivant si on fait une reprise.
                $Run->setEndTime(null);
                    
            $Run->setStatus($Info['status']);
            $Run->setExitCode($Info['exit']);
            $Run->setMachine($Info['machine']);
            $Run->setRun($Info['run']);
            $Run->setTry($Info['try']);
            $Run->setMessage($Info['comment']);
            
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
            }

            if (!$Job) { # sinon on cree le job
                print "+ ".$Info['job_name']."<br/>";

                $Job= new \Arii\ReportBundle\Entity\JOB();
                $Job->setCreated($Start_time);                    
                
                // On devrait pouvoir retrouver le spooler reference dans le portail, intérêt ?
                $Job->setSpoolerName($Info['spooler_name']);
                $Job->setSpoolerType('ATS');

                $Job->setJobName($Info['job_name']);
                $Job->setJobType('JOB'); # Si commande <>''

                $Job->setFirstExecution($Start_time);
                if ($Info['end']!='')
                    $Job->setLastExecution(new \Datetime($Info['end']));
                
                $Job->setUpdated(new \Datetime());

                $em->persist($Job);
                // on flush tout de suite
                $em->flush();
                
                $new_job++;
            }
            else {
                $flag=false;
                if ($Info['end']!='')
                    $End_time = new \Datetime($Info['end']);
                else 
                    $End_time = new \Datetime('1970-01-01');
                if ((!$Job->getFirstExecution())                         
                    or ($Start_time<$Job->getFirstExecution())) {
                    $Job->setFirstExecution($Start_time);
                    $flag = true;
                }
                if ((!$Job->getLastExecution())
                    or ($End_time>$Job->getLastExecution())) {
                    $Job->setLastExecution($End_time);                    
                    $flag = true;
                }
                if ($flag)  {
                    $em->persist($Job);                        
                    // pas la peine de flusher
                    $upd_job++;  
                }
            }

            $Run->setJob($Job);
            $em->persist($Run);
            
            $n++;
            if ($n % 100 == 0)
                $em->flush();             
        }
        
        $em->flush();            
        return new Response("New ($new) Update (".($n-$new)." New job ($new_job) Upd job ($upd_job) ".(time() - $debut)."s");
    }

    public function jobsAction()
    {
        set_time_limit(3600);
        ini_set('memory_limit','-1');
        if ($this->container->has('profiler')) {
            $this->container->get('profiler')->disable();
        }             
        $time = time();
        
        $Infos = $Files = $File = array();

        $log = $this->getLog('jobs.csv');
        
        $Log = explode("\n",$log);
        $Header = explode("\t",trim(array_shift($Log)));
        
        $em = $this->getDoctrine()->getManager();
        
        $n = $new = $upd = $nochange = 0;
        foreach ($Log as $l) {
            $Infos = explode("\t",trim($l));
            $i=0;
            foreach ($Header as $h) {
                if (isset($Infos[$i])) {
                    $Info[$h] = trim($Infos[$i]);
                }
                else {
                    $Info[$h] = '';                
                }
                $i++;
            }

            if (!isset($Info['job_name']) or ($Info['job_name']=='')) continue;

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
                // Pas d'update dans l'heure ?
/*                
                $last_update = $Job->getUpdated();                
                $interval = $last_update->diff(new \DateTime());
                if ($interval->format('%i')<60) continue;
 */
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
            
            $Job->setDescription($Info['description']);
            $Job->setCommand($Info['command']);
            $Job->setUser($Info['owner']);
            $Job->setMachine($Info['machine']);
            $Job->setApplication($Info['application']);
            $Job->setEnv($Info['env']);

            $Job->setDeleted(NULL);
            
            if (isset($Info['watch_file']))
                $Job->setWatchFile($Info['watch_file']);
                        
            $Job->setUpdated(new \Datetime());

            $em->persist($Job);
            
            $n++;
            if ($n % 100 == 0)
                $em->flush(); 
        }

        $em->flush();    
        return new Response("New ($new) Update ($upd) ".(time() - $time)."s");
    }

    // Audit 
    public function auditAction()
    {
        if ($this->container->has('profiler')) {
            $this->container->get('profiler')->disable();
        }             
        set_time_limit(3600);
        ini_set('memory_limit','-1');
        
        $Infos = $Files = $File = array();

        $log = $this->getLog('audit.csv');
        
        $Log = explode("\n",$log);
        $Header = explode("\t",trim(array_shift($Log)));
        
        $em = $this->getDoctrine()->getManager();
        
        $new = $del = 0;
        foreach ($Log as $l) {
            $Infos = explode("\t",trim($l));
            $i=0;
            foreach ($Header as $h) {
                if (isset($Infos[$i])) {
                    $Info[$h] = trim($Infos[$i]);
                }
                else {
                    $Info[$h] = '';                
                }
                $i++;
            }

            if ($Info['job_name']=='') continue;

            # est ce qu'il existe
            # Pour Autosys, un job est unique dans une meme instance
            $Job = $em->getRepository("AriiReportBundle:JOB")->findOneBy(
                        array( 
                            'job_name'=> $Info['job_name'], 
                            'spooler_name'=>  $Info['spooler_name']
                        ));
            
            if (!$Job)
                continue;
            
            # Le job est supprimé mais recréé ensuite 
            if ($Info['insert']>$Info['delete'])
                $Info['delete']='';
                        
            $flag = false;
            if ($Info['delete']!='') {
                $delete = new \Datetime($Info['delete']);
                // Est ce que la date de suppression est plus récente ?
                if ($delete>$Job->getDeleted()) {
                    $Job->setDeleted($delete);
                    $flag = true;
                    $del++;
                }
            }
            if ($Info['insert']!='') {
                $insert = new \Datetime($Info['insert']);
                // Est ce que la date de creation est plus ancienne ?
                if ($insert<$Job->getCreated()) {
                    $Job->setCreated($insert);
                    $flag = true;
                    $new++;
                }
                if ($insert>$Job->getLastChange()) {
                    $Job->setLastChange($insert);
                    $flag = true;
                    $new++;
                }
            }
            if ($flag) {
                $Job->setUpdated(new \Datetime());                
                $em->persist($Job);
            }
        }
        $em->flush();            
        return new Response("Create ($new) Delete ($del)");
    }
    
    public function calendarsAction()
    {
        $time = time();
        ini_set('memory_limit','-1');
        if ($this->container->has('profiler')) {
            $this->container->get('profiler')->disable();
        }             
        
        $Infos = $Files = $File = array();

        $log = $this->getLog('autocal.asc');
        
        set_time_limit(3600);
        $em = $this->getDoctrine()->getManager();
        $calendar='?';
        $new = $upd = 0;
        foreach (explode("\n",$log) as $line) {
            // Format americain
            if (substr($line,0,9)=='calendar:' ) {
                $calendar=substr($line,10);
            }
            else {
                $day = \DateTime::createFromFormat("m/d/Y H:i", $line);
                if ($day) {
                    // on sauve
                    $Cal = $em->getRepository("AriiReportBundle:CAL")->findOneBy(
                                array( 
                                    'name'  => $calendar,
                                    'spooler_type' => 'ATS',
                                    'day'      => $day                                    
                                ));            
                    if (!$Cal) {
                        $Cal = new \Arii\ReportBundle\Entity\CAL();
                        $new++;
                    }
                    else {
                        $upd++;
                    }
                    $Cal->setSpoolerName('VA1');
                    $Cal->setSpoolerType('ATS');
                    $Cal->setName($calendar);
                    $Cal->setDay($day);
                    
                    $em->persist($Cal);
                }
            }
        }
        
        $em->flush();            
        return new Response("New ($new) Update ($upd) ".(time() - $time)."s");
    }
    
}

