<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
</head>
<body>
    <nav>
        <a href="/">Home</a> |
        <a href="/customers">Customer Accounts</a> |
        <a href="/users">User Accounts</a>
    </nav>

    <hr>

    <h1>Change Password</h1>

    <?php if ($success = session()->getFlashdata('success')): ?>
        <p><?= esc($success) ?></p>
    <?php endif; ?>

    <?php if (! empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $message): ?>
                <li><?= esc($message) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="<?= esc(site_url('account/password'), 'attr') ?>" method="post">
        <?= csrf_field() ?>

        <p>
            <label for="current_password">Current Password</label><br>
            <input
                type="password"
                id="current_password"
                name="current_password"
                autocomplete="current-password"
                required
            >
        </p>

        <p>
            <label for="new_password">New Password</label><br>
            <input
                type="password"
                id="new_password"
                name="new_password"
                autocomplete="new-password"
                required
            >
        </p>

        <p>
            <label for="password_confirmation">Confirm New Password</label><br>
            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                autocomplete="new-password"
                required
            >
        </p>

        <button type="submit">Change Password</button>
    </form>
</body>
</html>