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
    <title>Register | TransFree</title>
</head>
<body>
    <form action="register" method="POST">
        <div>
            <label>Username</label>
            <input id="username" type="text" name="username">
        </div>

        <div>
            <label>Email</label>
            <input id="email" type="email" name="email">
        </div>

        <div>
            <label>Password</label>
            <input id="password" type="password" name="password">
        </div>

        <div>
            <label>Repeat password</label>
            <input id="repeat-password" type="password" name="repeat-password">
        </div>

        <button>Register</button>
    </form>
</body>
</html>