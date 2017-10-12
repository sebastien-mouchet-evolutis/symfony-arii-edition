<?php

namespace Arii\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class NodesController extends Controller
{
   public function indexAction()
    {
        return $this->render('AriiAdminBundle:Nodes:index.html.twig');
    }
 
    public function grid_toolbarAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render('AriiHubBundle:Nodes:grid_toolbar.xml.twig',array(), $response );
    }

    public function toolbarAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render('AriiAdminBundle:Nodes:toolbar.xml.twig', array(), $response);
    }
    
    public function toolbar2Action()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render('AriiAdminBundle:Nodes:toolbar2.xml.twig', array(), $response);
    }

    public function schemaAction()
    {
/*        
        $Nodes = "
            {id: 1, label: 'Node 1'},
            {id: 2, label: 'Node 2', shape: 'image', color:'#97C2FC', image: dir+'/database.png'},
            {id: 3, label: 'Node 3'},
            {id: 4, label: 'Node 4'},
            {id: 5, label: 'Node 5'}";
        $Edges = "
            {from: 1, to: 3},
            {from: 1, to: 2, color:{color:'red'} },
            {from: 2, to: 4},
            {from: 2, to: 5}";
*/
        $portal = $this->container->get('arii_core.portal');        
        $Nodes = $portal->getNodes();
                
        $Done = $NODES = $EDGES = array();
        foreach ($Nodes as $Node) {
            array_push($NODES, "{ id: 'n".$Node['id']."', shape: 'box', label: '".$Node['title']."', shape: 'image', image: dir+'/big/".$Node['component'].".png', size: 48, font: {size: 18, strokeColor : '#00ff00' } }" );
            
            // Connections
            foreach ($Node['Connections'] as $Connection) { 
                $id = $Connection['id'];
                if (!isset($Done[$id])) {
                  array_push($NODES, "{ id: 'c".$id."', label: '".$Connection['title']."', shape: 'image', image: dir+'/".$Connection['domain'].".png' }" );
                  $Done[$id]=1;
                }
                array_push($EDGES, "{ from: 'n".$Node['id']."', to: 'c".$Connection['id']."', label: '".$Connection['protocol']."', font: {strokeWidth: 2, strokeColor : 'yellow'} }" );
            }
        }
        
        return $this->render("AriiAdminBundle:Connections:schema.html.twig",  array('NODES' => implode(", \n",$NODES), 'EDGES' =>  implode(", \n",$EDGES) ) );
    }
        
    public function gridAction()
    {
        $portal = $this->container->get('arii_core.portal');        
        $Nodes = $portal->getNodes(); 
        
        $dhtmlx = $this->container->get('arii_core.render'); 
        return $dhtmlx->grid($Nodes,'category,title,description,component_str,vendor_str,status');
    }

    public function treeAction()
    {
        $portal = $this->container->get('arii_core.portal');
        $Nodes = $portal->getNodes(); 
        
        $dhtmlx = $this->container->get('arii_core.render'); 
        return $dhtmlx->tree($Nodes);
    }
    
    // Arborescence des noeuds
    public function listAction()
    {
        $portal = $this->container->get('arii_core.portal');        
        $Nodes = $portal->getNodes(); 
        
        $dhtmlx = $this->container->get('arii_core.render'); 
        return $dhtmlx->grid($Nodes,'category,name,role_str,description,status');
    }
    
    public function formAction()
    {
        $request = Request::createFromGlobals();
        
        $portal = $this->container->get('arii_core.portal');        
        $Node = $portal->getNodeById(($request->query->get('id')>0)?[ 'id'=> $request->query->get('id') ]:[]); 
        if (!$Node)
            throw nex \Exception('ARI',3);
        
        $dhtmlx = $this->container->get('arii_core.render'); 
        return $dhtmlx->form($Node);
    }

    public function connectionsAction()
    {
        $request = Request::createFromGlobals();
        
        $portal = $this->container->get('arii_core.portal');     
        $Connections = $portal->getNodeConnectionsById(($request->query->get('id')>0)?[ 'id'=> $request->query->get('id') ]:[]); 

        $dhtmlx = $this->container->get('arii_core.render'); 
        return $dhtmlx->grid($Connections,'title,domain,description,host,protocol,login');
    }
        
    public function deleteAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        
        if($id=="") return;
                
        $em = $this->getDoctrine()->getManager();
        $node = $this->getDoctrine()->getRepository("AriiCoreBundle:Node")->find($id);      

        # Retrouver les liens
        $NodeConnections = $this->getDoctrine()->getRepository("AriiCoreBundle:NodeConnection")->findBy([ 'node' => $node ]);
        foreach ($NodeConnections as $NodeConnection) {
            $em->remove($NodeConnection);
        }
        $em->remove($node);
        $em->flush();
        
        // Raz Nodes
        $portal = $this->container->get('arii_core.portal');
        $portal->setNodes();
        
        return new Response("success");          
    }
	
    public function saveAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->get('id');
        
        $node = new \Arii\CoreBundle\Entity\Node();
        if( $id!="" ) 
            $node = $this->getDoctrine()->getRepository("AriiCoreBundle:Node")->find($id);      
        
        $node->setName($request->get('name'));
        $node->setTitle($request->get('title'));
        $node->setDescription($request->get('description'));
        $node->setComponent($request->get('component'));
        $node->setRole($request->get('role'));
        $node->setVendor($request->get('vendor'));

        $site = $this->getDoctrine()->getRepository("AriiCoreBundle:Site")->find($request->get('site_id'));
        if ($site)
            $node->setSite($site);
        
        $category = $this->getDoctrine()->getRepository("AriiCoreBundle:Category")->find($request->get('category_id'));
        if ($category)
            $node->setCategory($category);
        
        $node->setStatus("creation");
        $node->setStatusDate(new \DateTime());
      
        $em = $this->getDoctrine()->getManager();                
        $n=1; # position de la connexion
        print $request->get('connections');
        $IDs = explode(',',$request->get('connections'));

        foreach ($IDs as $connection_id) {
            $Connection = $this->getDoctrine()->getRepository("AriiCoreBundle:Connection")->find($connection_id);
            if (!$Connection)
                continue;
            
            // On update le Node<->Connection
            $NodeConnection = $this->getDoctrine()->getRepository("AriiCoreBundle:NodeConnection")->findOneBy([ 'node' => $node, 'connection' => $Connection]);
            if (!$NodeConnection)
                $NodeConnection = new \Arii\CoreBundle\Entity\NodeConnection();
            
            $NodeConnection->setNode($node);
            $NodeConnection->setConnection($Connection);
            $NodeConnection->setPriority($n);
            $NodeConnection->setDisabled(false);
            $NodeConnection->setDescription($node->getName().' -> '.$Connection->getName());
            $em->persist($NodeConnection);         
            $n++;
        };                
        
        // supprimer les ids qui ne sont plus dans la liste
        $NodeConnections = $this->getDoctrine()->getRepository("AriiCoreBundle:NodeConnection")->findBy( [ 'node' => $node ] );
        foreach ($NodeConnections  as $NodeConnection) {
            $id = $NodeConnection->getId();
            if (!in_array($id,$IDs)) {
                $em->remove($NodeConnection);
                $em->persist($NodeConnection);
            }
        }
        
        $em->persist($node);
        $em->flush();
        
        // Raz Nodes
        $portal = $this->container->get('arii_core.portal');
        $portal->resetNodes(true);
                
        return new Response("success");        
    }
    
}
