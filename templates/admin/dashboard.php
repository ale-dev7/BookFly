
<?php
// 1. Enforce admin protection
require_once __DIR__ . '/../../includes/admin_auth.php';
require_once __DIR__ . '/../../includes/db.php';

// 2. Handle status update actions (Activate/Suspend)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['haendler_id'])) {
    $newStatus = ($_POST['action'] === 'activate') ? 'active' : 'suspended';
    
    $stmt = $pdo->prepare('UPDATE haendler SET status = ? WHERE id = ?');
    $stmt->execute([$newStatus, $_POST['haendler_id']]);
    
    header('Location: dashboard.php');
    exit;
}

// 3. Fetch all registered Händler accounts
$stmt = $pdo->query('SELECT * FROM haendler ORDER BY erstellt_am DESC');
$haendlerList = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Bookfly B2B</title>
    <link rel="stylesheet" href="../../static/css/style.css">
</head>
<body>

    <header class="admin-header">
        <div class="container">
            <h2>Bookfly Admin Panel</h2>
            <p>Eingeloggt als Admin | <a href="logout.php">Abmelden</a></p>
        </div>
    </header>

    <main class="container">
        <h1>Händler-Registrierungen verwalten</h1>

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
                <?php foreach ($haendlerList as $h): ?>
                    <tr>
                        <td><?= htmlspecialchars($h['firma']) ?></td>
                        <td><?= htmlspecialchars($h['ansprechpartner']) ?></td>
                        <td><?= htmlspecialchars($h['email']) ?></td>
                        <td>
                            <span class="badge badge-<?= htmlspecialchars($h['status']) ?>">
                                <?= htmlspecialchars(strtoupper($h['status'])) ?>
                            </span>
                        </td>
                        <td>
                            <form action="dashboard.php" method="POST" style="display:inline;">
                                <input type="hidden" name="haendler_id" value="<?= $h['id'] ?>">
                                
                                <?php if ($h['status'] === 'pending'): ?>
                                    <button type="submit" name="action" value="activate" class="btn btn-success">Freischalten</button>
                                <?php elseif ($h['status'] === 'active'): ?>
                                    <button type="submit" name="action" value="suspend" class="btn btn-danger">Sperren</button>
                                <?php endif; ?>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

</body>
</html>