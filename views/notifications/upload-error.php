<?php
//laad de configuratie
$config = require __DIR__ . "/../../config/Config.php";
if (!isset($error)) $error = 'Something went wrong while uploading..';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Upload Failed | Trans Free</title>
    <link rel="stylesheet" href="<?= $config['base_path'] ?>/public/css/style.css">
    <link rel="stylesheet" href="<?= $config['base_path'] ?>/public/css/navbar.css">
</head>
<body>
    <?php require_once __DIR__ . "/../partials/navbar.php"; ?>
    <div class="notice error">
        <h2>Upload Failed</h2>
        <p><?= htmlspecialchars($error) ?></p>
        <p><a href="<?= $config['base_path'] ?>/upload">Back to upload</a></p>
    </div>
</body>
</html>
