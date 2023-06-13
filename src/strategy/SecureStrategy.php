<?php

namespace Smartedutech\Securelayer\Strategy;

class SecureStrategy{
    public  $_Strategy;
    public function __construct(string $File="")
    {
        $this->_Strategy= new SecureStrategyLoader($File);
       
        
    }

    public function LogStrategy(){

    }

    public function analyseSecure(){

    }

    public function getStrategyForAction(){
        $url=$_SERVER['REQUEST_URI']; 
        $parsedURI=parse_url($url); 
        return $this->_Strategy->getStrategy($parsedURI['path']); 

    }

    
}