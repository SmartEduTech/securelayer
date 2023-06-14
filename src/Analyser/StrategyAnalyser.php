<?php


namespace Smartedutech\Securelayer\Analyser;

use Smartedutech\Securelayer\Filters\FilterDatas;
use Smartedutech\Securelayer\Strategy\SecureStrategy;
use Smartedutech\Securelayer\Watchdog\WatchDog;

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
        $strategyData=isset($strategyAction['datas']) ? $strategyAction['datas'] :"";
        $this->DataAnalyse($strategyAction['datas']); 
        $strategyWD=isset($strategyAction['watchdog']) ? $strategyAction['watchdog'] :"";
        $this->_WatchDog->run($strategyWD);
    }

    public function DataAnalyse($strategyData){
        if(!empty($strategyData) && is_array($strategyData)>0){
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