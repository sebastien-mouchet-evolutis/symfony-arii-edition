<?php
// src/Arii/CoreBundle/Service/AriiMenu.php
// 
// Ce service gère la session utilisateur
namespace Arii\CoreBundle\Service;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Locale\Locale;
// use Symfony\Component\HttpFoundation\RedirectResponse;

use Doctrine\ORM\EntityManager;
use Arii\CoreBundle\Entity\Parameter;

class AriiSession
{
    protected $session;
    protected $em;
    protected $username;
    
    public function __construct(Session $session, EntityManager $em, ContainerInterface $service_container )
    {
        $this->em = $em;
  
        $this->session = $session;
        $this->container = $service_container;
        
        // on teste si il est anonyme
        // est ce qu'il y a un tocken ?
        $token_storage = $this->container->get('security.token_storage');
        if( !$token_storage->getToken() ) {
            return;
        }
        if( !$this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY') 
                and !$this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED') ){
            // authenticated REMEMBERED, FULLY will imply REMEMBERED (NON anonymous)
//            return new RedirectResponse($this->generateUrl('arii_Home_index'));
            return;
        }

        $this->username = $token_storage->getToken()->getUsername();
        $this->roles = $token_storage->getToken()->getRoles();   
    }           

    /**************************************
     * SET et GET internes
     **************************************/
    public function get($id) {
        return $this->session->get($id);
    }
    
    public function set($id,$value) {
        $this->session->set($id, $value);
        return $value;
    }

    /**************************************
     * User
     **************************************/
    public function getUserName() {
        return $this->username;        
    }
    
    public function setUserInfo() {
        $this->set('User', $this->em->getRepository("AriiUserBundle:User")->findOneBy(array('username'=> $this->username ))); 
    }  

    public function getRoles() {
        return $this->roles;        
    }

}
