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
         
        // Genereer een willekeurige unieke code voor de downloadlink
        $token = bin2hex(random_bytes(16));
        
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
                'file_hash' => $fileHash,
                'token' => $token
            ]
        );

        // return token voor download url
        return $token;
    }

    // Haal uploads op voor een gebruiker
    public function listUploadsByUser($userId) {
        return $this->db->queryDatabase(
            "SELECT * FROM uploads WHERE user_id = :user_id ORDER BY created_at DESC",
            ['user_id' => $userId]
        )->fetchAll();
    }

    // Werk metadata bij (titel/beschrijving)
    public function updateMetadata($id, $userId, $title, $description) {
        $this->db->queryDatabase(
            "UPDATE uploads SET title = :title, description = :description WHERE id = :id AND user_id = :user_id",
            [
                'id' => $id,
                'user_id' => $userId,
                'title' => $title,
                'description' => $description
            ]
        );
        return true;
    }

    // Verwijder upload: bestand en database record
    public function deleteUpload($id, $userId) {
        $upload = $this->db->queryDatabase(
            "SELECT * FROM uploads WHERE id = :id AND user_id = :user_id",
            ['id' => $id, 'user_id' => $userId]
        )->fetch();

        if (!$upload) {
            return false;
        }

        $uploadPath = __DIR__ . "/../../public/uploads/" . $upload['filename'];
        if (file_exists($uploadPath)) {
            @unlink($uploadPath);
        }

        $this->db->queryDatabase(
            "DELETE FROM uploads WHERE id = :id AND user_id = :user_id",
            ['id' => $id, 'user_id' => $userId]
        );

        return true;
    }
}