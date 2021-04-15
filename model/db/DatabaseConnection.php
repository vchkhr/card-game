<?php

class DatabaseConnection {
    public $connection;

    public function __construct($host, $port, $username, $password, $database)
    {
        try {
            $this->connection = new PDO("mysql:host=$host;dbname=$database", $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e) {
            
        }
    }

    public function __destruct()
    {
        if ($this->connection) {
            $this->connection = null;
        }
    }

    public function getConnectionStatus()
    {
        return ($this->connection) ? true : false;
    }
}
