<?php

namespace Arii\AdminBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class TeamsController extends Controller {

    public function indexAction()
    {
        return $this->render('AriiAdminBundle:Teams:index.html.twig');
    }
        
   public function menuAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render("AriiAdminBundle:Teams:menu.xml.twig", array(), $response);
    }

    public function selectAction()
    {
        $sql = $this->container->get("arii_core.sql");
        $qry = $sql->Select(array("ID","NAME"))
               .$sql->From(array("ARII_TEAM"))
               .$sql->OrderBy(array("NAME")); 
        
        $db = $this->container->get('arii_core.db');
        $select = $db->Connector('select');       
        $select->render_sql($qry,"ID","ID,NAME");
    }

    public function gridAction() {
        $sql = $this->container->get('arii_core.sql');                  
        $qry =  $sql->Select(array('ID','NAME','DESCRIPTION'))
                .$sql->From(array('ARII_TEAM'))
                .$sql->OrderBy(array('NAME'));

        $db = $this->container->get('arii_core.db');
        $data = $db->Connector('grid');
        $data->render_sql($qry,'ID','NAME,DESCRIPTION');
    }
    
    public function treeAction() {

        $db = $this->container->get('arii_core.db');
        $data = $db->Connector('data');        
        
        $sql = $this->container->get('arii_core.sql');                  
        $qry =  $sql->Select(array('u.ID','USERNAME','t.ID as TEAM_ID','t.NAME'))
                .$sql->From(array('ARII_USER u'))
                .$sql->LeftJoin('ARII_TEAM t',array('u.TEAM_ID','t.ID'))
                .$sql->OrderBy(array('NAME','USERNAME'));

        $Tree = array();
        $res = $data->sql->query($qry);
        while ($line = $data->sql->get_next($res)) {
            $id = $line['ID'];
            $team_id = $line['TEAM_ID'];
            if ($team_id=='') {
                $Tree['USERS'][$id] = $line['USERNAME'];                
            }
            else {
                $Tree['GROUPS'][$team_id]['NAME'] = $line['NAME'];
                $Tree['GROUPS'][$team_id]['USERS'][$id] = $line['USERNAME'];
            }
        }
        
        $tree = '<tree id="0">';
        if (isset($Tree['USERS'])) {
            foreach ($Tree['USERS'] as $k=>$v) {
                $tree .= '<item id="U'.$k.'" text="'.$v.'" child="-1"/>';
            }
        }
        if (isset($Tree['GROUPS'])) {
            foreach ($Tree['GROUPS'] as $k=>$Group) {
                $tree .= '<item id="'.$k.'" text="'.$Group['NAME'].'" child="-1">';
                foreach ($Group['USERS'] as $u=>$v) {
                    $tree .= '<item id="U'.$u.'" text="'.$v.'" child="-1"/>';
                }
                $tree .= '</item>';
            }
        }
        
        $tree .= '</tree>';

        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        $response->setContent( $tree );
        return $response;
    }
}
?>
