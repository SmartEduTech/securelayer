<?php
namespace Smartedutech\Securelayer\Log;

class DBAgentLog {
    public static function DBSaveLogMessage($message) {
        // Modify this method to save the log message in your database table
        $host = '127.0.0.1';
        $dbname = 'bdlogs';
        $username = 'root';
        $password = '';

        try {
            $pdo = new \PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
            $query = "INSERT INTO logs (message) VALUES (?)";
            $statement = $pdo->prepare($query);
            $statement->execute([$message]);
            $pdo = null; // Close the database connection
        } catch (\PDOException $e) {
            echo "Database connection error: " . $e->getMessage();
        }
    }
}
