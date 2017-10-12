<?php
namespace Arii\GraphvizBundle\Service;

class AriiOSJ {
    
    protected $portal;
    
    public function __construct(
            \Arii\CoreBundle\Service\AriiPortal $portal
    ) {
        $this->portal = $portal;
    }
    
    public function getConfigPath() {
        $config = $this->portal->getConnectionByName('arii_config'); 
        return str_replace('/',DIRECTORY_SEPARATOR,$config['path']);
    }

    public function getPerlscript($script) {
        $perl = str_replace('/',DIRECTORY_SEPARATOR,$this->portal->getParameter('perl'));
        return '"'.$perl.'" '.dirname(__FILE__).str_replace('/',DIRECTORY_SEPARATOR,'/../Perl/'.$script.'.pl ');
    }
}    
?>
