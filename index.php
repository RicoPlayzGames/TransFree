<?php

session_start();

require_once "core/Database.php";
require_once "core/Router.php";
require_once "core/Helper.php";

require_once "app/controllers/UploadController.php";

require_once "app/models/UploadModel.php";

require_once "app/services/UploadService.php";

$config = require "config/Config.php";
$db = new Database($config);
$router = new Router($config);

$router->get('/', function() {
    require "views/index.php";
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

$router->get('/download', function() use ($db, $config) {
    $uploadModel = new UploadModel($db);
    require "views/download.php";
});

$router->resolve();