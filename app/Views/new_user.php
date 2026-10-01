<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New User</title>
</head>
<body>
    <h1>Add New User</h1>

    <?php if (! empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="/users" method="post">
        <p>
            <label for="username">Username</label><br>
            <input
                type="text"
                id="username"
                name="username"
                value="<?= esc($user['username'] ?? '') ?>"
                required
            >
        </p>

        <p>
            <label for="full_name">Full Name</label><br>
            <input
                type="text"
                id="full_name"
                name="full_name"
                value="<?= esc($user['full_name'] ?? '') ?>"
                required
            >
        </p>

        <button type="submit">Save User</button>
    </form>

    <p><a href="/users">Back to User Accounts</a></p>
</body>
</html>