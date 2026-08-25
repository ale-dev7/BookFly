<?php
require_once __DIR__ . '/../../includes/admin_auth.php';
require_once __DIR__ . '/../../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['haendler_id'])) {
    $haendlerId = (int)$_POST['haendler_id'];

    if ($_POST['action'] === 'delete') {
        $stmt = $pdo->prepare('DELETE FROM haendler WHERE id = ?');
        $stmt->execute([$haendlerId]);

        $_SESSION['flash_message'] = "Händler wurde gelöscht.";
    } else {
        $newStatus = ($_POST['action'] === 'activate') ? 'active' : 'suspended';

        $stmt = $pdo->prepare('UPDATE haendler SET status = ? WHERE id = ?');
        $stmt->execute([$newStatus, $haendlerId]);

        $_SESSION['flash_message'] = "Händler-Status wurde erfolgreich geändert.";
    }

    header('Location: dashboard.php');
    exit;
}

$flashMessage = $_SESSION['flash_message'] ?? '';
unset($_SESSION['flash_message']);

$stmt = $pdo->query('SELECT * FROM haendler ORDER BY erstellt_am DESC');
$haendlerList = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Bookfly B2B</title>
    <link rel="stylesheet" href="../../static/css/style.css">
</head>
<body class="bg-light">

    <header class="admin-header">
        <div class="container">
            <h2>Bookfly Admin Panel</h2>
            <p>Eingeloggt als Admin | <a href="logout.php">Abmelden</a></p>
        </div>
    </header>

    <main class="container">
        <h1>Händler-Registrierungen verwalten</h1>

        <?php if (!empty($flashMessage)): ?>
            <div class="badge-active" style="padding: 10px; margin-bottom: 15px; border-radius: 4px;">
                <?= htmlspecialchars($flashMessage) ?>
            </div>
        <?php endif; ?>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>Firma</th>
                    <th>Ansprechpartner</th>
                    <th>E-Mail</th>
                    <th>Status</th>
                    <th>Aktionen</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($haendlerList)): ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">Keine Händler vorhanden.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($haendlerList as $h): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($h['firma']) ?></strong></td>
                            <td><?= htmlspecialchars($h['ansprechpartner'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($h['email']) ?></td>
                            <td>
                                <span class="badge badge-<?= htmlspecialchars($h['status']) ?>">
                                    <?= htmlspecialchars(strtoupper($h['status'])) ?>
                                </span>
                            </td>
                            <td>
                                <form action="dashboard.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="haendler_id" value="<?= $h['id'] ?>">
                                    
                                    <?php if ($h['status'] === 'pending' || $h['status'] === 'suspended'): ?>
                                        <button type="submit" name="action" value="activate" class="btn btn-success">Freischalten</button>
                                    <?php endif; ?>

                                    <?php if ($h['status'] === 'active'): ?>
                                        <button type="submit" name="action" value="suspend" class="btn btn-danger">Sperren</button>
                                    <?php endif; ?>

                                    <!-- Neuer Löschen-Button mit Sicherheitsabfrage -->
                                    <button type="submit" name="action" value="delete" class="btn btn-outline-danger" onclick="return confirm('Möchtest du diesen Händler wirklich unwiderruflich löschen?');">
                                        Löschen
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </main>

</body>
</html>