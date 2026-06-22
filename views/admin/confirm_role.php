<?php
if (session_status() == PHP_SESSION_NONE) { session_start(); }
if (!isset($config)) { $config = require __DIR__ . '/../../config/Config.php'; }
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Confirm Role Change</title>
    <link rel="stylesheet" href="<?php echo $config['base_path']; ?>/public/css/navbar.css">
    <link rel="stylesheet" href="<?php echo $config['base_path']; ?>/public/css/dashboard.css">
</head>
<body>
<?php include __DIR__ . '/../partials/navbar.php'; ?>
<div class="container">
    <h1>Confirm Role Change</h1>

    <?php if (empty($user)): ?>
        <p>User not found.</p>
        <p><a href="<?php echo $config['base_path']; ?>/admin">Back to admin</a></p>
    <?php else: ?>
        <?php $selectedRole = htmlspecialchars($_GET['role'] ?? 'gebruiker'); ?>
        <p>Change role for <strong><?php echo htmlspecialchars($user['username']); ?></strong> (current: <?php echo htmlspecialchars($user['role']); ?>) to <strong><?php echo $selectedRole; ?></strong>?</p>

        <form action="<?php echo $config['base_path']; ?>/admin/users/role/<?php echo $user['id']; ?>" method="post">
            <input type="hidden" name="role" value="<?php echo $selectedRole; ?>" />
            <div style="margin:12px 0">
                <label for="admin_password">Enter your password to confirm:</label><br>
                <input type="password" name="admin_password" id="admin_password" required />
            </div>
            <button type="submit" class="btn">Confirm Change</button>
            <a href="<?php echo $config['base_path']; ?>/admin" style="margin-left:12px">Cancel</a>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
