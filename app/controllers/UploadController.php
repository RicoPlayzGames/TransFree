<?php 

class UploadController {
    private $uploadService;
    private $config;

    public function __construct($db) {
        $this->uploadService = new UploadService($db);
        $this->config = require __DIR__ . "/../../config/Config.php";
    }

    public function uploadFile() {
        $userId = 1; // nog aanpassen RICO!
        $title = $_POST['title'];
        $description = $_POST['description'];
        $file = $_FILES['file'];

        $this->uploadService->uploadFile($userId, $title, $description, $file);

        return "OK!";
        exit();
    }
}