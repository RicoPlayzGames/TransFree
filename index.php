<?php



session_start();

require_once "core/Database.php";
require_once "core/Router.php";
require_once "core/Helper.php";

require_once "app/controllers/UploadController.php";
require_once "app/controllers/DownloadController.php";
require_once "app/controllers/AuthController.php";

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
    
    require "views/download.php";
});

$router->get('/download/:token/file', function($token) use ($db) {
    $controller = new DownloadController($db);
    $controller->downloadFile($token);
});

$router->resolve();