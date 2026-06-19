<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit | Trans Free</title>
    <link rel="stylesheet" href="../../public/css/navbar.css">
    <link rel="stylesheet" href="../../public/css/dashboard.css">
</head>
<body>
<?php include __DIR__ . '/../partials/navbar.php'; ?>
<div class="container">
        <h1>Edit: <?php echo htmlspecialchars($upload['title']); ?></h1>

    <form action="<?php echo $config['base_path'] . '/dashboard/edit/' . $upload['id']; ?>" method="post">
            <div>
                <label>Title</label>
                <input type="text" name="title" value="<?php echo htmlspecialchars($upload['title']); ?>">
            </div>
            <div>
                <label>Description</label>
                <textarea name="description"><?php echo htmlspecialchars($upload['description']); ?></textarea>
            </div>
            <div>
                <button type="submit">Save</button>
                <a href="<?php echo $config['base_path'] . '/dashboard'; ?>">Cancel</a>
            </div>
    </form>
</div>
</body>
</html>
