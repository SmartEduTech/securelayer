<?php
namespace Smartedutech\Securelayer\Watchdog;

use Smartedutech\Securelayer\Log\DBAgentLog;
use GeoIp2\Database\Reader;

abstract class ClientScan
{
    public static function getClient()
    {
        return json_encode([
            "REMOTE_ADDR" => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '',  // Adresse IP du client
            "HTTP_USER_AGENT" => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '',  // User Agent du client (navigateur, système d'exploitation, etc.)
            "HTTP_ACCEPT_LANGUAGE" => isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : '',  // Langue préférée du client
            "HTTP_AUTHORIZATION" => isset($_SERVER['HTTP_AUTHORIZATION']),  // Autorisation HTTP du client
            "HTTP_REFERER" => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '',  // URL de la page précédente depuis laquelle l'utilisateur a été redirigé
            "HTTP_X_FORWARDED_FOR" => isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : '',  // Adresse IP du client si le serveur est derrière un proxy
            "REMOTE_PORT" => isset($_SERVER['REMOTE_PORT']) ? $_SERVER['REMOTE_PORT'] : ''  // Port du client
        ]);
    }
    public static function geoLocalisation(){
        $reader = new Reader(dirname(__FILE__).'/../../refdb/GeoIP2-City.mmdb');

        // Get information from the IP address
        $address =  $_SERVER['REMOTE_ADDR'];//"102.156.31.244";
        $record = $reader->city($address);
        return json_encode([
            "country"=>$record->country->name
            ,"city"=>$record->city->name

        ]);
         
    }
}

