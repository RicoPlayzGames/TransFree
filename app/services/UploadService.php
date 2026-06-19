<?php
class UploadService {
    private $db;

    public function __construct($db) {
        // Sla de databaseverbinding op
        $this->db = $db;
    }

    public function uploadFile($userId, $title, $description, $file) {
        $uploadPath = __DIR__ . "/../../public/uploads/";
        $uploadName = uniqid() . "_" . basename($file["name"]);
         
        // unieke token maken
        $token = bin2hex(random_bytes(16));
        
        // Verplaats het bestand van de tijdelijke map naar de uploadmap
        move_uploaded_file($file["tmp_name"], $uploadPath . $uploadName);

        // hash het bestand voor integriteit
        $fileHash = hash_file('sha256', $uploadPath . $uploadName);

        // Sla alle gegevens op in de database
        $this->db->queryDatabase(
            "INSERT INTO uploads (user_id, title, description, filename, file_hash, token, created_at)
            VALUES (:user_id, :title, :description, :filename, :file_hash, :token, NOW())",
            [
                'user_id' => $userId,
                'title' => $title,
                'description' => $description,
                'filename' => $uploadName,
                'file_hash' => $fileHash,
                'token' => $token
            ]
        );

        // return token voor download url
        return $token;
    }
}