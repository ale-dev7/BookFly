<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$isLoggedIn = isset($_SESSION['b2b_user_id']);

$errors = [];
$success = false;

// Initialize form fields with defaults
$fields = [
    'firma' => '', 'ansprechpartner' => '', 'ust_idnr' => '',
    'strasse_hausnummer' => '', 'plz' => '', 'ort' => '',
    'land' => 'Deutschland', 'email' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Trim all posted text fields at once
    foreach ($fields as $key => $default) {
        $fields[$key] = trim($_POST[$key] ?? $default);
    }

    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    // Validation
    if ($fields['firma'] === '') {
        $errors[] = 'Firma ist erforderlich.';
    }
    if (!filter_var($fields['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Bitte eine gültige E-Mail-Adresse angeben.';
    }
    if (strlen($password) < 8) {
        $errors[] = 'Passwort muss mindestens 8 Zeichen lang sein.';
    }
    if ($password !== $password_confirm) {
        $errors[] = 'Die Passwörter stimmen nicht überein.';
    }

    // Process Registration
    if (empty($errors)) {
        require_once __DIR__ . '/../includes/db.php';

        $stmt = $pdo->prepare('SELECT id FROM haendler WHERE email = ?');
        $stmt->execute([$fields['email']]);

        if ($stmt->fetch()) {
            $errors[] = 'Diese E-Mail-Adresse ist bereits registriert.';
        } else {
            $passwort_hash = password_hash($password, PASSWORD_DEFAULT);

            $sql = 'INSERT INTO haendler 
                    (firma, ansprechpartner, email, passwort_hash, ust_idnr, strasse_hausnummer, plz, ort, land)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $fields['firma'], $fields['ansprechpartner'], $fields['email'], 
                $passwort_hash, $fields['ust_idnr'], $fields['strasse_hausnummer'], 
                $fields['plz'], $fields['ort'], $fields['land']
            ]);

            $success = true;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Händler-Registrierung - Bookfly B2B</title>
    <link rel="stylesheet" href="../static/css/style.css">
</head>
<body>

    <?php require_once __DIR__ . '/header.php'; ?>

    <section class="b2b-hero">
        <div class="container">
            <h1>Als Händler registrieren</h1>
            <p>Registrieren Sie Ihre Buchhandlung für Zugang zu B2B-Preisen und Staffelrabatten.</p>
        </div>
    </section>

    <main class="container">

        <?php if ($success): ?>
            <p class="b2b-success">Registrierung erfolgreich! Ihr Konto wird innerhalb von 24h geprüft.</p>
        <?php else: ?>

            <?php if (!empty($errors)): ?>
                <ul class="b2b-errors">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <form action="register.php" method="POST" class="b2b-form">
                <h2>Firmendaten</h2>
                <label for="firma">Firma *</label>
                <input type="text" id="firma" name="firma" value="<?= htmlspecialchars($fields['firma']) ?>" required>

                <label for="ansprechpartner">Ansprechpartner</label>
                <input type="text" id="ansprechpartner" name="ansprechpartner" value="<?= htmlspecialchars($fields['ansprechpartner']) ?>">

                <label for="ust_idnr">USt-IdNr.</label>
                <input type="text" id="ust_idnr" name="ust_idnr" value="<?= htmlspecialchars($fields['ust_idnr']) ?>">

                <h2>Adresse</h2>
                <label for="strasse_hausnummer">Straße und Hausnummer</label>
                <input type="text" id="strasse_hausnummer" name="strasse_hausnummer" value="<?= htmlspecialchars($fields['strasse_hausnummer']) ?>">

                <label for="plz">PLZ</label>
                <input type="text" id="plz" name="plz" value="<?= htmlspecialchars($fields['plz']) ?>">

                <label for="ort">Ort</label>
                <input type="text" id="ort" name="ort" value="<?= htmlspecialchars($fields['ort']) ?>">

                <label for="land">Land</label>
                <input type="text" id="land" name="land" value="<?= htmlspecialchars($fields['land']) ?>">

                <h2>Zugangsdaten</h2>
                <label for="email">E-Mail *</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($fields['email']) ?>" required>

                <label for="password">Passwort *</label>
                <input type="password" id="password" name="password" required>

                <label for="password_confirm">Passwort bestätigen *</label>
                <input type="password" id="password_confirm" name="password_confirm" required>

                <button type="submit" class="btn btn-primary">Registrieren</button>
            </form>

        <?php endif; ?>

    </main>

    <?php require_once __DIR__ . '/footer.php'; ?>

</body>
</html>