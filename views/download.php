<?php

if (!isset($_SESSION["user_id"])) {
    header("Location: login");
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
    <h1>Download <?= htmlspecialchars($upload["title"]) ?></h1>
    
    <a href="<?= htmlspecialchars($config["base_path"]) ?>/download/<?= htmlspecialchars($upload["token"]) ?>/file">Download</a>
</body>
</html>