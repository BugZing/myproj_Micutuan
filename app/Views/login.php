<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <nav>
        <a href="/">Home</a> |
        <a href="/about">About</a> |
        <a href="/login">Login</a>
    </nav>

    <hr>

    <h1>Login</h1>
    <?php if ($authError = session()->getFlashdata('auth_error')): ?>
        <p><?= esc($authError) ?></p>
    <?php endif; ?>

    <?php if (! empty($error)): ?>
        <p><?= esc($error) ?></p>
    <?php endif; ?>

    <?php if (! empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $message): ?>
                <li><?= esc($message) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="<?= esc(site_url('login'), 'attr') ?>" method="post">
        <?= csrf_field() ?>

        <p>
            <label for="username">Username</label><br>
            <input
                type="text"
                id="username"
                name="username"
                value="<?= esc($username ?? '') ?>"
                autocomplete="username"
                required
            >
        </p>

        <p>
            <label for="password">Password</label><br>
            <input
                type="password"
                id="password"
                name="password"
                autocomplete="current-password"
                required
            >
        </p>

        <button type="submit">Log In</button>
    </form>
</body>
</html>