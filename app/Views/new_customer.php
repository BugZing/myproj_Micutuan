<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Customer</title>
</head>
<body>
    <h1>Add New Customer</h1>

    <?php if (! empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="/customers" method="post">
        <p>
            <label for="full_name">Full Name</label><br>
            <input
                type="text"
                id="full_name"
                name="full_name"
                value="<?= esc($customer['full_name'] ?? '') ?>"
                required
            >
        </p>

        <p>
            <label for="email">Email</label><br>
            <input
                type="email"
                id="email"
                name="email"
                value="<?= esc($customer['email'] ?? '') ?>"
                required
            >
        </p>

        <p>
            <label for="phone">Phone <em>(optional)</em></label><br>
            <input
                type="tel"
                id="phone"
                name="phone"
                value="<?= esc($customer['phone'] ?? '') ?>"
            >
        </p>

        <button type="submit">Save Customer</button>
    </form>

    <p><a href="/customers">Back to Customer Accounts</a></p>
</body>
</html>