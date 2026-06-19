<?php 

class DownloadService {
    private $db;

    // connect database
    public function __construct($db) {
        $this->db = $db;
    }

    public function getFileDownload($token) {
        // Map waar bestanden worden opgeslagen
        $uploadPath = __DIR__ . "/../../public/uploads/";

        // haal file hash op uit de database
        $record = $this->db->queryDatabase(
            "SELECT filename, file_hash FROM uploads WHERE token = :token",
            [
                'token' => $token
            ]
        )->fetch();

        // als er niks is fout geven
        if (!$record) {
            throw new Exception('File not found.');
        }

        $filePath = $uploadPath . $record['filename'];

        if (!file_exists($filePath)) {
            throw new Exception('File is deleted or no longer exists on the server.');
        }

        // hash bij het bestand maken
        $currentHash = hash_file('sha256', $filePath);

        // gebruik hash equals om de hashes te vergelijken
        if (!hash_equals($record['file_hash'], $currentHash)) {
            throw new Exception('File is not the same (integrety check failed).');
        }

        // returnen
        return [
            'path' => $filePath,
            'filename' => $record['filename']
        ];
    }
}