<?php

namespace Smartedutech\Securelayer\Strategy;

use Smartedutech\Securelayer\Watchdog\ActivityScan;

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

    public function getStrategyForAction(string $paramget=""){ 
        $parsedURI=ActivityScan::getActivity($paramget);
        return $this->_Strategy->getStrategy($parsedURI); 

    }

    
}