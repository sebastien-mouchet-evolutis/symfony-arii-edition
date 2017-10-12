<?php
// src/Arii/JIDBundle/Service/AriiHistory.php
/*
 * Recupere les données et fournit un tableau pour les composants DHTMLx
 */
namespace Arii\ReportBundle\Service;
use Symfony\Component\HttpFoundation\Request;

class ReportFilter
{
    protected $portal;
    protected $start;
    
    public function __construct (\Arii\CoreBundle\Service\AriiPortal $portal) {
        $this->portal = $portal;
    }
    
    // fonction qui remplacera le getfilter
    public function getRequestFilter() {         
        $request = Request::createFromGlobals();
        $Request = array();
        foreach (['env','app','day_past','month','year'] as $f) {
            if ($request->query->get($f)!='')
                $Request[$f] = $request->query->get($f);
        }
       
        $User = $this->portal->getUserInterface();    
        foreach(['env','app','day_past','month','day','year','hour','minute','second'] as $f) {
            if (isset($Request[$f]))
                $User[$f] = $Request[$f];            
        }
        return $this->portal->setUserInterface($User);
    }
    
    // fonction obsolete
    public function getFilter($env='',$app='',$day_past='',$day='',$month='',$year='') {       
        $User = $this->portal->getUserInterface();        

        if ($env=='') $env = $User['env'];
        if ($env=='') $env = 'P';        
        $User['env'] = $env;
        
        if ($app=='') $app = $User['app'];
        if ($app=='') $app = '*';
        $User['app'] = $app;
        
        if ($day_past=='') $day_past = $User['day_past'];
        if ($day_past=='') $day_past = -90;
        $User['day_past'] = $day_past;
        
        $date = new \DateTime();
        if ($day=='')
            $day = $date->format('d');
        
        if ($year=='')
            $year = $date->format('Y');

        if ($month=='last') {
            $date->modify("last month");
            $month = $date->format('m');
        }
        elseif ($month=='')
            $month = $date->format('m');

        $end = new \DateTime("$year-$month-01 23:59:59");
        $end->modify('last day of this month');
        
        $month_add = round($day_past/30)+1; // on va du 1er au 31 de la fin
        $start = new \DateTime("$year-$month-01"); 
        $start->modify("$month_add months");
        $start->modify('first day of this month');

        // on se positionne au premier jour de mois precedent
        $this->start = date('Y-m-d',strtotime(substr($User['day_past'],0,8).'01'));
        
        $this->portal->setUserInterface($User);
        return array($env,$app,$day_past,$day,$month,$year,$start,$end);
    }
    
    public function getEnv() {
        $User = $this->portal->getUserInterface();
    return $User['env'];  
    }

    public function getApp() {
        $User = $this->portal->getUserInterface();
    return $User['app'];  
    }

    public function getStart() {
    return $this->start;
    }
    
}
