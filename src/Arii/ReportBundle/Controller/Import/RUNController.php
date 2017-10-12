<?php

namespace Arii\ReportBundle\Controller\Import;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RUNController extends Controller
{
 
    public function __construct() {
    }
    
    // Mise a jour des apps
    public function APPAction()            
    {
        $em = $this->getDoctrine()->getManager();
        $Runs = $em->getRepository("AriiReportBundle:RUN")-> findApplications(new \DateTime('1970-01-01'));
                
        $new = $upd = 0;
        foreach ($Runs as $run) {
            $app = $run['app'];
            $App = $em->getRepository("AriiCoreBundle:Application")->findOneBy(array( 'name'=> $app));
            if ($App) {
                $upd++;
            }
            else {
                $new++;
                $App= new \Arii\CoreBundle\Entity\Application();
            }
            $App->setName($app);     
            $em->persist($App);
        }
        $em->flush();
        return new Response("New ($new) Update ($upd)");
    }
    
    
    // Mise a jour des jobs
    // on peut les faire par cycle !
    public function JOBAction()            
    {
        $debut = time();
        if ($this->container->has('profiler')) {
            $this->container->get('profiler')->disable();
        }             
        set_time_limit(3600);
        ini_set('memory_limit','-1');
        $em = $this->getDoctrine()->getManager();
        $Runs = $em->getRepository("AriiReportBundle:RUN")->findMinMaxDates();
        $new = $upd = $no = 0;
        $n = 0;
        foreach ($Runs as $run) {
            $job_name = $run['job_name'];
            
            $first_execution= $run['first_execution'];
            $last_execution= $run['last_execution'];
            $spooler_name = $run['spooler_name'];      
            
            $Job = $em->getRepository("AriiReportBundle:JOB")->findOneBy(
                    array(
                        'job_name'=> $job_name, 
                        'spooler_name'=> $spooler_name ));

            $update = false;
            $first = new \Datetime($first_execution);
            if ($Job and (!$Job->getFirstExecution() or ($first<$Job->getFirstExecution()))) {
                $Job->setFirstExecution($first);
                $update = true;
            }
            $last = new \Datetime($last_execution);
            if ($Job and (!$Job->getLastExecution() or ($last<$Job->getLastExecution()))) {
                $Job->setLastExecution($last);
                $update = true;
            }
            if ($update) {
                $em->persist($Job);
                $n++;
                if ($n % 100==0) {
                    print ".";
                    $em->flush();
                }
            }
        }
        $em->flush();
        return new Response(time()-$debut);
    }

    public function RunHourAction($force=true)
    {
        // par défaut
        $request = Request::createFromGlobals();
        // reprise sur 10j
        if ($request->query->get( 'to' )=='')
            $to = new \DateTime($request->query->get( 'to' ));
        else
            $to = new \DateTime();            
        
        if ($request->query->get( 'from' )=='') {
            $from = clone $to;
            $from->modify('-10 days');
        }
        else
            $from = new \DateTime($request->query->get( 'from' ));
        if ($request->query->get( 'force' )!='')
            $force = $request->query->get( 'force' );
        
        
        set_time_limit(3600);
        ini_set('memory_limit', '-1');
        
        if ($this->container->has('profiler'))
            $this->container->get('profiler')->disable();

        $em = $this->getDoctrine()->getManager();
       
        
        $Runs = $em->getRepository("AriiReportBundle:RUN")->findRunHours($from,$to);
        $Run = array();
        foreach ($Runs as $run) {   

            $app  = $run['app'];
//            if ($app=='')
//                continue;

            $env  = $run['env'];
            $date = str_replace('-','',$run['start_date']);
            $hour = $run['start_hour'];
            $id = "$app:$env:$date:$hour";

            if (!isset($Run[$id])) {
                $Run[$id]['executions'] = 0;
                $Run[$id]['acks'] = 0;
                $Run[$id]['warnings'] = 0;            
                $Run[$id]['alarms'] = 0;             
                $Run[$id]['date'] = $date;
                $Run[$id]['hour'] = $hour;
                $Run[$id]['warnings'] = 0;
            }

            $Run[$id]['app'] = $run['app'];
            $Run[$id]['spooler_name'] = $run['spooler_name'];
            $Run[$id]['env'] = $run['env'];

            $Run[$id]['executions'] += $run['executions'];
            $Run[$id]['acks'] += $run['acks'];
            if (($run['alarms']=='MINRUNALARM')
                or ($run['alarms']=='MAXRUNALARM')) {
                $Run[$id]['warnings'] += $run['alarms'];             
            }
            else {
                $Run[$id]['alarms'] += $run['alarms'];                
            }
        }

        $upd=$new=0;
        foreach ($Run as $run) {
            $date = new \Datetime($run['date']);
            $hour = $run['hour'];
            $Agg = $em->getRepository("AriiReportBundle:RUNHour")->findOneBy(
                array( 'application'=> $run['app'] , 'env' => $run['env'], 'date' => $date, 'hour' => $hour ));
            if (!$Agg) {
                $Agg = new \Arii\ReportBundle\Entity\RUNHour();
                $new++;
            }
            else {
                if (!$force) continue;
                $upd++;
            }
            $Agg->setDate($date);
            $Agg->setHour($hour);
            $Agg->setEnv($run['env']);
            $Agg->setApplication($run['app']);
            if ($run['executions']=='') $run['executions']=0;
            $Agg->setExecutions($run['executions']);
            if ($run['alarms']=='') $run['alarms']=0;
            $Agg->setAlarms($run['alarms']);
            if ($run['warnings']=='') $run['warnings']=0;
            $Agg->setWarnings($run['warnings']);
            if ($run['acks']=='') $run['acks']=0;
            $Agg->setAcks($run['acks']);
            $Agg->setSpoolerName($run['spooler_name']);
            $Agg->setSpoolerType('ATS');
            
            $em->persist($Agg);
        }        
        $em->flush();
        return new Response("From ".$from->format('Y-m-d H:i:s')." to ".$to->format('Y-m-d H:i:s').": Runs/Hour New ($new) Update ($upd)");
    }
    
    public function RunDayAction()
    {
        set_time_limit(3600);
        if ($this->container->has('profiler'))
            $this->container->get('profiler')->disable();

        $em = $this->getDoctrine()->getManager();

        $Runs = $em->getRepository("AriiReportBundle:RUN")->findRunDays(new \DateTime('2017-01-01'));

        $Run = array();
        foreach ($Runs as $run) {
            $app  = $run['app'];
//            if ($app=='')
//                continue;
            
            $env  = $run['env'];
            $date = str_replace('-','',$run['start_date']);
            $id = "$app:$env:$date";
            
            if (!isset($Run[$id])) {
                $Run[$id]['executions'] = 0;
                $Run[$id]['acks'] = 0;
                $Run[$id]['warnings'] = 0;            
                $Run[$id]['alarms'] = 0;             
                $Run[$id]['date'] = $date;
                $Run[$id]['warnings'] = 0;
            }
            
            $Run[$id]['app'] = $run['app'];
            $Run[$id]['spooler_name'] = $run['spooler_name'];
            $Run[$id]['env'] = $run['env'];
            
            $Run[$id]['executions'] += $run['executions'];
            $Run[$id]['acks'] += $run['acks'];
            if (($run['alarms']=='MINRUNALARM')
                or ($run['alarms']=='MAXRUNALARM')) {
                $Run[$id]['warnings'] += $run['alarms'];             
            }
            else {
                $Run[$id]['alarms'] += $run['alarms'];                
            }
        }

        $upd=$new=0;
        foreach ($Run as $run) {
            $date = new \Datetime($run['date']);
            $Agg = $em->getRepository("AriiReportBundle:RUNDay")->findOneBy(
                array( 'application'=> $run['app'] , 'env' => $run['env'], 'date' => $date ));
            if (!$Agg) {
                $Agg = new \Arii\ReportBundle\Entity\RUNDay();
                $new++;
            }
            else {
                $upd++;
            }
            $Agg->setDate($date);
            $Agg->setEnv($run['env']);
            $Agg->setApplication($run['app']);
            if ($run['executions']=='') $run['executions']=0;
            $Agg->setExecutions($run['executions']);
            if ($run['alarms']=='') $run['alarms']=0;
            $Agg->setAlarms($run['alarms']);
            if ($run['warnings']=='') $run['warnings']=0;
            $Agg->setWarnings($run['warnings']);
            if ($run['acks']=='') $run['acks']=0;
            $Agg->setAcks($run['acks']);
            $Agg->setSpoolerName($run['spooler_name']);
            $Agg->setSpoolerType('ATS');
            
            $em->persist($Agg);
        }        
        $em->flush();
        return new Response("Runs/Day New ($new) Update ($upd)");
    }

    /* Agrégation des runs par jour */
    public function RunMonthAction()
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
        $Runs = $em->getRepository("AriiReportBundle:RUNDay")->findRunsMonth();
        $n = $new = 0;
        foreach ($Runs as $Run) {
            
            $app = $Run['application'];
            $env = $Run['env'];
            $month = $Run['run_month'];
            $year = $Run['run_year'];
            $spooler_type = $Run['spooler_type'];
            $spooler_name = $Run['spooler_name'];
            $runs = $Run['runs'];
            $alarms = $Run['alarms'];
            $acks = $Run['acks'];
            
            // truncate ?! si on truncate on perd l'historique
            $RunMonth = $em->getRepository("AriiReportBundle:RUNMonth")->findOneBy(
                    array('application'=>$app,'env' =>$env, 'spooler_type' => $spooler_type, 'spooler_name' => $spooler_name, 'month' => $month, 'year' => $year
            ));

            if (!$RunMonth) {
                $RunMonth = new \Arii\ReportBundle\Entity\RUNMonth;
                $new++;
            }
            
            $RunMonth->setApplication($app);            
            $RunMonth->setEnv($env);
            $RunMonth->setMonth($month);
            $RunMonth->setYear($year);
            
            $RunMonth->setSpoolerType($spooler_type);
            $RunMonth->setSpoolerName($spooler_name);
            
            $RunMonth->setExecutions($runs);
            $RunMonth->setAlarms($alarms);
            $RunMonth->setAcks($acks);
            
            $em->persist($RunMonth);
            $n++;
        }        
        $em->flush();        

        return new Response("Runs/Month New($new) Update (".($n-$new).") [".(time()-$debut)."]");
    }
    
    /* COMPLEMENTS */
    public function RulesAction()
    {
        $debut=time();
        if ($this->container->has('profiler'))
            $this->container->get('profiler')->disable();        
        set_time_limit(3600);
        
       $portal = $this->container->get('arii_core.portal');
        $Rules = $portal->getRules();        

        $em = $this->getDoctrine()->getManager();
        foreach ($Rules as $job=>$Values) {            
            print "$job: ".$em->getRepository("AriiReportBundle:RUN")->UpdateAppEnv($job,$Values['OutApp'],$Values['OutEnv'])."\n";
        }
        return new Response("Ok!");
    }
    
}

