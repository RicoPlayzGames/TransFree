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
        // Basic validation
        if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
            throw new Exception('No file selected.');
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('Upload failed (file could not be uploaded).');
        }

        // Optional: limit file size (5MB) and allowed types (PNG)
        if ($file['size'] > 5 * 1024 * 1024) {
            throw new Exception('File is too large. Maximum 5 MB allowed.');
        }

        $allowed = ['image/png'];
        if (!in_array($file['type'], $allowed)) {
            throw new Exception('Invalid file type. Only PNG files are allowed.');
        }

        // Verplaats het bestand van de tijdelijke map naar de uploadmap
        if (!is_dir($uploadPath) && !mkdir($uploadPath, 0755, true)) {
            throw new Exception('Upload directory does not exist and could not be created.');
        }

        if (!move_uploaded_file($file["tmp_name"], $uploadPath . $uploadName)) {
            throw new Exception('Could not save the file on the server. Please try again.');
        }

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