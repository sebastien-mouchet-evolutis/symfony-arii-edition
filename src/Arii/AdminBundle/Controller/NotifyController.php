<?php

namespace Arii\AdminBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class NotifyController extends Controller{

    public function indexAction()
    {
        return $this->render('AriiAdminBundle:Notify:index.html.twig');
    }

    public function toolbarAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render("AriiAdminBundle:Notify:toolbar.xml.twig", array(), $response);
    }

    public function grid_toolbarAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render("AriiAdminBundle:Notify:grid_toolbar.xml.twig", array(), $response);
    }

    public function gridAction()
    {   
        $sql = $this->container->get('arii_core.sql');        
        $qry = $sql->Select(array("ID","NAME","TITLE","DESCRIPTION"))
                .$sql->From(array("ARII_NOTIFY"))
                .$sql->OrderBy(array('NAME,TITLE,DESCRIPTION'));
        
        $db = $this->container->get('arii_core.db');
        $data = $db->Connector('grid');
        $data->render_sql($qry,"ID","NAME,TITLE,DESCRIPTION");
    }

    public function users_gridAction()
    {   
        $request = Request::createFromGlobals();
        $id = $request->get('id');

        $Notify = $this->getDoctrine()->getRepository("AriiCoreBundle:Notify")->find($id);
        $Notify = $this->getDoctrine()->getRepository("AriiCoreBundle:NotifyUser")->findBy([ 'notify' => $Notify ] );
        
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        $list = '<?xml version="1.0" encoding="UTF-8"?>';
        $list .= "<rows>\n";
        $list .= '<head>
            <afterInit>
                <call command="clearAll"/>
            </afterInit>
        </head>';

        foreach ($Notify as $n) {
            $list .= '<row id="'.$n->getId().'">';
            $User = $n->getUser();
            $list .= '<cell>'.$n->getNotifyUse().'</cell>';
            $list .= '<cell>'.$User->getUsername().'</cell>';
            $list .= '</row>';            
        }
        $list .= "</rows>\n";
        $response->setContent( $list );
        return $response;            
    }

    public function files_gridAction()
    {   
        $request = Request::createFromGlobals();
        $id = $request->get('id');

        $Notify = $this->getDoctrine()->getRepository("AriiCoreBundle:Notify")->find($id);
        $Notify = $this->getDoctrine()->getRepository("AriiCoreBundle:NotifyFile")->findBy([ 'notify' => $Notify ] );
        
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        $list = '<?xml version="1.0" encoding="UTF-8"?>';
        $list .= "<rows>\n";
        $list .= '<head>
            <afterInit>
                <call command="clearAll"/>
            </afterInit>
        </head>';

        foreach ($Notify as $n) {
            $list .= '<row id="'.$n->getId().'">';
            $File = $n->getNotifyFile();
            $list .= '<cell>'.$File->getName().'</cell>';
            $list .= '</row>';            
        }
        $list .= "</rows>\n";
        $response->setContent( $list );
        return $response;            
    }
    
    public function formAction()
    {   
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        
        $sql = $this->container->get('arii_core.sql');        
        $qry = $sql->Select(array("ID","NAME","TITLE","DESCRIPTION","MESSAGE"))
                .$sql->From(array("ARII_NOTIFY"))
                .$sql->Where(array("ID"=>$id));
        
        $db = $this->container->get('arii_core.db');
        $data = $db->Connector('form');
        $data->event->attach("beforeRender",array($this,"detail_render"));
        $data->render_sql($qry,"ID","ID,NAME,TITLE,DESCRIPTION,MESSAGE");
    }
    
    function detail_render ($data){
        $data->set_value( 'MESSAGE', str_replace("\n","<br/>", $data->get_value( 'MESSAGE') ) );
    }
    
    public function deleteAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('ID');
        
        $note = $this->getDoctrine()->getRepository("AriiCoreBundle:Notify")->find($id);      
        if ($note) {
            $em = $this->getDoctrine()->getManager();       
            $em->remove($note);
            $em->flush();
            return new Response("success");            
        }
        
        return new Response("?!");            
    }
    
    public function saveAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('ID');

        $note = new \Arii\CoreBundle\Entity\Note();
        if( $id!="" )
            $note = $this->getDoctrine()->getRepository("AriiCoreBundle:Notify")->find($id);      
  
        $note->setName($request->get('NAME'));
        $note->setTitle($request->get('TITLE'));
        $note->setDescription($request->get('DESCRIPTION'));
        $note->setMessage($request->get('MESSAGE'));
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($note);
        $em->flush();
        
        return new Response("success");
    }

    public function importAction()
    {
        $portal = $this->container->get('arii_core.portal');        
        $file = file_get_contents($portal->getWorkspace().'/Admin/Import/mails.csv');
        $Log = explode("\r\n",$file);
        
        $header = array_shift($Log);
        $Head = explode("\t",$header);
                
        // On traite le log
        $em = $this->getDoctrine()->getManager();
        $n=0;
        foreach ($Log as $l) {
            $Infos = explode("\t",$l);
            for($i=0;$i<count($Head);$i++) {
                if (isset($Infos[$i])) 
                    $Data[$Head[$i]] = utf8_encode(str_replace('|',"\n",$Infos[$i]));
                else
                    $Data[$Head[$i]] = '';
            }
            
            $Notify = $this->getDoctrine()->getRepository("AriiCoreBundle:Notify")->findOneBy( array( 'name' => $Data['filename'] ) );
            if (!$Notify) {
                $Notify = new \Arii\CoreBundle\Entity\Notify();
            }
            $Notify->setName($Data['filename']);
            $Notify->setTitle($Data['object']);
            $Notify->setMessage($Data['mess']);
            $Notify->setNotifyType('mail');
            
            // utilisateurs
            // a mettre en parametre
            $domain = '@vaudoise.ch';
            $user_manager = $this->container->get('fos_user.user_manager');
            foreach (['from','to','css','replyto'] as $t) {
                if (!isset($Data[$t]) or ($Data[$t]=='')) continue;
                
                $Users = explode("\n",strtolower($Data[$t]));
                foreach ($Users as $u) {
                    $u = trim(str_replace($domain,'',$u));
                    $User  = $this->getDoctrine()->getRepository("AriiUserBundle:User")->findOneBy( array( 'username' => $u ) );
                    if (!$User) {
                        $User = $user_manager->createUser();
                        
                        $User->setUsername($u);
                        $User->setEmail($u.$domain);
                        $User->setPlainPassword($u);                        
                        $User->setEnabled(0);
                        $User->setSuperAdmin(0);
                        $User->setFirstName($u);
                        $User->setLastName($u);
                        $user_manager->updateUser($User);
                    }
                    
                    $NotifyUser  = $this->getDoctrine()->getRepository("AriiCoreBundle:NotifyUser")->findOneBy( array( 'notify' => $Notify, 'user' => $User ) );
                    if (!$NotifyUser)
                        $NotifyUser = new \Arii\CoreBundle\Entity\NotifyUser();                    
                    $NotifyUser->setNotify($Notify);
                    $NotifyUser->setUser($User);
                    if ($t=='css')
                        $NotifyUser->setNotifyUse('cc');
                    else
                        $NotifyUser->setNotifyUse($t);
                    $em->persist($NotifyUser);
                }
            }

            // Pieces attachees
            $Files = explode("\n",$Data['attach']);
            foreach ($Files as $f) {
                if (trim($f)=='') continue;
                $File  = $this->getDoctrine()->getRepository("AriiCoreBundle:File")->findOneBy( array( 'name' => $f ) );
                if (!$File)
                    $File = new \Arii\CoreBundle\Entity\File();
                $File->setName($f);
                $File->setDescription('attachment');
                $em->persist($File);

                $NotifyFile  = $this->getDoctrine()->getRepository("AriiCoreBundle:NotifyFile")->findOneBy( array( 'notify' => $Notify, 'notify_file' => $File ) );
                if (!$NotifyFile)
                    $NotifyFile = new \Arii\CoreBundle\Entity\NotifyFile();                    
                $NotifyFile->setNotify($Notify);
                $NotifyFile->setNotifyFile($File);
                $em->persist($NotifyFile);
            }            
            
            $em->persist($Notify);
        }
        $em->flush();        
        return new Response("success");
    }
    
}

?>
