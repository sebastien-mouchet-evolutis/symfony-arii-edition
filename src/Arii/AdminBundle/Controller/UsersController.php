<?php
namespace Arii\AdminBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Arii\CoreBundle\Entity\TeamFilter;

class UsersController extends Controller {
    
    public function indexAction()
    {
        return $this->render('AriiAdminBundle:Users:index.html.twig');
    }
    
    public function menuAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render("AriiAdminBundle:Users:menu.xml.twig", array(), $response);
    }
    
    public function toolbarAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render("AriiAdminBundle:Users:toolbar.xml.twig", array(), $response);
    }

    public function gridAction()
    {
        $em = $this->getDoctrine()->getManager(); 
        $Users = $em->getRepository("AriiUserBundle:User")->findBy(array(), array('username' => 'ASC'));
        
        $xml = "<?xml version='1.0' encoding='iso-8859-1'?>";
        $xml = "<rows>";
        foreach ($Users as $User) {
            $xml .= '<row id="'.$User->getId().'">';
            $xml .= '<cell>'.$User->getUsername().'</cell>';
            $xml .= '<cell>'.$User->getFirstName().' '.$User->getLastName().'</cell>';
            $xml .= '<cell>'.$User->getEmail().'</cell>';
            if ($User->getTeam())
                $xml .= '<cell>'.$User->getTeam()->getName().'</cell>';
            else 
                $xml .= '<cell/>';
/*            $xml .= '<cell>'.$User->isEnabled().'</cell>';
            if ($User->getLastLogin())
                $xml .= '<cell>'.$User->getLastLogin()->format('Y-m-d').'</cell>';
            else 
                $xml .= '<cell/>';
*/            $xml .= '<cell>'.str_replace('ROLE_','',implode(',',$User->getRoles())).'</cell>';
            $xml .= '</row>';
        }
        $xml .= '</rows>';
        
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');        
        $response->setContent( $xml );
        return $response;            
    }
}
?>
