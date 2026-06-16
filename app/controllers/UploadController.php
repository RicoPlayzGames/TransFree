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
        $userId = 1;
        $title = $_POST['title'];
        $description = $_POST['description'];
        $file = $_FILES['file'];
        // Sla het bestand op en krijg een unieke code terug
        $token = $this->uploadService->uploadFile(
            $userId, 
            $title, 
            $description, 
            $file
        );
    // Maak de downloadlink aan met de unieke code
        $downloadUrl = $this->config['base_path'] . "/download/" . $token;

        require __DIR__ . "/../../views/notifications/upload-succes.php";
    }
}