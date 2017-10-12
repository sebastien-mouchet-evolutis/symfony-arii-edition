<?php

namespace Arii\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class OptionsController extends Controller
{
    
    public function rolesAction()
    {
        $portal = $this->container->get('arii_core.portal');        
        $Roles = $portal->getOptionsByDomain('role'); 

        $dhtmlx = $this->container->get('arii_core.render'); 
        return $dhtmlx->select($Roles,'name,title');
    }

    public function vendorsAction()
    {
        $request = Request::createFromGlobals();
        $component = $request->get('component');
        $selected =  $request->get('selected');
                
        $portal = $this->container->get('arii_core.portal');        
        $Vendors = $portal->getOptionsByDomain($component); 

        $dhtmlx = $this->container->get('arii_core.render'); 
        return $dhtmlx->select($Vendors,'name,title',$selected);
    }

    public function componentsAction()
    {
        $portal = $this->container->get('arii_core.portal');        
        $Components = $portal->getOptionsByDomain('component'); 

        $dhtmlx = $this->container->get('arii_core.render'); 
        return $dhtmlx->select($Components,'name,title');
    }

    public function eventtypesAction()
    {
        $portal = $this->container->get('arii_core.portal');        
        $EventTypes = $portal->getOptionsByDomain('event_type'); 

        $dhtmlx = $this->container->get('arii_core.render'); 
        return $dhtmlx->select($EventTypes,'name,title');
    }

}
