<?php 

class UploadController {
    private $uploadService;
    private $config;

    public function __construct($db) {
        $this->uploadService = new UploadService($db);
        $this->config = require __DIR__ . "/../../config/Config.php";
    }

    public function uploadFile() {
        
    }
}