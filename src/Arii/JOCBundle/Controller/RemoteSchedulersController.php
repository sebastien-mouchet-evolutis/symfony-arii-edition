<?php

namespace Arii\JOCBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class RemoteSchedulersController extends Controller {
    
    protected $ColorStatus = array (
            'CONNECTED' => '#ccebc5',
            'DISCONNECTED' => '#FF0000'
          );
    
    public function indexAction()
    {
        return $this->render("AriiJOCBundle:RemoteSchedulers:index.html.twig");
    }

   public function  toolbarAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        return $this->render('AriiJOCBundle:RemoteSchedulers:grid_toolbar.xml.twig',array(), $response );
    }

    public function formAction()
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        return $this->render('AriiJOCBundle:RemoteSchedulers:form.json.twig',array(), $response );
    }

    public function gridAction()
    {
        $db = $this->container->get('arii_core.db');
        $data = $db->Connector('data');
        
        $sql = $this->container->get("arii_core.sql");
        $date = $this->container->get("arii_core.date");
        $qry = $sql->Select(array('fs.NAME as SUPERVISOR','frs.ID','frs.NAME','frs.HOSTNAME','frs.IP','frs.PORT','frs.VERSION'))
            .$sql->From(array('JOC_REMOTE_SCHEDULERS frs'))
            .$sql->LeftJoin('JOC_SPOOLERS fs', array('frs.SPOOLER_ID','fs.ID'))
            .$sql->OrderBy(array('fs.NAME','frs.NAME'));
        
        $res = $data->sql->query( $qry );
        
        $list = '<?xml version="1.0" encoding="UTF-8"?>';
        $list .= "<rows>\n";
        $list .= '<head>
            <afterInit>
                <call command="clearAll"/>
            </afterInit>
        </head>';
        while ($line = $data->sql->get_next($res)) {
            // on cacule la couleur
            $status = 'connected';
            if (isset($this->ColorStatus[$status]))
                $color=$this->ColorStatus[$status];
            else 
                $color='white';
            $list .= '<row id="'.$line['ID'].'" bgColor="'.$color.'">';
            $list .= '<cell>'.$line['SUPERVISOR'].'</cell>';
            $list .= '<cell>'.$line['NAME'].'</cell>';
            $list .= '<cell>'.$line['HOSTNAME'].'</cell>';
            $list .= '<cell>'.$line['IP'].'</cell>';
            $list .= '<cell>'.$line['PORT'].'</cell>';
            $list .= '<cell>'.$line['VERSION'].'</cell>';
            $list .= '</row>';
        }
        $list .= "</rows>\n";
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        $response->setContent( $list );
        return $response;
    }

    public function pieAction() {        

        $request = Request::createFromGlobals();

        $state = $this->container->get('arii_joc.state');
        $Spoolers = $state->RemoteSchedulers();
        $State = array('CONNECTED' => 0,'DISCONNECTED'=>0);
        foreach ($Spoolers as $k=>$spooler) {
            $state = $spooler['STATUS'];
            if (isset($State[$state])) 
                $State[$state]++;
            else 
                $State[$state]=1;
        }
        
        $pie = '<data>';
        // ksort($State);
        foreach (array_keys($State) as $k) {
            if (isset($this->ColorStatus[$k])) 
                $color = $this->ColorStatus[$k];
            else
                $color = 'black';
            $pie .= '<item id="'.$k.'"><STATUS>'.$k.'</STATUS><JOBS>'.$State[$k].'</JOBS><COLOR>'.$color.'</COLOR></item>';
        }
        $pie .= '</data>';
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        $response->setContent( $pie );
        return $response;
    }
    
}

?>
