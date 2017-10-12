<?php
namespace Arii\CoreBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MessageListener implements EventSubscriberInterface
{
    const AFTER_MESSAGE_SENT = "arii_message.after_message_sent";    
    
    protected $portal;
    protected $curl;
    
    public function __construct(
            \Arii\CoreBundle\Service\AriiPortal $portal,
            \Arii\CoreBundle\Service\AriiCurl   $curl) {
        
        $this->portal = $portal;
        $this->curl   = $curl;
    }
    
    public static function getSubscribedEvents() {
        return array(
            // must be registered before the default Locale listener
            MessageListener::AFTER_MESSAGE_SENT => 'Notify'
        );        
    }

    public function Notify(\Arii\CoreBundle\EventDispatcher\MessageEvent $event)
    {        
        // ECHO !!!
        $Msg = $event->getMsg();        
        $Info = $this->portal->getUserInfo();
        
        // Quel est la priorité ?
        $priority = $Msg->getMsgType();
        switch($priority) {
            case 'A':
                $notifs = $Info['notify_alert'];
                break; 
            case 'W':
                $notifs = $Info['notify_warning'];
                break; 
            case 'I':
                $notifs = $Info['notify_info'];
                break; 
            default:
                return;
        }
        
        foreach (explode(',',$notifs) as $notification) {
            switch($notification) {
                case 'pushbullet':
                    $token = $Info['pushbullet_token'];
                    $devices = $Info['pushbullet_devices'];
                    $Return = $this->curl->post([
                        'host' => 'api.pushbullet.com',
                        'auth' => $Info['pushbullet_token'],
                        'command' => '/v2/pushes',
                        'format'  => 'json',
                        'data' => [
                            'type'  => 'note',
                            'title' => $Msg->getTitle(),
                            'body'  => $Msg->getMsgText(),
                            'device_iden' => 'ujDNvlB4CjssjAcyrQ9Cmq'
                        ]
                    ]);
                    if (isset($Return['data']['error']['message']))
                        throw new \Exception($Return['data']['error']['message']);
                    break;
                case 'sms':
                    $token = $Info['pushbullet_token'];
                    $devices = $Info['pushbullet_devices'];
                    $Return = $this->curl->post([
                        'host' => 'api.pushbullet.com',
                        'command' => '/v2/ephemerals',
                        'auth' => $token,
                        'format'  => 'json',
                        'data' => [
                            'type' => 'push',
                            'push' => [
                                "conversation_iden" => "+41 76 565 84 18",
                                "message" => $Msg->getTitle()."\n".$Msg->getMsgText(),
                                "package_name" => "com.pushbullet.android",
                                "source_user_iden" => "ujDNvlB4Cjss",
                                "target_device_iden" => "ujDNvlB4CjssjAcyrQ9Cmq",
                                "type" => "messaging_extension_reply"
                            ]
                        ]
                    ]);
                    break;
                default:
                    break;
            }
        }
        return;
    }

}