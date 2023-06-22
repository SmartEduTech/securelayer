<?php

namespace Smartedutech\Securelayer\Watchdog;

use Smartedutech\Securelayer\Log\FileAgentLog;
use Smartedutech\Securelayer\Log\DBAgentLog;
abstract class ActivityScan{


    public static function getActivity(string $paramget=""){
        if(!empty($paramget) && isset($_GET[$paramget]) && !empty($_GET[$paramget])){
            return $_GET[$paramget];
        }else{
            $url=$_SERVER['REQUEST_URI']; 
            $parsedURI=parse_url($url); 
            return $parsedURI['path'];
        } 
    } 
    public static function uriFault(){
        $HttpStatus = $_SERVER["REDIRECT_STATUS"]; 
        return $HttpStatus;
    }
    public static function scanAllInfo(){
        return json_encode(array(
            "status"=>self::uriFault()
            ,"activity"=>self::getActivity()
            ,"client"=>ClientScan::getClient()
            ,"temp_requete"=>date('d/m/Y H:i:s', $_SERVER["REQUEST_TIME"])  
            ,"QUERY_STRING"=>$_SERVER['QUERY_STRING']
            ,"SERVER_NAME"=>$_SERVER['SERVER_NAME']
    
             
        ));
    }
    public static function logActivity() {
        $logMessage = self::scanAllInfo();
        FileAgentLog::FileSaveLogMessage($logMessage);
        DBAgentLog::DBSaveLogMessage($logMessage);
    }
} 