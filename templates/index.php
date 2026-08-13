<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Prüfen, ob ein Händler angemeldet ist
$isLoggedIn = isset($_SESSION['b2b_user_id']);
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookfly B2B Portal | Großhandel & Geschäftskunden</title>
    <link rel="stylesheet" href="../static/css/style.css">
</head>
<body>

    <!-- ================= HEADER ================= -->
    <header class="b2b-header">
        <div class="header-top-bar">
            <span>B2B-Kundenservice: +49 (0) 30 12345678 | Mo–Fr 08:00–17:00 Uhr</span>
            <div class="header-top-links">
                <a href="#konditionen">Händler-Konditionen</a>
                <a href="#hilfe">Hilfe & FAQ</a>
            </div>
        </div>
        
        <div class="header-main container">
            <div class="logo">
                <a href="index.php">
                    <img src="../static/Bookfly-logo.png" alt="Bookfly Logo">
                </a>
                <span class="b2b-badge">B2B Portal</span>
            </div>

            <?php if ($isLoggedIn): ?>
                <!-- NUR FÜR ANGEMELDETE HÄNDLER -->
                <div class="header-search">
                    <form action="index.php" method="GET">
                        <input type="text" name="query" placeholder="Suchen nach ISBN, Titel, Autor..." required>
                        <button type="submit">Suchen</button>
                    </form>
                </div>

                <div class="header-actions">
                    <a href="dashboard.php" class="btn btn-outline">Mein Konto</a>
                    <a href="cart.php" class="cart-btn">
                        <span>Warenkorb</span>
                        <span class="cart-count">(<?php echo $_SESSION['cart_count'] ?? 0; ?>)</span>
                    </a>
                    <a href="logout.php" class="btn btn-logout">Abmelden</a>
                </div>
            <?php else: ?>
                <!-- NUR FÜR GÄSTE (NICHT EINGELOGGT) -->
                <div class="header-actions">
                    <a href="login.php" class="btn btn-outline">Händler-Login</a>
                    <a href="register.php" class="btn btn-primary">Als Händler registrieren</a>
                </div>
            <?php endif; ?>
        </div>
    </header>

    <!-- ================= HERO BEREICH ================= -->
    <section class="b2b-hero">
        <div class="container hero-content">
            <h1>Großhandel & Nachbestellungen für den Buchhandel</h1>
            <p>Profitieren Sie von attraktiven Händler-Rabatten, flexibler Rechnungsabwicklung und schneller Lieferung direkt aus unserem Zentrallager.</p>
            
            <div class="hero-actions">
                <?php if ($isLoggedIn): ?>
                    <a href="#schnellbestellung" class="btn btn-primary">ISBN-Schnellbestellung</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-primary">Jetzt Anmelden</a>
                    <a href="register.php" class="btn btn-secondary">Als Händler registrieren</a>
                <?php endif; ?>
            </div>

            <ul class="b2b-benefits">
                <li>✓ Kauf auf Rechnung (30 Tage)</li>
                <li>✓ Bis zu 40% Buchhändlerrabatt</li>
                <li>✓ Express-Lieferung am nächsten Werktag</li>
            </ul>
        </div>
    </section>

    <!-- ================= HAUPTBEREICH (MAIN) ================= -->
    <main class="container main-content">

        <?php if ($isLoggedIn): ?>

            <!-- 1. ISBN-Schnellbestellungs-Modul (Nur für eingeloggte Händler) -->
            <section id="schnellbestellung" class="quick-order-section">
                <h2>ISBN-Direkteingabe / Schnellbestellung</h2>
                <p>Geben Sie eine oder mehrere ISBNs ein, um Artikel direkt zum Warenkorb hinzuzufügen.</p>
                
                <form action="index.php" method="POST" class="quick-order-form">
                    <div class="form-row">
                        <input type="text" name="isbn[]" placeholder="ISBN (z.B. 978-3-16-148410-0)">
                        <input type="number" name="quantity[]" value="1" min="1" placeholder="Menge">
                        <button type="button" class="btn btn-small">+ Zeile</button>
                    </div>
                    <button type="submit" class="btn btn-primary">In den Warenkorb übernehmen</button>
                </form>
            </section>

            <!-- 2. B2B Katalog / Produktübersicht (Nur für eingeloggte Händler) -->
            <section class="b2b-catalog">
                <div class="catalog-header">
                    <h2>Aktuelle B2B-Katalogtitel & Bestseller</h2>
                    <div class="catalog-controls">
                        <span>Preisanzeige: <strong>Nettopreise (zzgl. MwSt.)</strong></span>
                    </div>
                </div>

                <table class="b2b-table">
                    <thead>
                        <tr>
                            <th>Cover</th>
                            <th>Titel / Autor / ISBN</th>
                            <th>Verpackungseinheit (VE)</th>
                            <th>Lagerbestand</th>
                            <th>Nettopreis (UVP)</th>
                            <th>Ihr B2B-Preis</th>
                            <th>Bestellmenge</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><img src="https://via.placeholder.com/50x70" alt="Cover" class="thumb"></td>
                            <td>
                                <strong>Beispiel-Buchtitel 01</strong><br>
                                <small>Autor Name | ISBN: 978-3-123456-78-9</small>
                            </td>
                            <td>10 Stk.</td>
                            <td><span class="stock-badge in-stock">Auf Lager (> 100)</span></td>
                            <td><del>12,15 €</del></td>
                            <td><strong>8,50 €</strong> zzgl. USt.</td>
                            <td>
                                <form action="#" method="POST" class="table-order-form">
                                    <input type="number" value="10" min="1" step="1">
                                    <button type="submit" class="btn btn-small">Hinzufügen</button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>

        <?php else: ?>

            <!-- INFOS FÜR UNANGEMELDETE GÄSTE -->
            <section class="b2b-guest-info">
                <h2>Zugang nur für registrierte Geschäftskunden</h2>
                <p>Um unsere Buchpreise, B2B-Konditionen und das Schnellbestell-System nutzen zu können, melden Sie sich bitte an oder beantragen Sie ein neues Händlerkonto.</p>
                
                <div class="info-grid">
                    <div class="info-card">
                        <h3>B2B-Kundenservice</h3>
                        <p>Mo–Fr: 08:00 – 17:00 Uhr<br>Telefon: +49 (0) 30 12345678<br>E-Mail: b2b@bookfly.de</p>
                    </div>
                    <div class="info-card">
                        <h3>Vorteile für Buchhandlungen</h3>
                        <p>Kauf auf Rechnung mit 30 Tagen Zahlungsziel, Buchhändlerrabatte und ISBN-Direktbestellung.</p>
                    </div>
                </div>
            </section>

        <?php endif; ?>

    </main>

    <!-- ================= FOOTER ================= -->
    <footer class="b2b-footer">
        <div class="container footer-grid">
            <div class="footer-col">
                <h3>Bookfly B2B</h3>
                <p>Ihr zuverlässiger Partner für Verlags- und Buchhandelslogistik.</p>
                <p><small>© 2026 Bookfly GmbH<br>Eulenstraße 11 · 10115 Smaragdstadt</small></p>
            </div>

            <div class="footer-col">
                <h4>Geschäftskunden-Service</h4>
                <ul>
                    <li><a href="#">Händler-Konditionen & Staffeln</a></li>
                    <li><a href="#">Liefer- & Versandkonditionen</a></li>
                    <li><a href="#">Zahlungsarten & SEPA</a></li>
                    <li><a href="#">EDI / API-Schnittstellen</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Rechtliches (B2B)</h4>
                <ul>
                    <li><a href="#">AGB für Geschäftskunden</a></li>
                    <li><a href="#">Widerrufsbelehrung (B2B)</a></li>
                    <li><a href="#">Datenschutz</a></li>
                    <li><a href="#">Impressum</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>B2B-Supportzeiten</h4>
                <p>Montag – Freitag: 08:00 – 17:00 Uhr<br>
                E-Mail: b2b@bookfly.de<br>
                Tel: +49 (0) 30 12345678</p>
            </div>
        </div>
    </footer>

    <script src="../static/js/script.js"></script>
</body>
</html>


<script>
document.addEventListener('DOMContentLoaded', () => {
    const addRowBtn = document.querySelector('.quick-order-form .btn-small');
    if (addRowBtn) {
        addRowBtn.addEventListener('click', () => {
            const form = document.querySelector('.quick-order-form');
            const newRow = document.createElement('div');
            newRow.className = 'form-row';
            newRow.style.marginTop = '10px';
            newRow.innerHTML = `
                <input type="text" name="isbn[]" placeholder="ISBN (z.B. 978-3-16-148410-0)">
                <input type="number" name="quantity[]" value="1" min="1" placeholder="Menge">
                <button type="button" class="btn btn-small btn-danger" onclick="this.parentElement.remove()">✕</button>
            `;
            // Fügt die neue Zeile direkt vor dem Absende-Button ein
            form.insertBefore(newRow, form.querySelector('button[type="submit"]'));
        });
    }
});
</script>

