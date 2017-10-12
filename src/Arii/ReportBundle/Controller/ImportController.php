<?php

namespace Arii\ReportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ImportController extends Controller
{
    public function indexAction()
    {
        return $this->render('AriiReportBundle:Import:index.html.twig' );
    }

    public function getAction($get='')
    {
        $request = Request::createFromGlobals();
        if ($request->query->get( 'get' )!='') {
            $get = $request->query->get( 'get' );
        }
        
        // A rendre generique !!
        $connector = $get;
        
        $import = $this->container->get('report_import.'.$connector);
        $result = $import->Import();
        print "<pre>";
        print $result;
        exit();
    }

}
