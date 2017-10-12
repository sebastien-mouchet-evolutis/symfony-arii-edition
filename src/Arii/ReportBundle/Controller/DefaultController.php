<?php

namespace Arii\ReportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Yaml\Parser;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $request = Request::createFromGlobals();

        $filter = $this->container->get('report.filter');
        list($env,$app,$day_past,$day,$month,$year,$start,$end) = $filter->getFilter(
            $request->query->get( 'env' ),
            $request->query->get( 'app' ),
            $request->query->get( 'day_past' ),
            $request->query->get( 'day' ),
            $request->query->get( 'month' ),
            $request->query->get( 'year' )
        );
        if ($app=='') 
            return $this->render('AriiReportBundle:Default:index.html.twig');
        
        return $this->render('AriiReportBundle:Dashboard:index.html.twig', 
            array( 
                'appl' => $app,
                'env' => $env,
                'month' => $month,
                'year' => $year,
                'day_past' => $day_past,
                'header' => 0,
                'footer' => 0
                ) 
            );
    }

    public function publicAction()
    {
        $request = Request::createFromGlobals();

        // par defaut: mois precedent.
        $date = new \DateTime('now');
        $date->modify('last day of previous month');

        $filter = $this->container->get('report.filter');
        list($env,$app,$day_past,$day,$month,$year,$start,$end) = $filter->getFilter(
            $request->query->get( 'env' ),
            $request->query->get( 'app' ),
            $request->query->get( 'day_past' ),
            $request->query->get( 'day' ),                
            ($request->query->get( 'month' )!=''?$request->query->get( 'month' ):$date->format('m')),
            ($request->query->get( 'year' )!=''?$request->query->get( 'year' ):$date->format('Y'))
        );
        return $this->render('AriiReportBundle:Default:public.html.twig', 
            array( 
                'appl' => $app,
                'env' => $env,
                'month' => $month,
                'year' => $year,
                'day_past' => $day_past
                ) 
            );
    }
    
    public function summaryAction()
    {

        $portal = $this->container->get('arii_core.portal');
        $Module = $portal->getModule('Report');

        $em = $this->getDoctrine()->getManager();
        $Apps = $em->getRepository("AriiCoreBundle:Application")->findApplications();
        foreach ($Apps as $appl) {
            $id = $appl['name'];
            if ($appl['title']!='')
                $Applications[$id] = $appl['title'];
            else 
                $Applications[$id] = $appl['name'];
        }
        
        $Options = $portal->getOptionsByDomain('env');
        $Env = array();
        foreach ($Options as $o) {
            $id = $o['name'];
            $title = $this->get('translator')->trans('env.'.$o['name'],[],'internal');
            $Env[$id] = $title;
        }
        // si la base n'est pas dans la liste, on reset ?
        return $this->render('AriiReportBundle:Default:summary.html.twig',array(
            'module' => $Module, 
            'Applications' => $Applications,
            'Env' => $Env));
    }

    public function toolbarAction()
    {
        $request = Request::createFromGlobals();
        $filter = $this->container->get('report.filter');
        list($env,$app,$day_past,$day,$month,$year,$start,$end) = $filter->getFilter(
            $request->query->get( 'env' ),
            $request->query->get( 'app' ),
            $request->query->get( 'day_past' ),
            $request->query->get( 'day' ),
            $request->query->get( 'month' ),
            $request->query->get( 'year' )
        );
        
        // Récuperer les applications
        $Applications = array();
        $em = $this->getDoctrine()->getManager();
        $Apps = $em->getRepository("AriiCoreBundle:Application")->findApplications();
        foreach ($Apps as $appl) {
            $id = $appl['name'];
            if ($appl['title']!='')
                $Applications[$id] = $appl['title'];
            else 
                $Applications[$id] = $appl['name'];
        }
        
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render('AriiReportBundle:Default:toolbar.xml.twig', 
            array( 
                'appl' => $app,
                'env' => $env,                
                'month' => $month,
                'year' => $year,
                'day_past' => $day_past,
                'Applications' => $Applications ) 
            , $response);
    }

    public function readmeAction()
    {
        return $this->render('AriiReportBundle:Default:readme.html.twig');
    }
    
    public function documentAction()
    {
        return $this->render('AriiReportBundle:Default:document.html.twig' );
    }
    public function statusAction()
    {
        return $this->render('AriiReportBundle:Default:status.html.twig' );
    }
    
    public function historyAction()
    {
        return $this->render('AriiReportBundle:Default:history.html.twig' );
    }

    public function ribbonAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        $yaml = new Parser();
        $basedir = $this->getBaseDir();

        $Requests = array();
        if ($dh = @opendir($basedir)) {
            while (($file = readdir($dh)) !== false) {
                if (substr($file,-4) == '.yml') {
                    $content = file_get_contents("$basedir/$file");
                    $v = $yaml->parse($content);
                    $v['id']=substr($file,0,strlen($file)-4);
                    if (!isset($v['icon'])) $v['icon']='cross';
                    if (!isset($v['title'])) $v['title']='?';
                    array_push($Requests, $v);
                }
            }
        }
        $Applications = array();
        $em = $this->getDoctrine()->getManager();
        $Apps = $em->getRepository("AriiCoreBundle:Application")->findApplications();
        foreach ($Apps as $app) {
            $id = $app['name'];
            if ($app['title']!='')
                $Applications[$id] = $app['title'];
            else
                $Applications[$id] = $app['name'];            
        }
        return $this->render('AriiReportBundle:Default:ribbon.json.twig',
                array( 'Requests' => $Requests, 'Applications' => $Applications ), 
                $response );
    }

    public function treeAction($path='report')
    {        
        $session = $this->container->get('arii_core.session');
        $config = $session->get('osjs_config');
                
        # On retrouve le chemin des rapports
        $path = $config.'/jasperreports';

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
                // on ne s'intéresse qu'aux pdfs
                if (substr($file,-4)=='.pdf') {
                    $f = substr($file,0,strlen($file)-4);
                    $xml .= '<item id="'.utf8_encode("$basedir/$dir/$file").'" text="'.utf8_encode($f).'" im0="pdf.png"/>';
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

    public function docAction()
    {
        $request = Request::createFromGlobals();
        
        $session = $this->container->get('arii_core.session');        
        $this->charset = $session->get('charset');
        
        $doc = $this->Decodage($request->query->get( 'doc' ));
        $p = strpos($doc,'.');
        $type = substr($doc,$p+1);
        $response = new Response();
        $content = file_get_contents($doc);
        switch($type) {
            case 'pdf':
                $response->headers->set('Content-Type', 'application/pdf');
                break;
            case 'rtf':
                $response->headers->set('Content-Type', 'application/msword');
                break;
            case 'xls':
                $response->headers->set('Content-Type', 'application/xls');
                break;
            case 'html':
                $response->headers->set('Content-Type', 'text/html');
                break;
            case 'xml':
                $content = "<pre>".str_replace('<','&lt;',$content)."</pre>";
                break;
            default:
               $content = $doc;
        }    
        $length = strlen($content);        
        $response->headers->set('Content-Length',$length);
        $response->headers->set('Content-Disposition', 'inline; filename="'.$doc.'"');
        $response->headers->set('Content-Transfer-Encoding', 'binary');
        $response->headers->set('Expires', 0);
        $response->headers->set('Cache-Control', 'must-revalidate');
        $response->headers->set('Pragma', 'public');
        $response->setContent($content);
        return $response;
    }
    
    protected function Decodage($text) {
        if ($this->charset != 'UTF-8')
            return utf8_decode($text);
        return $text;
    }

    public function infoAction()
    {
        $request = Request::createFromGlobals();
        $doc = $this->Decodage($request->query->get( 'doc' ));

        $session = $this->container->get('arii_core.session');        
        $this->charset = $session->get('charset');
        
        $stat = stat($doc);
        $size = $stat[7];
        $TM = localtime($stat[9],true);
        $date = sprintf("%04d-%02d-%02d %02d:%02d:%02d",
                $TM['tm_year']+1900, $TM['tm_mon']+1,$TM['tm_mday'],
                $TM['tm_hour'], $TM['tm_min'],$TM['tm_sec'] );
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        $form = '<?xml version="1.0" encoding="UTF-8"?>';
        $form .= "<data>\n";
        $form .= "<file>".utf8_encode(basename($doc))."</file>";    
        $form .= "<size>".$size."</size>";    
        $form .= "<date>".$date."</date>";  
        $form .= "</data>\n";
        $response->setContent($form);
        return $response;
    }
    
    private function getBaseDir() {
        $lang = $this->getRequest()->getLocale();        
        $portal = $this->container->get('arii_core.portal');        
        return $portal->getWorkspace().'/Report/Requests/'.$lang;        
    }    
}
