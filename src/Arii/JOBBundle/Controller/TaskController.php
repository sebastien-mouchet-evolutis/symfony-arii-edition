<?php

namespace Arii\JOBBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Parser;

class TaskController extends Controller
{

    public function formAction()
    {  
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        
        $portal = $this->container->get('arii_core.portal');
        
        $file = $portal->getWorkFile("/Tasks/$id.yml",'JOB');        
        $content = file_get_contents($file);

        $yaml = new Parser();        
        $Infos = $yaml->parse($content);
        $response = new Response();
       
        $form = '<data>';
        $form .= '<id>'.$id.'</id>';        
        foreach ($Infos as $k=>$v) {
            $form .= '<'.$k.'><![CDATA['.$v.']]></'.$k.'>';
        }
        $form .= '</data>';        
        $response->headers->set('Content-Type', 'text/xml');
        $response->setContent( $form );
        return $response;        
    }
    
    public function filesAction()
    {  
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        
        $portal = $this->container->get('arii_core.portal');
        $Paths = $portal->getWorkPaths('/Tasks','JOB');
        
        $yaml = new Parser();
        $list = '<?xml version="1.0" encoding="UTF-8"?>';
        $list .= "<rows>\n";
        foreach ($Paths as $dir) {
            if ($dh = @opendir("$dir/$id")) {
                while (($file = readdir($dh)) !== false) {
                    if (is_file("$dir/$file")) {
                        $list .= '<row id="'."$dir/$file".'"><cell>'.$title.'</cell><cell>'.$file.'</cell></row>';
                    }
                }
                closedir($dh);
            }        
        }
        $list .= "</rows>\n";
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        $response->setContent( $list );
        return $response;        
    }
    
    public function toolbarAction()
    {        
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        
        return $this->render('AriiJOBBundle:Task:toolbar.xml.twig', array(), $response  );
    }

}

