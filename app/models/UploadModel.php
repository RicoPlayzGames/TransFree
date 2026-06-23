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

    // Stat s voor homepage
    public function getStats() {
        $files = $this->db->queryDatabase("
            SELECT COUNT(*) AS total_files
            FROM uploads
        ")->fetch();

        $users = $this->db->queryDatabase("
            SELECT COUNT(*) AS total_users 
            FROM users
        ")->fetch();

        $folderSize = $this->getUploadsSize(__DIR__ . "/../../public/uploads");

        return [
            'total_files' => $files['total_files'] ?? 0,
            'total_users' => $users['total_users'] ?? 0,
            'total_bytes' => $folderSize
        ];
    }

    public function getUploadsSize($path) {
        $size = 0;

        if (!is_dir($path)) {
            return 0;
        }

        foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path)) as $file) {
            if ($file->isFile()) {
                $size += $file->getSize();
            }
        }

        return $size;
    }
}