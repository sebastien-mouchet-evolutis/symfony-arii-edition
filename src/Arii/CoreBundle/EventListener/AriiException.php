<?php
namespace Arii\CoreBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class AriiException {
    protected $log;
    
    public function __construct(\Arii\CoreBundle\Service\AriiPortal $log) {
        $this->log = $log;
    }
    
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        $response = new Response();
        $message = $this->log->ErrorLog(
            $exception->getMessage(),
            $exception->getCode(),
            $exception->getFile(),
            $exception->getLine(),
            $exception->getTraceAsString()
        );
        
        $response->setContent($message);
        
        if ($exception instanceof HttpExceptionInterface)
        {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        } else
        {
            $response->setStatusCode(500);
        }
        
        $event->setResponse($response);
    }
}

?>
