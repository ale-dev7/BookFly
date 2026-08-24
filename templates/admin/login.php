<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit;
}

require_once __DIR__ . '/../../includes/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!empty($email) && !empty($password)) {
        $stmt = $pdo->prepare('SELECT * FROM admins WHERE email = ?');
        $stmt->execute([$email]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['passwort_hash'])) {
            session_regenerate_id(true);

            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['name'];
            
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Ungültige E-Mail-Adresse oder Passwort.';
        }
    } else {
        $error = 'Bitte füllen Sie alle Felder aus.';
    }
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Bookfly B2B</title>
    <link rel="stylesheet" href="../../static/css/style.css">
</head>
<body class="bg-light">

    <main class="container admin-login-wrapper">
        <div class="admin-login-card">
            <h2 class="admin-login-title">Bookfly Admin Login</h2>

            <?php if (!empty($error)): ?>
                <div class="alert-danger">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <div class="form-group">
                    <label for="email">E-Mail</label>
                    <input type="email" id="email" name="email" class="form-control" autocomplete="off" required>
                </div>

                <div class="form-group">
                    <label for="password">Passwort</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-success btn-full">Anmelden</button>
            </form>
        </div>
    </main>

</body>
</html>