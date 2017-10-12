<?php

namespace Arii\AdminBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ParametersController extends Controller{

    public function indexAction()
    {
        return $this->render('AriiAdminBundle:Parameters:index.html.twig');
    }

    public function toolbarAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render("AriiAdminBundle:Parameters:toolbar.xml.twig", array(), $response);
    }

    public function menuAction()
    {
        $session = $this->container->get('arii_core.session');
        
        $db = $this->container->get('arii_core.db');
        $data = $db->Connector('grid');

        $qry = "select id,filter,title,spooler,job,job_chain,order_id,status from ARII_FILTER order by filter";
        $data->render_sql($qry,"id","filter,title,spooler,job,job_chain,order_id,status");
    }

    public function gridAction($bundle='Core')
    {        
        $request = Request::createFromGlobals();
        if ($request->query->get('bundle')!='') {
            $bundle = $request->query->get('bundle');
        }
        
        $portal = $this->container->get('arii_core.portal');
        $Parameters = $portal->getParameters();
        
        $xml = "<?xml version='1.0' encoding='iso-8859-1'?>";
        $xml .= '<rows>';
        foreach ($Parameters as $Param) {
            if ($Param['domain']=='color') continue;
            $xml .= '<row id="'.$Param['id'].'">';
            $xml .= '<cell>'.$Param['name'].'</cell>';  
            $xml .= '<cell>'.$Param['value'].'</cell>';            
            $xml .= '<cell>'.$Param['domain'].'</cell>';  
            $xml .= '</row>';
        }
        $xml .= '</rows>';
        
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');        
        $response->setContent( $xml );
        return $response;            
    }
    
    public function bundlesAction()
    {        
        
        $em = $this->getDoctrine()->getManager(); 
        $Bundles = $em->getRepository("AriiCoreBundle:Parameter")->findBundles();
        
        $xml = "<?xml version='1.0' encoding='iso-8859-1'?>";
        $xml .= '<rows>';
        foreach ($Bundles as $Bundle) {
            $xml .= '<row>';
            $xml .= '<cell>'.$Bundle['bundle'].'</cell>';            
            $xml .= '</row>';
        }
        $xml .= '</rows>';
        
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');        
        $response->setContent( $xml );
        return $response;            
    }

    public function formAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        
        $Parameter = $this->getDoctrine()->getRepository("AriiCoreBundle:Parameter")->find($id);
        
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');        
        $form = '<data>';
        if ($Parameter) {
            $form .= '<id>'.$Parameter->getId().'</id>';
            $form .= '<bundle>'.$Parameter->getBundle().'</bundle>';
            $form .= '<name>'.$Parameter->getName().'</name>';
            $form .= '<value>'.$Parameter->getValue().'</value>';
            $form .= '<domain>'.$Parameter->getDomain().'</domain>';
        }
        $form .= '</data>';
        $response->setContent( $form );
        return $response;        
    }

    public function deleteAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');

        $parameter = $this->getDoctrine()->getRepository("AriiCoreBundle:Parameter")->find($id);
        if (!$parameter)
            throw new \Exception("Id '$id' ?!");
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($parameter);
        $em->flush();  
        
        // RAZ session
        $portal = $this->container->get('arii_core.portal');
        $Parameters = $portal->resetParameters();
        
        return new Response("success");
    }

    public function saveAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        
        $parameter = new \Arii\CoreBundle\Entity\Parameter();
        if( $id != "" )
            $parameter = $this->getDoctrine()->getRepository("AriiCoreBundle:Parameter")->find($id);

        $parameter->setBundle('Core');
        $parameter->setName($request->get('name'));
        $parameter->setDomain($request->get('domain'));
        $parameter->setValue($request->get('value'));
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($parameter);
        $em->flush();

        // RAZ session
        $portal = $this->container->get('arii_core.portal');
        $Parameters = $portal->resetParameters();
        
        return new Response("success");
    }
    
    
}

?>
