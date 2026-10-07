<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Accounts</title>

    <style>
        .avatar {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 50%;
            border: 1px solid #999;
        }
    </style>
</head>
<body>
    <nav>
        <a href="/">Home</a> |
        <a href="/about">About</a> |
        <a href="/customers">Customer Accounts</a> |
        <a href="/users">User Accounts</a>
        <p><a href="/users/new">Add New User</a></p>
        <form action="<?= esc(site_url('logout'), 'attr') ?>" method="post" style="display: inline;">
        <?= csrf_field() ?>
            <button type="submit">Log Out</button>
        <a href="/account/password">Change Password</a> |
        </form>  
    </nav>

    <hr>

    <h1>User Accounts</h1>
    <?php if (session()->get('logged_in') === true): ?>
        <p>Logged in as <?= esc(session()->get('username')) ?>.</p>
    <?php endif; ?>

    <table border="1">
        <thead>
            <tr>
                <th>Avatar</th>
                <th>ID</th>
                <th>Username</th>
                <th>Full Name</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($users as $user): ?>
                <?php
                    $avatarName = basename((string) ($user['avatar'] ?? ''));

                    $isExpectedAvatar = preg_match(
                        '/\Aavatar_[a-f0-9]{32}\.(?:jpg|png)\z/i',
                        $avatarName
                    ) === 1;

                    $avatarPath = FCPATH . 'uploads/avatars/' . $avatarName;

                    $avatarUrl = ($isExpectedAvatar && is_file($avatarPath))
                        ? base_url('uploads/avatars/' . rawurlencode($avatarName))
                        : base_url('images/avatar-placeholder.svg');
                ?>

                <tr>
                    <td>
                        <img
                            class="avatar"
                            src="<?= esc($avatarUrl, 'attr') ?>"
                            alt="<?= esc(($user['full_name'] ?? 'User') . ' avatar', 'attr') ?>"
                            loading="lazy"
                        >
                    </td>
                    <td><?= esc($user['id']) ?></td>
                    <td><?= esc($user['username']) ?></td>
                    <td><?= esc($user['full_name']) ?></td>
                    <td>
                        <a href="/users/<?= esc($user['id']) ?>/edit">Edit</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p><a href="/">Back to Home</a></p>
</body>
</html>