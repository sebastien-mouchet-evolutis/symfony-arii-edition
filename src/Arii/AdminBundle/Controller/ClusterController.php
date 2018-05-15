<?php

namespace Arii\AdminBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
class ClusterController extends Controller {

    public function indexAction()
    {
        return $this->render('AriiAdminBundle:Cluster:index.html.twig');
    }

    public function toolbarAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render('AriiAdminBundle:Cluster:toolbar.xml.twig', array(), $response);
    }

    public function sitesAction()
    {
        $sql = $this->container->get('arii_core.sql');        
        $qry = $sql->Select(array("ID","NAME"))
                .$sql->From(array("ARII_SITE"))
                .$sql->OrderBy(array("NAME"));
        
        $db = $this->container->get('arii_core.db');
        $select = $db->Connector('select');
        $select->render_sql($qry,"ID","ID,NAME");
    }
           
    public function deleteAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        
        /*
        $em = $this->getDoctrine()->getManager();
        if( $id!="" )
        {
            $spooler = $this->getDoctrine()->getRepository("AriiCoreBundle:Cluster")->find($id);
            $connection = $spooler->getConnection();
            $em->remove($spooler);
            $em->flush();
            if($connection != null){
                $em->remove($connection);
                $em->flush();
            }
            return new Response('success');
        } else 
        {
            return new Response("Error: Can not find a id for deleting!");
        }
         * 
         */
        
        if ($id != ""){
            $db = $this->container->get('arii_core.db');
            $data = $db->Connector('data');
            $qry = "UPDATE ARII_SPOOLER SET supervisor_id=null WHERE supervisor_id='$id'";
            $data->sql->query($qry);
            
            $qry = "UPDATE ARII_SPOOLER SET primary_id=null WHERE primary_id='$id'";
            $data->sql->query($qry);
            
            $em = $this->getDoctrine()->getManager();
            $spooler = $this->getDoctrine()->getRepository("AriiCoreBundle:Cluster")->find($id);
            $connection = $spooler->getConnection();
            $em->remove($spooler);
            $em->flush();
            if($connection != null){
                $em->remove($connection);
                $em->flush();
            }
            
            return new Response('success');
        }
        else 
        {
            return new Response("Error: Can not find a id for deleting!");
        }
    }
	
    public function saveAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('ID');
        $em = $this->getDoctrine()->getManager();
        
        $spooler = new \Arii\CoreBundle\Entity\Cluster();
        if( $id!="" )
            $spooler = $this->getDoctrine()->getRepository("AriiCoreBundle:Cluster")->find($id);      
        
        $spooler->setName($request->get('NAME'));
        $spooler->setInstance($request->get('INSTANCE'));
        $spooler->setDescription($request->get('DESCRIPTION'));
        $spooler->setLicence($request->get('LICENCE'));        

        $repository = $this->getDoctrine()->getRepository("AriiCoreBundle:Connection")->find($request->get('REPOSITORY_ID'));
        if ($repository)
            $spooler->setRepository($repository);                
        $master = $this->getDoctrine()->getRepository("AriiCoreBundle:Connection")->find($request->get('MASTER_ID'));
        if ($master)
            $spooler->setMaster($master);        
        $connection = $this->getDoctrine()->getRepository("AriiCoreBundle:Connection")->find($request->get('CONNECTION_ID'));
        if ($connection)
            $spooler->setConnection($connection);        
        $smtp = $this->getDoctrine()->getRepository("AriiCoreBundle:Connection")->find($request->get('SMTP_ID'));
        if ($smtp)
            $spooler->setSmtp($smtp);
        $remote = $this->getDoctrine()->getRepository("AriiCoreBundle:Connection")->find($request->get('REMOTE_ID'));
        if ($remote)
            $spooler->setRemote($remote);
        $webaccess = $this->getDoctrine()->getRepository("AriiCoreBundle:Connection")->find($request->get('WEBACCESS_ID'));
        if ($webaccess)
            $spooler->setWebaccess($webaccess);

        $site = $this->getDoctrine()->getRepository("AriiCoreBundle:Site")->find($request->get('SITE_ID'));
        if ($site)
            $spooler->setSite($site);
        
        $spooler->setInstallPath($request->get('INSTALL_PATH'));
        $spooler->setUserPath($request->get('USER_PATH'));
        $spooler->setStatusDate(new \DateTime());

        $em->persist($spooler);
        $em->flush();
        
        return new Response("success");
    }
    
    public function formAction()
    {
        $db = $this->container->get('arii_core.db');
        $sql = $this->container->get('arii_core.sql');
        
        $form = $db->Connector('form');
        $qry = $sql->Select(array("sp.ID","sp.INSTANCE","sp.NAME","sp.DESCRIPTION","sp.MASTER_ID","sp.SITE_ID","sp.SMTP_ID","sp.REPOSITORY_ID","sp.CONNECTION_ID","sp.INSTALL_PATH","sp.USER_PATH","sp.REMOTE_ID"))
                .$sql->From(array("ARII_SPOOLER sp"))
                .$sql->LeftJoin("ARII_CONNECTION ac",array("sp.CONNECTION_ID","ac.ID"))
                .$sql->OrderBy(array("sp.NAME"));
        
        $form->render_sql($qry,"sp.ID","ID,INSTANCE,NAME,DESCRIPTION,MASTER_ID,SITE_ID,SMTP_ID,CONNECTION_ID,REPOSITORY_ID,INSTALL_PATH,USER_PATH");
    }
        
}

?>
