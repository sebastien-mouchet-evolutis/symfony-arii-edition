<?php

namespace Arii\ReportBundle\Controller\Requests;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Parser;
use Doctrine\ORM\Query\ResultSetMapping;
use \Dompdf\Dompdf;
use \Dompdf\Options;

class RequestsController extends Controller
{
    public function indexAction()
    {
        return $this->render('AriiReportBundle:Requests:index.html.twig');
    }

    public function toolbarAction()
    {        
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');    
        return $this->render('AriiReportBundle:Requests:toolbar.xml.twig',array(), $response );
    }

    public function treeAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        $list = '<?xml version="1.0" encoding="UTF-8"?>';
        $list .= '<tree id="0">
                    <item id="runtimes" text="Runtimes"/>
                 </tree>';

        $response->setContent( $list );
        return $response;        
    }

    public function listAction()
    {
        // On récupère les statuts en cours
        $em = $this->getDoctrine()->getManager();        
        $Checks = $em->getRepository("AriiReportBundle:CHECK")->findAll();
        foreach ($Checks as $Check) {
            $request = $Check->getName();
            $State[$request] = [
                'status'  => $Check->getStatus(),
                'executed'  => $Check->getExecuted()->format('U'),
                'results'  => $Check->getResults()
            ];            
        }
        
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        $list = '<?xml version="1.0" encoding="UTF-8"?>';
        $list .= '<rows>';
        $list .= '<head>
            <afterInit>
                <call command="clearAll"/>
            </afterInit>
        </head>';
        
        $yaml = new Parser();
        $basedir = $this->getBaseDir();

        $portal = $this->container->get('arii_core.portal');
        $ColorStatus = $portal->getColors();

        if ($dh = @opendir($basedir)) {
            while (($file = readdir($dh)) !== false) {
                if (substr($file,-4) == '.yml') {
                    $content = file_get_contents("$basedir/$file");
                    $v = $yaml->parse($content);
                    $title = $v['title'];
                    $name = substr($file,0,strlen($file)-4);
                    if (isset($State[$name])) {
                        $nb     = $State[$name]['results'];
                        $delay = round((time() - $State[$name]['executed'])/3600);
                        if ($delay>4) {
                            $bg = ' style="background-color: '.$ColorStatus['RUNNING']['bgcolor'].';"';
                        }
                        else {
                            switch ($State[$name]['status']) {
                                case 1:
                                    $bg = ' style="background-color: '.$ColorStatus['INACTIVE']['bgcolor'].';"';
                                    break;
                                case 2:
                                    $bg = ' style="background-color: '.$ColorStatus['SUCCESS']['bgcolor'].';"';
                                    break;
                                case 4:
                                    $bg = ' style="background-color: '.$ColorStatus['FAILURE']['bgcolor'].';"';
                                    break;
                                default:
                                    $bg = '';
                            }
                        }
                    }
                    else {
                        $nb='';
                        $bg = '';
                    }
                    $Files[$title] = '<row id="'.$name.'"'.$bg.'><cell>'.$title.'</cell><cell>'.$nb.'</cell></row>';
                }
            }
            ksort($Files);
            foreach ($Files as $k=>$v) {
                $list .= $v;
            }
        }
        $list .= '</rows>';

        $response->setContent( $list );
        return $response;        
    }
   
    public function summaryAction()
    {
        $lang = $this->getRequest()->getLocale();
        $basedir = $this->getBaseDir();

        $yaml = new Parser();
        $value['title'] = $this->get('translator')->trans('Summary');
        $value['description'] = $this->get('translator')->trans('List of requests');
        $value['columns'] = array(
            $this->get('translator')->trans('Title'),
            $this->get('translator')->trans('Description') );
        
        $nb=0;
        if ($dh = @opendir($basedir)) {
            while (($file = readdir($dh)) !== false) {
                if (substr($file,-4)=='.yml') {
                    $content = file_get_contents("$basedir/$file");
                    $v = $yaml->parse($content);
                    $nb++;
                    $value['lines'][$nb]['cells'] = array($v['title'],$v['description']);
                }                
            }
        }
        
        $value['count'] = $nb;
        return $this->render('AriiReportBundle:Requests:bootstrap.html.twig', array('result' => $value));
    }

    public function resultAction($output='html',$req='')
    {
        $lang = $this->getRequest()->getLocale();
        $request = Request::createFromGlobals();
        if ($request->query->get( 'request' ) and $request->query->get( 'request' )!='')
            $req=$request->query->get( 'request');
        if ($request->query->get( 'output' ) and $request->query->get( 'output' )!='')
            $output=$request->query->get( 'output');
        
        if (!isset($req)) return $this->summaryAction();

        $page = $this->getBaseDir().'/'.$req.'.yml';
        $content = file_get_contents($page);

        $yaml = new Parser();
        try {
            $value = $yaml->parse($content);
            
        } catch (ParseException $e) {
            $error = array( 'text' =>  "Unable to parse the YAML string: %s<br/>".$e->getMessage() );
            return $this->render('AriiReportBundle:Requests:ERROR.html.twig', array('error' => $error));
        }

        $runtime = microtime();
                
        // Test de json
        if (isset( $value['curl'])) {
            $url = $value['curl']['url'];
            $ch = curl_init();
            
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_VERBOSE, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            //execute post
            $content = curl_exec($ch);
            if ($content === FALSE) {
                throw new \Exception( sprintf("cUrl error (#%d): %s", curl_errno($ch),htmlspecialchars(curl_error($ch))));
            }
            curl_close($ch);
            
            $Content = json_decode($content, true);
            
            $root = $value['curl']['root'];
            if (isset($Content[$root])) {
                $Content = $Content[$root];                
            }
            
            // On cree le tableau des consoles et des formats
            $Values = $Format = array();
            foreach(explode(',',$value['curl']['fields']) as $col) {
                list($f,$v) = explode('=',$col);
                $Values[$f] = $v;
            }
            
            // On recupere les valeurs
            $Data = [];
            if ($Content) {
            // print_r($Content);
            foreach ($Content as $content) {
                $line = [];
                foreach ($Values as $f=>$v ) {
                    if (isset($content[$v])) 
                        $line[$f] = $content[$v];
                    else 
                        $line[$f] = '';
                }
                array_push($Data,$line);
            }
            print_r($Data);
            }
            exit();
        }
        else {
           // Connexion additionelle ?
            if (isset($value['connection'])) {
                $em = $this->getDoctrine()->getManager($value['connection']);
            }
            else {
                $em = $this->getDoctrine()->getManager();
            }
            $driver = $em->getConnection()->getDriver()->getName();
                        
            // simplification
            // ?! devrait être le protocole
            switch($driver) {
                case 'mysqli':
                    $driver='mysql';
                    break;
                case 'oci8':
                    $driver='oracle';
                    break;
            }

            if (!isset($value['sql'][$driver])) {
                return $this->render('AriiReportBundle:Requests:ERROR.html.twig', array('error' => array( 'text' => "Section '$driver' manquante dans '$page' !")));
            }
            $sql = $value['sql'][$driver];

            // On cree le tableau des consoles et des formats
            $value['columns'] = $Format = array();
            $rsm = new ResultSetMapping();
            foreach (explode(',',$value['header']) as $c) {
                if (($p = strpos($c,'('))>0) {
                    $h = substr($c,0,$p);
                    $Format[$h] = substr($c,$p+1,strpos($c,')',$p)-$p-1);
                    $c = $h;
                }
                $rsm->addScalarResult( strtoupper($c), $c);
                array_push($value['columns'],$c);
            }

            // bibliothèques
            $date = $this->container->get('arii_core.date');
            $query = $em->createNativeQuery($sql, $rsm);
            $Data = $query->getResult();
        }
        
        // Mise en tableau
        $nb=0;
        foreach ($Data as $line) 
        {
            $r = array();
            $status = 'unknown';
            foreach ($value['columns'] as $h) {
                if (isset($line[$h])) {
                    // format special
                    $value['status'] = '';
                    if (isset($Format[$h])) {
                        switch ($Format[$h]) {
                            case 'localtime':
                                $dt = new \DateTime($line[$h], new \DateTimeZone('UTC'));
                                $dt->setTimezone(new \DateTimeZone('Europe/Paris')); // a integrer au portail
                                $val = $dt->format('Y-m-d H:i:s');
                                break;
                            case 'timestamp':
                                $val = $date->Time2Local($line[$h]);
                                break;
                            case 'duration':
                                $val = $date->FormatTime($line[$h]);
                                break;
                            case 'event':
                                $val = $ats->Event($line[$h]);
                                break;
                            case 'alarm':
                                $val = $ats->Alarm($line[$h]);
                                break;
                            case 'br':
                                $val = str_replace(array("\t","\n"),array("     ","<br/>"),$line[$h]);
                                break;
                            case 'ping':
                                $val = $this->ping($h);
                                break;
                            case 'host':
                                $val = gethostbyname($h);
                                break;
                            case 'log':
                                switch ($driver) {
                                    case 'oracle':
                                        $Res = gzinflate ( substr( $line[$h], 10, -8) );
                                        break;
                                }
                                // on ne prend que le batch
                                $New = [];
                                foreach (explode("\n",$Res) as $line) {
                                    if (!preg_match('/\d\d\d\d-.*?\[(.*?)\]   \(.*?\) /',$line,$Matches)) continue;
                                    if ($Matches[1]=='ERROR') {
                                        $before = '<font color="red">';
                                        $after = '</font>';
                                    }
                                    elseif ($Matches[1]=='WARN') {
                                        $before = '<font color="orange">';
                                        $after = '</font>';
                                    }
                                    else {
                                        $before = $after = '';
                                    }
                                    array_push($New,$before.preg_replace('/\d\d\d\d-.*?\[(.*?)\]   \(.*?\) /','',$line).$after);                                    
                                }
                                $val = '<pre>'.implode("<br/>",$New).'</pre>';
                            break;
                            default:
                                if (strpos($Format[$h],':')>0) {                                    
                                    list($class,$function) = explode(':',$Format[$h]);
                                    $my = $this->container->get($class);
                                    $val = $my->$function($line[$h]);
                                }
                                else {
                                    $val = $line[$h].'('.$Format[$h].')';
                                }
                                break;
                        }
                    }
                    else {
                        $val = $line[$h];
                    }
                }
                else  $val = '';
                array_push($r,$val);
            }
            $nb++;
            $value['lines'][$nb]['cells'] = $r;
            $value['lines'][$nb]['status'] = $status;
         }
        $value['count'] = $nb;
        
        // Statut 
        $status = 0; // inconnu
        $min=0;
        $max=999999999;
        if (!isset($value['expected'])) {
            $status=1; // info
        }
        else {
            $expected = $value['expected'];
            $Limits = explode("-",$expected);
            if (isset($Limits[0]) and (trim($Limits[0])!=''))
                $min=$Limits[0];
            if (isset($Limits[1]) and (trim($Limits[1])!=''))
                $max=$Limits[1];
            if (($nb>=$min) and ($nb<=$max))
                $status = 2; // success
            else 
                $status = 4; // error
        }
        
        $runtime = microtime() - $runtime;

        // on peut mettre a jour la table des sondes
        $em = $this->getDoctrine()->getManager();        
        $Check = $em->getRepository("AriiReportBundle:CHECK")->findOneBy( [ 'name' => $req ] );

        if (!$Check)
            $Check = new \Arii\ReportBundle\Entity\CHECK();  

        $Check->setName($req);
        $Check->setTitle($value['title']);
        $Check->setRunTime($runtime);
        $Check->setResults($nb);
        $Check->setMinSuccess($min);
        $Check->setMaxSuccess($max);
        $Check->setStatus($status);
        $Check->setExecuted(new \Datetime());

        $em->persist($Check);
        $em->flush();
        
        if ($output=='html') {
            return $this->render('AriiATSBundle:Requests:bootstrap.html.twig', array('result' => $value, 
                'infos' => [ 
                    'results' => $nb,
                    'min_success' => $min,
                    'max_success' => $max,
                    'min_warning' => $min,
                    'max_warning' => $max,
                    'status' => $status,
                    'runtime' => $runtime,
                    'request' => $req
                ] ));
        }
        elseif ($output=='csv') {
            $sep = ";";
            $response = new Response();
            $response->headers->set('Content-type', 'text/plain');
            $response->headers->set("Content-disposition", "attachment; filename=$req.csv"); 
            $csv = implode($sep,$value['columns'])."\n";
            if (isset($value['lines'])) {
                foreach ($value['lines'] as $k=>$l) {
                    $csv .= implode($sep,$l['cells'])."\n";
                }
            }
            if ($nb==0)
                $response->setStatusCode( '204' );
            $response->setContent( utf8_decode( $csv ) );

            return $response;                      
        }
        elseif ($output=='check') {
            $sep = ";";
            $response = new Response();
            $response->headers->set('Content-type', 'text/plain');
            $csv = implode($sep,$value['columns'])."\n";
            if (isset($value['lines'])) {
                foreach ($value['lines'] as $k=>$l) {
                    $csv .= implode($sep,$l['cells'])."\n";
                }
            }
            print "(($min <= $nb <= $max) => $status)";
            if ($status==4)
                $response->setStatusCode( '417' );
            $response->setContent( utf8_decode( $csv ) );

            return $response;                      
        }
        
        $twig = file_get_contents('../src/Arii/ATSBundle/Resources/views/Requests/dompdf.pdf.twig');
        $content = $this->get('arii_ats.twig_string')->render( $twig, array('result' => $value ) );      
        require_once('../vendor/dompdf/dompdf_config.inc.php');
        header('Content-Type: application/pdf');
        $dompdf = new \DOMPDF();
        $dompdf->load_html($content);
        $dompdf->render();
        $dompdf->stream("sample.pdf");
                
        exit();        
        switch ($output) {
            case 'csv':
                $response = new Response();
                if ($nb>0) {
                    $sep = ";";
                    $response->headers->set('Content-type', 'text/plain');
                    $response->headers->set("Content-disposition", "attachment; filename=$req.csv"); 
                    $csv = implode($sep,$value['columns'])."\n";
                    if (isset($value['lines'])) {
                        foreach ($value['lines'] as $k=>$l) {
                            $csv .= implode($sep,$l['cells'])."\n";
                        }
                    }
                    $response->setContent( utf8_decode( $csv ) );
                }
                else {
                    $response->setStatusCode( '204' );
                }
                return $response;                   
                break;
            case 'excel':
            case 'xls':
                $response = new Response();
                if ($nb>0) {
                    $sep = "\t";
                    $response->headers->set('Content-type', 'application/vnd.ms-excel; charset=utf-8');
                    $response->headers->set("Content-disposition", "attachment; filename=$req.xls"); 

                    $csv = implode($sep,$value['columns'])."\n";
                    if (isset($value['lines'])) {
                        foreach ($value['lines'] as $k=>$l) {
                            $csv .= implode($sep,$l['cells'])."\n";
                        }
                    }
                    $response->setContent( utf8_decode( $csv ) );
                }
                else {
                    $response->setStatusCode( '204' );
                }
                return $response;                      
                break;
            case 'pdf':
                $twig = file_get_contents('../src/Arii/ReportBundle/Resources/views/Requests/dompdf.pdf.twig');
                $content = $this->get('arii_ats.twig_string')->render( $twig, array('result' => $value ) );      
                require_once('../vendor/dompdf/autoload.inc.php');
               
                set_time_limit(300);
                header('Content-Type: application/pdf');
                $dompdf = new DOMPDF();
                $dompdf->load_html($content);
                $dompdf->set_option('isHtml5ParserEnabled', true);
                $dompdf->set_paper('a4', 'landscape');
                $dompdf->render();
                $dompdf->stream("$req.pdf");
                exit();
                break;
            case 'md': //markdown
                $response = new Response();
                if ($nb>0) {
                    $sep = " | ";
                    $response->headers->set('Content-type', 'text/plain');
                    $response->headers->set("Content-disposition", "attachment; filename=$req.csv"); 
                    $csv = "| ".implode($sep,$value['columns'])." |\n";
                    $csv .= preg_replace('/\w/','-',$csv);
                    if (isset($value['lines'])) {
                        foreach ($value['lines'] as $k=>$l) {
                            $csv .= "| ".implode($sep,$l['cells'])." |\n";
                        }
                    }
                    $response->setContent( utf8_decode( $csv ) );
                }
                else {
                    $response->setStatusCode( '204' );
                }
                return $response;                   
                break;
            case 'jira': //syntaxe particulière
                $response = new Response();
                if ($nb>0) {
                    $sep = "|";
                    $response->headers->set('Content-type', 'text/plain');
                    $response->headers->set("Content-disposition", "attachment; filename=$req.csv"); 
                    $csv = "||".implode('||',$value['columns'])."||\n";
                    if (isset($value['lines'])) {
                        foreach ($value['lines'] as $k=>$l) {
                            $csv .= "|".implode($sep,$l['cells'])."|\n";
                        }
                    }
                    $response->setContent( utf8_decode( $csv ) );
                }
                else {
                    $response->setStatusCode( '204' );
                }
                return $response;                   
                break;
            default:
                return $this->render('AriiReportBundle:Requests:bootstrap.html.twig', array('result' => $value ));
        }
        
    }

    private function ping ($host) {
        $log = `ping -a $host -n 1`;
        return $log;
    }
    
    private function getBaseDir() {
        $lang = $this->getRequest()->getLocale();
        $portal = $this->container->get('arii_core.portal');
        return $portal->getWorkspace().'/Report/Requests/'.$lang;        
    }    
    
}