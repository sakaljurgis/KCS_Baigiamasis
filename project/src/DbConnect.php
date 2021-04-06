<?php

namespace KCS;

use PDO;

class DbConnect
{
    /** @var PDO $conn */
    private PDO $conn;
            
    public function __construct(Config $config)
    {
        $dbConfig = $config->get('database');
        $host = $dbConfig['host'];
        $database = $dbConfig['database'];
        
        $this->conn = new PDO("mysql:host=$host;dbname=$database", $dbConfig['user'], $dbConfig['password']);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
    }

    public function getConn(): PDO
    {
        return $this->conn;
    }
}