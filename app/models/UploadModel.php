<?php

class UploadModel {
    private $db;

    public function __construct($db) {
                // Sla de databaseverbinding op
        $this->db = $db;
    }
    // Zoek een upload op via het ID
    public function getUploadById($id) {
        return $this -> db-> queryDatabase(
            "SELECT * FROM uploads WHERE id = :id",
            ['id' => $id]
        )->fetch();
    }
    // Zoek een upload op via de unieke code
    public function getUploadByToken($token) {
        return $this->db->queryDatabase(
            "SELECT * FROM uploads WHERE token = :token",
            [
                "token" => $token
            ]
        )->fetch();
    }
}