<?php

session_start();

require_once "core/Database.php";
require_once "core/Router.php";
require_once "core/Helper.php";

$config = require "config/Config.php";
$db = new Database($config);
$router = new Router($config);

$router->get('/', function() {
    require "views/index.php";
});

$router->resolve();