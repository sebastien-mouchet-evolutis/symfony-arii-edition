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
        $date = new \DateTime();
        $Default = [
            'env' => 'P',
            'app' => '*',
            'tag' => '*',
            'spooler' => '*',
            'day_past' => -30,
            'hour' => $date->format('h'),
            'day' => $date->format('d'),
            'month' => $date->format('m'),
            'year' => $date->format('Y'),
            'limit' => 10
        ];
        
        $request = Request::createFromGlobals();
        $User = $this->portal->getUserInterface();    
        foreach (['env','app','day_past','month','day','year','hour','minute','second','tag','spooler','limit'] as $f) {
            // cas speciaux
            switch ($f) {
                case 'month':
                    if ($request->query->get($f)=='last') {
                        $date->modify("last month");
                        $User[$f] = $date->format('m');
                    }
                    break;
                default:
                    if ($request->query->get($f)!='') {
                        $User[$f] = $request->query->get($f);
                    }
                    elseif (isset($Default[$f])) {
                        $User[$f] = $Default[$f];
                    }
                    break;
            }
        }       
        
        // Calcul fixe
        $end = new \DateTime($User['year'].'-'.$User['month'].'-'.$User['day']);
        $start = clone $end;
        $start->add(\DateInterval::createFromDateString($User['day_past'].' day'));
        
        $User['start'] = $start;
        $User['end'] = $end;
        
        // Conflit avec app.request de twig
        $Filters = $this->portal->setUserInterface($User);
        $Filters['appl']=$Filters['app'];
        unset($Filters['app']);
        // compatibilite
        $Filters['job_class']=$Filters['tag'];  
        return $Filters;
    }
    
    // fonction obsolete
    public function getFilter($env='',$app='',$day_past='',$day='',$month='',$year='',$class='', $hour='', $spooler='' ) {       
        $User = $this->portal->getUserInterface();        

        // nouveauté
        if (!isset($User['class'])) $User['class']='*';
        
        if ($class=='') $class = $User['class'];
        if ($class=='') $class = '*';        
        $User['class'] = $class;
        
        if ($env=='') $env = $User['env'];
        if ($env=='') $env = 'P';        
        $User['env'] = $env;
        
        if ($app=='') $app = $User['app'];
        if ($app=='') $app = '*';
        $User['app'] = $app;

        if ($spooler=='') $spooler = $User['spooler'];
        if ($spooler=='') $spooler = 'arii';
        $User['spooler'] = $spooler;
        
        if ($day_past=='') $day_past = $User['day_past'];
        if ($day_past=='') $day_past = -90;
        $User['day_past'] = $day_past;
        
        $date = new \DateTime();
        // compatibilite temporaire
        if (!isset($User['day'])) $User['day']=$date->format('d');
        if ($day=='') $day = $User['day'];
        if ($day=='') $day = $date->format('d');
        $User['day'] = $day;
        
        if ($year=='') $year = $User['year'];
        if ($year=='') $year = $date->format('Y');
        $User['year'] = $year;

        if ($month=='') $month = $User['month'];
        if ($month=='last') {
            $date->modify("last month");
            $month = $date->format('m');
        }

        if ($hour=='') $hour = $User['hour'];
        if ($hour=='') $hour = $date->format('H');
        $User['hour'] = $hour;
        
/*        
        $end = new \DateTime("$year-$month-01 23:59:59");
        $end->modify('last day of this month');
        
        $month_add = round($day_past/30)+1; // on va du 1er au 31 de la fin
        $start = new \DateTime("$year-$month-01"); 
        $start->modify("$month_add months");
        $start->modify('first day of this month');
        // on se positionne au premier jour de mois precedent
        $this->start = date('Y-m-d',strtotime(substr($User['day_past'],0,8).'01'));
*/
        // Calcul fixe
        $end = new \DateTime("$year-$month-$day");
        $start = clone $end;
        $start->add(\DateInterval::createFromDateString($day_past.' day'));

        $this->portal->setUserInterface($User);
        return array($env,$app,$day_past,$day,$month,$year,$start,$end,$class,$hour,$spooler);
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
