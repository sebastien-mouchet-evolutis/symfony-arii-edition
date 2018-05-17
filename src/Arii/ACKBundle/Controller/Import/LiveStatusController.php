<?php
namespace Arii\ACKBundle\Controller\Import;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class LiveStatusController extends Controller
{
    public function downtimesAction()
    {
        // On traite le log
        if (isset($_FILES['txt']['tmp_name']))
            $log = file_get_contents($_FILES['txt']['tmp_name']);
        else 
            $log = file_get_contents('../workspace/ACK/Input/Nagios/downtimes.txt');
        // Nettoyage 
        $this->csv2array($log);
        exit();
    }

    public function hostsAction()
    {
        // On traite le log
        if (isset($_FILES['txt']['tmp_name']))
            $log = file_get_contents($_FILES['txt']['tmp_name']);
        else 
            $log = file_get_contents('../workspace/ACK/Input/Nagios/hosts.txt');

        $Infos = $this->csv2array($log);

        $em = $this->getDoctrine()->getManager();
        $n = 0;
        foreach ($Infos as $Info) {
            
            $record = $this->getDoctrine()->getRepository("AriiACKBundle:Network")->findOneBy(
            [
                'name' => $Info['name']
            ]);
            if (!$record)
                $record = new \Arii\ACKBundle\Entity\Network();
            
            $record->setName                 ($Info['name']);
            $record->setTitle                ($Info['display_name']);
            $record->setDescription          ($Info['alias']);
            $record->setHost                 ($Info['address']);
            $record->setAcknowledged         ($Info['acknowledged']);
            $record->setAcknowledgementType  ($Info['acknowledgement_type']);
            $record->setLastState            ($Info['last_state']);
            $record->setLastStateChange      (new \DateTime('@'.$Info['last_state_change']));
            $record->setLastTimeDown         (new \DateTime('@'.$Info['last_time_down']));
            $record->setLastTimeUnreachable  (new \DateTime('@'.$Info['last_time_unreachable']));
            $record->setLastTimeUp           (new \DateTime('@'.$Info['last_time_up']));
            $record->setLatency              ($Info['latency']);
            $record->setState                ($Info['state']);
            $record->setStateInformation     ($Info['plugin_output']);
            
            // Verification IP
            // Il faudra distinguer synchro rapide et màj
            if (filter_var($Info['address'], FILTER_VALIDATE_IP)) {
                $record->setIPAddress            ($Info['address']);
            } else {
                // $record->setIPAddress            (gethostbyname($Info['address']));
                $record->setIPAddress            (null);
            }
            
            // Chaine speciale
            if (is_array($Info['downtimes']))
                $record->setDowntimes(implode(',',$Info['downtimes']));
            else
                $record->setDowntimes($Info['downtimes']);
            
            if (is_array($Info['downtimes_with_info'])) {
                // On prend le dernier 
                $last_info = array_pop($Info['downtimes_with_info']);
                
                $downtimes  = array_shift($last_info);
                $user       = array_shift($last_info);
                $info       = array_shift($last_info);
                
                $record->setDowntimesUser($user);
                $record->setDowntimesInfo($info);
            }
            else {
                $record->setDowntimesUser(null);
                $record->setDowntimesInfo($Info['downtimes_with_info']);
            }            
            
            // STATUS ARII
            if ($Info['downtimes']!='') {
                $record->setStatus('DOWNTIME');
            }
            elseif ($Info['state']==0) {
                $record->setStatus('OK');
            } 
            elseif ($Info['state']==1) {
                $record->setStatus('WARNING');
            } 
            elseif ($Info['state']==4) {
                $record->setStatus('ERROR');
            } 
            else {
                $record->setStatus('UNKNOWN');
            }
            
            $em->persist($record);
            if ($n++ % 100 == 0)
                $em->flush();            
        }
        $em->flush();
        return new Response("success");        
    }

    public function servicesAction()
    {
        // On traite le log
        if (isset($_FILES['csv']['tmp_name']))
            $log = file_get_contents($_FILES['svc']['tmp_name']);
        else 
            $log = file_get_contents('../workspace/ACK/Input/Nagios/services.csv');
        // Nettoyage 
        print_r($this->csv2array($log));
        exit();
    }
    
    // Symfony3 offre un serializer
    private function csv2array($log,$sep_col=1,$sep_list=2,$sep_hs=3,$sep_line="\n") {
        $Infos = explode($sep_line,$log);
        $header = array_shift($Infos);
        $Columns = explode(chr($sep_col),$header);
        
        $Array = [];
        $limit=50;
        foreach ($Infos as $line) {
            $i=0;
            foreach (explode(chr($sep_col),$line) as $v) {
                if (!isset($Columns[$i]))
                    continue;
                
                $c = $Columns[$i];
                // Tableau de tableau ?
                if (strpos($v, $sep_hs)) {
                    $Lines = [];
                    foreach (explode (chr ($sep_list), $v) as $hs) {
                        array_push($Lines, explode(chr($sep_hs), $hs));
                    }
                    $New[$c] = $Lines;
                }
                elseif (strpos($v, $sep_list)) {
                    $New[$c] = explode(chr($sep_list),$v);                    
                }
                // Valeur
                else {
                    $New[$c] = $v;
                }                
                $i++;
            }
            array_push($Array,$New);
            // if ($limit-- <= 0) break;
        }
        return $Array;
    }
    
}

