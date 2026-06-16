<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Upload</h1>

    <p>Download URL:</p>

    <input
        type="text"
        value="<?= htmlspecialchars($downloadUrl) ?>"
        readonly
        style="width: 400px;"
    >
</body>
</html>