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
        <a href="<?php echo $config["base_path"] ?>/login" class="navbar-login">Login</a>
        <a href="<?php echo $config["base_path"] ?>/register" class="navbar-register">Register</a>
    </div>
</nav>