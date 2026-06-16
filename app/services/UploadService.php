<?php

class UploadService {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function uploadFile($userId, $title, $description, $file) {
        $uploadPath = __DIR__ . "/../../public/uploads/";
        $uploadName = uniqid() . "_" . basename($file["name"]);

        move_uploaded_file($file["tmp_name"], $uploadPath . $uploadName);

        $this->db->queryDatabase(
            "INSERT INTO uploads (user_id, title, description, filename, created_at)
            VALUES (:user_id, :title, :description, :filename, NOW())",
            [
                'user_id' => $userId,
                'title' => $title,
                'description' => $description,
                'filename' => $uploadName
            ]
        );
    }
}