<?php

namespace Smartedutech\Securelayer\Strategy;

use Smartedutech\Securelayer\WatchDog\ActivityScan;

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
        $parsedURI=ActivityScan::getActivity();
        return $this->_Strategy->getStrategy($parsedURI); 

    }

    
}