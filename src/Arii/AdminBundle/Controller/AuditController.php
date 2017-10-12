<?php

namespace Arii\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class AuditController extends Controller {

    public function indexAction()
    {
        return $this->render("AriiAdminBundle:Audit:index.html.twig");
    }
    
    public function gridAction()
    {
        $request = Request::createFromGlobals();

        $em = $this->getDoctrine()->getManager();
        $Actions = $em->getRepository("AriiCoreBundle:Audit")->findAudit();      
        
        $dhtmlx = $this->container->get('arii_core.render'); 
        return $dhtmlx->grid($Actions,'logtime,module,user,action,status,message,ip','status');
    }
        
}

?>
