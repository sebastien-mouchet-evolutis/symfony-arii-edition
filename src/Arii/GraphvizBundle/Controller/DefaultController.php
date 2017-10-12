<?php

namespace Arii\GraphvizBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function __construct() {
    }
    
    public function indexAction()
    {
        return $this->render('AriiGraphvizBundle:Default:index.html.twig');
    }

    public function readmeAction()
    {
        return $this->render('AriiGraphvizBundle:Default:readme.html.twig');
    }

    public function selectionAction()
    {
        return $this->render('AriiGraphvizBundle:Default:selection.html.twig');
    }
    
    public function ribbonAction()
    {
        $osj = $this->container->get('arii_gvz.osj');
        $config = $osj->getConfigPath();
        
        $folder = $this->container->get('arii_core.folder');
        $Dir = $this->Remotes("$config/remote");

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        return $this->render('AriiGraphvizBundle:Default:ribbon.json.twig',array('Schedulers' => $Dir), $response);
    }

    public function toolbarAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render('AriiGraphvizBundle:Default:toolbar.xml.twig',array(), $response);
    }

    public function legendAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render('AriiGraphvizBundle:Default:legend.xml.twig',array(), $response);
    }

    private function Remotes($path) {

        $Dir = array();
        if ($dh = @opendir($path)) {
            while (($file = readdir($dh)) !== false) {
                if (($file != '_all') and (substr($file,0,1) != '.') and is_dir($path.'/'.$file)) {
                    array_push($Dir, str_replace('#',':',$file) );
                }
            }
            closedir($dh);
        }
        else {
            array_push($Dir,'empty !');
        }

        sort($Dir);
        return $Dir;
    }

    public function fileAction()
    {
        $request = Request::createFromGlobals();
        $path = dirname($request->query->get( 'path' ));
        $file = basename($request->query->get( 'file' ));
        
        $portal = $this->container->get('arii_gvz.osj');
        $config = $portal->getConfigPath();
        
        $folder = $this->container->get('arii_core.folder');
        $content = "<!-- $path/$file -->\n";
        $content .= @file_get_contents("$config/$path/$file");
        print "<pre>".str_replace('<','&lt;',$content)."</pre>";
        exit();
    }

}
