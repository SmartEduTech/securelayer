<?php

namespace Smartedutech\Securelayer\Watchdog;

abstract class ClientScan{ 
    public static function getClient(){ 
        return json_encode(array(
            "REMOTE_ADDR"=>$_SERVER['REMOTE_ADDR'] 
            ,"HTTP_USER_AGENT"=>$_SERVER['HTTP_USER_AGENT'] 
            ,"HTTP_ACCEPT_LANGUAGE"=>$_SERVER['HTTP_ACCEPT_LANGUAGE'] 
            ,"HTTP_AUTHORIZATION"=>$_SERVER['HTTP_AUTHORIZATION'] 
        ));  
    }
}