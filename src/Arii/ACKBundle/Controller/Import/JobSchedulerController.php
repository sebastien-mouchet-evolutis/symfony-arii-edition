<?php
namespace Arii\ACKBundle\Controller\Import;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class JobSchedulerController extends Controller
{
    
    public function dbAction($db)
    {  
        $time=time();
        set_time_limit(300);
        $ojs = $this->getDoctrine()->getManager($db);
        $em = $this->getDoctrine()->getManager();

        // Referentiel des jobs
        $n = 0;
        $date = new \DateTime();
        $date->modify('-4 day');

        $Records = $ojs->getRepository("AriiJIDBundle:SchedulerHistory")->synchroHistory($date);
        $Done=[];
        foreach ($Records as $Record) {
            $instance   = $Record['spoolerId'];
            $job_name   = $Record['jobName'];
            
            $name = "$instance#$job_name";
            if (isset($Done[$name])) continue;
            
            $Status = $em->getRepository("AriiACKBundle:Status")->findOneBy([ 'name' =>   $name ]);
            if (!$Status) {
                $Status = new \Arii\ACKBundle\Entity\Status();
                $Status->setState('OPEN');
            }       
            $Status->setInstance ($instance);            
            $Status->setName     ($name);
            $Status->setSource   ('OJS');            
            $Status->setType     ('JOB');
            $Status->setTitle    ($job_name);
            $Status->setLastStart($Record['startTime']);
            $Status->setLastEnd  ($Record['endTime']);
            $Status->setExitCode ($Record['exitCode']);
            $Status->setMessage  ($Record['errorText']);
            if ($Record['log'])
                $Status->setJobLog   ( utf8_encode( gzinflate ( substr( stream_get_contents($Record['log']), 10, -8) ) ) );
            
            if ($Record['error']>0) {
                $Status->setStatus  ('ERROR');
                $Status->setStatusTime($Record['endTime']);               
            }
            else {
                $Status->setStatus  ('SUCCESS');
                $Status->setState('CLOSE');
                $Status->setStatusTime($Record['endTime']);
            }
            $Status->setStateTime($Record['endTime']);
            
            $Status->setUpdated  (new \DateTime());
            
            $em->persist($Status);
            if ($n++ % 100 == 0)
                $em->flush();
            $Done[$name] = 1;
            print "DONE $name<br/>";
        } 
        $em->flush();
        return new Response(sprintf( "# %d\n%d s\n%s\n",$n,(time()-$time),"success"));    
    }
    
    public function purgeAction()
    {  
        set_time_limit(300);
                
        // On traite le log
        if (isset($_FILES['txt']['tmp_name']))
            $log = file_get_contents($_FILES['txt']['tmp_name']);
        else 
            $log = file_get_contents('../workspace/ACK/Input/Autosys/status.txt');

        // Info supplementaires
        $request = Request::createFromGlobals();
        $source = $request->get('source');
        
        $Infos = explode("\n",$log);
        do {
            $head = array_shift($Infos);
        } while (substr($head,0,10)!='__________');
        $head = array_shift($Infos);
        
        $em = $this->getDoctrine()->getManager();
        $n = 0;
        foreach ($Infos as $info) {
            $job_name   = trim(substr($info,0,64));
            $last_start = trim(substr($info,65,20));
            $last_end   = trim(substr($info,86,20));
            $status     = trim(substr($info,107,2));
            $run        = str_replace('/','.',trim(substr($info,110,9)));
            $exit       = trim(substr($info,119,9));
            
            $record = $this->getDoctrine()->getRepository("AriiACKBundle:Status")->findOneBy(
            [
                'source' => $source,
                'name'   => $job_name
            ]);
            
            if (!$record)
                $record = new \Arii\ACKBundle\Entity\Status();
            
            $record->setSource               ($source);
            $record->setName                 ($job_name);
            $record->setType                 ('ATS');
            $record->setTitle                ($source.' '.$job_name);
            $record->setLastStart            (($last_start == '-----')?null:new \DateTime($last_start));
            $record->setLastEnd              (($last_end == '-----')?null:new \DateTime($last_end));
            $record->setExitCode             ($exit);
            $record->setRunTry               ($run_try);
            $record->setStatus               (isset($this->Status[$status])?$this->Status[$status]:'UNKNOWN');
            $record->setUpdated              (new \DateTime());
            
            $em->persist($record);
            if ($n++ % 100 == 0)
                $em->flush();            
        }
        $em->flush();
        return new Response("success");        
    }
    
}

