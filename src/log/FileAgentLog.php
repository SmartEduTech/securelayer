<?php 
namespace Smartedutech\Securelayer\Log;
/**
 * Si l'utilisateur de l'API configure les deux constante
 *  __LOG_LAYERSECURE__ : emplacement de fichier log
 * __LOG_LAYERSECURE__FILENAME__ : nom de fichier log
 * Alors l'api utilisera les definition de l'utilisateur
 * Sinon il va utilisé les deux definition déjà mis dans ce fichier
 * */
defined('__LOG_LAYERSECURE__') || define('__LOG_LAYERSECURE__', dirname(__FILE__)."/../../logs");
defined('__LOG_LAYERSECURE__FILENAME__') || define('__LOG_LAYERSECURE__FILENAME__', "logs.txt");

abstract class FileAgentLog{

    public static function FileSaveLogMessage(string $Message){
        if(!empty($Message)){ 
            $LogFileName=__LOG_LAYERSECURE__."/".__LOG_LAYERSECURE__FILENAME__; 
          
           ///si le fichier existe il s'ouvre en mode append sinon il va etre créer et il s'ouvre en mode ecriture
              $Mode=file_exists($LogFileName)?"a":"w";
              $LogFile = fopen($LogFileName, $Mode); 
              fwrite($LogFile,$Message);
              fclose($LogFile);
            }
    }


}