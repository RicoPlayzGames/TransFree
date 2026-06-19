<?php
// Load config for correct asset paths
$config = require __DIR__ . "/../config/Config.php";
if (!isset($message)) $message = 'Something went wrong..';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Error | Trans Free</title>
    <link rel="stylesheet" href="<?= $config['base_path'] ?>/public/css/style.css">
</head>
<body>
    <?php require_once __DIR__ . "/partials/navbar.php"; ?>
    <div class="notice error">
        <h2>Oops</h2>
        <p><?= htmlspecialchars($message) ?></p>
        <p><a href="<?= $config['base_path'] ?>">Back to start</a></p>
    </div>
</body>
</html>
