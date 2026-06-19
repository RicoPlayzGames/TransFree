<?php 

class UploadController {
    private $uploadService;
    private $config;

    public function __construct($db) {
        // Maak een nieuwe uploadservice aan en laad de configuratie
        $this->uploadService = new UploadService($db);
        $this->config = require __DIR__ . "/../../config/Config.php";
    }

    public function uploadFile() {
        // Haal de gegevens op uit het formulier
        $userId = $_SESSION["user_id"];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $file = $_FILES['file'];
        try {
            // Sla het bestand op en krijg een unieke code terug
            $token = $this->uploadService->uploadFile(
                $userId,
                $title,
                $description,
                $file
            );

            // Maak de downloadlink aan met de unieke code
            $downloadUrl = $this->config['base_path'] . "/download/" . $token;

            $message = 'File uploaded successfully. Use the download URL below.';
            require __DIR__ . "/../../views/notifications/upload-success.php";
        } catch (Exception $e) {
            $error = $e->getMessage();
            require __DIR__ . "/../../views/notifications/upload-error.php";
        }
    }
}