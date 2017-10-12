<?php

namespace Arii\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ConnectionsController extends Controller
{
   public function indexAction()
    {
        return $this->render('AriiAdminBundle:Connections:index.html.twig');
    }

    public function toolbarAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render('AriiAdminBundle:Connections:toolbar.xml.twig', array(), $response);
    }

    public function menuAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render("AriiAdminBundle:Connections:menu.xml.twig", array(), $response );
    }

    public function gridAction()
    {
        $request = Request::createFromGlobals();

        $portal = $this->container->get('arii_core.portal');        
        $Connections = $portal->getConnections(($request->query->get('category')>0)?[ 'category_id'=>$category_id ]:[]); 
        
        $dhtmlx = $this->container->get('arii_core.render'); 
        return $dhtmlx->grid($Connections,'name,title,domain,description,host,protocol,login');
    }
    
    public function formAction()
    {
        $request = Request::createFromGlobals();

        $portal = $this->container->get('arii_core.portal');        
        $Connection = $portal->getConnectionById(($request->query->get('id')>0)?[ 'id'=> $request->query->get('id') ]:[]); 

        $dhtmlx = $this->container->get('arii_core.render'); 
        return $dhtmlx->form($Connection);
    }
    
    public function saveAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        
        $connection = new \Arii\CoreBundle\Entity\Connection();
        if( $id != "" )
            $connection = $this->getDoctrine()->getRepository("AriiCoreBundle:Connection")->find($id);
                    
        $connection->setName($request->get('name'));
        $connection->setTitle($request->get('title'));
        $connection->setDescription($request->get('description'));
        $connection->setDomain($request->get('domain'));
        $connection->setHost($request->get('host'));
        
        $connection->setInterface($request->get('interface'));
        $connection->setProtocol($request->get('protocol'));
        $connection->setDriver($request->get('driver'));
        $connection->setPort($request->get('port'));
        $connection->setLogin($request->get('login'));
        $connection->setAuthMethod($request->get('auth_method'));
        $connection->setKey($request->get('private_key'));
        $connection->setPassword($request->get('password'));
        $connection->setVendor($request->get('vendor'));
        $connection->setOwner($request->get('owner'));
        $connection->setPath($request->get('path'));
        $connection->setDatabase($request->get('database'));
        $connection->setInstance($request->get('instance'));
        $connection->setService($request->get('service'));
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($connection);
        $em->flush();
        
        // Mise à jour de la session
        $portal = $this->container->get('arii_core.portal'); 
        $portal->resetConnections();
        
        # On sauve et on verifie après
        # le problème de connexion est peut être temporaire
        # on ne peut pas bloquer la sauvegarde
        return $this->checkAction($request);
        
        return new Response("success");
    }

    public function checkAction($request='') 
    {
        if ($request=='')
            $request = Request::createFromGlobals();
        
        if ($request->get('port')=='')
            return new Response("success");
        
        switch ($request->get('protocol')) {
            case 'oracle':
                if ($request->get('service'))
                    $conn= oci_connect( $request->get('login'), $request->get('password'), $request->get('host').':'.$request->get('port').'/'.$request->get('database')  );                
                else 
                    $conn= oci_connect( $request->get('login'), $request->get('password'), $request->get('instance')  );
                if (!$conn) {
                    $e = oci_error();
                    throw new \Exception($e['message']);
                }
                break;
            case 'mysqli':                
                $conn= mysqli_connect(  $request->get('host'), $request->get('login'), $request->get('password'), $request->get('database') );
                if (mysqli_connect_errno())
                    throw new \Exception(mysqli_connect_error());
                break;
            case 'mssql':
                $serverName = $request->get('host').'\\'.$request->get('instance');      
                if ($request->get('login')!='') 
                    $connectionInfo = array( 
                        "Database"=> $request->get('database'), 
                        "UID"=>  $request->get('login'), 
                        "PWD"=>  $request->get('password') );
                else # Connexion Windows
                    $connectionInfo = array( 
                        "Database"=> $request->get('database') );
                $conn = sqlsrv_connect( $serverName, $connectionInfo);
                if( !$conn ) {
                    $Errors = [];
                    foreach( sqlsrv_errors() as $error)  
                    {  
                        $msg =  "SQLSTATE: ".$error[ 'SQLSTATE']."\n";  
                        $msg .=  "code: ".$error[ 'code']."\n";  
                        $msg .=  "message: ".$error[ 'message']."\n";  
                        if (!in_array($msg,$Errors))
                            array_push($Errors,$msg);
                    }
                    throw new \Exception(implode("\n",$Errors));
                }
                break;
            default:
                # au moins tester l'ouverture de port
                $socket = @fsockopen(
                    $request->get('host'), 
                    $request->get('port'), $errno, $errstr, 3
                );
                if (!$socket)
                    throw new \Exception($errstr);
        }
        return new Response("success");
    }
    
    public function deleteAction()
    {        
        $request = Request::createFromGlobals();
        $id = $request->get('id');

        $connection = $this->getDoctrine()->getRepository("AriiCoreBundle:Connection")->find($id);      
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($connection);
        $em->flush();
        
        // Mise à jour de la session
        $portal = $this->container->get('arii_core.portal'); 
        $portal->resetConnections(true);
        
        return new Response("success");
    }
    
    public function form_structureAction()
    {
       $db = $this->container->get("arii_core.db");
        $data = $db->Connector("data");
        $qry = "SELECT n.id as network_id, cat.id as category_id, cat.name as category,n.description as type,n.protocol,n.form 
                FROM ARII_CATEGORY cat
                LEFT JOIN ARII_NETWORK n
                ON cat.id=n.category_id
                ORDER BY cat.name, n.description";
        
        $res = $data->sql->query( $qry );
        $form = '';
        # on cree l'arborescence
        $Cat = array();$last='';
        while ($line = $data->sql->get_next($res)) {
            $cat_id   = $line['category_id'];
            $net_id   = $line['network_id'];
            $cat      = $line['category'];
            $type     = $line['type'];
            $protocol = $line['protocol'];
            $form     = $line['form'];
            $infos = "$net_id;$type;$protocol|$form";
            if ($cat!=$last) {
                //array_push($Cat,$cat);
                $Cat[$cat]['value']= $cat_id;
                $Cat[$cat]['label']= $cat;
                $Cat[$cat]['infos']=array();
            }
            array_push($Cat[$cat]['infos'],$infos);
            $last = $cat;
        }

        # Desssin
        $n=0;
        $Form = array();
        
        foreach ($Cat as $c) {

            $Items = array();
            foreach ($c['infos'] as $i) {
                list($label,$form) = explode('|',$i);
                list($net_id,$type,$protocol) = explode(';',$label);
                $item = "\n".'  {  text: "'.$type.'",value: "'.$net_id.'", list: [ ';
                $item .= "\n".'    { type: "hidden", name: "protocol_'.$net_id.'", value: "'.$protocol.'" }'; 
                $item .= "\n".'    ,{ type: "input", name: "ip_'.$net_id.'", value: "", label: "'.$this->get('translator')->trans('ip_address').'" }'; 
                foreach (explode(';',$form) as $f) {
                    # cas particulier
                        if (($p=strpos($f,'='))>0) {
                            $var = substr($f,0,$p);
                            $val = substr($f,$p+1);
                        }
                        else {
                            $var = $f;
                            $val = '';
                        }
                        $item .= $this->FormItem($net_id,$var,$val); 
                }
                $item .= "\n".'    ] }';
                array_push($Items, $item);
            }
            array_push($Form, '{ text: "'.$this->get('translator')->trans($c['label']).'", value: "'.$c['value'].'", '."\n".'  list: [ {  type: "select", 
     name: "category_'.$c['value'].'", label: "Type", options: [ '.implode(",\n",$Items).'] } ] }');
            
        }
        
        return new Response(implode(",\n",$Form));
        print "<pre>";
        print(implode(",\n",$Form));
        print "</pre>";
        exit();  
    }
    
    private function FormItem($id,$name,$val='') {
        $form='';
        # Le specifique
        if ($name == 'publickey') {
            $form .=  "\n".'       ,{ inputWidth: 300, type: "checkbox", label: "'.$this->get('translator')->trans('login').'", name: "'.$name.'_'.$id.'", value: "'.$val.'", list: [ ';                    
            $name = 'login'; $val = '';
            $form .= "\n".'       { inputWidth: 200, type: "password", label: "'.$this->get('translator')->trans($name).'", name: "'.$name.'_'.$id.'", value: "'.$val.'" },';                    
            $name = 'password'; $val = '';
            $form .= "\n".'       { inputWidth: 200, type: "password", label: "'.$this->get('translator')->trans($name).'", name: "'.$name.'_'.$id.'", value: "'.$val.'" }';                    
            $form .=  "\n".'      ] }';
        }
        elseif ($name == 'login') {
            $form .= ', { inputWidth: 350, type: "fieldset", label: "Authentication", list: [ ';
            $form .=  "\n".'       { inputWidth: 200, type: "input", label: "'.$this->get('translator')->trans($name).'", name: "'.$name.'_'.$id.'", value: "'.$val.'" }';                    
            $name = 'password'; $val = '';
            $form .= "\n".'       ,{ inputWidth: 200, type: "password", label: "'.$this->get('translator')->trans($name).'", name: "'.$name.'_'.$id.'", value: "'.$val.'" }';                    
            $form .= '] }';
        }
        elseif ($name == 'proxy') {
            $form .= ', { inputWidth: 350, type: "fieldset", label: "Proxy", list: [ ';
//            $form .= "\n".'       ,{ type: "checkbox", label: "'.$this->get('translator')->trans($name).'", name: "'.$id.'_'.$name.'", value: "'.$val.'" ';
//            $form .= '}';                    
            $form .= '] }';
        }
        else {
           $form .= "\n".'       ,{ inputWidth: 300, type: "input", label: "'.$this->get('translator')->trans($name).'", name: "'.$name.'_'.$id.'", value: "'.$val.'" }';                    
        }
        return $form;
    }
    
}
