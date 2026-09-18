<?php require_once __DIR__ . '/../app/includes/functions.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Task Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="login-body">

    <form method="post" action="../app/controllers/login.php" class="shadow p-4 login-card" autocomplete="off">
        <h3 class="display-1 text-center">Task Pro</h3>
        <p class="text-center lead mb-4">Login to your account</p>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger py-2">Incorrect username or password</div>
        <?php endif; ?>

        <div class="mb-3">
            <label for="username" class="form-label">User Name</label>
            <input type="text" class="form-control" id="username" name="username"
                   value="<?php echo isset($_GET['username']) ? esc($_GET['username']) : ''; ?>" autocomplete="off">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" autocomplete="new-password">
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

</body>

</html>