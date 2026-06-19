<?php
$config = require __DIR__ . "/../../config/Config.php";
if (!isset($message)) $message = 'Upload success.';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Upload success | Trans Free</title>
    <link rel="stylesheet" href="<?= $config['base_path'] ?>/public/css/style.css">
    <link rel="stylesheet" href="<?= $config['base_path'] ?>/public/css/navbar.css">
</head>
<body>
    <?php require_once __DIR__ . "/../partials/navbar.php"; ?>
    <div class="notice success">
        <h2>Success</h2>
        <p><?= htmlspecialchars($message) ?></p>
        <p>Download URL: <a href="<?= htmlspecialchars($downloadUrl) ?>"><?= htmlspecialchars($downloadUrl) ?></a></p>
    </div>
</body>
</html>
