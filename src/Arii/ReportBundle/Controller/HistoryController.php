<?php

namespace Arii\ReportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HistoryController extends Controller
{

    public function jobsAction()
    {    
        $request = Request::createFromGlobals();
        $jobs = $request->query->get( 'jobs' );  
        
        $em = $this->getDoctrine()->getManager();
        $Jobs = $em->getRepository("AriiReportBundle:RUN")->findJobsByLike($jobs);
        foreach ($Jobs as $Job) {
            $start = $Job->getStartTime()->format('Y-m-d H:i:s');
            $ds = $Job->getStartTime();
            $de = $Job->getEndTime();
            if (!$de) continue;
            $run_time = $de->diff($ds); 
            
            print $Job->getJobName();
            print "\t$start\t".$run_time->h;
            print "\n";
            
        }
        exit();
    }
}

