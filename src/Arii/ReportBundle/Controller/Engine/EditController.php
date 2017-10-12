<?php

namespace Arii\ReportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EditController extends Controller
{
    public function indexAction()
    {
        return $this->render('AriiReportBundle:Edit:index.html.twig' );
    }
    
    public function treeAction($path='report')
    {        
        $session = $this->container->get('arii_core.session');
        $engine = $session->getSpoolerByName('arii');
                
        # On retrouve le chemin des rapports
        $path = $engine[0]['shell']['data'].'/config/live/Arii/Reports';

        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        $xml = "<?xml version='1.0' encoding='utf-8'?>";                
        $xml .= '<tree id="0">';        
        $xml .= $this->TreeXML($path,'');
        $xml .= '</tree>';        
        $response->setContent($xml);
        return $response;
    }

    public function TreeXML($basedir,$dir ) {
        $xml ='';
        if ($dh = @opendir($basedir.'/'.$dir)) {
            $Dir = array();
            $Files = array();
            while (($file = readdir($dh)) !== false) {
                $sub = $basedir.'/'.$dir.'/'.$file;
                if (($file != '.') and ($file != '..')) {
                    if (is_dir($sub)) {
                        array_push($Dir, $file );
                    }
                    else {
                        array_push($Files, $file );                
                    }
                }
            }
            closedir($dh);
            
            sort($Files);
            foreach ($Files as $file) {
                // on ne s'intéresse qu'aux ordres
                if (substr($file,-10)=='.order.xml') {
                    $f = substr($file,0,strlen($file)-10);
                    $xml .= '<item id="'.utf8_encode("$dir/$file").'" text="'.utf8_encode($f).'" im0="order.png"/>';
                }
            }

            sort($Dir);
            foreach ($Dir as $file) {
                $xml .= '<item id="'.utf8_encode("$dir/$file/").'" text="'.utf8_encode($file).'" im0="folder.gif">';
                $xml .= $this->TreeXML($basedir,"$dir/$file");
                $xml .= '</item>';
            }
            
        }
        else {
            exit();
        }
        return $xml;
    }

    public function sqlAction()
    {        
        $session = $this->container->get('arii_core.session');
        $engine = $session->getSpoolerByName('arii');
        
        # On retrouve le chemin des rapports
        $data   = $engine[0]['shell']['data'];
        $config = "$data/config";
        $path   = $config.'/live/Arii/Reports';

        $request = Request::createFromGlobals();
        $order = $request->query->get('order');

        # On retrouve le chemin des rapports
        $content = file_get_contents("$path/$order");
        $tools = $this->container->get('arii_core.tools');
        $Result = $tools->xml2array( $content , 1, 'attributes');
        
        if (!isset($Result['order']['params']['param'])) {
            print "Params ?!";
            exit();
        }
        
        $p = 0;
        while  (isset($Result['order']['params']['param'][$p]['attr']['name'])) {
            $name  = $Result['order']['params']['param'][$p]['attr']['name'];
            $value = $Result['order']['params']['param'][$p]['attr']['value'];
            $Val[$name] = $value;
            $p++;
        }
        
        $sql = $Val['query_filename'];
        print file_get_contents("$data/$sql");
        
        exit();
    }

}
