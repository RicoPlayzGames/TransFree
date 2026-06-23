<?php
// Laad de benodigde bestanden
require_once __DIR__ . "/../core/Database.php";
require_once __DIR__ . "/../app/models/UploadModel.php";

$config = require __DIR__ . "/../config/Config.php";

$db = new Database($config);
$uploadModel = new UploadModel($db);
$stats = $uploadModel->getStats();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trans Free</title>
    <link rel="stylesheet" href="<?= htmlspecialchars($config['base_path']) ?>/public/css/navbar.css">
    <link rel="stylesheet" href="<?= htmlspecialchars($config['base_path']) ?>/public/css/style.css">
</head>
<body>
    <?php require_once __DIR__ . "/partials/navbar.php"; ?>

    <section class="hero">
        <div class="hero-content">
            <div class="slop">
                <span>🔥 3 files uploaded in the last 5 minutes</span>
            </div>
            <h1 class="hero-title">
                Share files,<br>without hassle
            </h1>

            <p class="hero-subtitle">
                Upload your files and share instantly with a secure link.<br> No nonsense.
            </p>

            <div class="hero-buttons">
                <a href="<?= $config['base_path'] ?>/upload" class="hero-primary">Upload File</a>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="<?= $config['base_path'] ?>/dashboard" class="hero-secondary">Dashboard</a>
                <?php else: ?>
                    <a href="<?= $config['base_path'] ?>/register" class="hero-secondary">Get Started</a>
                <?php endif; ?>
            </div>

            <div class="stats">
                <div class="stat-box">
                    <div class="stat-number"><?= $stats['total_users'] ?? 0 ?></div>
                    <div class="stat-label">Users</div>
                </div>

                <div class="stat-box">
                    <div class="stat-number"><?= $stats['total_files'] ?? 0 ?></div>
                    <div class="stat-label">Files uploaded</div>
                </div>

                <div class="stat-box">
                    <div class="stat-number">
                        <?= $stats['total_bytes'] / 1024 / 1024 / 1024, 2 ?> GB
                    </div>
                    <div class="stat-label">Data shared</div>
                </div>
            </div>
        </div>
    </section>

    <section class="how">
        <h2>How it works</h2>

        <div class="how-grid">
            <div>
                <h3>📤 Upload</h3>
                <p>Drag & drop your file in seconds.</p>
            </div>

            <div>
                <h3>🔗 Get link</h3>
                <p>We generate a secure share link instantly.</p>
            </div>

            <div>
                <h3>🚀 Share</h3>
                <p>Send it anywhere, no subscription needed.</p>
            </div>
        </div>
    </section>

    <section class="trust">
        <div>✔ Secure download links</div>
        <div>✔ Fast downloads</div>
        <div>✔ Top tier security (frfr)</div>
    </section>

    <section class="cta">
        <h2>Ready to share files faster?</h2>
        <a href="upload">Start uploading</a>
    </section>
</body>
</html>