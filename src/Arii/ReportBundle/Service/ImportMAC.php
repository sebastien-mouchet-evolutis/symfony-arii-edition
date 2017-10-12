<?php
namespace Arii\ReportBundle\Service;

class ImportMAC {
    
    
    public function __construct(\Doctrine\ORM\EntityManager $em, $Parameters) {
        $this->em = $em;        
    }

    public function Import() {
        return $this->importMAC();
    }


    private function importMAC() {     
        set_time_limit(600);
        $handle = fopen('../src/Arii/ReportBundle/Service/oui.txt', "r");
        if (!$handle) 
            return 'failed !!';
        
        $n=0;
        while (!feof($handle)) {
            $buffer = fgets($handle, 4096);
            if (substr($buffer,2,1)<>'-') continue;
            $mac = str_replace('-',':',substr($buffer,0,8));
            $vendor = str_replace(array("\n","\r"),array('',''),substr($buffer,18));

            $MAC = $this->em->getRepository("AriiReportBundle:MAC")->findOneBy(array('oui'=> $mac));        
            if ($MAC) continue;
            
            $MAC= new \Arii\ReportBundle\Entity\MAC();
            
            $MAC->setOui($mac);
            $MAC->setVendor($vendor);
            
            if ($n % 50 == 0) 
                $this->em->flush();
            
            $this->em->persist($MAC);
            $n++;
        }
        fclose($handle);
        
        return "success";
    }

}