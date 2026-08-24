<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = isset($_SESSION['b2b_user_id']);
$errors = [];
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $errors[] = 'Bitte E-Mail und Passwort eingeben.';
    } else {
        require_once __DIR__ . '/../includes/db.php';

        $stmt = $pdo->prepare('SELECT * FROM haendler WHERE email = ?');
        $stmt->execute([$email]);
        $haendler = $stmt->fetch();

        if (!$haendler || !password_verify($password, $haendler['passwort_hash'])) {
            $errors[] = 'E-Mail oder Passwort ist falsch.';
        } elseif ($haendler['status'] === 'pending') {
            $errors[] = 'Ihr Konto wird noch geprüft. Bitte warten Sie auf die Freischaltung.';
        } elseif ($haendler['status'] === 'suspended') {
            $errors[] = 'Ihr Konto wurde gesperrt. Bitte kontaktieren Sie den B2B-Support.';
        } else {
            // Prevent Session Fixation
            session_regenerate_id(true);

            $_SESSION['b2b_user_id'] = $haendler['id'];
            $_SESSION['b2b_firma'] = $haendler['firma'];

            // Update login timestamp
            $update = $pdo->prepare('UPDATE haendler SET letzter_login = NOW() WHERE id = ?');
            $update->execute([$haendler['id']]);

            header('Location: index.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Händler-Login - Bookfly B2B</title>
    <link rel="stylesheet" href="../static/css/style.css">
</head>
<body>

    <?php require_once __DIR__ . '/header.php'; ?>

    <section class="b2b-hero">
        <div class="container">
            <h1>Händler-Login</h1>
            <p>Melden Sie sich an, um auf B2B-Preise und Ihre Bestellungen zuzugreifen.</p>
        </div>
    </section>

    <main class="container">

        <?php if (!empty($errors)): ?>
            <div class="b2b-errors">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST" class="b2b-form">
            <div class="form-group">
                <label for="email">E-Mail</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Passwort</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary">Anmelden</button>
        </form>

    </main>

    <?php require_once __DIR__ . '/footer.php'; ?>

</body>
</html>