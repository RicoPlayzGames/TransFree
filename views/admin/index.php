<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="public/css/navbar.css">
    <link rel="stylesheet" href="public/css/dashboard.css">
</head>
<body>
<?php include __DIR__ . '/../partials/navbar.php'; ?>
<?php
    $statusMsg = '';
    if (!empty($_GET['msg'])) {
        switch ($_GET['msg']) {
            case 'cannot_change_own_role': $statusMsg = 'You cannot change your own role.'; break;
            case 'missing_password': $statusMsg = 'Please enter your password to confirm the change.'; break;
            case 'invalid_password': $statusMsg = 'Invalid password. Role not changed.'; break;
            case 'invalid_role': $statusMsg = 'Invalid role selected.'; break;
            case 'role_updated': $statusMsg = 'Role updated successfully.'; break;
            default: $statusMsg = ''; break;
        }
    }
?>
<div class="container">
    <?php if ($statusMsg): ?>
        <div style="padding:10px;border:1px solid #ccc;background:#f9f9f9;margin-bottom:16px"><?php echo htmlspecialchars($statusMsg); ?></div>
    <?php endif; ?>
    <h1>Admin Dashboard</h1>

    <section style="margin-top:20px">
        <h2>Users</h2>
        <?php if (empty($users)): ?>
            <p>No users found.</p>
        <?php else: ?>
            <table class="dashboard-table">
                <thead>
                    <tr><th>Username</th><th>Email</th><th>Role</th><th>Joined</th><th>Actions</th></tr>
                </thead>
                <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($u['username']); ?></td>
                        <td><?php echo htmlspecialchars($u['email']); ?></td>
                        <td><?php echo htmlspecialchars($u['role']); ?></td>
                        <td><?php echo $u['created_at']; ?></td>
                        <td class="actions">
                            <?php if (session_status() == PHP_SESSION_NONE) { session_start(); } ?>
                            <?php $isSelf = isset($_SESSION['user_id']) && intval($_SESSION['user_id']) === intval($u['id']); ?>
                            <form action="#" method="get" class="role-control" onsubmit="return false;">
                                <select name="role" id="role-select-<?php echo $u['id']; ?>" <?php echo $isSelf ? 'disabled' : ''; ?> >
                                    <option value="gebruiker" <?php echo $u['role'] === 'gebruiker' ? 'selected' : '' ?>>User</option>
                                    <option value="admin" <?php echo $u['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
 <script>
 function redirectToConfirm(id) {
     var sel = document.getElementById('role-select-' + id);
     if (!sel) return;
     var role = sel.value;
     var base = '<?php echo $config['base_path']; ?>';
     window.location.href = base + '/admin/users/role/confirm/' + id + '?role=' + encodeURIComponent(role);
 }
 </script>
                                </select>
                                <button class="btn" type="button" onclick="redirectToConfirm(<?php echo $u['id']; ?>)" <?php echo $isSelf ? 'disabled' : ''; ?>>Update</button>
                                <?php if ($isSelf): ?>
                                    <span style="margin-left:8px;color:#a00;font-size:0.9rem">You cannot change your own role</span>
                                <?php endif; ?>
                            </form>
                            <form action="<?php echo $config['base_path'] ?>/admin/users/delete/<?php echo $u['id']; ?>" method="post" class="action-form" onsubmit="return confirm('Delete user?')">
                                <button type="submit" class="action-delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>

    <section style="margin-top:32px">
        <h2>Uploads</h2>
        <?php if (empty($uploads)): ?>
            <p>No uploads found.</p>
        <?php else: ?>
            <table class="dashboard-table">
                <thead>
                    <tr><th>Title</th><th>Owner</th><th>Filename</th><th>Created</th><th>Actions</th></tr>
                </thead>
                <tbody>
                <?php foreach ($uploads as $u): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($u['title']); ?></td>
                        <td><?php echo htmlspecialchars($u['username'] ?? '—'); ?></td>
                        <td><?php echo htmlspecialchars($u['filename']); ?></td>
                        <td><?php echo $u['created_at']; ?></td>
                        <td class="actions">
                            <a class="action-link" href="<?php echo $config['base_path'] . '/download/' . $u['token']; ?>" target="_blank">View</a>
                            <form action="<?php echo $config['base_path'] ?>/admin/uploads/delete/<?php echo $u['id']; ?>" method="post" class="action-form" onsubmit="return confirm('Delete upload?')">
                                <button type="submit" class="action-delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>

    <section style="margin-top:32px">
        <h2>Algemeen Logs</h2>
        <?php if (empty($logs)): ?>
            <p>No upload logs found.</p>
        <?php else: ?>
            <table class="dashboard-table">
                <thead>
                    <tr><th>User</th><th>Event</th><th>IP</th><th>Browser</th><th>Created</th></tr>
                </thead>
                <tbody>
                <?php foreach ($logs as $log): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($log['username'] ?? 'User '.$log['user_id']); ?></td>
                        <td><?php echo htmlspecialchars($log['content']); ?></td>
                        <td><?php echo htmlspecialchars($log['ip_address']); ?></td>
                        <td><?php echo htmlspecialchars($log['browser']); ?></td>
                        <td><?php echo $log['created_at']; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>

</div>
</body>
</html>
