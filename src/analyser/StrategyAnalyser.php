<?php


namespace Smartedutech\Securelayer\Analyser;

use Smartedutech\Securelayer\Filters\FilterDatas;
use Smartedutech\Securelayer\Strategy\SecureStrategy;
use Smartedutech\Securelayer\WatchDog\WatchDog;

class StrategyAnalyser{
    private $_SecureStrategy;
    private $_WatchDog;
    public function __construct(string $file="")
    {
        $this->_SecureStrategy=new SecureStrategy($file);
        $this->_WatchDog=new WatchDog();
    }
    public function run(string $paramget=""){
        //testé si on a une stratégie de securité ou pas dans l'action
        $strategyAction=$this->_SecureStrategy->getStrategyForAction($paramget);
        $this->DataAnalyse($strategyAction['datas']); 
        $this->_WatchDog->run($strategyAction['watchdog']);
    }

    public function DataAnalyse($strategyData){
        if(isset($strategyData)){
            foreach($strategyData as $key => $value){
                if(isset($_REQUEST[$key])){
                    FilterDatas::filter($value,$_REQUEST[$key]); 
                } 
            }
        }
    }

    public function watchdogAnalyse($strategyWatch){
        
    }
}