<?php

namespace Arii\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class PushbulletController extends Controller
{
    public function indexAction()
    {
        $portal = $this->container->get('arii_core.portal');
        return $this->render('AriiCoreBundle:Pushbullet:index.html.twig',array('Modules' => $portal->getModules()));
    }

    public function meAction()
    {      
        $portal = $this->container->get('arii_core.portal');
        $Info = $portal->getUserInfo();        
        $token = $Info['pushbullet_token'];
        $devices = $Info['pushbullet_devices'];

        $this->SendSMSAction();
        $curl = $this->container->get('arii_core.curl');
        $User = $curl->get([
            'host' => 'api.pushbullet.com',
            'command' => '/v2/users/me',
            'format'  => 'json'           
        ]);
        $Devices = $curl->get([
            'host' => 'api.pushbullet.com',
            'command' => '/v2/devices',
            'format'  => 'json'           
        ]);
        return $this->render('AriiCoreBundle:Pushbullet:bootstrap.html.twig', [ 'User' => $User['data'], 'Devices' => $Devices['data']['devices'] ]);
    }

    public function ChatsAction()
    {        
        $portal = $this->container->get('arii_core.portal');
        $Info = $portal->getUserInfo();        
        $token = $Info['pushbullet_token'];
        $devices = $Info['pushbullet_devices'];

        $curl = $this->container->get('arii_core.curl');
        $Chats = $curl->get([
            'host' => 'api.pushbullet.com',
            'command' => '/v2/pushes',
            'format'  => 'json'           
        ]);
        print_r($Chats);
        exit();
        return $this->render('AriiCoreBundle:Pushbullet:bootstrap.html.twig', [ 'User' => $User['data'], 'Devices' => $Devices['data']['devices'] ]);
    }

    public function SendMsgAction($title,$text,$from,$to)
    {        
        $portal = $this->container->get('arii_core.portal');
        $Info = $portal->getUserInfo();        
        $token = $Info['pushbullet_token'];
        $devices = $Info['pushbullet_devices'];

        $curl = $this->container->get('arii_core.curl');
        $Msg = $curl->post([
            'host' => 'api.pushbullet.com',
            'command' => '/v2/pushes',
            'format'  => 'json',
            'data' => [
                'type' => 'note',
                'title' => $title,
                'body' =>  $text,
                'device_iden' => $to
            ]
        ]);
        print_r($Msg);
        exit();
        return $this->render('AriiCoreBundle:Pushbullet:bootstrap.html.twig', [ 'User' => $User['data'], 'Devices' => $Devices['data']['devices'] ]);
    }

    public function SendSMSAction($title,$text,$from,$to,$type='pushbullet')
    {        
        $portal = $this->container->get('arii_core.portal');
        $Info = $portal->getUserInfo();        
        $token = $Info['pushbullet_token'];
        $devices = $Info['pushbullet_devices'];

        $curl = $this->container->get('arii_core.curl');
        $Msg = $curl->post([
            'host' => 'api.pushbullet.com',
            'command' => '/v2/ephemerals',
            'format'  => 'json',
            'data' => [
                'type' => 'push',
                'push' => [
                    "conversation_iden" => $Info['pushbullet_token'],
                    "message" => $text,
                    "package_name" => "com.pushbullet.android",
                    "source_user_iden" => $from,
                    "target_device_iden" => $to,
                    "type" => "messaging_extension_reply"
                ]
            ]
        ]);
        print_r($Msg);
        exit();
        return $this->render('AriiCoreBundle:Pushbullet:bootstrap.html.twig', [ 'User' => $User['data'], 'Devices' => $Devices['data']['devices'] ]);
    }
    
}
