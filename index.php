<?php



session_start();

require_once "core/Database.php";
require_once "core/Router.php";
require_once "core/Helper.php";

require_once "app/controllers/UploadController.php";
require_once "app/controllers/DownloadController.php";
require_once "app/controllers/AuthController.php";
require_once "app/controllers/LogoutController.php";
require_once "app/controllers/DashboardController.php";
require_once "app/controllers/AdminController.php";

require_once "app/models/UploadModel.php";
require_once "app/models/UserModel.php";

require_once "app/services/UploadService.php";
require_once "app/services/DownloadService.php";
require_once "app/services/AuthService.php";

$config = require "config/Config.php";
$db = new Database($config);
$router = new Router($config);

$router->get('/', function() {
    require "views/index.php";
});

$router->get('/register', function() {
    require "views/auth/register.php";
});

$router->post('/register', function() use ($db, $config) {
    $controller = new AuthController($db, $config);
    $controller->register();
});

$router->get('/login', function() {
    require "views/auth/login.php";
});

$router->post('/login', function() use ($db, $config) {
    $controller = new AuthController($db, $config);
    $controller->login();
});

$router->get('/logout', function() {
    $controller = new LogoutController();
    $controller->logout();
});

$router->get('/upload', function() use ($db, $config) {
    $uploadModel = new UploadModel($db);
    require "views/upload.php";
});

$router->post('/upload', function() use ($db) {
    $controller = new uploadController($db);
    $controller->uploadFile();

    require_once "app/controllers/UploadController.php";
});

$router->get('/download/:token', function($token) use ($db, $config) {
    $uploadModel = new UploadModel($db);
    $upload = $uploadModel->getUploadByToken($token);

    if (!$upload) {
        http_response_code(404);
        echo "Upload niet gevonden.";
        return;
    }

    require "views/download.php";
});
$router->get('/download/:token/file', function($token) use ($db) {
    $controller = new DownloadController($db);
    $controller->downloadFile($token);
});

$router->get('/dashboard', function() use ($db, $config) {
    if (!isset($_SESSION['user_id'])) {
        header("Location: " . $config['base_path'] . "/login");
        exit;
    }

    $uploadService = new UploadService($db);
    $uploads = $uploadService->listUploadsByUser($_SESSION['user_id']);

    require "views/dashboard/index.php";
});

$router->get('/dashboard/edit/:id', function($id) use ($db, $config) {
    if (!isset($_SESSION['user_id'])) {
        header("Location: " . $config['base_path'] . "/login");
        exit;
    }

    $uploadModel = new UploadModel($db);
    $upload = $uploadModel->getUploadById($id);

    if (!$upload || $upload['user_id'] != $_SESSION['user_id']) {
        http_response_code(404);
        echo "Upload not found or access denied.";
        return;
    }

    $config = $config;
    require "views/dashboard/edit.php";
});

$router->post('/dashboard/edit/:id', function($id) use ($db) {
    $controller = new DashboardController($db);
    $controller->update($id);
});

$router->post('/dashboard/delete/:id', function($id) use ($db) {
    $controller = new DashboardController($db);
    $controller->delete($id);
});

// Admin routes
$router->get('/admin', function() use ($db, $config) {
    if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
        http_response_code(403);
        echo "Forbidden";
        return;
    }

    $userModel = new UserModel($db);
    $users = $userModel->getAllUsers();

    $uploads = $db->queryDatabase("SELECT u.*, usr.username FROM uploads u LEFT JOIN users usr ON u.user_id = usr.id ORDER BY u.created_at DESC", [])->fetchAll();

    $logs = $db->queryDatabase(
        "SELECT l.*, usr.username FROM logs l LEFT JOIN users usr ON l.user_id = usr.id WHERE l.type = 'info' ORDER BY l.created_at DESC LIMIT 100",
        []
    )->fetchAll();

    require "views/admin/index.php";
});

$router->post('/admin/users/delete/:id', function($id) use ($db) {
    $controller = new AdminController($db);
    $controller->deleteUser($id);
});

$router->get('/admin/users/role/confirm/:id', function($id) use ($db, $config) {
    if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
        http_response_code(403);
        echo "Forbidden";
        return;
    }

    $userModel = new UserModel($db);
    $user = $userModel->getUserById($id);

    require "views/admin/confirm_role.php";
});

$router->get('/admin/users/delete/confirm/:id', function($id) use ($db, $config) {
    if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
        http_response_code(403);
        echo "Forbidden";
        return;
    }

    $userModel = new UserModel($db);
    $user = $userModel->getUserById($id);

    require "views/admin/confirm_delete.php";
});

$router->post('/admin/users/role/:id', function($id) use ($db) {
    $controller = new AdminController($db);
    $controller->updateUserRole($id);
});

$router->post('/admin/uploads/delete/:id', function($id) use ($db) {
    $controller = new AdminController($db);
    $controller->deleteUpload($id);
});

$router->resolve();