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
            print "-----------------------------\n";
            print "SERVER:   ".$Data['server']."\n";
            print "DATABASE: ".$Data['database']."\n";
            print "LOG_FILE: ".$Data['log_file']."\n";
            #print "COPYTIME: ".$Data['copytime']."\n";
                        
            // pas de log, pas de sauvegarde
            if ($Data['log_file']=='') continue;
            
            $create = new \Datetime($Data['mtime']);
            print "MTIME:    ".$create->format('Y-m-d H:i:s')."\n";

            // Retourver la référence
            $Ref = $this->em->getRepository("AriiReportBundle:BKP_REF")->findOneBy(
                array(  'db_instance'=> $Data['server'],
                        'db_name'=> $Data['database']
                )
            );
            if (!$Ref) {
                $Ref= new \Arii\ReportBundle\Entity\BKP_REF(); 
                print "NOREF!\n";
            }
            else {
                print "Ref:\n";
                print "\tDB_ENV:      ".$Ref->getDbEnv()."\n";
                print "\tDB_INSTANCE: ".$Ref->getDbInstance()."\n";
                print "\tDB_NAME:     ".$Ref->getDbName()."\n";
            }

            $Bkp = $this->em->getRepository("AriiReportBundle:BKP_BAK")->findOneBy(
                array(  'bkp_ref'=> $Ref,
                        'created'=> $create
                )
            );
            
            // Rattrapage
            if ($Data['archive_size']>0)
                $Data['archived']=1;
            
            if (!$Bkp) {
                print " Nouveau backup\n";
                $Bkp= new \Arii\ReportBundle\Entity\BKP_BAK();
            }
            else {
                print "Backup:\n";
                print "\tCREATED:     ".$Bkp->getCreated()->format('Y.m.d')."\n";
                if ($Bkp->getDeleted())
                    print "\tARCHIVED:    ".$Bkp->getDeleted()->format('Y.m.d')."\n";
                print "\tARCHIVED:    ".$Bkp->getArchived()."\n";
            }
                        
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
                print "ARCHIVED\n";
                $Arc = $this->em->getRepository("AriiReportBundle:BKP_ARC")->findOneBy(
                    array(  'bkp_bak'=> $Bkp,
                            'id_archive'=> $id_archive
                    )
                );
                if (!$Arc) {
                    print " Nouvelle archive\n";
                    $Arc = new \Arii\ReportBundle\Entity\BKP_ARC();  
                }
                else {
                    if ($Bkp->getArchived())
                        print "\tCREATED:     ".$Arc->getCreated()->format('Y.m.d')."\n";
                    
                }
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
