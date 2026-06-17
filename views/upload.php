<?php

if (!isset($_SESSION["user_id"])) {
    header("Location: " . $config["base_path"] . "/login");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($config['app_name']) ?></title>
</head>
<body>
    <form action="<?= $config['base_path'] ?>/upload" method="POST" enctype="multipart/form-data">
        <input id="title" type="text" name="title" required>
        <textarea id="description" name="description"></textarea>
        <input id="file-upload" type="file" accept=".png" name="file">
        <button>Upload</button>
    </form>
</body>
</html>