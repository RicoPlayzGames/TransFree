<?php
require_once __DIR__ . "/../../config/Config.php";
?>
<nav class="navbar">
    <a href="<?php echo $config["base_path"] ?>" class="navbar-brand">
        <span class="navbar-mark">
            <image src="<?php echo $config["base_path"] ?>/public/assets/icons/plus.svg">
        </span>
        <div>
            Trans<span class="navbar-accent">Free</span>
        </div>
    </a>
    <ul class="navbar-links">
        <li><a href="<?php echo $config["base_path"] ?>">Home</a></li>
        <li><a href="<?php echo $config["base_path"] ?>/upload">Upload</a></li>
    </ul>
    <div class="navbar-auth">
        <?php
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION["user_id"])): ?>
            <span class="navbar-login">Hello, <?php echo htmlspecialchars($_SESSION["username"] ?? 'User'); ?></span>
            <a href="<?php echo $config["base_path"] ?>/logout" class="navbar-register">Logout</a>
        <?php else: ?>
            <a href="<?php echo $config["base_path"] ?>/login" class="navbar-login">Login</a>
            <a href="<?php echo $config["base_path"] ?>/register" class="navbar-register">Register</a>
        <?php endif; ?>
    </div>
</nav>