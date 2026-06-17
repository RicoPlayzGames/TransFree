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
    <link rel="stylesheet" href="public/css/navbar.css">
    <link rel="stylesheet" href="public/css/login.css">
</head>
<body>
    <?php require_once __DIR__ . "/../partials/navbar.php"; ?>

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h1 class="login-title">Welcome Back</h1>
                <p class="login-subtitle">Login to your TransFree account</p>
            </div>

            <form class="login-form" action="login" method="POST">
                <div class="form-group">
                    <label for="name">Username or Email</label>
                    <input id="name" type="text" name="name" placeholder="Enter your username or email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" placeholder="Enter your password" required>
                </div>

                <button type="submit" class="login-button">Login</button>
            </form>

            <div class="login-footer">
                <p>Don't have an account? <a href="<?php echo $config["base_path"] ?>/register">Register here</a></p>
            </div>
        </div>
    </div>
</body>
</html>