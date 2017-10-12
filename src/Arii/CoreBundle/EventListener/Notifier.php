<?php
namespace Arii\CoreBundle\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class Notifier {
    
    protected $Notify;
    
    public function __construct(\Arii\CoreBundle\Service\AriiNotifier $Notify) {
        $this->Notify = $Notify;
    }
    
    public function Notification(FilterResponseEvent $event)
    {
        // On teste si la requête est bien la requête principale (et non une sous-requête)
        if (!$event->isMasterRequest()) {
          return;
        }

        // On récupère la réponse que le gestionnaire a insérée dans l'évènement
        $response = $event->getResponse();

        // Ici on modifie comme on veut la réponse…
        // $response = $this->Notify->displayMessage($response);

        // Puis on insère la réponse modifiée dans l'évènement
        $event->setResponse($response);
        
    }
}

?>
