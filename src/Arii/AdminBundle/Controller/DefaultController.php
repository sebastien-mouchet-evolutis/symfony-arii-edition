<?php

namespace Arii\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class DefaultController extends Controller
{

/**
 * @Security("has_role('ROLE_ADMIN')")
 */    
    public function indexAction()
    {
        return $this->render('AriiAdminBundle:Default:index.html.twig');
    }

    public function ribbonAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        
        return $this->render('AriiAdminBundle:Default:ribbon.json.twig',array(), $response );
    }

    public function readmeAction()
    {
        return $this->render('AriiAdminBundle:Default:readme.html.twig');
    }

}
