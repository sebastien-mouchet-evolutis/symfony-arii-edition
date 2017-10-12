<?php

namespace Arii\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class BundlesController extends Controller
{
    public function indexAction()
    {
        return $this->render('AriiAdminBundle:Bundles:index.html.twig');
    }
 
    public function toolbarAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render("AriiAdminBundle:Bundles:toolbar.xml.twig",array(), $response );
    }

    public function activationAction()
    {
        $request = Request::createFromGlobals();
        $bundle = $request->get('bundle');
        $namespace = $bundle.'Bundle';
        $activate = $request->get('activate');   
        $appkernel = $routing = $url = '';
        $thisBundle = 'new Arii\\'.$namespace.'\Arii'.$namespace.'()';
        
        $root = $this->get('kernel')->getRootDir();
        
        ######################################
        # KERNEL
        ######################################        
        $appKernel = "$root/AppKernel.php";
        $appContent = file_get_contents($appKernel);
        $pattern = '/\$bundles\s?=\s?array\((.*?)\);/is';
        preg_match($pattern, $appContent,$matches);

        $bList = rtrim($matches[1],"\n ");
        $e = explode(",",$bList);

        $newBList = array();
        foreach ($e as $b) {
            $b = trim($b);
            if ($b == $thisBundle) continue;
            array_push($newBList,$b);
        }

        if ($activate) {
            $mode = 'Disabled';            
        }
        else  {
            $mode = 'Enabled';
            
            array_push( $newBList, $thisBundle );
        }
        $newlist = "\$bundles = array(\n        "
                .implode(",\n        ",$newBList)
                ."\n        );";
        file_put_contents($appKernel,preg_replace($pattern,$newlist,$appContent));

        ######################################
        # ROUTING 
        ######################################
        $Routing = "$root/config/routing.yml";
        $routingContent = file_get_contents($Routing);

        # La route existe ?
        $pattern2 = '/(# =+\s?# '.$bundle.'.*?_locale: .*?\n)/is';
        preg_match($pattern2, $routingContent,$matches);
        if (isset($matches[1])) {
            # On supprime
            $routingContent = str_replace($matches[1],'',$routingContent);
        }
                
        # En mode activé on le rajoute à la fin        
        $newroute = '
# ========================================
# '.$bundle.'
# ----------------------------------------
arii_'.$bundle.':
    resource: "@Arii'.$bundle.'Bundle/Resources/config/routing.yml"
    prefix:   /'.strtolower($bundle).'/{_locale}
    requirements:
        _locale: en|fr|es|de|cn|ar|ru|jp 
';
        if ($mode == 'Enabled') {
            $routingContent .= $newroute;
        }
        
        # Si tout est ok
        file_put_contents($Routing,$routingContent);

        # Accessible ?
        if (!$activate) {
//            $url = $this->generateUrl('arii_'.$bundle);
        }
        
        # Suppression du cache ?
        return $this->render("AriiAdminBundle:Bundles:bootstrap.html.twig",
            array(
                'bundle' => $bundle,
                'mode' => $mode,
                'appkernel' => $newlist,
                'routing' => $routingContent,
                'route' => $newroute,
                'url' => $url ) 
        );
    }
    
    # Affichage des modules en cours
    # sauf le Core
    public function gridAction()
    {
        $root = $this->get('kernel')->getRootDir();

        $Bundle=array();
        # Repertoire
        $src = "$root/../src/Arii";
        $dh = opendir($src);        
        while (($file = readdir($dh)) !== false) {
            if (!is_dir($src.'/'.$file)) continue;
            if (substr($file,-6)=='Bundle') {
                $bundle = substr($file,0,strlen($file)-6);
                if (($bundle != 'Core') and ($bundle != 'User') and ($bundle != 'Admin')) {
                    $Bundle[$bundle]['name'] = $bundle;
                    $Bundle[$bundle]['active'] = 0;
                    $Bundle[$bundle]['color'] = 'FALSE';
                }
            }
        }
        closedir($dh);
     
        # Activation
        $kernel = file_get_contents("$root/AppKernel.php");
        foreach (explode("\n",$kernel) as $line) {
            $line = str_replace(' ','',$line);
            if (substr($line,0,2)=='//') continue;
            if (substr($line,0,8)=="newArii\\") {                
                $bundle = substr($line,8,strpos($line,'\\',8)-14);
                if (($bundle != 'Core') and ($bundle != 'User') and ($bundle != 'Admin')) {
                    $Bundle[$bundle]['name'] = $bundle;
                    $Bundle[$bundle]['active'] = 1;
                    $Bundle[$bundle]['color'] = 'TRUE';
                }
            }
        }

        $dhtmlx = $this->container->get('arii_core.render'); 
        return $dhtmlx->grid($Bundle,'name,active','color');
    }

    # Activation dans le kernel et le routing
    public function enableAction()
    {
    }
    
    # Desactivation
    public function disableAction()
    {
    }
    
}
