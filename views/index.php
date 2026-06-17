<?php
require_once __DIR__ . "/../core/Database.php";
require_once __DIR__ . "/../app/models/UploadModel.php";

$config = require __DIR__ . "/../config/Config.php";

$db = new Database($config);
$uploadModel = new UploadModel($db);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trans Free</title>
    <link rel="stylesheet" href="public/css/navbar.css">
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <?php require_once __DIR__ . "/partials/navbar.php"; ?>

    <section class="hero">
        <h1 class="hero-title">
            Share files,<br>
            without hassle
        </h1>

        <p class="hero-subtitle">
            Upload your files and share instantly with a link.
        </p>

        <div class="hero-buttons">
            <a href="<?php echo $config["base_path"] ?>/upload" class="hero-primary">Upload File</a>
            <a href="<?php echo $config["base_path"] ?>/register" class="hero-secondary">Get Started</a>
        </div>
    </section>
</body>
</html>