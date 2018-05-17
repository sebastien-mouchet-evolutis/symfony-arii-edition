<?php
namespace Arii\CoreBundle\EventListener;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Connection;
use Exception;
use Monolog\Logger;



class DBSwitcher {

    private $request;
    private $connection;
    private $logger;

    public function __construct(Request $request, Connection $connection, Logger $logger) {
        $this->request = $request;
        $this->connection = $connection;
        $this->logger = $logger;
    }

    public function onKernelRequest() {
        $site='jobscheduler';
        
//        if ($this->request->attributes->has('_site')) {
//            $site = $this->request->attributes->get('_site');

            $connection = $this->connection;
            $params     = $this->connection->getParams();

            // $db_name = 'br_'.$this->request->attributes->get('_site');
            $db_name='jobscheduler';
            
            // TODO: validate that this site exists
            if ($db_name != $params['dbname']) {
                $this->logger->debug('switching connection from '.$params['dbname'].' to '.$db_name);
                $params['dbname'] = $db_name;
                if ($connection->isConnected()) {
                    $connection->close();
                }
                $connection->__construct(
                    $params, $connection->getDriver(), $connection->getConfiguration(),
                    $connection->getEventManager()
                );

                try {
                    $connection->connect();
                } catch (Exception $e) {
                    // log and handle exception
                }
            }
        }
//    }
}