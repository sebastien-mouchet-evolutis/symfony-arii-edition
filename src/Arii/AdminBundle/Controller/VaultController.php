<?php
namespace Arii\AdminBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class VaultController extends Controller{

    public function indexAction()
    {
        return $this->render('AriiAdminBundle:Vault:index.html.twig');
    }

    public function toolbarAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render("AriiAdminBundle:Vault:toolbar.xml.twig", array(), $response);
    }

    public function treeAction($path='')
    {
        $request = Request::createFromGlobals();        
        if ($request->get('path') != '') {
            $path = str_replace(':','#', $request->get('path'));            
        }

        $portal = $this->container->get('arii_core.portal');
        $workspace = $portal->getWorkspace();
        
        $folder = $this->container->get('arii_core.folder');

        $xml = "<?xml version='1.0' encoding='utf-8'?>";                
        $xml .= '<tree id="0">';        
        $xml .= $folder->TreeXML( str_replace('\\','/',$workspace), $path );
        $xml .= '</tree>';
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        $response->setContent($xml);
        return $response;
    }
    
    public function gridAction($path='')
    {
        $request = Request::createFromGlobals();        
        if ($request->get('path') != '') {
            $path = $request->get('path');
        }
        
        $portal = $this->container->get('arii_core.portal');
        $workspace = $portal->getWorkspace();

        // on garde en session
        $portal->setSessionVar('path',$path);
                
        $xml = "<?xml version='1.0' encoding='utf-8'?>";   
        $xml .= "<rows>\n";
        $xml .= '<head>
            <afterInit>
                <call command="clearAll"/>
            </afterInit>
        </head>';        
        if ($dh = @opendir($workspace.$path)) {
            while (($file = readdir($dh)) !== false) {                
                if (substr($file,0,1)=='.') continue;
                $filename = $workspace.'/'.$path.'/'.$file;
                if (is_dir($filename)) continue;
                if (!$this->isUtf8($file))
                    $file = utf8_encode($file);
                $xml .= '<row id="'.$file.'">';
                $xml .= '<cell>'.$file.'</cell>';
                $Info = stat($filename);
                $mtime = $Info[9];                
                $xml .= '</row>';
            }
        }
        $xml .= '</rows>';
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        $response->setContent($xml);
        return $response;
    }

    // a mutualiser dans un service
    public function viewAction()
    {
        $request = Request::createFromGlobals();
        $file = $request->query->get( 'file' );

        $portal = $this->container->get('arii_core.portal');
        $workspace = $portal->getWorkspace();
        $path = $portal->getSessionVar('path');
        
        $filename = str_replace('//','/',$workspace.'/'.$path.'/'.$file );
        if ($this->isUtf8($filename))
            $filename = utf8_decode($filename);
        
        if (!($content = file_get_contents($filename)))
            throw new \Exception('File not found: '.$file);
        
        $response = new Response();
        $ext = strtolower(substr($file,-3));
        switch ($ext) {
            case 'png':
            case 'jpg':
                $type = 'image/'.$ext;
                break;
//            case 'xml':
//                $type = 'text/'.$ext;
//                break;
            case 'xls':
                if (!$this->isUtf8($content))
                    $content = utf8_encode($content);
                $response->headers->set('Content-type', 'application/vnd.ms-excel; charset=utf-8');
                $response->headers->set("Content-disposition", "attachment; filename=$file"); 
                $response->setContent($content);
                return $response;
                break;            
            default:
                if (!$this->isUtf8($content))
                    $content = utf8_encode($content);
                $type = 'text/plain';
        }
        $response->headers->set('Content-Type', $type);
        $response->setContent($content);
        return $response;
    }
    
    public function uploadAction()
    {
        $portal = $this->container->get('arii_core.portal');
        $workspace = $portal->getWorkspace();
        $path = $portal->getSessionVar('path');
        $target = $workspace.'/'.$path;
        
        $request = Request::createFromGlobals();
        $file = $request->query->get( 'file' );

        $response = new Response();
        $response->headers->set('Content-Type', 'text/json');
        
        if ($request->query->get( 'mode') == "conf") {
            $response->setContent('{ "maxFileSize": "50000" }');
            return $response;
        }

        if ($request->query->get( 'zero_size' ) == "1") {
            throw new \Exception("ZERO!!");
            // IE10, IE11 zero file fix
            // get file name
            $filename = $request->query->get( 'file_name' );
            // just create empty file
            file_put_contents($target.'/'.$filename, "");
            $response->setContent( '{state: true, name: "'.str_replace("'","\\'",$name).'"}' );
            return $response;
        } elseif (isset($_FILES["file"])) {
            $filename = $_FILES["file"]["name"];
            move_uploaded_file($_FILES["file"]["tmp_name"], $target.'/'.$filename);
            
            $response->setContent( json_encode(array(
                "state" => true,    // saved or not saved
                "name"  => $filename,   // server-name
                "extra" => array(   // extra info, optional
                        "info"  => "just a way to send some extra data",
                        "param" => "some value here"
                )
            )));
        }

        return $response;
    }
    
    // A mettre en service
    function isUtf8($string) {
        if (function_exists("mb_check_encoding") && is_callable("mb_check_encoding")) {
            return mb_check_encoding($string, 'UTF8');
        }

        return preg_match('%^(?:
              [\x09\x0A\x0D\x20-\x7E]            # ASCII
            | [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte
            |  \xE0[\xA0-\xBF][\x80-\xBF]        # excluding overlongs
            | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  # straight 3-byte
            |  \xED[\x80-\x9F][\x80-\xBF]        # excluding surrogates
            |  \xF0[\x90-\xBF][\x80-\xBF]{2}     # planes 1-3
            | [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
            |  \xF4[\x80-\x8F][\x80-\xBF]{2}     # plane 16
        )*$%xs', $string);

    }     
    
}
?>