<?php

class Database {
    private $conn;
    private $config;

    public function __construct($config) {
                // Haal de database instellingen op uit de configuratie
        $this->config = $config['database'];

        $this->getConnection();
    }

    public function getConnection() {
        try {
                        // Maak verbinding met de database
            $this->conn = new PDO(
                "mysql:host={$this->config['host']};dbname={$this->config['dbname']}",
                $this->config['username'],
                $this->config['password'],
                [
                                        // Gooi een foutmelding als er iets misgaat
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                ]
            );
        } catch (PDOException $error) {
                        // Stop de applicatie en toon de foutmelding
            die("Database Connection Error: " . $error->getMessage());
        }

        return $this->conn;
    }

    // Voer een query uit met de meegegeven waardes
    public function queryDatabase($sql, $params = []) {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);

        return $stmt;
    }

        // Geef het ID terug van de laatst ingevoegde rij
    public function lastInsertId() {
        return $this->conn->lastInsertId();
    }
}