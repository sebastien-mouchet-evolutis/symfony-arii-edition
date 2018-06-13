<?php
namespace Arii\CoreBundle\Service;
use Symfony\Component\HttpFoundation\Response;

class AriiRender
{
    protected $Colors;
    
    public function __construct(AriiPortal $portal) {
        $this->Colors=$portal->getColors();
    }

    /********************************
     * GRID
     */
    public function grid($Data,$fields='*',$color='color') {
        $xml = "<?xml version='1.0' encoding='iso-8859-1'?>";
        $xml .= '<rows>';
        $xml .= '<head><afterInit><call command="clearAll"/></afterInit></head>';        
        $Plus = $Fields = array(); // Informations complementaires   

        foreach ($Data as $id => $Line ) {            
            if (isset($Line['id']))
                $xml .= '<row id="'.$Line['id'].'"';
            else
                $xml .= '<row';
            if (isset($Line[$color])) {
                $col = $Line[$color];
                if (isset($this->Colors[$col])) {
                    $xml .= ' bgColor="'.$this->Colors[$col]['bgcolor'].'"';
                    if (($this->Colors[$col]['color']!='black') and ($this->Colors[$col]['color']!='#000000')) {
                        $xml .= ' style="color: '.$this->Colors[$col]['color'].'"';
                    }
                }
            }
            $xml .= '>';
            list($Fields,$Plus) = $this->getFields($fields,$Data);
            foreach ($Fields as $k) {
                if (isset($Line[$k])) {
                    $xml .= '<cell>'.$this->Cell($Line[$k]).'</cell>';
                }
                elseif ($k=='+') {
                    $id = $Line['id'];
                    $xml .= '<cell>'.$this->Cell($Plus[$id]).'</cell>';
                }
                else 
                    $xml .= '<cell/>';
            }
            $xml .= '</row>';
        }
        $xml .= '</rows>';
        
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');        
        $response->setContent( $xml );
        return $response;            
    }

    /********************************
     * TREE
     */    
    public function tree($Data) {

        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');        
        $xml = '<tree id="0">';        

        if ($Data) {
            $tree = $this->buildTree($Data, 'parent_id', 'id');        
            $xml .= $this->tree2Items($tree);
        }
        
        $xml .= '</tree>';
        $response->setContent( $xml );
        return $response;        
    }

    /********************************
     * FORM
     */    
    public function form($Data,$fields='*') {
        $xml = "<?xml version='1.0' encoding='iso-8859-1'?>";
        $xml .= '<data>';

        if (isset($Data[0])) $Data=$Data[0];
        
        if (!empty($Data)) {
            // Champs
            $Fields = array();
            foreach (explode(',',$fields) as $f) {
                if ($f=='*') {
                    foreach(array_keys($Data) as $k) {
                        array_push($Fields,$k);
                    }
                }
                else {
                    array_push($Fields,$f);
                }
            }

            foreach ($Fields as $k) {            
                if ($Data[$k] instanceof \DateTime) {                    
                    $val = $Data[$k]->format('Y-m-d H:i:s');
                    if ($val == '1970-01-01 00:00:00')
                        $xml .= '<'.$k.'/>';
                    else 
                        $xml .= '<'.$k.'>'.$val.'</'.$k.'>';
                }
                elseif (isset($Data[$k]) and !(is_array($Data[$k])))
                    $xml .= '<'.$k.'><![CDATA['.$Data[$k].']]></'.$k.'>';
                else 
                    $xml .= '<'.$k.'/>';
            }        
        }
        $xml .= '</data>';
        
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');        
        $response->setContent( $xml );
        return $response;            
    }
    
    /********************************
     * SELECT
     */
    public function select($Data,$fields='id,title',$selected='') {

        $xml = "<?xml version='1.0' encoding='iso-8859-1'?>";
        $xml .= '<data>';
        $xml .= '<item value="" label=""/>';
        $Plus = array(); // Informations complementaires
        foreach ($Data as $Line ) {
            if (!isset($Fields)) {
                list($Fields,$Plus) = $this->getFields($fields,$Data);
                $id = $Fields[0];
                if (isset($Fields[1]))
                    $name = $Fields[1];
                else
                    $name = $id;
            }
                        
            $xml .= '<item value="'.$Line[$id].'" label="';
            if (isset($Line[$name]))
                $xml .= $Line[$name];
            if ($Line[$id]==$selected)
                $xml .= '" selected="true';
            $xml .= '"/>';
        }
        $xml .= '</data>';
        
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');        
        $response->setContent( $xml );
        return $response;            
    }

    /********************************
     * PIE
     */    
    public function pie($Data) {
        $pie = '<data>';
        foreach ($Data as $k=>$v) {
            if ($k=='') continue;
            if (isset($this->Colors[$k]['bgcolor']))
                $color=$this->Colors[$k]['bgcolor'];
            else
                $color='#ffffff';
            $pie .= '<item id="'.$k.'"><NAME>'.$k.'</NAME><NB>'.$v.'</NB><COLOR>'.$color.'</COLOR></item>';
        }
        $pie .= '</data>';
        
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml');
        $response->setContent( $pie );
        return $response;
    }
    
    /********************************
     * PRIVATE !
     */           
    private function getFields($fields,$Data) {

        if (empty($Data)) return;

        $Line = array_keys($Data);
        $Fields = $Plus = array();
        foreach (explode(',',$fields) as $f) {
            if ($f=='*') {
                foreach(array_keys($Line) as $k) {
                    if ($k!='id')
                        array_push($Fields,$k);
                }
            }
            elseif (substr($f,0,1)=='/') {
                array_push($Fields,'+');
                $Plus = $this->Tree2Line($Data);
            }
            else {
                array_push($Fields,$f);
            }
        }
        return array($Fields,$Plus);
    }

    private function Tree2Line($Tree) {
        $Cat = array();
        $Label = array( 0 => '' );
        foreach ($Tree as $line) {
            $id = $line['id'];
            $name = $line['title'];
            $category = $line['parent_id'];
            if ($category=="") $category=0;
            $Cat[$id] = $category;
            $Label[$id] = $name;     
        }

        $List = array();
        foreach ($Label as $k=>$v) {
            $label = $v;
            $cat = $k;
            while (isset($Cat[$cat])) {
                $c = $Cat[$cat];
                if (isset($Label[$c]))
                    $label = $Label[$c]."/$label";
                else 
                    $label = "[$c]/$label";
                $cat = $c;
            }
            $List[$k] = $label;
        }
        return $List;
    }
    private function tree2Items($tree) {
        $xml = '';
        foreach ($tree as $leaf) {
            $xml .= '<item id="'.$leaf['id'].'" text="'.$leaf['title'].'"';
            if (isset($leaf['children'])) {
                 $xml .= '>';
                $xml .= $this->tree2Items($leaf['children']);
                $xml .= '</item>';
            }
            else {
                $xml .= '/>';
            }
        }
        return $xml;
    }
    
    private function buildTree($flat, $pidKey, $idKey = null)
    {
        $grouped = array();
        foreach ($flat as $sub){
            $grouped[$sub[$pidKey]][] = $sub;
        }

        $fnBuilder = function($siblings) use (&$fnBuilder, $grouped, $idKey) {
            foreach ($siblings as $k => $sibling) {
                $id = $sibling[$idKey];
                if(isset($grouped[$id])) {
                    $sibling['children'] = $fnBuilder($grouped[$id]);
                }
                $siblings[$k] = $sibling;
            }

            return $siblings;
        };

        $tree = $fnBuilder($grouped[0]);

        return $tree;
    }
   
    private function cell($value) {
        if (is_a($value, 'DateTime'))
            return $value->format('Y-m-d H:i:s');
        $value = str_replace('<','&lt;',$value);
        if (!is_numeric($value)) {
            $value = '<![CDATA['.$value.']]>';
        }
        return $value;
    }
    
}
