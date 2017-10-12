<?php
namespace Arii\ReportBundle\Service;

class ImportIP {
    
    
    public function __construct(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;        
    }

    public function Import() {
        set_time_limit(600);
        $Asset = $this->get();
        return $this->updateIP($Asset);
    }

    private function get($limit=100) {
        set_time_limit(3600);
        // D'abord les null
        $IPs = $this->em->getRepository('AriiReportBundle:IP')->findBy(array('updated' => null),array(), $limit );
        if (!$IPs)
            $IPs = $this->em->getRepository('AriiReportBundle:IP')->findBy(array(),array('updated' => 'ASC'), $limit );
        $Asset = array();
        foreach ($IPs as $ip) {
            $name = $ip->getName();
            if ($name != '-') {
                $Asset[$name]['ip'] = $ip->getIp();            
                $Asset[$name]['updated'] = $ip->getUpdated();
            }
        }
        return $Asset;
    }

    private function updateIP($Asset) {       
        $n=0;
        $msg = "<!-- {{MESSAGE ";
        foreach ($Asset as $name => $asset) {           
            $msg .= "$name ";
            $IP = $this->em->getRepository("AriiReportBundle:IP")->findOneBy(array('name'=> $name));        
            if (!$IP)
                $IP= new \Arii\ReportBundle\Entity\IP();
            
            $IP->setName($name);
            
            list($ip,$dns,$status) = $this->getIP($name);
            print "($ip - $dns - $status)";
            
            $IP->setIp($ip);
            $IP->setStatus($status);
            $IP->setHost($dns);
            
            $IP->setUpdated (new \DateTime());
            
            $this->em->persist($IP);
            
            $n++;
//            if ($n % 10 == 0)
//                $this->em->flush();
        }
        $msg .= "}} -->";
        $this->em->flush();            
        return "$msg success";
    }

    private function getIPWindows($name) {
       $res = `ping -a "$name" -n 1`;
       $line = explode("\n",$res);
       
       $ip= $dns = '?';
       if ($p = strpos($line[1],"[")) {
           $e = strpos($line[1],"]",$p+1);
           $ip  = substr($line[1],$p+1,$e-$p-1);
           $dns = substr($line[1],8,$p-9);
           
           $status = $line[2];
       }
       else {
           $status = $line[0];
       }
       return array($ip,$dns,$status);
    }

    // version Unix
    private function getIP($name) {
        $res = `ping -a "$name" -c 1`;
        $line = explode("\n",$res);

        $ip= $dns = '?';
        if (isset($line[1])) {
            if ($p = strpos($line[1],"(")) {
                $e = strpos($line[1],")",$p+1);
                $ip  = substr($line[1],$p+1,$e-$p-1);
                $dns = substr($line[1],5,$p-6);

                $status = $line[2];
            }
            else {
                $status = $line[0];
            }
        }
        else {
            $ip = '0.0.0.0';
            $dns = $name;
            $status = "unknown host $name";
        }
       return array($ip,$dns,$status);
    }
    
}