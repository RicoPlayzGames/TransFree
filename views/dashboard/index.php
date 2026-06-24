<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/navbar.css">
    <title>Dashboard | Trans Free</title>
    <link rel="stylesheet" href="public/css/dashboard.css">
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/../partials/navbar.php'; ?>
    <div class="container">
        <h1>My Links</h1>
        <p><a href="<?php echo $config['base_path'] ?>/upload">Upload new file</a></p>

        <?php if (empty($uploads)): ?>
        <p>You have no uploads yet.</p>
        <?php else: ?>
            <form method="post" action="<?php echo $config['base_path'] . '/dashboard/delete-multiple'; ?>" onsubmit="return confirm('Delete selected uploads?')">
            <div class="table-card">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all-dashboard"></th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Link</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($uploads as $u): ?>
                    <tr>
                        <td><input type="checkbox" name="ids[]" value="<?php echo intval($u['id']); ?>"></td>
                        <td><?php echo htmlspecialchars($u['title']); ?></td>
                        <td><?php echo htmlspecialchars($u['description']); ?></td>
                        <td><a href="<?php echo $config['base_path'] . '/download/' . $u['token']; ?>" target="_blank">View</a></td>
                        <td><?php echo $u['created_at']; ?></td>
                        <td class="actions">
                            <a class="action-link" href="<?php echo $config['base_path'] . '/dashboard/edit/' . $u['id']; ?>">Edit</a>
                            <form action="<?php echo $config['base_path'] . '/dashboard/delete/' . $u['id']; ?>" method="post" class="action-form" onsubmit="return confirm('Are you sure?')">
                                <button type="submit" class="action-delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            </div>
            <div style="margin-top:12px;">
                <button type="submit" class="action-delete">Delete selected</button>
            </div>
            </form>
            <script>
            document.getElementById('select-all-dashboard').addEventListener('change', function(e){
                var checked = e.target.checked;
                document.querySelectorAll('input[name="ids[]"]').forEach(function(cb){ cb.checked = checked; });
            });
            </script>
        <?php endif; ?>
    </div>
</body>
</html>
