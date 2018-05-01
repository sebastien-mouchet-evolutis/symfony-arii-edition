<?php

namespace Arii\MFTBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class JadeController extends Controller
{
    /* Le CSV est la base de l'historique
     * Le LOG permet de compléter les données manquantes
     */
    public function historyAction()
    {
        $Infos = $Files = $File = array();

        // On traite le log
        if (isset($_FILES['log']['tmp_name']))
            $log = file_get_contents($_FILES['log']['tmp_name']);
        else 
            $log = file_get_contents('../workspace/MFT/Input/Yade/test.log');
        // Nettoyage 
        $Log = explode("\n",str_replace("\r",'',$log));
        $prefix = 'global';
        $time = ''; # derniere heure
        $count=0;
        foreach ($Log as $l) {
            if (substr($l,2,1)==':') {
                $last = $time;
                $time=substr($l,0,12);
                $l = substr($l,21);
                $p = strpos($l,': ');                
                $type = substr($l,0,$p);
                $data = substr($l,$p+2);
                switch ($type) {
                    // File 'FICHIER' deleted. 
                    case 'SOSVfs_I_0113':
                        $p = strpos($data,"'",6);
                        $file = $this->FileName(substr($data,6,$p-6));
                        $File[$file]['deleted'] = 1;
                        break; 
                    // Transfer-operation 'receive' started at 20160121054103, ended at 20160121054108. Duration: 5000
                    case 'SOSVfs_D_213':
                        $p = strpos($data,"'",20);
                        $Infos['global']['operation'] = substr($data,20,$p-20);
                        // le reste est fixe
                        $Infos['global']['start'] = $this->Date(substr($data,$p+13,14));
                        $Infos['global']['end'] = $this->Date(substr($data,$p+38,14));
                        $Infos['global']['duration'] = substr($data,$p+64)/1000;
                        break;                   
                    // Operation = receive, TargetFile = /smbwin/transfers/test/octo/InTest/gm_etatsinistres_2015122101_t.xml, SourceFile = /QOpenSys/WL_EXPORT/gm_etatsinistres_2015122101_t.xml, BytesTransferred = 8556 
                    case 'SOSVfs_D_214':
                        $Data = explode(', ',$data);
                        foreach ($Data as $d) {
                            if (strpos($d,' = ')) {
                                list($var,$val) = explode(' = ',$d);                            
                                $Line[$var] = $val;
                            }
                            else { // Il y a des virgules dans le nom !
                                $Line[$var] .= ", $d";
                            }
                        }
                        $file = $this->FileName($Line['SourceFile']);
                        $File[$file]['operation'] = $Line['Operation'];
                        $File[$file]['source_file'] = $file;
                        $File[$file]['target_file'] = $Line['TargetFile'];
                        $File[$file]['size'] = $Line['BytesTransferred'];
                        // $File[$file]['starttime'] = $last;
                        // $File[$file]['endtime'] = $time;
                        
                        // Infos globales
                        if (isset($Infos['status']['status'])) 
                            $Infos['status']['size'] += $Line['BytesTransferred'];
                        else
                            $Infos['status']['size'] = $Line['BytesTransferred'];
                        break;
                        
                        $count++; 
                    case 'SOSJADE_I_0101':
                        break;
                }
            }
            elseif (substr($l,21,3)==' = ') {
                $info = trim(substr($l,1,20));
                if (in_array($info,array('execution status','successful transfers','skipped transfers','failed transfers','last error'))) {
                    $prefix = 'status';
                    $Infos[$prefix][$info] = substr($l,24);
                }
            }
            elseif (strpos($l,' = ')>0) {
                list($var,$val) = explode(' = ',$l);
                $var = strtolower(trim(str_replace('  | ','',$var)));
                $val = trim($val);
                $Infos[$prefix][$var] = $val;
            }
            else {
                $check=substr($l,0,33);
                if ($check =='  +------------Source------------') {
                    $prefix = 'source';
                }
                elseif ($check =='  +------------Target------------') {
                    $prefix = 'target';
                }
            }
        }

        // On traite la sortie pour compléter le csv
        // doublon avec le log ?
        $Main = array();     
        if (isset($_FILES['out']['tmp_name']))
            $log = file_get_contents($_FILES['out']['tmp_name']);
        else 
            $log = file_get_contents('../workspace/MFT/Input/Yade/test.out');
        
        if (trim($log)!='') {
            $Log = explode("\n",$log);
            $prefix = 'global';
            foreach ($Log as $l) {
                $len = strlen($l);
                // Debut et fin
                if (substr($l,0,13) == '+ DATE     : ') {
                    if (isset($Main['start'])) {
                        $Main['end'] = substr($l,13,20);
                    }
                    else {
                        $Main['start'] = substr($l,13,20);
                    }
                }
                elseif (strpos($l,"::run SOSVfs_I_0108: transfer of ")>0) {
                    $time = substr($l,11,8);
                    $file = $this->FileName(substr($l,87,$len - 96));
                    $File[$file]['start_time'] = $this->Time($Infos['global']['date'], $time );                
                }
                elseif ((strpos($l,"::doTransfer SOSVfs_I_274: Security hash (MD5) for file ")>0)) {
                    $time = substr($l,11,8);
                    $file = $this->FileName(substr($l,100,$len - 138));                
                    // $File[$file]['MD5'] = substr($l,130);            
                }
            }
        }
        print_r($Main);
        
        // Complement avec le csv
        if (isset($_FILES['data']['tmp_name']))
            $content = file_get_contents($_FILES['data']['tmp_name']);
        else 
            $content = file_get_contents('../workspace/MFT/Input/Yade/test.csv');
     
        // Est ce que le fichier csv contient des informations ?
        if (trim($content) != '') {
            $Transfers = explode("\n",$content);

            // On teste la prmière ligne pour verifier qu'il y une entete
            if (substr($content,0,5)=='guid;') {
                $head = array_shift($Transfers);
                // $Cols = explode(";",$head);
            }
            else { // on est en 1.10 ou plus
                // $Cols = explode(";",'guid;mandator;transfer_timestamp;pid;ppid;operation;localhost;localhost_ip;local_user;remote_host;remote_host_ip;remote_user;protocol;port;local_dir;remote_dir;local_filename;remote_filename;file_size;md5;status;last_error_message;log_filename;jump_host;jump_host_ip;jump_port;jump_protocol;jump_user;transfer_start;modification_date');
            }
            
            # On force sauf si la version est explicitement indiqué
            $Cols = explode(";",'guid;mandator;transfer_end;pid;ppid;operation;localhost;localhost_ip;local_user;remote_host;remote_host_ip;remote_user;protocol;port;local_dir;remote_dir;local_filename;remote_filename;file_size;md5;status;last_error_message;log_filename;jump_host;jump_host_ip;jump_port;jump_protocol;jump_user;transfer_start;modification_date');

            $em = $this->getDoctrine()->getManager();
            foreach($Transfers as $line) {
                if ($line == '') continue;

                $Info = array(); # RAZ
                $n=0;
                foreach (explode(";",$line) as $cell) {
                    $c = $Cols[$n];
                    $Info[$c]=$cell;
                    $n++;
                }        

                if (!isset($Info['operation'])) continue;
                $count++;

                // Quel est le sens ?
    //            if ($Info['operation']=='receive') {
                    $file = $Info['local_filename'];
    /*            }
                else {
                    $file = $Info['remote_dir'].'/'.$Info['remote_filename'];
                }
    */
                $file = str_replace('\\','/',$file);
                foreach ($Info as $k => $v) {
                    $File[$file][$k] = $v;
                }            
            }        
        }
        
        // on retrouve la fiche dans la tables des operations
        print_r($Infos);
        
        $em = $this->getDoctrine()->getManager();
        $Operation = $em->getRepository("AriiMFTBundle:Operations")->findOneBy(array('name'=> $Infos['global']['profile']));        

        $name = $Infos['global']['profile'];      
        $p = strpos($name,'.');
        $title = substr($name,0,$p);
        $env = substr($name,$p+1);
        $step = 10;
        $step_start = $step;
        $step_last =  $step;
        $step_end =  $step;
        $run=0; // Run du transfert
        $try=0; // Reprise de transmission
        $start_time = $Infos['global']['date'];
        $end_time = $this->Time($Infos['global']['date'], substr($time,0,8));
        $status = $state = 'unknown';
        $transferring = 0; // Transfert en cours
        //
        // L'operation est elle connue ?
        if (empty($Operation)) {    
            // Creation d'une operation ?
            $Operation= new \Arii\MFTBundle\Entity\Operations();
            $Operation->setName($name);
            
            // Instance
            // On remplit avec les informations disponibles
            $Operation->setTitle($title);
            $Operation->setEnv($env);
            $Operation->setStep($step_start);
            // Attention au filepath
            if (isset($Infos['source']['directory'])) 
                $source_dir = $Infos['source']['directory'];
            elseif (isset($Infos['source']['filepath'])) {
                $source_dir = dirname($Infos['source']['filepath']);
            }
            else {
                $source_dir = '?';
            }
            $Operation->setSourcePath($source_dir);
            $Operation->setTargetPath($Infos['target']['directory']);
            if (isset($Infos['source']['filespec']))
                $Operation->setSourceFiles($Infos['source']['filespec']);
            elseif (isset($Infos['source']['filelist']))
                $Operation->setSourceFiles('list:'.$Infos['source']['filelist']);
            $Operation->setTargetFiles('');
            
            // fichiers attendus
            $expected_files = 1;
            $ordering = 1;
            $exit_if_nothing=0;

            // A ajouter
            $Operation->setExpectedFiles($expected_files);
            $Operation->setOrdering($ordering);
            $Operation->setExitIfNothing($exit_if_nothing);
            
        }
        else {
            // operation en cours 
            $step =           $Operation->getStep();
            // fichiers attendus
            $expected_files = $Operation->getExpectedFiles();
            $ordering =       $Operation->getOrdering();
            $exit_if_nothing= $Operation->getExitIfNothing(); 
        }

        // Si le transfert n'existe pas, on le reference
        $Transfer = $Operation->getTransfer();         
        if (!$Transfer) {
            // On cree un nouveau Status
            $Transfer = new \Arii\MFTBundle\Entity\Transfers();
            $Transfer->setName($name);
            $Transfer->setTitle($title);
            $Transfer->setEnv($env);
            $Transfer->setStepStart($step_start);
            $Transfer->setStepEnd($step_end);            
            $steps = 1;
        }
        else {
            $step_start =    $Transfer->getStepStart();
            $step_end =      $Transfer->getStepEnd(); 
            $steps =         $Transfer->getSteps(); 
        }
        
        // On rattache l'operation au transfert
        $Operation->setTransfer($Transfer);
        
        // On doit retrouver le status avec le numero du transfert
        $Status = $em->getRepository("AriiMFTBundle:Status")->findOneBy(array('transfer'=> $Transfer));  
        if (!$Status) {
            // Creation du statut
            $Status = new \Arii\MFTBundle\Entity\Status();
        }
        else {
            // On recupere les infos du dernier historique
            $Last = $Status->getHistory();  
            $run    = $Last->getRun();
            
            // transfert en cours ?
            $transferring = $Last->getTransferring();
        }
        
        // Si le transfert est terminé, on crée un nouvel historique
        if ($transferring==0) {
            $run++;            
            $History = new \Arii\MFTBundle\Entity\History();
        }
        else {
            // On recupere l'historique en cours
            $History = $em->getRepository("AriiMFTBundle:History")->findOneBy(array('transfer'=> $Transfer));             
            // Si il n'existe pas, on le crée
            if (!$History)
                $History = new \Arii\MFTBundle\Entity\History();
        }                
        
        // Livraison en cours 
        // Est ce qu'il y a déjà eu tentative
        $delivery = $em->getRepository("AriiMFTBundle:Deliveries")->findOneBy(array('operation'=> $Operation,'run'=>$run ), array('id' => 'DESC'));        
        if ($delivery) {
            $try = $delivery->getTry()+1;
        }
        
        // on conserve les changements
        $em->persist($Operation);

        // nouvelle livraison
        $delivery = new \Arii\MFTBundle\Entity\Deliveries();
        $delivery->setHistory($History);
        $delivery->setOperation($Operation);
        
        $delivery->setStartTime(new \DateTime($Main['start']));
        $delivery->setEndTime(new \DateTime($Main['end']));
        $delivery->setDuration( strtotime($Main['end']) - strtotime($Main['start']) );
        
        $delivery->setLogName($this->FileName($Infos['global']['logfile']));
        /*
        if (isset($Infos['global']['duration']))
            $delivery->setDuration($Infos['global']['duration']);
        else 
            $delivery->setDuration( strtotime($end_time) - strtotime($Infos['global']['date']) );
        */
        if (isset($Infos['status']['size']))
            $delivery->setFilesSize($this->CleanNumber($Infos['status']['size']));     
        else
            $delivery->setFilesSize(0);     
        
        // status
        // on essaie de préciser l'erreur
        if (isset($Infos['status']['execution status'])) {
            $p = strpos($Infos['status']['execution status'],'.');    
            $error = $Infos['status']['last error'];
            if (strpos($error,'Connection refused')) {
                $status = 'REFUSED';
            }
            elseif (strpos($error,':CheckMandatory:')) {
                $status = '!CONFIG';
            } 
            else {
                $status = strtoupper(substr($Infos['status']['execution status'],0,$p));
            }
            $delivery->setStatusText(substr($Infos['status']['execution status'],$p+2));
        }
        else {
            $delivery->setStatusText('UNKNOWN!');
        }
        
        // pas de fichiers et simple erreur failure
        if (!isset($Infos['status']['size']) and ($status=='FAILURE')) {
            if ($expected_files==0) { // aucun fichier attendu
                $status = 'NOTHING';
            }
        }
        $delivery->setStatus($status);
                
        $delivery->setFilesCount($count);
                
        if (isset($Infos['status'])) {
            $delivery->setSuccess($this->CleanNumber($Infos['status']['successful transfers']));
            $delivery->setSkipped($this->CleanNumber($Infos['status']['skipped transfers']));
            $delivery->setFailed($this->CleanNumber($Infos['status']['failed transfers']));
            $delivery->setLastError($this->CleanNumber($Infos['status']['last error']));
        }
        else { // Cas ou la connexion n'a pu être réaslisée
            $delivery->setSuccess('0');
            $delivery->setSkipped('0');
            $delivery->setFailed('0');
            $delivery->setLastError('0');
        }
        $delivery->setLogOutput($log);
        $delivery->setRun($run);
        $delivery->setTry($try);  
        
        $em->persist($delivery);

        if (isset($Infos['status'])) {
            // On precise le statut
            if ($Infos['status']['failed transfers']>0)
                $status = 'FAILED';
            elseif ($Infos['status']['skipped transfers']>0) 
                $status = 'SKIPPED';
        }
        else 
                $status = 'UNKNOWN';
        
        // Les transmissions
        print "<pre>";
        print_r($File);
        print "</pre>";
        
        $end = $end_time;
        foreach ($File as $name=>$file) {            
            $transmission = new \Arii\MFTBundle\Entity\Transmissions();
            $transmission->setDelivery($delivery);
            
            if (isset($file['local_filename'])) 
                $source = $file['local_filename'];
            elseif (isset($file['source_file']))
                $source = $file['source_file'];            
            $transmission->setSourceFile($source);
            
            if (isset($file['remote_filename'])) 
                $target = $file['remote_filename'];
            elseif (isset($file['target_file']))
                $target = $file['target_file'];            
            $transmission->setTargetFile($target);
                        
            // Changement sur la 1.10
            if (isset($file['start_time']))
                $start = $file['start_time'];
            elseif (isset($file['transfer_start']))
                $start = $file['transfer_start'];
            else
                $start = $Infos['global']['start'];
            
            if (isset($file['transfer_end']))
                $end = $file['transfer_end'];
            if (isset($file['end_time']))
                $end = $file['end_time'];
            else
                $end = $Infos['global']['end'];
            
            $transmission->setStartTime(new \DateTime($start));
            $transmission->setEndTime(new \DateTime($end));
            $transmission->setDuration( strtotime($end) - strtotime($start));
            
            if (isset($file['md5']))
                $transmission->setMd5($file['md5']);
            
            if (isset($file['status']))
                $tstatus = $file['status'];
            else
                $tstatus = 'success';            
            $transmission->setStatus($tstatus);        
            
            if (isset($file['file_size']))
                $size = $file['file_size'];
            elseif (isset($file['size']))
                $size = $file['size'];
            else 
                $size = 0;
            $transmission->setFileSize($size);            
            $em->persist($transmission);        
        }

        $em->persist($Transfer);      

        // Statut final
        if (($count==0) and ($exit_if_nothing==1)) {
            $status = 'ABORT';
        }

        // Transfert terminé ?
        if (
                ($step>=$step_end)    // le label est le label de fin
            or  ($ordering>=$steps)   // le numero de d'étape est egal au nombre d'étape
            or  ($status=='ABORT') 
           ) {
            $transferring=0;   
        }
        else {
            $transferring=1;
            $status = 'RUNNING';
        }
       
        // On Etat de l'historique
        $History->setStatusTime(new \DateTime());
        $History->setTransfer($Transfer);
        $History->setRun($run);
        $History->setStatus($status);
        $History->setTransferring($transferring);
        $em->persist($History);      
                        
        $Status->setHistory($History);
        $Status->setTransfer($Transfer);
        $em->persist($Status);
                                    
        $em->flush();            
        return new Response("success");
    }

    // Function pour trouver la date même si on dépasse minuit
    private function Time($ref,$time) {
        return $time;
        
        $time_ref = substr($ref,12);
        $date_ref = substr($ref,0,10);
        $time = substr($time,0,8);
        
        // cas simple
        if ($time>=$time_ref) 
            return $date_ref.' '.$time;
        // on passe au lendemain
        $Date = localtime(strtotime($date_ref)+24*3600,true);
        return sprintf("%04d-%02d-%02d",$Date['tm_year']+1900,$Date['tm_mon']+1,$Date['tm_mday'],$Date['tm_hour']).' '.$time;
    }
    
    private function Date($time) {
        return sprintf("%04d-%02d-%02d %02d:%02d:%02d",substr($time,0,4),substr($time,4,2),substr($time,6,2),substr($time,8,2),substr($time,10,2),substr($time,12,2));
    }
    
    private function FileName($file) {
        return str_replace('\\','/',trim($file));
    }
        
    private function CleanNumber($text) {
        return str_replace(' ','',str_replace('\r','',$text));
    }
    
}

