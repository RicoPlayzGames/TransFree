<?php

class DownloadController {
    private $downloadService;

    // connect db
    public function __construct($db) {
        $this->downloadService = new DownloadService($db);
    }

    public function downloadFile($token) {
        try {
            // haal de file info op
            $file = $this->downloadService->getFileDownload($token);

            // zet headers zodat hij download
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file['filename']) . '"');
            header('Content-Length: ' . filesize($file['path']));

            // stuur het bestand
            readfile($file['path']);
            exit;
        } catch (Exception $e) {
            // toon een gebruiksvriendelijke foutpagina
            http_response_code(404);
            $message = $e->getMessage();
            require __DIR__ . "/../../views/error.php";
        }
    }
}