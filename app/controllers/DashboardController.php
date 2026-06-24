<?php
// Gebruiker dashboard
class DashboardController {
    private $uploadService;
    private $uploadModel;
    private $config;

    public function __construct($db) {
        $this->uploadService = new UploadService($db);
        $this->uploadModel = new UploadModel($db);
        // Laad de configuratie
        $this->config = require __DIR__ . "/../../config/Config.php";
    }

    // Titel of descriptie editen
    public function update($id) {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }

        $userId = $_SESSION['user_id'];
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';

        $this->uploadService->updateMetadata($id, $userId, $title, $description);

        header("Location: " . $this->config['base_path'] . "/dashboard");
        exit;
    }

    // Delete de upload
    public function delete($id) {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }

        $userId = $_SESSION['user_id'];
        $this->uploadService->deleteUpload($id, $userId);

        header("Location: " . $this->config['base_path'] . "/dashboard");
        exit;
    }

    // Bulk delete uploads (selected in dashboard)
    public function deleteMultiple() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }

        $userId = $_SESSION['user_id'];
        $ids = $_POST['ids'] ?? [];

        if (!is_array($ids)) {
            header("Location: " . $this->config['base_path'] . "/dashboard");
            exit;
        }

        foreach ($ids as $id) {
            $id = intval($id);
            if ($id > 0) {
                $this->uploadService->deleteUpload($id, $userId);
            }
        }

        header("Location: " . $this->config['base_path'] . "/dashboard");
        exit;
    }
}
