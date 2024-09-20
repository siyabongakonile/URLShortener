<?php
declare(strict_types = 1);

require_once 'config.php';

class Database{
    private static ?Database $database;

    private ?PDO $connectionObj;

    private function __construct(){}

    private function __clone(){}

    public static function getDatabase(): Database{
        if(isset(Database::$database))
            return Database::$database;

        Database::$database = new Database();
        Database::$database->connect();
        return Database::$database;
    }

    private function connect(){
        $dsn = DB_PRODUCT_NAME . ':host=' . DB_HOSTNAME . ';dbname=' . DB_NAME; 
        $this->connectionObj = new PDO($dsn, DB_USERNAME, DB_PASSWORD);
    }

    public function close(){
        $this->connectionObj = null;
    }

    private function isValidConnection(){
        if(!is_null($this->connectionObj))
            return true;
        return false;
    }

    public function query(string $sql, array $args){
        $statement = $this->connectionObj->prepare($sql);
        return $statement->execute($args);
    }

    public function fetch(string $sql, array $args){
        $statement = $this->connectionObj->prepare($sql);
        $hasStmtExecuted = $statement->execute($args);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}