<?php

namespace Arii\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class InstallController extends Controller
{

/**
 * @Security("has_role('ROLE_ADMIN')")
 */    
    public function indexAction()
    {
        return $this->render('AriiAdminBundle:Install:index.html.twig');
    }

    // DOonnees par defaut
    public function installAction()
    {
        $portal = $this->container->get('arii_core.portal');
        
        $Change = array();
        // Appel des valeurs par defaut        
        $res = $portal->resetParameters(true);
        $Change['Parameters'] = implode(', ',array_keys($res));

        $res = $portal->resetCategories(true);
        $Change['Categories'] = implode(', ',array_keys($res));

        $res = $portal->resetOptions(true);
        $Change['Options'] = implode(', ',array_keys($res));

        $res = $portal->resetSites(true);
        $Change['Sites'] = implode(', ',array_keys($res));

        $res = $portal->resetConnections(true);
        $Change['Connections'] = implode(', ',array_keys($res));

        $res = $portal->resetNodes(true);
        $Change['Nodes'] = implode(', ',array_keys($res));

        $res = $portal->resetTeams(true);
        $Change['Teams'] = implode(', ',array_keys($res));

        $res = $portal->resetUsers(true);
        $Change['Users'] = implode(', ',array_keys($res));

        $res = $portal->resetRights(true);
        $Change['Rights'] = implode(', ',array_keys($res));
        
        return $this->render('AriiAdminBundle:Install:bootstrap.html.twig', array('Change' => $Change));
    }    
}
