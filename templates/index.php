
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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

    <?php require_once __DIR__ . '/header.php'; ?>

    <!-- ================= HERO BEREICH ================= -->
    <section class="b2b-hero">
        <div class="container hero-content">
            <h1>Großhandel & Nachbestellungen für den Buchhandel</h1>
            <p>Profitieren Sie von attraktiven Händler-Rabatten, flexibler Rechnungsabwicklung und schneller Lieferung direkt aus unserem Zentrallager.</p>
            
            <?php if ($isLoggedIn): ?>
                <!-- Für eingeloggte Nutzer: Direkter Schnellzugriff -->
                <div class="hero-actions">
                    <a href="#schnellbestellung" class="btn btn-primary">ISBN-Schnellbestellung</a>
                </div>
            <?php else: ?>
                <!-- Für Gäste: Info-Text statt doppelter Buttons -->
                <div class="hero-info-text">
                    <p><strong>Exklusiv für Geschäftskunden:</strong> Einfache Verifizierung über Gewerbenachweis innerhalb von 24h.</p>
                    <p><strong>Ihr zuverlässiger Partner für Verlags- und Buchhandelslogistik.</strong></p>
                </div>
            <?php endif; ?>

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

    <?php require_once __DIR__ . '/footer.php'; ?>

    
    <script src="../static/js/script.js"></script>
</body>
</html>
