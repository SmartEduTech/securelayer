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
    public static function scanAllInfo() {
        return json_encode(array(
            "status" => self::uriFault(), // Statut de l'URI
            "activity" => self::getActivity(), // Activité de l'utilisateur
            "client" => ClientScan::getClient(), // Informations sur le client
            "temp_requete" => date('d/m/Y H:i:s', $_SERVER["REQUEST_TIME"]), // Date et heure de la requête
            "QUERY_STRING" => $_SERVER['QUERY_STRING'], // Chaîne de requête
            "REQUEST_PARAMS" => $_SERVER['REQUEST_METHOD'], // Paramètres de la requête
            "SERVER_NAME" => $_SERVER['SERVER_NAME'], // Nom du serveur
            "USER_ID" => self::getUserId(), // Identifiant de l'utilisateur
            "PAGE_VISITED" => self::getCurrentPage() // Page visitée
        ));
    }
    
    private static function getUserId() {
        session_start();
        if (isset($_SESSION['user_id'])) {
            return $_SESSION['user_id'];
        } else {
            return "N/A";
        }
    }
    private static function getCurrentPage() {
        if (isset($_SERVER['REQUEST_URI'])) {
            return $_SERVER['REQUEST_URI'];
        } else {
            return "N/A";
        }
    }
    
    public static function logActivity() {
        $logMessage = self::scanAllInfo();
        FileAgentLog::FileSaveLogMessage($logMessage);
        DBAgentLog::DBSaveLogMessage($logMessage);
    }
} 