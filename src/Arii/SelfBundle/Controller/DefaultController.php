<?php

namespace Arii\SelfBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Parser;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AriiSelfBundle:Default:index.html.twig');
    }

    public function helpAction()
    {
        return $this->render('AriiSelfBundle:Default:bootstrap.html.twig');
    }
    
    public function ribbonAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        
        return $this->render('AriiSelfBundle:Default:ribbon.json.twig',array(), $response );
    }

    public function toolbarAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render('AriiSelfBundle:Default:toolbar.xml.twig',[], $response);
    }
    
    public function readmeAction()
    {
        return $this->render('AriiSelfBundle:Default:readme.html.twig');
    }

    public function listAction()
    {
        $Requests = $this->getDoctrine()->getRepository("AriiSelfBundle:Request")->findAll();
      
        $portal = $this->container->get('arii_core.portal');
        $ColorStatus = $portal->getColors();
        # On recupere le template, le statut et le nombre de jobs en file d'attente
        $Nb = [];
        $Status =[];
        foreach ($Requests as $Request) {
            $name = $Request->getName();
            if (isset($Nb[$name])) 
                $Nb[$name]++;
            else 
                $Nb[$name] =1;
            $Status[$name] = [
                'status' => $Request->getReqStatus(),
                'nb' => $Nb[$name]
            ];
        } 
        ksort($Status);

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
        $lang = $this->getRequest()->getLocale();

        $basedir = $portal->getWorkspace().'/Self/'.$lang;    
        
        if ($dh = opendir($basedir)) {
            while (($file = readdir($dh)) !== false) {
                if (substr($file,-4) == '.yml') {
                    $content = file_get_contents("$basedir/$file");
                    $v = $yaml->parse($content);
                    $title = $v['title'];
                    $name = substr($file,0,strlen($file)-4);
                    if (isset($Status[$name])) {
                        $status = $Status[$name]['status'];
                        if (isset($ColorStatus[$status]))
                            $bg = 'style="background-color: '.$ColorStatus[$status]['bgcolor'].';"';
                        else $bg='';
                        $Files[$title] = '<row id="'.$name.'" '.$bg.'><cell>'.$title.'</cell><cell>'.$Status[$name]['nb'].'</cell></row>';                    
                    }
                    else {
                        $Files[$title] = '<row id="'.$name.'"><cell>'.$title.'</cell><cell/></row>';                    
                    }
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

    public function treeAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        
        $Requests = $this->getDoctrine()->getRepository("AriiSelfBundle:Request")->findToDo();
      
        $yaml = new Parser();
        $lang = $this->getRequest()->getLocale();

        $portal = $this->container->get('arii_core.portal');
        $basedir = $portal->getWorkspace().'/Self/'.$lang;    
        
        $Tree = [];
        if ($dh = opendir($basedir)) {
            while (($file = readdir($dh)) !== false) {
                if (substr($file,-4) != '.yml') continue;
                
                $content = file_get_contents("$basedir/$file");
                $v = $yaml->parse($content);
                $name = $v['name'];
                $title = $v['title'];
                if (($p=strpos($title,'/'))>0) {
                    $group = substr($title,0,$p);
                    $title=substr($title,$p+1);
                }
                else {
                    $group = $v['name'];
                }
                if (!isset($Tree[$group])) {
                    $Tree[$group]['group']=$group;
                    $nb=0;
                }
                else {
                    $nb = $Tree[$group]['nb']+1;
                }
                $Tree[$group]['nb'] = $nb;
                $Tree[$group]['template'][$nb]['file']  = substr($file,0,strlen($file)-4);
                $Tree[$group]['template'][$nb]['title'] = $title;
            }
        }
        sort($Tree);

        $list = '<?xml version="1.0" encoding="UTF-8"?>';
        $list .= '<tree id="0">';
        foreach ($Tree as $Group) {
                $list .= '<item id="G'.$Group['group'].'" text="'.$Group['group'].'" open="1" im0="group.png" im1="group.png" im2="group_add.png">';
                foreach ($Group['template'] as $Temp) {
                    $file = $Temp['file'];
                    $list .= '<item id="T'.$file.'" text="'.$Temp['title'].'" im0="form.png" im1="form.png" im2="form_add.png"/>';
                }
                $list .= '</item>';
        }
        $list .= '</tree>';

        $response->setContent( $list );
        return $response;        

    }    
    
}
