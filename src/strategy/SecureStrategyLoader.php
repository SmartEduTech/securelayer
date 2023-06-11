<?php

namespace Smartedutech\Securelayer\Strategy;

defined('__STRATEGY_LAYERSECURE__') || define('__STRATEGY_LAYERSECURE__', dirname(__FILE__)."/../../roles");
defined('__STRATEGY_LAYERSECURE__FILENAME__') || define('__STRATEGY_LAYERSECURE__FILENAME__', "strategys.json");

class SecureStrategyLoader{
    private $_Strategy;
    public function __construct(String $File="")
    {
        $this->LoadFileStrategy($File);
    }  
    private function LoadFileStrategy(String $File=""):void{
        $StrategyFileName=!empty($File) ? $File : __STRATEGY_LAYERSECURE__."/".__STRATEGY_LAYERSECURE__FILENAME__; 
    
            if(file_exists($StrategyFileName)){
            $StrategyFile = fopen($StrategyFileName, "r"); 
            $StrategyText=fread($StrategyFile,filesize($StrategyFile));
            $this->_Strategy=json_decode($StrategyText,true);
            fclose($StrategyFile);
           }
           
    }
    public function getStrategy(String $_StrategyName):array{
        if(isset($this->_Strategy[$_StrategyName])){
            return $this->_Strategy[$_StrategyName];
        }
    }


}