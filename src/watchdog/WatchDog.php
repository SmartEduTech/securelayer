<?php

namespace Smartedutech\Securelayer\WatchDog;

use Smartedutech\Securelayer\Log\AgentLog;

class WatchDog{ 

    public function run(string $strategywatchdog){
        $this->scanActivity();
        $this->scanClient();
        $this->analyseAlert($strategywatchdog);
    }
    public function analyseAlert(string $strategywatchdog){

    }

    public function scanClient(){
        $client = ClientScan::getClient();
        AgentLog::LogerMessage($client); 
    }

    public function scanActivity(){ 
        AgentLog::LogerMessage(ActivityScan::scanAllInfo());
    }
}