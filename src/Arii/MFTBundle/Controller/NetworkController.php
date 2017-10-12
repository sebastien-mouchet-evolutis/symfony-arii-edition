<?php
// src/Arii/MFTBundle/Controller/PartnersController.php

namespace Arii\MFTBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class NetworkController extends Controller
{
    protected  $ColorStatus = array (
            'success' => '#ccebc5',
            'error' => '#fbb4ae'
        );

    public function indexAction()
    {
        $session = $this->container->get('arii_core.session');

        $Spooler_info = array();
        $Nodes = array();
        $Links = array();
        $Done = array();
        
        $em = $this->getDoctrine()->getManager();
        $Transfers = $em->getRepository("AriiMFTBundle:Summary")->findAll();
        
        foreach ($Transfers as $transfer) {
            
            $spooler = $line['spooler'];
            $spooler_id = $line['spooler_id'];
            array_push($Nodes, array( 'id'=>'spooler_'.$spooler_id, 'name' => $spooler, 'image' => 'spooler' ));

            $supervisor = $line['supervisor_id'];
            if ($supervisor != '') {
                    array_push($Links, array( 'from'=>'spooler_'.$supervisor, 'to' => 'spooler_'.$spooler_id, 'color'=>'lightblue', 'style'=> 'moving-dot', 'length'=>50, 'width'=>0.5 ));
            }
            $primary = $line['primary_id'];
            if ($primary != '') {
                    array_push($Links, array( 'from'=>'spooler_'.$primary, 'to' => 'spooler_'.$spooler_id, 'color'=>'green', 'style'=> 'moving-dot', 'length'=>50, 'width'=>0.5 ));
            }
            
            $db = $line['db'];
            if ($db != '') {
                $db_id = $line['db_id'];
                if (!isset($Done["db_$db_id"])) {
                    array_push($Nodes, array( 'id'=>'db_'.$db_id, 'name' => $db, 'image' => 'database' ));
                    $Done["db_$db_id"] = 1;
                }
                array_push($Links, array( 'from'=>'spooler_'.$spooler_id, 'to' => 'db_'.$db_id, 'color'=>'lightgray', 'style'=> 'moving-dot', 'length'=>100, 'width'=>1 ));
            }
           }
		
/*		
        $network = "nodesTable.addRow([1, 'Wireless', DIR + 'Network-Pipe-icon.png', 'image']);";
        $network .= "nodesTable.addRow([2, 'Wireless', DIR + 'Network-Pipe-icon.png', 'image']);";
        $network .= "linksTable.addRow([1, 2, lengthMain]);";
*/		
        return $this->render('AriiMFTBundle:Network:index.html.twig', array('Nodes' => $Nodes, 'Links' => $Links) );
    }
        
}
