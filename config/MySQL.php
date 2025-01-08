<?php

require_once __DIR__ . '/ConnectionInterface.php';

class MySQL implements ConnectionInterface {
    private $host;
    private $port;
    private $database;
    private $username;
    private $password;
    private $pdo;

    public function __construct($config) {
        $this->host = $config['host'];
        $this->port = $config['port'];
        $this->database = $config['database'];
        $this->username = $config['username'];
        $this->password = $config['password'];
    }

    public function connect() {
        try {
            $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->database}";
            $this->pdo = new PDO($dsn, $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->pdo;
        } catch (PDOException $e) {
            throw new Exception("MySQL Connection failed: " . $e->getMessage());
        }
    }
}
