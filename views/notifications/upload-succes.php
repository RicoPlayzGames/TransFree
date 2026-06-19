<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/public/css/navbar.css">
    <link rel="stylesheet" href="/public/css/dashboard.css">
</head>
<body>
    <?php include __DIR__ . '/../partials/navbar.php'; ?>

    <div class="container">
        <div class="notif">
            <div class="info">
                <h2>Upload successful</h2>
                <p>Your file has been uploaded. Use the download link below to share it.</p>
                <div class="url-row">
                    <input id="download-url" type="text" value="<?= htmlspecialchars($downloadUrl) ?>" readonly>
                    <button class="copy-btn" id="copy-btn">Copy</button>
                </div>
            </div>
            <div>
                <a class="btn" href="<?php echo $config['base_path'] ?>/dashboard">Go to dashboard</a>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('copy-btn').addEventListener('click', function(){
            var input = document.getElementById('download-url');
            input.select();
            input.setSelectionRange(0, 99999);
            try { navigator.clipboard.writeText(input.value); alert('Copied'); } catch(e) { document.execCommand('copy'); alert('Copied'); }
        });
    </script>
</body>
</html>