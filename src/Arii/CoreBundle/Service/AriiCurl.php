<?php
// src/Sdz/BlogBundle/Service/AriiSQL.php
 
namespace Arii\CoreBundle\Service;

class AriiCurl
{
    public function __construct(\Arii\CoreBundle\Service\AriiPortal $portal ) {
    }

    public function Version() {
        return curl_version();
    }
    
    public function Get($Info) {        
        return $this->Curl($Info);
    }

    public function Post($Info) {
        $Info['method'] = 'POST';
        return $this->Curl($Info);
    }
    
    private function Curl($Info)
    {   
        if (!isset($Info['host']))     $Info['protocol']='localhost';
        if (!isset($Info['protocol'])) $Info['protocol']='https';
        if (!isset($Info['method']))   $Info['method']='GET';
        if (!isset($Info['port'])) {
            if ($Info['protocol']=='https')
                $Info['port']=443;
            else 
                $Info['port']=80;
        }
        $url = $Info['protocol']."://".$Info['host'].":".$Info['port'].$Info['command'];        
    
        if (!isset($Info['format']))   $Info['format']='text';
        $httpheader = [];
        switch ($Info['format']) {
            case 'json':
                array_push($httpheader, 'Content-Type: application/json');
                break;
        }
        
        $data = '';
        if (isset($Info['data'])) {
            switch ($Info['format']) {
            case 'json':
                $data = json_encode($Info['data']);
                array_push($httpheader, 'Content-Length: ' . strlen($data) );
                break;
            }
        }
        
        $ch = curl_init();
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL,$url);
        if (isset($Info['auth']))
            curl_setopt($ch, CURLOPT_USERPWD, $Info['auth']);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $Info['method']);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
        if ($Info['method']=='POST') {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        //execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            throw new \Exception(curl_error($ch));
        }      
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);        
        
        $Return = [];
        if ($Info['format']=='json') 
            $Return['data'] = json_decode($result, true);
        else
            $Return['data'] = $result;

        // On complète
        $Return['httpcode'] = $httpCode;
        $Return['errno'] = curl_errno($ch);
        $Return['error'] = curl_error($ch);
        
        curl_close($ch);
        return $Return;
    }

}
