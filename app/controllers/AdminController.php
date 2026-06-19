<?php

class AdminController {
    private $db;
    private $userModel;
    private $uploadModel;
    private $uploadService;
    private $config;

    public function __construct($db) {
        $this->db = $db;
        $this->userModel = new UserModel($db);
        $this->uploadModel = new UploadModel($db);
        $this->uploadService = new UploadService($db);
        $this->config = require __DIR__ . "/../../config/Config.php";
    }

    // check of admin is
    private function ensureAdmin() {
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            http_response_code(403);
            echo "Forbidden";
            exit;
        }
    }

    public function deleteUser($id) {
        $this->ensureAdmin();
        $this->userModel->deleteUserById($id);

        header("Location: " . $this->config['base_path'] . "/admin");
        exit;
    }

    public function updateUserRole($id) {
        $this->ensureAdmin();
        $role = $_POST['role'] ?? 'gebruiker';
        $this->userModel->updateUserRole($id, $role);
        header("Location: " . $this->config['base_path'] . "/admin");
        exit;
    }

    public function deleteUpload($id) {
        $this->ensureAdmin();
        $upload = $this->db->queryDatabase(
            "SELECT * FROM uploads WHERE id = :id",
            ['id' => $id]
        )->fetch();

        if ($upload) {
            $uploadPath = __DIR__ . "/../../public/uploads/" . $upload['filename'];
            if (file_exists($uploadPath)) {
                @unlink($uploadPath);
            }

            $this->db->queryDatabase(
                "DELETE FROM uploads WHERE id = :id",
                ['id' => $id]
            );
        }
        header("Location: " . $this->config['base_path'] . "/admin");
        exit;
    }
}
