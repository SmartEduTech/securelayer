<?php
namespace Smartedutech\Securelayer\Watchdog;

use Smartedutech\Securelayer\Log\DBAgentLog;

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
}

