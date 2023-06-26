<?php

namespace Smartedutech\Securelayer\Log;

abstract class MessageLog{

    public static function getMessage($Class,$Func,$Message,$Langue){
 
        if(file_exists(dirname(__FILE__)."/Message/$Class.json")){
            
            $json = file_get_contents(dirname(__FILE__)."/Message/$Class.json");
            $Data=json_decode($json);
            if(isset($Data->$Class->$Func->$Message->$Langue)){
                return $Data->$Class->$Func->$Message->$Langue;
            }else{
                return $Message;
            }
            
        }else{
            return $Message;
        }
       
    }

}