<?php
// required files directions
require_once __DIR__ . "/../../core/Database.php";
require_once __DIR__ . "/../../app/services/AuthService.php";
require_once __DIR__ . "/../../app/controllers/AuthController.php";

$config = require __DIR__ . "/../../config/Config.php";
$db = new Database($config);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | TransFree</title>
    <link rel="stylesheet" href="<?= htmlspecialchars($config['base_path']) ?>/public/css/navbar.css">
    <link rel="stylesheet" href="<?= htmlspecialchars($config['base_path']) ?>/public/css/style.css">
    <link rel="stylesheet" href="<?= htmlspecialchars($config['base_path']) ?>/public/css/login.css">
</head>
<body>
    <?php require_once __DIR__ . "/../partials/navbar.php"; ?>

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h1 class="login-title">Create Account</h1>
                <p class="login-subtitle">Sign up for a free TransFree account</p>
            </div>

            <form class="login-form" action="register" method="POST">
                <div class="form-group">
                    <label for="name">Username</label>
                    <input id="name" type="text" name="name" placeholder="Choose a username" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" placeholder="your@email.com" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" placeholder="Create a password" required>
                </div>

                <div class="form-group">
                    <label for="password_confirm">Confirm Password</label>
                    <input id="password_confirm" type="password" name="password_confirm" placeholder="Repeat your password" required>
                </div>

                <button type="submit" class="login-button">Register</button>
            </form>

            <div class="login-footer">
                <p>Already have an account? <a href="<?php echo $config["base_path"] ?>/login">Login here</a></p>
            </div>
        </div>
    </div>
</body>
</html>