<?php

namespace Arii\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class CronController extends Controller
{
    
   public function execAction()
    {
        $em = $this->getDoctrine()->getManager();
        $now = new \DateTime();
        
        // Remplir les next_start
       $Tasks = $em->getRepository("AriiCoreBundle:Cron")->findTaskToExecute($now);
       
       require_once('../vendor/autoload.php');

       $response = new Response();       
       foreach ($Tasks as $Task) {
                      
            $schedule = implode(' ',array(
                    $Task->getMinutes(),
                    $Task->getHours(),
                    $Task->getMonthDays(),
                    $Task->getMonths(),
                    $Task->getWeekDays(),
                    $Task->getYears() ) );
            $cron = \Cron\CronExpression::factory($schedule);
            
            $next_run = $Task->getNextRun();
            if ($next_run!='') {
                // Appel de la page
                // $uri =  $this->generateUrl($Task->getUrl());
                $uri =  $Task->getUrl();
                set_time_limit(300);
                $start = microtime(true);
                $content = file_get_contents($uri);
                if ($content === false)
                    throw new \Exception('ARI',4);

                // Message ?
                if (($p=strpos($content,'{{MESSAGE '))>0) {
                    $p+=10;
                    $e = strpos($content,'}}',$p);
                    $message = substr($content,$p,$e-$p);
                }
                else {
                    $message = '';
                }
                
                $History = new \Arii\CoreBundle\Entity\CronHistory();
                $History->setCron($Task);
                $History->setDone(new \DateTime());
                $History->setStatus($status);
                $History->setMessage($message);
                $History->setDuration(microtime(true)-$start);
                $em->persist($History);
            }
            $next_run = $cron->getNextRunDate()->format('Y-m-d H:i:s');
            $Task->setNextRun(new \DateTime($next_run));                
            
            $em->persist($Task);
            $em->flush();
        }
        $response->setContent( 'SUCCESS' );
        return $response;
    }

/* Appels internes ?
$router = $this->container->get('router');
$route = $router->getRouteCollection()->all();
print_r($route);

$controllerAction = $route->getDefault('_controller');
print $controllerAction;
 */
}
