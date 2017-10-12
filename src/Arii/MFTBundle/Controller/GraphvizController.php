<?php

namespace Arii\MFTBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GraphvizController extends Controller
{
    private $graphviz_dot;
    private $plantuml;
    private $config;
    private $Color = array(
        's' => 'green', 
        'f' => 'red',
        'd' => 'blue',
        'n' => 'orange',
        't' => 'purple',
        'e' => 'cyan'
    );
    
    public function transferAction()
    {

        $request = Request::createFromGlobals();
        $return = 0;

        set_time_limit(120);
        $request = Request::createFromGlobals();
        $transfer = $request->query->get( 'id' );
                
        // Localisation des images 
        $images = '/bundles/ariigraphviz/images/silk';
        $images_path = $this->get('kernel')->getRootDir().'/../web'.$images;
        $images_url = $this->container->get('templating.helper.assets')->getUrl($images);        
        
        $session = $this->container->get('arii_core.session');
        $this->graphviz_dot = $session->get('graphviz_dot');
        
        $descriptorspec = array(
            0 => array("pipe", "r"),  // // stdin est un pipe où le processus va lire
            1 => array("pipe", "w"),  // stdout est un pipe où le processus va écrire
            2 => array("pipe", "w") // stderr est un fichier
         );
        $output = 'svg';

        $gvz_cmd = '"'.$this->graphviz_dot.'" -T '.$output;       
        $process = proc_open($gvz_cmd, $descriptorspec, $pipes);
        
        $splines = 'polyline';
        $rankdir = 'TB';
        
        $digraph = "digraph MFT {
fontname=arial
fontsize=12
splines=$splines
randkir=$rankdir
node [shape=plaintext,fontname=arial,fontsize=12]
edge [shape=plaintext,fontname=arial,fontsize=12,decorate=true,compound=true]
bgcolor=transparent
";

        $db = $this->container->get('arii_core.db');
        $data = $db->Connector('data');

        $mft = $this->container->get('arii_mft.mft');
        $Operations = $mft->Operations($transfer);

        # D'abord les noeuds    
        $Done = array();
        $Node = array();
        $step=0;
        $Rank = array(0);
        // Premier noeud 0_0
        $digraph .=  "\"0_0\" [label=\"Opération\"]\n";

        foreach ($Operations as $Operation) {
            $id_source = $Operation['SOURCE_ID'];
            $node = $Operation['SOURCE'];
            if (!isset($Done[$id_source])) {
                $Node[$id_source] = $Operation['ID'];                  
                $digraph .= '"'.$step."_"."$id_source\" [label=<".$this->Node(array('TITLE' => $node)).">]\n";
                array_push($Rank,$id_source);
                $Done[$id_source]=1;
            }
            
            $id_target = $Operation['TARGET_ID'];
            $node = $Operation['TARGET'];
            if (!isset($Done[$id_target])) {
                $Node[$id_source] = $Operation['ID'];
                $digraph .= '"'.$step."_"."$id_target\" [label=<".$this->Node(array('TITLE' => $node)).">]\n";
                array_push($Rank,$id_target);
                $Done[$id_target]=1;
            }
        }
        
        $S = array();
        foreach ($Operations as $Operation) {
            $s = $Operation['STEP'];
            array_push($S,$s);
            # on conserve le rang
            $Same = array();
            # On dessine l'echelle          
            foreach ($Rank as $r) {
                $node = $s."_".$r;
                $digraph .=  "\"$node\" [label=\".\"]\n";
                if ($r==0)
                    $digraph .=  '"'.$step."_"."$r\" -> \"$node\" [arrowhead=none, style=dotted, color=grey]\n";
                else
                    $digraph .=  '"'.$step."_"."$r\" -> \"$node\" [arrowhead=none, style=dashed, color=grey]\n";
                array_push($Same,$step."_".$r);
            }
            $digraph .= "{ rank = same; \"".implode('"; "',$Same)."\"; }\n";
            
            $digraph .= "\"$s"."_0\" [label=".$Operation['TITLE']."]\n";
            $id_source = $Operation['SOURCE_ID'];
            $id_target = $Operation['TARGET_ID'];
            // noeud utilisé
            $digraph .= "\"$s"."_$id_source\" [label=O]\n";
            $digraph .= "\"$s"."_$id_target\" [label=X]\n";
            $digraph .= "\"$s"."_$id_source\" -> \"$s"."_$id_target\" [constraint=false]\n";
            $step = $s;
        }
        
/*     
         print "<pre>$digraph";
        exit();
*/        
        $digraph .= "}";

        if (is_resource($process)) {
            fwrite($pipes[0], $digraph );
            fclose($pipes[0]);

            $out = stream_get_contents($pipes[1]);
            fclose($pipes[1]);

            $err = stream_get_contents($pipes[2]);
            fclose($pipes[2]);

            $return_value = proc_close($process);
            if ($return_value != 0) {
                print "<pre>$cmd</pre><br/>";
                print "[exit $return_value]<br/>";
                print "$out<br/>";
                print "<font color='red'>$err</font>";
                print "<hr/>";
                print "<pre>$digraph</pre>";
                exit();
            }
        }  
        else {
            print "Ressource !";
            exit();
        }

        if ($output == 'svg') {
            
            header('Content-type: image/svg+xml');
            // integration du script svgpan
            $head = strpos($out,'<g id="graph');
            if (!$head) {                
                print $check;
                print $this->graphviz_dot;
                exit();
            }
            $xml = '<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
<svg style="width: 100%;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1">
<script xlink:href="'.$this->container->get('templating.helper.assets')->getUrl("bundles/ariigraphviz/js/SVGPan.js").'"/>
<g id="viewport"';
            $xml .= substr($out,$head+14);
            print str_replace('xlink:href="'.$images_path,'xlink:href="'.$images_url,$xml);
        }
        elseif ($output == 'pdf') {
            header('Content-type: application/pdf');
            print trim($out);
        }
        else {
            header('Content-type: image/'.$output);
            print trim($out);
            exit();
        }
        exit();
    }

    public function exchangeAction()
    {
        $request = Request::createFromGlobals();
        $return = 0;

        set_time_limit(120);
        $request = Request::createFromGlobals();
        $transfer = $request->query->get( 'id' );
        $output = 'svg';
        if ($request->query->get( 'output' )!='')
            $output = $request->query->get( 'output' );
                
        // Localisation des images 
        $images = '/bundles/ariigraphviz/images/silk';
        $images_path = $this->get('kernel')->getRootDir().'/../web'.$images;
        $images_url = $this->container->get('templating.helper.assets')->getUrl($images);        
        
        $session = $this->container->get('arii_core.session');
        $this->graphviz_dot = $session->get('graphviz_dot');
        
        $this->java = $session->get('java');
        $this->plantuml = $session->get('plantuml');
        
        $descriptorspec = array(
            0 => array("pipe", "r"),  // // stdin est un pipe où le processus va lire
            1 => array("pipe", "w"),  // stdout est un pipe où le processus va écrire
            2 => array("pipe", "w") // stderr est un fichier
         );
            
        $cmd = '"'.$this->java.'/bin/java" -jar ../java/'.$this->plantuml.' -charset UTF-8 -graphvizdot dot -pipe flag -t'.$output; 

        $process = proc_open($cmd, $descriptorspec, $pipes);

        $splines = 'polyline';
        $rankdir = 'TB';
        
        $uml = "@startuml
skinparam monochrome true
";
        
        $db = $this->container->get('arii_core.db');
        $data = $db->Connector('data');

        $mft = $this->container->get('arii_mft.mft');
        $Operations = $mft->Operations($transfer);

        if (!$Operations) exit();
        
        $n=0;
        foreach ($Operations as $Operation) {
            if (($Operation['SOURCE']!='') and ($Operation['TARGET']!='')) {
                $uml .= "\"".$Operation['SOURCE']."\" -> \"".$Operation['TARGET']."\" : ".str_replace('_',' ',$Operation['NAME'])."\n";
                $n++;
            }
        }

        if ($n==0) exit();
        
        $uml .= "@enduml";     

        if (is_resource($process)) {
            fwrite($pipes[0], $uml );
            fclose($pipes[0]);

            $out = stream_get_contents($pipes[1]);
            fclose($pipes[1]);

            $err = stream_get_contents($pipes[2]);
            fclose($pipes[2]);

            $return_value = proc_close($process);
            if ($return_value != 0) {
                print "<pre>$cmd</pre><br/>";
                print "[exit $return_value]<br/>";
                print "$out<br/>";
                print "<font color='red'>$err</font>";
                print "<hr/>";
                print "<pre>$uml</pre>";
                exit();
            }
        }  
        else {
            print "Ressource !";
            exit();
        }
        
        if ($output == 'svg') {

            header('Content-type: image/svg+xml');
            // integration du script svgpan
            $tag = '<defs>';
            $head = strpos($out,$tag);
            if (!$head) {                
                print $out;
                exit();
            }
            $xml = '<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
<svg style="width: 100%;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1">
'.$tag;
            $xml .= substr($out,$head+strlen($tag));
            print $xml;
        }
        elseif ($output == 'pdf') {
            header('Content-type: application/pdf');
            print trim($out);
        }
        else {
            header('Content-type: image/'.$output);
            print trim($out);
            exit();
        }
        exit();
    }

    // suivi graphique
    public function historyAction()
    {
        $request = Request::createFromGlobals();
        $return = 0;

        set_time_limit(120);
        $request = Request::createFromGlobals();
        $history = $request->query->get( 'history_id' );
                
        $splines = 'polyline';
        $rankdir = 'TB';
         
        $db = $this->container->get('arii_core.db');
        $data = $db->Connector('data');

        $mft = $this->container->get('arii_mft.mft');
        $Operations = $mft->HistoryDeliveries($history);

        $uml = "@startuml
";
// legend top
// endlegend        
     //   if (!$Operations) exit();
        
        $n=0;
        foreach ($Operations as $Operation) {      
            $uml .= "== ".$Operation['START_TIME']." ==\n";
            if (($Operation['SOURCE']!='') and ($Operation['TARGET']!='')) {                
                $uml .= "\"".$Operation['SOURCE']."\" -> \"".$Operation['TARGET']."\" : ".str_replace('_',' ',$Operation['TITLE'])."\n";
                $uml .= "note right ".$Operation['COLOR']."\n";
                $uml .= $Operation['END_TIME'].": ".$Operation['STATUS']."\n";
                $uml .= "end note\n";
                $n++;
            }
        }
        // if ($n==0) exit();        
        $uml .= "@enduml";     
        
        $plantuml = $this->container->get('arii_core.plantuml');
        return $plantuml->graph($uml);
    }
    
    function CleanPath($path) {
        
        // bidouille en attendant la fin de l'étude
/*        if (substr($path,0,4)=='live') 
            $path = substr($path,4);
        elseif (substr($path,0,6)=='remote') 
            $path = substr($path,6);
        elseif (substr($path,0,5)=='cache') 
            $path = substr($path,5);
*/      
        $path = str_replace('/','.',$path);
        $path = str_replace('\\','.',$path);
        $path = str_replace('#','.',$path);
        
        // protection des | sur windows
        $path = str_replace('|','^|',$path);       
        
        return $path;
    }
    
    private function Node($Node) {
        $table = '<TABLE BORDER="1" CELLBORDER="0" CELLSPACING="0" COLOR="grey">';
        $table .= '<TR><TD>'.$Node['TITLE'].'</TD></TR>';
        $table .= '</TABLE>';
        return $table;
    }
    
}
