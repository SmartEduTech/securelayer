<?php

namespace Smartedutech\Securelayer\WatchDog;

abstract class ClientScan{ 
    public static function getClient(){ 
        return json_encode(array(
            "REMOTE_ADDR"=>$_SERVER['REMOTE_ADDR'] 
            ,"REMOTE_USER"=>$_SERVER['REMOTE_USER'] 
            ,"REMOTE_USER"=>$_SERVER['REMOTE_USER'] 
        ));  
    }
}