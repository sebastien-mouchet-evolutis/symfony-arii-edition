<?php

namespace Arii\JIDBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller {

    public function logAction($id=0,$db='')
    {
        $JID = $this->container->get('arii.JID');
        $JID->getTaskLog($id,$db);
        exit();
    }
}
