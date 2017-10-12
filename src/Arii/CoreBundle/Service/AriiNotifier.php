<?php
namespace Arii\CoreBundle\Service;

use Symfony\Component\HttpFoundation\Response;

class AriiNotifier
{
    private $portal;

    public function __construct(AriiPortal $portal)
    {
        $this->portal = $portal;
    }
        
    public function displayMessage(Response $response)
    {
        // on a du javascript ?
        $content = $response->getContent();
        $tag = '<script type="text/javascript">';
        $p=strpos($content,$tag);
        if ($p==0) return $response;
         
        $Messages = $this->portal->getMessages();

        if (empty($Messages)) return $response;
        
        foreach ($Messages as $Msg) {
        // Code à rajouter
        $html = '
dhtmlx.message({
    type: "error",
    expire: -1,
    text: "'.$Msg.'"
});
';
        }
        $l = $p+strlen($tag);
        $content = substr($content,0,$l).$html.substr($content,$l);
        
        $response->setContent($content);        
        return $response;
    }
    
}
