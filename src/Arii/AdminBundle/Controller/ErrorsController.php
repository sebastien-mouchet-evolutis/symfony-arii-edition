<?php

namespace Arii\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ErrorsController extends Controller {

    public function indexAction()
    {
        return $this->render("AriiAdminBundle:Errors:index.html.twig");
    }
    
    public function gridAction()
    {
        $em = $this->getDoctrine()->getManager();
        $Errors = $em->getRepository("AriiCoreBundle:ErrorLog")->findErrors();      
        
        $dhtmlx = $this->container->get('arii_core.render'); 
        return $dhtmlx->grid($Errors,'logtime,message,code,file_name,line,trace,username,ip','status');
    }
        
}

?>
