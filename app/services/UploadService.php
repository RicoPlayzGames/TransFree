<?php
class UploadService {
    private $db;

    const MAX_FILE_SIZE = 32 * 1024 * 1024; // 32 MB

    const ALLOWED_EXTENSIONS = [
        'png'  => 'image/png',
        'jpg'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'mp4'  => 'video/mp4',
        'zip'  => 'application/zip',
    ];

    public function __construct($db) {
        // Sla de databaseverbinding op
        $this->db = $db;
    }

    public function uploadFile($userId, $title, $description, $file) {
        if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
            throw new Exception('No file selected.');
        }

        if ($file['error'] === UPLOAD_ERR_INI_SIZE || $file['error'] === UPLOAD_ERR_FORM_SIZE) {
            throw new Exception('File is too large. Maximum 32 MB allowed.');
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('Upload failed (file could not be uploaded).');
        }

        if ($file['size'] > self::MAX_FILE_SIZE) {
            @unlink($file['tmp_name']);
            throw new Exception('File is too large. Maximum 32 MB allowed.');
        }

        if ($file['size'] === 0) {
            @unlink($file['tmp_name']);
            throw new Exception('Uploaded file is empty.');
        }

        if (mb_strlen($title ?? '') > 255) {
            throw new Exception('Title is too long.');
        }
        if (mb_strlen($description ?? '') > 2000) {
            throw new Exception('Description is too long.');
        }

        $originalName = basename($file['name']);
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

        if (!isset(self::ALLOWED_EXTENSIONS[$ext])) {
            throw new Exception('Invalid file type. Only PNG, JPG, MP4 and ZIP files are allowed.');
        }

        // Echte MIME-type server-side detecteren (nooit vertrouwen op $file['type'] van de client)
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $realMime = $finfo->file($file['tmp_name']);

        $expectedMime = self::ALLOWED_EXTENSIONS[$ext];
        $zipMimeVariants = ['application/zip', 'application/x-zip-compressed', 'multipart/x-zip'];

        $mimeOk = ($realMime === $expectedMime)
            || ($ext === 'zip' && in_array($realMime, $zipMimeVariants, true));

        if (!$mimeOk) {
            @unlink($file['tmp_name']);
            throw new Exception('Invalid file type. File content does not match its extension.');
        }

        // Definieer het uploadpad en genereer een unieke, veilige bestandsnaam
        // (extensie komt uit onze eigen whitelist, niet uit user-input)
        $uploadPath = __DIR__ . "/../../public/uploads/";
        $uploadName = bin2hex(random_bytes(16)) . '.' . $ext;

        // unieke token maken voor de downloadlink
        $token = bin2hex(random_bytes(16));

        // Verplaats het bestand van de tijdelijke map naar de uploadmap
        if (!is_dir($uploadPath) && !mkdir($uploadPath, 0755, true)) {
            throw new Exception('Upload directory does not exist and could not be created.');
        }

        if (!move_uploaded_file($file["tmp_name"], $uploadPath . $uploadName)) {
            throw new Exception('Could not save the file on the server. Please try again.');
        }

        // Sanity-check: daadwerkelijke grootte op schijf moet overeenkomen met verwachting
        $actualSize = filesize($uploadPath . $uploadName);
        if ($actualSize === false || $actualSize > self::MAX_FILE_SIZE || $actualSize === 0) {
            @unlink($uploadPath . $uploadName);
            throw new Exception('File validation failed after upload.');
        }

        // hash het bestand voor integriteit
        $fileHash = hash_file('sha256', $uploadPath . $uploadName);

        try {
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

            // voegt en slaat logregel op in de database
            $ipAddress = $_SERVER['REMOTE_ADDR'] ?? null;
            $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? null;
            $browser = $userAgent ? substr($userAgent, 0, 30) : null;
            $content = "Upload: stored_name={$uploadName}; original_name={$originalName}; title=" . ($title ?? '');

            $this->db->queryDatabase(
                "INSERT INTO logs (type, content, user_id, ip_address, browser, created_at)
                VALUES (:type, :content, :user_id, :ip_address, :browser, NOW())",
                [
                    'type' => 'info',
                    'content' => $content,
                    'user_id' => $userId,
                    'ip_address' => $ipAddress,
                    'browser' => $browser
                ]
            );
        } catch (Exception $e) {
            // Voorkom wees-bestanden als de database-opslag faalt
            @unlink($uploadPath . $uploadName);
            throw $e;
        }

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
        if (mb_strlen($title ?? '') > 255) {
            throw new Exception('Title is too long.');
        }
        if (mb_strlen($description ?? '') > 2000) {
            throw new Exception('Description is too long.');
        }

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

        // Verwijder het bestand van de server
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