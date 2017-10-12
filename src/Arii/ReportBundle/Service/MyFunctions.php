<?php
namespace Arii\ReportBundle\Service;

class MyFunctions {
    
    
    public function __construct() {
    }
/*
Informatique/Instances OS serveur/Hypervisé Wmware
Informatique/Instances OS serveur/Serveurs physiques RISC
Informatique/Instances OS serveur/Serveur Intel Physique
Informatique/Instances OS serveur/Serveur AIX
Informatique/Instances OS serveur/Physique
Informatique/Instances OS serveur/Hypervisé Power
Informatique/Instances OS serveur/Baies de stockage
*/    
    public function Categorie ($vendor) {
        switch (trim($vendor)) {
            case 'VMware, Inc.':
                return 'Informatique/Instances OS serveur/Hypervisé Wmware';
            case 'Intel Corporate':
                return 'Informatique/Instances OS serveur/Serveur Intel Physique';
            case 'Hewlett-Packard Company':
                return 'Informatique/Instances OS serveur/Serveurs physiques RISC';
            case 'Super Micro Computer, Inc.':
                return 'Informatique/Instances OS serveur/Serveur Nutanix';
            case 'Dell Inc':                
            case 'Dell Inc.':                
                return 'Informatique/Instances OS serveur/Serveur Dell';
            case 'IBM':                
                return 'Informatique/Instances OS serveur/Serveur IBM';
            case 'CLARIION':                
                return 'Informatique/Instances OS serveur/Baies de stockage';
            case 'CISCO SYSTEMS, INC.':
                return 'Informatique/Instances OS serveur/Serveur Cisco UCS';
            case '':
                return 'Informatique/Instances OS serveur/Hypervisé Power';                
            default:
                return "?! $vendor";
        }
    }
    
    public function Marque ($vendor) {
        switch (trim($vendor)) {
            case 'VMware, Inc.':
                return 'VMware';
            case 'Intel Corporate':
                return 'Intel';
            case 'Hewlett-Packard Company':
                return 'HP';
            case 'Super Micro Computer, Inc.':
                return 'SMC';
            case 'Dell Inc':                
            case 'Dell Inc.':                
                return 'Dell';
            case 'IBM':                
                return 'IBM';
            case 'CLARIION':                
                return 'CLARRION';
            case 'CISCO SYSTEMS, INC.':
                return 'CISCO';
            case '':
                return 'IBM';           
            default:
                return "?! $vendor";
        }
    }

    public function Modele ($vendor) {
        return;
    }

    public function Heure ($time) {
        
        return sprintf("%02d/%02d/%04d",substr($time,8,2),substr($time,5,2),substr($time,0,4));
    }

}

