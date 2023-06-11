<?php

namespace Smartedutech\Securelayer\Filters;
use Smartedutech\Securelayer\Log\AgentLog;

abstract class FilterDatas{
    public static $_Langue="FR";
     
    public static function filterEMail($email){
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ""; 
          } else {
            return AgentLog::Loger("FilterDatas","filterEmail","ERREUR_EMail","FR"); 
          }
    }
    public static function filterString(){

    }
/**
 * Filter Int with range
 */
    public static function filterInt($int,$min="",$max=""){
        ///Si c'est un entier
        if(is_numeric($int)){ 
          return  (!empty($int) && !empty($min) && !empty($max) ? self::filterIntRange($int,$min,$max) : (empty($min) &&  !empty($max) ? self::filterIntMax($int,$max) : (!empty($min) &&  empty($max) ? self::filterIntMin($int,$min) : "")));
        }else{
            AgentLog::Loger("FilterDatas","filterInt","Erreur_INT","FR");
        }
       
    }
    private static function filterIntMin($int,$min){
        if(is_numeric($int) && !empty($min)){
            if(filter_var($int, FILTER_VALIDATE_INT, array("options" => array("min_range"=>$min)))){
               return "";
            }else{
                AgentLog::Loger("FilterDatas","filterInt","Erreur_Interval",self::$_Langue);    
            }
        }else{
            return false;
        }
    }

    private static function filterIntMax($int,$max){
        if(is_numeric($int) && !empty($max)){
            if(filter_var($int, FILTER_VALIDATE_INT, array("options" => array("max_range"=>$max)))){
                return "";
             }else{
                 AgentLog::Loger("FilterDatas","filterInt","Erreur_Interval",self::$_Langue);    
             }        }else{
            return false;
        }
    }
    private static function filterIntRange($int,$min,$max){
        if(is_numeric($int) && !empty($min) && !empty($max) && $min!=0 && $max !=0){
            if(filter_var($int, FILTER_VALIDATE_INT, array("options" => array("min_range"=>$min, "max_range"=>$max)))){
                return "";
             }else{
                 AgentLog::Loger("FilterDatas","filterInt","Erreur_Interval",self::$_Langue);    
             } 
        }else{
            return false;
        }
    }
}