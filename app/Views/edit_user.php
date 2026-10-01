<h1>Edit User</h1>

<?php if (! empty($errors)): ?>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li><?= esc($error) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form action="/users/<?= esc($user['id']) ?>" method="post" enctype="multipart/form-data">
    <p>
        <label for="username">Username</label><br>
        <input
            type="text"
            id="username"
            name="username"
            value="<?= esc($user['username']) ?>"
            required
        >
    </p>

    <p>
        <label for="full_name">Full Name</label><br>
        <input
            type="text"
            id="full_name"
            name="full_name"
            value="<?= esc($user['full_name']) ?>"
            required
        >
    </p>

    <?php $avatarName = basename((string) ($user['avatar'] ?? '')); ?>

    <?php if ($avatarName !== ''): ?>
        <p>Current profile picture:</p>
        <p>
            <img
                src="<?= esc(base_url('uploads/avatars/' . rawurlencode($avatarName)), 'attr') ?>"
                alt="Current profile picture"
                width="100"
                height="100"
            >
        </p>
    <?php endif; ?>

    <p>
        <label for="avatar">Profile Picture (JPG or PNG, max 2 MB)</label><br>
        <input
            type="file"
            id="avatar"
            name="avatar"
            accept=".jpg,.jpeg,.png,image/jpeg,image/png"
        >
    </p>

    <button type="submit">Update User</button>
</form>

<p><a href="/users">Back to User Accounts</a></p>