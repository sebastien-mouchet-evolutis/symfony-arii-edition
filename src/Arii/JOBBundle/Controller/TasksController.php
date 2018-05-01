<?php

namespace Arii\JOBBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Yaml\Parser;

class TasksController extends Controller
{
    public function indexAction()
    {        
        return $this->render('AriiJOBBundle:Tasks:index.html.twig' );
    }

    public function welcomeAction()
    {        
        return $this->render('AriiJOBBundle:Tasks:welcome.html.twig' );
    }

    public function gridAction()
    {        
        $portal = $this->container->get('arii_core.portal');
        $Paths = $portal->getWorkPaths('/Tasks','JOB');
        
        $yaml = new Parser();
        $list = '<?xml version="1.0" encoding="UTF-8"?>';
        $list .= "<rows>\n";
        foreach ($Paths as $dir) {
            if ($dh = @opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    if (is_file("$dir/$file")) {
                        $Infos = explode('.',$file);
                        if (isset($Infos[2]) and ($Infos[2]=='yml')) {
                            $content = file_get_contents("$dir/$file");
                            $v = $yaml->parse($content);
                            $title = $v['title'];
                            $list .= '<row id="'.$Infos[0].'.'.$Infos[1].'"><cell>'.$title.'</cell><cell>'.$Infos[1].'</cell></row>';
                        }
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
    
}

