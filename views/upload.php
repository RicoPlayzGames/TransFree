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
    <link rel="stylesheet" href="<?= $config['base_path'] ?>/public/css/navbar.css">
    <link rel="stylesheet" href="<?= $config['base_path'] ?>/public/css/upload.css">
</head>
<body>
    <?php require_once __DIR__ . "/partials/navbar.php"; ?>

    <div class="upload-container">
        <div class="upload-card">
            <div class="upload-header">
                <h1 class="upload-title">Upload your file</h1>
                <p class="upload-subtitle">Add a title and description, choose a PNG file, and upload it securely.</p>
            </div>

            <form class="upload-form" action="<?= $config['base_path'] ?>/upload" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input id="title" type="text" name="title" placeholder="Give your file a title" required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" placeholder="Add a short description"></textarea>
                </div>

                <div class="form-group">
                    <label for="file-upload">Choose a file</label>
                        <input
                            id="file-upload"
                            type="file"
                            name="file"
                            accept="image/*,video/*,.txt,.md,.log,.zip,.rar,.7z"
                            required
                        >
                </div>

                <button type="submit" class="upload-button">Upload</button>
            </form>

            <div class="upload-footer">
                <p>Only PNG, jpg, jpeg, mp4, zip files are allowed. Maximum 32 MB.</p>
            </div>
        </div>
    </div>
</body>
</html>