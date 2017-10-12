<?php

namespace Arii\MFTBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class RestController extends Controller
{

    private function getResponse($Array, $Types="*/*") {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        $response = new Response();
        foreach ($Types as $t) {
            switch($t) {
                case '*/*':
                case 'application/json':                    
                    $response->headers->set('Content-Type', 'application/json');
                    $response->setContent( $serializer->serialize($Array, 'json') );
                    return $response;
                case 'text/xml':
                    $response->headers->set('Content-Type', 'text/xml');
                    $response->setContent( $serializer->serialize($Array, 'xml') );
                    return $response;
            }
        }
        return $response;        
    }
 
    private function getInput($type = 'json') {
        $json = file_get_contents('php://input');
        return json_decode($json,true);
    }
    
    public function getPartnersAction()
    {
        $request = Request::createFromGlobals();

        $history = $this->container->get('arii_mft.mft');
        $Partners = $history->Partners();
        
        $Types = $request->getAcceptableContentTypes();
        return $this->getResponse($Partners,$Types);
    }
    
    public function getStatusAction()
    {
        $request = Request::createFromGlobals();

        $history = $this->container->get('arii_mft.mft');
        $Status = $history->Status();
        
        $Types = $request->getAcceptableContentTypes();
        return $this->getResponse($Status,$Types);
    }
    
    public function getTransfersAction($partner_id=-1)
    {
        $request = Request::createFromGlobals();
        if ($request->query->get('partner_id')>=0)
            $partner_id = $request->query->get('partner_id');

        $history = $this->container->get('arii_mft.mft');
        $Transfers = $history->Transfers($partner_id);

        $Types = $request->getAcceptableContentTypes();
        return $this->getResponse($Transfers,$Types);
    }
    
    public function getOperationsAction($transfer_id=-1)
    {
        $request = Request::createFromGlobals();
        if ($request->query->get('transfer_id')>=0)
            $transfer_id = $request->query->get('transfer_id');

        $history = $this->container->get('arii_mft.mft');
        $Operations = $history->Operations($transfer_id);

        $Types = $request->getAcceptableContentTypes();
        return $this->getResponse($Operations,$Types);
    }
    
    public function getTransmissionsAction($transfer_id=-1)
    {
        $request = Request::createFromGlobals();
        if ($request->query->get('transfer_id')>=0)
            $transfer_id = $request->query->get('transfer_id');

        $history = $this->container->get('arii_mft.mft');
        $Transmissions = $history->Transmissions($transfer_id);

        $Types = $request->getAcceptableContentTypes();
        return $this->getResponse($Transmissions,$Types);
    }
    
    public function postTransmissionAction($transmission='')
    {
        $request = Request::createFromGlobals();
        if ($request->get('transmission')!='')
            $transmission = $request->get('transmission');

        print "$transmission";        
        exit();
    }

    public function putHistoryAction($transfer_id=-1)
    {
        $request = Request::createFromGlobals();
        if ($request->query->get('transfer_id')>0)
            $transfer_id = $request->request->get('transfer_id');
        
        print 'ID: '.$transfer_id."\n";
        
        $transfer = $this->getDoctrine()->getRepository("AriiMFTBundle:Transfers")->find($transfer_id);
        if (!$transfer) {
            $response = new Response();
            $response->setStatusCode(404);
            return $response;
        }
        
        print 'TRANSFER: '.$transfer->getName()."\n";

        $status = $this->getDoctrine()->getRepository("AriiMFTBundle:Status")->findOneBy( array( 'transfer' => $transfer ));
        if (!$status) {
            $response = new Response();
            $response->setStatusCode(404);
            return $response;
        }
        
        $history = $status->getHistory();
        
        // Valeurs 
        $Values = $this->getInput();
        
        $history->setStatusTime( new \DateTime() );        
        foreach ($Values as $k=>$v) {
            switch($k) {
                case 'status':
                    print " $k ".$history->getStatus()." -> $v\n";
                    $history->setStatus($v);
                    break;
            }
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($history);
        $em->flush();
        
        return new Response('success');
    }
    
}

