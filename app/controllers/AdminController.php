<?php
// Admin dashboard
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
        // Laad de configuratie
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

    // Verwijder user
    public function deleteUser($id) {
        $this->ensureAdmin();

        $currentUserId = $_SESSION['user_id'] ?? null;

        // Voorkom dat een admin zichzelf verwijdert
        if ($currentUserId && intval($currentUserId) === intval($id)) {
            header("Location: " . $this->config['base_path'] . "/admin?msg=" . urlencode('cannot_delete_own_account'));
            exit;
        }

        $password = $_POST['admin_password'] ?? '';
        if (empty($password)) {
            header("Location: " . $this->config['base_path'] . "/admin?msg=" . urlencode('missing_password'));
            exit;
        }

        $row = $this->db->queryDatabase(
            "SELECT password FROM users WHERE id = :id",
            ['id' => $currentUserId]
        )->fetch();

        if (!$row || !password_verify($password, $row['password'])) {
            header("Location: " . $this->config['base_path'] . "/admin?msg=" . urlencode('invalid_password'));
            exit;
        }

        $this->userModel->deleteUserById($id);
        header("Location: " . $this->config['base_path'] . "/admin?msg=" . urlencode('user_deleted'));
        exit;
    }

    // Update de role van de gebruiker via de dashboard
    public function updateUserRole($id) {
        $this->ensureAdmin();
        $currentUserId = $_SESSION['user_id'] ?? null;
        if ($currentUserId && intval($currentUserId) === intval($id)) {
            header("Location: " . $this->config['base_path'] . "/admin?msg=" . urlencode('cannot_change_own_role'));
            exit;
        }

        $role = $_POST['role'] ?? 'gebruiker';
        $allowed = ['gebruiker', 'admin'];
        if (!in_array($role, $allowed)) {
            header("Location: " . $this->config['base_path'] . "/admin?msg=" . urlencode('invalid_role'));
            exit;
        }

        $password = $_POST['admin_password'] ?? '';
        if (empty($password)) {
            header("Location: " . $this->config['base_path'] . "/admin?msg=" . urlencode('missing_password'));
            exit;
        }

        $row = $this->db->queryDatabase(
            "SELECT password FROM users WHERE id = :id",
            ['id' => $currentUserId]
        )->fetch();

        if (!$row || !password_verify($password, $row['password'])) {
            header("Location: " . $this->config['base_path'] . "/admin?msg=" . urlencode('invalid_password'));
            exit;
        }

        $this->userModel->updateUserRole($id, $role);
        header("Location: " . $this->config['base_path'] . "/admin?msg=" . urlencode('role_updated'));
        exit;
    }

    // Verwijder de upload van een gebruiker via de dashboard
    public function deleteUpload($id) {
        $this->ensureAdmin();
        $upload = $this->db->queryDatabase(
            "SELECT * FROM uploads WHERE id = :id",
            ['id' => $id]
        )->fetch();

        if ($upload) {
            $uploadPath = __DIR__ . "/../../public/uploads/" . $upload['filename'];
            if (file_exists($uploadPath)) {
            // Verwijderd de upload vn de server
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
