<?php
require_once __DIR__ . "/../../core/Database.php";
require_once __DIR__ . "/../../app/services/AuthService.php";
require_once __DIR__ . "/../../app/controllers/AuthController.php";

$config = require "config/Config.php";
$db = new Database($config);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | TransFree</title>
</head>
<body>
    <form action="login" method="POST">
        <div>
            <label>Username or Email</label>
            <input id="name" type="text" name="name">
        </div>

        <div>
            <label>Password</label>
            <input id="password" type="password" name="password">
        </div>

        <button>Login</button>
    </form>
</body>
</html>