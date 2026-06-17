<?php
require_once __DIR__ . '/../../core/encryption.php';

class UploadService {
    private $db;

    public function __construct($db) {
        // Sla de databaseverbinding op
        $this->db = $db;
    }

    public function uploadFile($userId, $title, $description, $file) {
        // define alle paths/tokens
        $uploadPath = __DIR__ . "/../../public/uploads/";
        $uploadName = uniqid() . "_" . basename($file["name"]);4
         
        // Genereer een willekeurige unieke code voor de downloadlink
        $key = random_bytes(32); // Genereert 32 random bits
        $token = generateToken(); // Token wordt gegenereerd
        $encryptedToken = encryptToken($token, $key); // Token wordt encrypt

        // Verplaats het bestand van de tijdelijke map naar de uploadmap
        move_uploaded_file($file["tmp_name"], $uploadPath . $uploadName);

        // maak een hash bij de file
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
                'token' => $encryptedToken
            ]
        );

        // return token voor download url
        return $token;
    }
}