<?php
namespace Arii\CoreBundle\EventDispatcher;

use Symfony\Component\EventDispatcher\Event;

class MessageEvent extends Event
{
    protected $Msg = null;

    public function setMsg($Msg)
    {
        $this->Msg = $Msg;
    }

    public function getMsg() {
        return $this->Msg;
    }
    
}
