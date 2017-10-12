<?php

namespace Arii\ReportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DatabaseController extends Controller
{
    public function indexAction()
    {
        return $this->render('AriiReportBundle:Database:index.html.twig' );
    }

    public function checkAction()
    {
        $Check = $Backup = array();
        
        $em = $this->getDoctrine()->getManager();

        $Jobs = $em->getRepository("AriiReportBundle:JOB")->findLast();
        if ($Jobs) {
            $Check['Jobs']['count'] = $Jobs[0]['NB']; 
            $Check['Jobs']['last'] = $Jobs[0]['lastUpdate']; 
            $Check['Jobs']['days'] = round((time() - strtotime($Jobs[0]['lastUpdate']))/(24*3600));
        }
        else {
            $Check['Jobs']['count'] = -1; 
        }

        $JobDays = $em->getRepository("AriiReportBundle:JOBDay")->findLast();
        if ($JobDays) {
            $Check['JobDays']['count'] = $JobDays[0]['NB']; 
            $Check['JobDays']['last'] = $JobDays[0]['lastUpdate']; 
            $Check['JobDays']['days'] = round((time() - strtotime($JobDays[0]['lastUpdate']))/(24*3600));
        }
        else {
            $Check['JobDays']['count'] = -1; 
        }
/*        
        $JobMonths = $em->getRepository("AriiReportBundle:JOBMonth")->findLast();
        if ($JobMonths) {
            $Check['JobMonths']['count'] = $JobMonths[0]['NB']; 
            $Check['JobMonths']['last'] = $JobMonths[0]['lastUpdate']; 
            $Check['JobMonths']['days'] = round((time() - strtotime($JobMonths[0]['lastUpdate']))/(24*3600));
        }
        else {
            $Check['JobMonths']['count'] = -1; 
        }
*/        
        $Runs = $em->getRepository("AriiReportBundle:RUN")->findLast();
        if ($Runs) {
            $Check['Runs']['count'] = $Runs[0]['NB']; 
            $Check['Runs']['last'] = $Runs[0]['lastUpdate']; 
            $Check['Runs']['days'] = round((time() - strtotime($Runs[0]['lastUpdate']))/(24*3600));
        }
        else {
            $Check['Runs']['count'] = -1; 
        }

        $RunHours = $em->getRepository("AriiReportBundle:RUNHour")->findLast();
        if ($RunHours) {
            $Check['RunHours']['count'] = $RunHours[0]['NB']; 
            $Check['RunHours']['last'] = $RunHours[0]['lastUpdate']; 
            $Check['RunHours']['days'] = round((time() - strtotime($RunHours[0]['lastUpdate']))/(24*3600));
        }
        else {
            $Check['RunHours']['count'] = -1; 
        }
        
        $RunDays = $em->getRepository("AriiReportBundle:RUNDay")->findLast();
        if ($JobDays) {
            $Check['RunDays']['count'] = $RunDays[0]['NB']; 
            $Check['RunDays']['last'] = $RunDays[0]['lastUpdate']; 
            $Check['RunDays']['days'] = round((time() - strtotime($RunDays[0]['lastUpdate']))/(24*3600));
        }
        else {
            $Check['RunDays']['count'] = -1; 
        }
/*
        $RunMonths = $em->getRepository("AriiReportBundle:RUNMonth")->findLast();
        if ($RunMonths) {
            $Check['RunMonths']['count'] = $RunMonths[0]['NB']; 
            $Check['RunMonths']['last'] = $RunMonths[0]['lastUpdate']; 
            $Check['RunMonths']['days'] = round((time() - strtotime($RunMonths[0]['lastUpdate']))/(24*3600));
        }
        else {
            $Check['RunMonths']['count'] = -1; 
        }
*/        
        $BkpRef = $em->getRepository("AriiReportBundle:BKP_REF")->findLast();
        if ($BkpRef) {
            $Backup['BkpRef']['count'] = $BkpRef[0]['NB']; 
            $Backup['BkpRef']['last'] = $BkpRef[0]['lastUpdate']; 
            $Backup['BkpRef']['days'] = round((time() - strtotime($BkpRef[0]['lastUpdate']))/(24*3600));
        }
        else {
            $Backup['BkpRef']['count'] = -1; 
        }

        $BkpBak = $em->getRepository("AriiReportBundle:BKP_BAK")->findLast();
        if ($BkpBak) {
            $Backup['BkpBak']['count'] = $BkpBak[0]['NB']; 
            $Backup['BkpBak']['last'] = $BkpBak[0]['lastUpdate']; 
            $Backup['BkpBak']['days'] = round((time() - strtotime($BkpBak[0]['lastUpdate']))/(24*3600));
        }
        else {
            $Backup['BkpBak']['count'] = -1; 
        }

        $BkpArc = $em->getRepository("AriiReportBundle:BKP_ARC")->findLast();
        if ($BkpArc) {
            $Backup['BkpArc']['count'] = $BkpArc[0]['NB']; 
            $Backup['BkpArc']['last'] = $BkpArc[0]['lastUpdate']; 
            $Backup['BkpArc']['days'] = round((time() - strtotime($BkpArc[0]['lastUpdate']))/(24*3600));
        }
        else {
            $Backup['BkpArc']['count'] = -1; 
        }
        
        return $this->render('AriiReportBundle:Database:check.html.twig', array('Check' => $Check, 'Backup' => $Backup ) );
    }
    
}
