<?php
namespace Arii\ReportBundle\Service;

class ImportBKP {
    
    protected $em;
    protected $portal;
    
    public function __construct(
        \Doctrine\ORM\EntityManager $em, 
        \Arii\CoreBundle\Service\AriiPortal $portal) {
        $this->em = $em;
        $this->portal = $portal;
    }

    public function Import() {
        
        if (isset($_FILES['log']['tmp_name']))
            if ($_FILES['log']['error']>0) {
                print "UPLOAD ERROR ".$_FILES['log']['error'];
                exit();
            }
            else {
                $log = file_get_contents( $_FILES['log']['tmp_name'] );
            }            
        else {
            $log = file_get_contents($this->portal->getWorkspace().'/Report/Import/BKP/FULL.csv');
        }            
        return $this->update(explode("\r\n",$log));
    }

    // Traitement du log
    private function update($Log = array())
    {
        set_time_limit(7200);        
        $header = array_shift($Log);

        $Head = explode("\t",$header);
        
        // On traite le log
        $n=0;
        foreach ($Log as $l) {
            if ($l=='') continue;
            
            $Infos = explode("\t",$l);
            for($i=0;$i<count($Infos);$i++) {
                $Data[$Head[$i]] = $Infos[$i];
            }
            
            // pas de log, pas de sauvegarde
            if ($Data['log_file']=='') continue;
            
            // Retourver la référence
            $Ref = $this->em->getRepository("AriiReportBundle:BKP_REF")->findOneBy(
                array(  'db_instance'=> $Data['server'],
                        'db_name'=> $Data['database']
                )
            );
            if (!$Ref) {
                $Ref= new \Arii\ReportBundle\Entity\BKP_REF(); 
            }
            $create = new \Datetime($Data['mtime']);
                
            $Bkp = $this->em->getRepository("AriiReportBundle:BKP_BAK")->findOneBy(
                array(  'bkp_ref'=> $Ref,
                        'created'=> $create
                )
            );
            
            // Rattrapage
            if ($Data['archive_size']>0)
                $Data['archived']=1;
            
            if (!$Bkp)
                $Bkp= new \Arii\ReportBundle\Entity\BKP_BAK();
                        
            $Ref->setDbType('sqlsrv');
            $Ref->setDbEnv($Data['env']);
            $Ref->setDbSystem($Data['system']);
            $Ref->setDbName($Data['database']);
            $Ref->setDbInstance($Data['server']);          
            $Ref->setDbGroup($Data['group']);
            $Ref->setPathSource(dirname($Data['backup_file']));
            if ($Data['archive_dir']!='') {
                $archive_dir = $Data['archive_dir'];
                if (substr($archive_dir,1,1)==':')
                        $archive_dir = substr($archive_dir,2);
                $Ref->setPathDestination($archive_dir);
            }
            $Ref->setUpdated(new \DateTime());            
            $this->em->persist($Ref);
            
            $Bkp->setBkpRef($Ref);
            $Bkp->setCreated($create);             
            $Bkp->setArchived($Data['archived']);             
            $Bkp->setFileName(basename($Data['backup_file']));
            $Bkp->setLogFile(basename($Data['log_file']));
            $Bkp->setBkpSize($Data['size']);
            $Bkp->setBkpDuration($Data['duration']);
            $Bkp->setBkpPages($Data['pages']);
            $Bkp->setBkpSpeed($Data['speed']);
            $Bkp->setValid($Data['valid']);
            $Bkp->setUpdated(new \DateTime());                       
            $Bkp->setArchived($Data['archived']);         
            
            $this->em->persist($Bkp);
            
            $id_archive = substr($Data['archive_dir'],-7);
            
            // Archivé ?
            if ($Data['archived']==1) {
                $Arc = $this->em->getRepository("AriiReportBundle:BKP_ARC")->findOneBy(
                    array(  'bkp_bak'=> $Bkp,
                            'id_archive'=> $id_archive
                    )
                );
                if (!$Arc)
                    $Arc = new \Arii\ReportBundle\Entity\BKP_ARC();  
                
                $Arc->setBkpRef($Ref);
                $Arc->setBkpBak($Bkp);
                $Arc->setIdArchive($id_archive);
                $Arc->setArcSize($Data['archive_size']);
                $Arc->setCopytime($Data['copytime']);
                $Arc->setCreated(new \DateTime($Data['archive_time']));
                $Arc->setUpdated(new \DateTime());
                $this->em->persist($Arc);
            }
            
            // print $Data['backup_file']."<br/>";
            
            $n++;
            if ($n % 100) {
                $this->em->flush();
            }
        }
        $this->em->flush();    
        return "success";
    }

}
?>
