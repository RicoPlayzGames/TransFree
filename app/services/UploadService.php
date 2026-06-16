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
    }
}