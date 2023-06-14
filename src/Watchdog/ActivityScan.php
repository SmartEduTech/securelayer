<?php

namespace Smartedutech\Securelayer\WatchDog;

abstract class ActivityScan{


    public static function getActivity(){
        $url=$_SERVER['REQUEST_URI']; 
        $parsedURI=parse_url($url); 
        return $parsedURI['path'];
    }
}