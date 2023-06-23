<?php

namespace Smartedutech\Securelayer\Watchdog;
use Smartedutech\Securelayer\Log\DBAgentLog;
abstract class ClientScan{ 
    public static function getClient(){ 
        return json_encode(array(
            "REMOTE_ADDR" => $_SERVER['REMOTE_ADDR'],  // Adresse IP du client
            "HTTP_USER_AGENT" => $_SERVER['HTTP_USER_AGENT'],  // User Agent du client (navigateur, système d'exploitation, etc.)
            "HTTP_ACCEPT_LANGUAGE" => $_SERVER['HTTP_ACCEPT_LANGUAGE'],  // Langue préférée du client
            "HTTP_AUTHORIZATION" => isset($_SERVER['HTTP_AUTHORIZATION']),  // Autorisation HTTP du client
            "HTTP_REFERER" => $_SERVER['HTTP_REFERER'],  // URL de la page précédente depuis laquelle l'utilisateur a été redirigé
            "HTTP_X_FORWARDED_FOR" => $_SERVER['HTTP_X_FORWARDED_FOR'],  // Adresse IP réelle du client en cas de proxy
            "EMAIL" => $_POST['email'] , // Adresse de messagerie de l'utilisateur
            "MAC_ADDR" => self::getMacAddress(),  // Adresse MAC du client
            "GEOLOCATION" => self::getGeolocation()  // Informations de géolocalisation du client
        ));
          
    }
    private static function getMacAddress() {
        ob_start();
        system('ipconfig /all');
        $output = ob_get_contents();
        ob_clean();
    
        if (preg_match('/Physical Address.*?:\s*([0-9A-Fa-f]+)/', $output, $matches)) {
            $macAddress = $matches[1];
            return $macAddress;
        }
    
        return '';
    }
    private static function getGeolocation() {
        $geolocation = array(
            "latitude" => "",
            "longitude" => "",
            "accuracy" => ""
        );
    
        if (isset($_SERVER['HTTP_CF_IPCOUNTRY'])) {
            // QT :vous utilisez un service de CDN  qui ajoute le pays dans l'en-tête de la requête
            $geolocation['country'] = $_SERVER['HTTP_CF_IPCOUNTRY'];
        }
    
        if (isset($_SERVER['HTTP_CF_IPCOUNTRY']) && $_SERVER['HTTP_CF_IPCOUNTRY'] !== 'XX') {
            // Si vous avez déjà récupéré le pays via le CDN et qu'il n'est pas inconnu ('XX')
            // Vous pouvez utiliser ce pays pour effectuer d'autres opérations ou vérifications
        } else {
            // Utilisation de l'API de géolocalisation du navigateur
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                // Si l'adresse IP réelle est transmise via un proxy
                $clientIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                // Sinon, utiliser l'adresse IP du client
                $clientIP = $_SERVER['REMOTE_ADDR'];
            }
    
            // Récupération des informations de géolocalisation à l'aide de l'API de géolocalisation HTML5
            if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
                $language = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
            } else {
                $language = 'FR'; // Langue par défaut si non disponible
            }
    
            $url = "https://api.ipgeolocationapi.com/geolocate/$clientIP/$language";
            $response = file_get_contents($url);
    
            if ($response !== false) {
                $data = json_decode($response, true);
                if (isset($data['status']) && $data['status'] === 'success') {
                    $geolocation['latitude'] = $data['geo']['latitude'];
                    $geolocation['longitude'] = $data['geo']['longitude'];
                    $geolocation['accuracy'] = $data['geo']['accuracy'];
                }
            }
        }
    
        return $geolocation;
    }
    
    public static function saveClientInfo() {
        $clientInfo = self::getClient();
        DBAgentLog::DBSaveLogMessage($clientInfo);
    }
}