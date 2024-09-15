<?php

namespace Components;

use PDO;
use PDOException;

class DB
{
    private static $instance = null;
    private $connection;

    private $host;
    private $dbName;
    private $username;
    private $password;
    private $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    public function __construct()
    {
        $this->username = getenv('DB_USERNAME');
        $this->password = getenv('DB_PASSWORD');
        $this->dbName = getenv('DB_NAME');
        $this->host = getenv('DB_HOST');
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbName . ';charset=utf8';

        try {
            $this->connection = new PDO($dsn, $this->username, $this->password, $this->options);
        } catch (PDOException $e) {
            // Handle the exception as needed
            throw new \Exception('Database connection error: ' . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }
}