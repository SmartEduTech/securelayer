<?php


namespace Smartedutech\Securelayer\Analyser;

use Smartedutech\Securelayer\Filters\FilterDatas;
use Smartedutech\Securelayer\Strategy\SecureStrategy;

class StrategyAnalyser{
    private $_SecureStrategy;
    public function __construct(string $file="")
    {
        $this->_SecureStrategy=new SecureStrategy($file);
    }
    public function run(){
        //testé si on a une stratégie de securité ou pas dans l'action
        $strategyAction=$this->_SecureStrategy->getStrategyForAction();
        if(isset($strategyAction['datas'])){
            foreach($strategyAction['datas'] as $key => $value){
                if(isset($_REQUEST[$key])){
                    FilterDatas::filter($value,$_REQUEST[$key]); 
                } 
            }
        }
    }
}