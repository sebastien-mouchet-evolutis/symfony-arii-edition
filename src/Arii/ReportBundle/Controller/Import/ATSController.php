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
                    'spooler_name'=>  $Info['spooler_name'],
                    'job_name'=> $Info['job_name']
                    
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

            $Job->setJobName($Info['job_name']);
            $Job->setJobType($Info['job_type']);
            
            $Job->setBoxName($Info['job_name']);
            
            $Job->setDescription($Info['description']);
            $Job->setCommand($Info['command']);
            $Job->setUser($Info['owner']);
            $Job->setMachine($Info['machine']);
            $Job->setApp($Info['application']);
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
                                    'day'      => $day                                    
                                ));            
                    if (!$Cal) {
                        $Cal = new \Arii\ReportBundle\Entity\CAL();
                        $new++;
                    }
                    else {
                        $upd++;
                    }
                    $Cal->setSpoolerName('.');
                    $Cal->setName($calendar);
                    $Cal->setDay($day);
                    
                    $em->persist($Cal);
                }
            }
        }
        
        $em->flush();            
        return new Response("New ($new) Update ($upd) ".(time() - $time)."s");
    }

    // Juste un test
    public function db_proc_eventvuAction($db='',$limit=3) {
        
        if ($this->container->has('profiler'))
            $this->container->get('profiler')->disable();
        set_time_limit(3600);
        
        $em = $this->getDoctrine()->getManager();
        // On récupère l'id de la dernière synchro
        
        $Sync = $em->getRepository("AriiReportBundle:SYNC")->findOneBy([
            'name' => $db,
            'entity' => 'UjoProcEventvu'
        ]);

        if (!$Sync) {
            $Sync = new \Arii\ReportBundle\Entity\SYNC();
            $last_id = 0;
        }
        else {
            $last_id = $Sync->getLastId();
        }
        $Sync->setName($db);
        $Sync->setEntity('UjoProcEventvu');
        
        $ats = $this->getDoctrine()->getManager($db);
        // On flush par partie et on appelle l'url régulièrement
        $new = $update = $n = $new_job = $upd_job = 0;
        $debut = time();
        
        # Quelle instance ?
        $qb = $ats->createQueryBuilder()
            ->Select('a')
            ->from('AriiATSBundle:UjoAlamode','a')
            ->where("a.type = 'AUTOSERV'");
        
        $Info = $qb->getQuery()->getResult();
        if (!$Info)
            new \Exception("$db ?!");
        
        $spooler_id = $Info[0]->getStrVal();

        $qb = $ats->createQueryBuilder()
            ->Select('e')          
            ->from('AriiATSBundle:UjoEventvu','e')
            ->where('e.eoid >= :last_id')
            ->setParameter('last_id',$last_id)
            ->setMaxResults($limit);
        
        $Events = $qb->getQuery()->getResult();
        if (!$Events) {
            return new \Exception($db);
        }
        
        foreach ($Events as $I) {
            print_r($I);
        }
        exit();
    }

    public function db_jobsAction($db='',$limit=1000) {
        
        if ($this->container->has('profiler'))
            $this->container->get('profiler')->disable();
        set_time_limit(3600);
        
        $em = $this->getDoctrine()->getManager();
        // On récupère l'id de la dernière synchro
        
        $ats = $this->getDoctrine()->getManager($db);
        // On flush par partie et on appelle l'url régulièrement
        $new = $update = $cancel = $n = $new_job = $upd_job = 0;
        $debut = time();

        # Quelle instance ?
        $qb = $ats->createQueryBuilder()
            ->Select('a')
            ->from('AriiATSBundle:UjoAlamode','a')
            ->where("a.type = 'AUTOSERV'");
        
        $Info = $qb->getQuery()->getResult();
        if (!$Info)
            new \Exception("$db ?!");
        $spooler_name = $Info[0]->getStrVal();

        $qb = $ats->createQueryBuilder()
            ->Select('j')
            ->from('AriiATSBundle:UjoJobst','j')
            ->where('j.isCurrver = 1');

        $Jobs = $qb->getQuery()->getResult();
        if (!$Jobs) {
            return new \Exception($db);
        }

        // Pour les infos internes
        $autosys = $this->container->get('arii_ats.autosys');
        // Stats
        $new = $update = $cancel = $n = $new_job = $upd_job = 0;
        $debut = time();
        foreach ($Jobs as $Job) {
            $update = 0; // Nombre de changements
            // Le job existe ?
            $Exist = $em->getRepository("AriiReportBundle:JOB")->findOneBy(
                        array( 
                            'job_name'=> $Job->getJobname(), 
                            'spooler_name'=>  $spooler_name
                        ));
            
            // Si il n'existe pas, on passe 
            if (!$Exist) {
                $new++;
                continue;
            }

            // Premiere date du job
            $StartTime = new \DateTime();
            if ($Job->getStatusTime()>$Job->getLastStart())
                $StartTime->setTimestamp($Job->getLastStart());  
            else
                $StartTime->setTimestamp($Job->getStatusTime());
            
            // Dates de départ
            // Remplissage des champs vides
            if (!$Exist->getCreated() or ($Exist->getCreated()>$StartTime)) {
                $update++;
                $Exist->setLastExecution($StartTime);
            }
            if (!$Exist->getFirstExecution()) {
                $update++;
                $Exist->setFirstExecution($StartTime);
            }            
            
            // Dernière exécution
            $EndTime = new \DateTime();
            if ($Job->getLastEnd()>$Job->getLastStart())
                $EndTime->setTimestamp($Job->getLastEnd());  
            else
                $EndTime->setTimestamp($Job->getLastStart());
                
            if (!$Exist->getLastExecution() or ($EndTime>$Exist->getLastExecution())) {
                $update++;
                $Exist->setLastExecution($EndTime);
            }
            
            if ($update>0) {
                $upd_job++;
                $Exist->setUpdated(new \DateTime());
                $em->persist($Exist);
            }
        }        
        // Flush final
        $em->flush();

        return new Response("New ($new) Update ($upd_job) ".(time() - $debut)."s");
    }    
    
    public function db_job_runsAction($db='',$limit=1000) {
        
        if ($this->container->has('profiler'))
            $this->container->get('profiler')->disable();
        set_time_limit(3600);
        
        $em = $this->getDoctrine()->getManager();
        // On récupère l'id de la dernière synchro
        
        $Sync = $em->getRepository("AriiReportBundle:SYNC")->findOneBy([
            'name' => $db,
            'entity' => 'UjoJobRuns'
        ]);

        if (!$Sync) {
            $Sync = new \Arii\ReportBundle\Entity\SYNC();
            $last_id = 0;
        }
        else {
            // print_r($Sync);
            $last_id = $Sync->getLastId();
        }

        $Sync->setName($db);
        $Sync->setEntity('UjoJobRuns');

        $ats = $this->getDoctrine()->getManager($db);
        // On flush par partie et on appelle l'url régulièrement
        $new = $update = $cancel = $n = $new_job = $upd_job = 0;
        $debut = time();

        # Quelle instance ?
        $qb = $ats->createQueryBuilder()
            ->Select('a')
            ->from('AriiATSBundle:UjoAlamode','a')
            ->where("a.type = 'AUTOSERV'");
        
        $Info = $qb->getQuery()->getResult();
        if (!$Info)
            new \Exception("$db ?!");
        $spooler_id = $Info[0]->getStrVal();

        $qb = $ats->createQueryBuilder()
            ->Select('r')
            ->from('AriiATSBundle:UjoJobRuns','r')
            ->leftjoin('AriiATSBundle:UjoProcEventvu','e',\Doctrine\ORM\Query\Expr\Join::WITH,'(r.joid = e.joid) and (r.runNum = e.runNum) and (r.ntry = e.ntry)')
            ->addSelect('e.joid,e.runNum,e.ntry,e.autoserv,e.jobName,e.boxName,e.event,e.eventtxt,e.status,e.statustxt,e.text,e.machine,e.globalValue,e.exitCode')
            ->leftjoin('AriiATSBundle:UjoAlarm','a',\Doctrine\ORM\Query\Expr\Join::WITH,'e.eoid = a.eoid')
            ->addSelect('a.eoid,a.alarm,a.alarmTime,a.state,a.theUser,a.stateTime,a.eventComment,a.response')
// Pour les jobs qui n'ont plus d'évenement
            ->leftjoin('AriiATSBundle:UjoJobst','j',\Doctrine\ORM\Query\Expr\Join::WITH,'r.joid = j.joid')
            ->addSelect('j.jobName,j.boxName,j.jobType')
            ->where('r.runNum > :last_id')
//            ->andWhere("e.jobName = 'VMT.BEDA.JOB.BedagStart'")
            ->andWhere('r.endtime > 0')
            ->andWhere('j.isCurrver = 1')
            ->orderBy('r.runNum,r.ntry')
            ->setParameter('last_id', $last_id)
            ->setMaxResults($limit);

        $History = $qb->getQuery()->getResult();
        if (!$History) {
            return new \Exception($db);
        }

        // Pour les infos internes
        $autosys = $this->container->get('arii_ats.autosys');

        foreach ($History as $I) {
     
            $Info = $I[0];
            
            $StartTime = new \DateTime();
            $StartTime->setTimestamp($Info->getStartime());
            
            $EndTime = new \DateTime();
            $EndTime->setTimestamp($Info->getEndtime()); 
 
            print $I['jobName']." -- ".$StartTime->format('Y-m-d H:i:s');
            print " -- ".$Info->getRunNum().'.'.$Info->getNtry();
        // unicite par spooler/job/start
            $Run = $em->getRepository("AriiReportBundle:RUN")->findOneBy(
                    [   'spooler_name' => $spooler_id, 
                        'job_name'=> $I['jobName'], 
                        'start_time'=> $StartTime
                    ]);
            if (!$Run) {
            // on teste le numero de run 
                $Run = $em->getRepository("AriiReportBundle:RUN")->findOneBy(
                        [   'spooler_name' => $spooler_id, 
                            'job_name'=> $I['jobName'], 
                            'run' => $Info->getRunNum(),
                            'try' => $Info->getNtry()
                        ]);
                // si c'est bon, on recale les heures de début
                if ($Run)
                    $Run->setStartTime($StartTime);
            }
            if (!$Run) continue;
            
            // Si le job n'existe pas, on le crée
            if (!$Run) {                
                $new++;
                $Run= new \Arii\ReportBundle\Entity\RUN();    
                
                $Run->setSpoolerName($spooler_id);
                $Run->setJobName($I['jobName']);

                print "NEW";
                # Dans une boite ?
                if ($I['boxName']!='') {
                    # Job  lié
                    $Box = $em->getRepository("AriiReportBundle:JOB")->findOneBy(
                    array(
                        'spooler_name'=> $spooler_id,
                        'job_name'=> $I['boxName']
                    ));                
                    $Run->setJob($Box);
                }
            }
            else {
                if ($Run->getEndTime())
                    print " (END ".$Run->getEndTime()->format('Y-m-d H:i:s').") ";
                # On regarde ce qu'il manque
                if ($Run->getEndTime()=='') {
                    $Run->setEndTime($EndTime); 
                }
                else {                    
                    # Si on a plus d'evenement, autant sortir
                    if ($I['joid']=='') {
                        $cancel++;
                        continue;        
                    }
                }
                print "UPDATE";
            }            
            print "<br/>";
            # Alarm ?
            if ($I['alarmTime']!='') {
                $Run->setAlarm($I['alarm']);
                $AlarmTime = new \DateTime();
                $AlarmTime->setTimestamp($I['alarmTime']);
                $Run->setAlarmTime($AlarmTime);
            }
            if ($I['stateTime']!='') {
                $Run->setAck($I['theUser']);
                $AckTime = new \DateTime();
                $AckTime->setTimestamp($I['stateTime']);
                $Run->setAckTime($AckTime);
            }
                        
            $Run->setMachine($Info->getRunMachine());
            $Run->setStatus($autosys->Status($Info->getStatus()));
            
            $Run->setRun($Info->getRunNum());
            $Run->setTry($Info->getNTry());
            $Run->setExitCode($Info->getExitCode());
            
            $Run->setMessage($I['text']);

           // Cas de l'update
            if ($Run->getJob()) {
                $Job = $Run->getJob();
            }
            else {
                // On rattache aux informations du job
                $Job = $em->getRepository("AriiReportBundle:JOB")->findOneBy(
                        array(
                            'spooler_name'=> $spooler_id,
                            'job_name'=> $I['jobName']
                        ));
            }

            if (!$Job) { # sinon on cree le job
                print "+ ".$I['jobName']."<br/>";

                $Job= new \Arii\ReportBundle\Entity\JOB();
                $Job->setCreated($StartTime);                    

                // On devrait pouvoir retrouver le spooler reference dans le portail, intérêt ?
                $Job->setSpoolerName($spooler_id);

                $Job->setJobName($I['jobName']);
                if ($Info->getRunMachine()=='')
                    $Job->setJobType('BOX');
                else 
                    $Job->setJobType('JOB');
                    
                $Job->setFirstExecution($StartTime);
                $Job->setLastExecution($EndTime);
                
                $Job->setUpdated(new \Datetime());

                $em->persist($Job);
                // on flush tout de suite
                $em->flush();
                
                $new_job++;
            }
            else {
                $flag=false;
                if ((!$Job->getFirstExecution())                         
                    or ($StartTime<$Job->getFirstExecution())) {
                    $Job->setFirstExecution($StartTime);
                    $flag = true;
                }
                if ((!$Job->getLastExecution())
                    or ($EndTime>$Job->getLastExecution())) {
                    $Job->setLastExecution($EndTime);                    
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

        // Flush final
        $new_id = $Info->getRunNum();
        $Sync->setLastId($new_id);
        $Sync->setLastUpdate(new \Datetime());
        $em->persist($Sync);
        $em->flush();

        return new Response("[$last_id => $new_id] New ($new) Update (".($n-$new)." New job ($new_job) Upd job ($upd_job)) Cancel ".$cancel." ".(time() - $debut)."s");
    }    

    // Reprise sur les job running
    public function db_started_jobsAction($db='',$spooler='',$limit=10) {
        
        if ($this->container->has('profiler'))
            $this->container->get('profiler')->disable();
        set_time_limit(3600);
        
        $em = $this->getDoctrine()->getManager();
        // On récupère l'id de la dernière synchro
        
        $ats = $this->getDoctrine()->getManager($db);
        // On flush par partie et on appelle l'url régulièrement
        $new = $update = $cancel = $n = $new_job = $upd_job = 0;
        $debut = time();

        // Pour les infos internes
        $autosys = $this->container->get('arii_ats.autosys');
                
        $Runs = $em->getRepository("AriiReportBundle:RUN")->findBy(
            [   'spooler_name' => $spooler, 
                'end_time' => null
            ],
            [   'start_time' => 'ASC' ],
            $limit
        );

        foreach ($Runs as $Run) {
            print ' '.$Run->getId();
            print ' '.$Run->getSpoolerName();
            print ' '.$Run->getJobName();
            print ' '.$Run->getStartTime()->format('Y-m-d H:i:s');
            print ' '.$Run->getRun();
            print ' '.$Run->getTry();
            
            $qb = $ats->createQueryBuilder()
                ->Select('r')          
                ->from('AriiATSBundle:UjoJobRuns','r')
                ->leftjoin('AriiATSBundle:UjoProcEventvu','e',\Doctrine\ORM\Query\Expr\Join::WITH,'(r.joid = e.joid) and (r.runNum = e.runNum) and (r.ntry = e.ntry)')
                ->addSelect('e.joid,e.runNum,e.ntry,e.autoserv,e.jobName,e.boxName,e.event,e.eventtxt,e.status,e.statustxt,e.text,e.machine,e.globalValue,e.exitCode')
                ->leftjoin('AriiATSBundle:UjoAlarm','a',\Doctrine\ORM\Query\Expr\Join::WITH,'e.eoid = a.eoid')
                ->addSelect('a.eoid,a.alarm,a.alarmTime,a.state,a.theUser,a.stateTime,a.eventComment,a.response')
                ->leftjoin('AriiATSBundle:UjoJobst','j',\Doctrine\ORM\Query\Expr\Join::WITH,'r.joid = j.joid')
                ->addSelect('j.jobName,j.boxName,j.jobType')
                ->where('j.jobName = :jobName' )
                ->andwhere('j.isCurrver = 1')
                ->andwhere('r.startime = :startTime')
                ->setParameter('jobName', $Run->getJobName())
                ->setParameter('startTime', $Run->getStartTime()->format('U') )
                ->setMaxResults($limit);

            $History = $qb->getQuery()->getResult();
            if (!$History)
                print "?!!";

            print "<br/>";
       }
        
       return new Response("New ($new) Update (".($n-$new)." New job ($new_job) Upd job ($upd_job)) Cancel ".$cancel." ".(time() - $debut)."s");
    }    
    
}

