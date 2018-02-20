<?php

namespace Arii\JOCBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class LocksUseController extends Controller {

    public function __construct( )
    {
    }

    public function listAction()
    {
        $state = $this->container->get('arii.joc');
        list($Locks,$Status) = $state->getLocksUse($sort=['updated' => 'ASC']);
                
        $Render = $this->container->get('arii_core.render');
        return $Render->Grid($Locks,'SPOOLER,PATH,LOCK,STATUS,UPDATED','COLOR');
    }

    public function pieAction() {
        $state = $this->container->get('arii.joc');
        list($Locks,$Status) = $state->getLocksUse([]);
                
        $Render = $this->container->get('arii_core.render');
        return $Render->Pie($Status,'STATE','COLOR');
    }

}

?>
