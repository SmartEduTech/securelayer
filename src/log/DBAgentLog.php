<?php 
//include_once dirname(__FILE__)."/mvc/Configuration.php";
namespace Smartedutech\Securelayer\Log;

abstract class DBAgentLog{

    public static function DBSaveLogMessage ($logMessage){
        try {
            $dbh = new \PDO('mysql:host=' . DBConfig::$host . ';dbname=' . DBConfig::$dbName, DBConfig::$user, DBConfig::$password);
            $dbh->exec("set names utf8");

            $stmt = $dbh->prepare("INSERT INTO log_table (log_message) VALUES (:logMessage)");
            $stmt->bindValue(':logMessage', $logMessage);
            $stmt->execute();
        } catch (\PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br/>";
            die();
        }
    }
    

}
