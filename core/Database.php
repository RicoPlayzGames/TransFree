<?php

class Database {
    private $conn;
    private $config;

    public function __construct($config) {
        $this->config = $config['database'];

        $this->getConnection();
    }

    public function getConnection() {
        try {
            $this->conn = new PDO(
                "mysql:host={$this->config['host']};dbname={$this->config['dbname']}",
                $this->config['username'],
                $this->config['password'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                ]
            );
        } catch (PDOException $error) {
            die("Database Connection Error: " . $error->getMessage());
        }

        return $this->conn;
    }

    public function queryDatabase($sql, $params = []) {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);

        return $stmt;
    }

    public function lastInsertId() {
        return $this->conn->lastInsertId();
    }
}