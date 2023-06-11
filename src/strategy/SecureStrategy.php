<?php

namespace Smartedutech\Securelayer\Strategy;

class SecureStrategy{

    public function __construct(string $File="")
    {
        $StrategyLoader = new SecureStrategyLoader($File);
        
    }

    
}