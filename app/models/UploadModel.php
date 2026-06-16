<?php

class UploadModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getUploadById($id) {
        return $this -> db-> queryDatabase(
            "SELECT * FROM uploads WHERE id = :id",
            ['id' => $id]
        )->fetch();
    }
}