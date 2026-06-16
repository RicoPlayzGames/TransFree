<?php 

class UploadController {
    private $uploadService;
    private $config;

    public function __construct($db) {
        $this->uploadService = new UploadService($db);
        $this->config = require __DIR__ . "/../../config/Config.php";
    }

    public function uploadFile() {
        $userId = $_SESSION['user_id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $file = $_FILES['file'];

        $this->uploadService->uploadFile($userId, $title, $description, $file);

        header("Location: " . $this->config['base_url'] . "/uploads");
        exit();
    }
}