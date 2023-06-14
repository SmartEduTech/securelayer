<?php

namespace Smartedutech\Securelayer\WatchDog;

use Smartedutech\Securelayer\Log\AgentLog;

class WatchDog{ 

    public function run(){
        $this->scanActivity();
        $this->scanClient();
    }
    public function analyseAlert(){

    }

    public function scanClient(){
        $client = ClientScan::getClient();
        AgentLog::LogerMessage($client); 
    }

    public function scanActivity(){ 
        AgentLog::LogerMessage(ActivityScan::scanAllInfo());
    }
}