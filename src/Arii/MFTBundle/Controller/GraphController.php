<?php

namespace Arii\MFTBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GraphController extends Controller
{

    public function exchangeAction()
    {
        $request = Request::createFromGlobals();
        $return = 0;

        set_time_limit(120);
        $request = Request::createFromGlobals();
        $transfer = $request->query->get( 'id' );

        $db = $this->container->get('arii_core.db');
        $data = $db->Connector('data');

        $mft = $this->container->get('arii_mft.mft');
        $Operations = $mft->Operations($transfer);
        
        // On récupère les connexions
        $portal = $this->container->get('arii_core.portal');
        $Connections = $portal->getConnections();
        
        $uml = "@startuml
skinparam monochrome true
";
        $n=0;
        if ($Operations) {
            foreach ($Operations as $Operation) {
                if (($Operation['SOURCE']!='') and ($Operation['TARGET']!='')) {
                    $source = $Operation['SOURCE'];
                    if (isset($Connections[$source]) and ($Connections[$source]['title']!='')) 
                        $source = $Connections[$source]['title'];
                    $target = $Operation['TARGET'];
                    if (isset($Connections[$target]) and ($Connections[$target]['title']!='')) 
                        $target = $Connections[$target]['title'];
                    if ($Operation['TITLE']!='')
                        $title = $Operation['TITLE'];
                    else
                        $title = $Operation['NAME'];
                    $uml .= "\"".$source."\" -> \"".$target."\" : ".str_replace('_',' ',$title)."\n";
                    $n++;
                }
            }
        }
        $uml .= "@enduml";     

        $plantuml = $this->container->get('arii_core.plantuml');

        return $plantuml->graph($uml);
    }
    
    public function schemaAction($partner_id=0)
    {
        $request = Request::createFromGlobals();
        if ($request->get('partner_id')>0)
            $partner_id = $request->get('partner_id');

        $history = $this->container->get('arii_mft.mft');
        $Transfers = $history->Transfers($partner_id);
        
        print_r($Transfers);
        exit();
    }

}
