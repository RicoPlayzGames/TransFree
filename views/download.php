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
    <link rel="stylesheet" href="../public/css/download.css">
    <link rel="stylesheet" href="../public/css/navbar.css">
</head>
<body>

    <?php require_once __DIR__ . "/partials/navbar.php"; ?>

    <div class="main-content">
        <div class="download-container">
            <h1>Download <?= htmlspecialchars($upload["title"]) ?></h1>
            <a class="btn-download" href="<?php echo $config["base_path"] ?>/public/uploads/<?php echo $upload["filename"] ?>">
                Download Bestand
            </a>
        </div>
    </div>

    <h1>Download <?= htmlspecialchars($upload["title"]) ?></h1>

    <a href="<?= htmlspecialchars($config["base_path"]) ?>/download/<?= htmlspecialchars($token) ?>/file">Download</a>
</body>
</html>