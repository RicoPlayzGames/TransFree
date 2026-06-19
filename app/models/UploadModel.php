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

    // Haal alle uploads op voor een bepaalde gebruiker
    public function getUploadsByUser($userId) {
        return $this->db->queryDatabase(
            "SELECT * FROM uploads WHERE user_id = :user_id ORDER BY created_at DESC",
            ['user_id' => $userId]
        )->fetchAll();
    }

    // Werk titel en beschrijving bij voor een upload (eigenaarcontrole op user_id)
    public function updateUploadById($id, $title, $description, $userId) {
        return $this->db->queryDatabase(
            "UPDATE uploads SET title = :title, description = :description WHERE id = :id AND user_id = :user_id",
            [
                'id' => $id,
                'title' => $title,
                'description' => $description,
                'user_id' => $userId
            ]
        );
    }

    // Verwijder een upload (DB) voor een gegeven gebruiker
    public function deleteUploadById($id, $userId) {
        return $this->db->queryDatabase(
            "DELETE FROM uploads WHERE id = :id AND user_id = :user_id",
            [
                'id' => $id,
                'user_id' => $userId
            ]
        );
    }
}