    <!-- ================= HEADER ================= -->
    <header class="b2b-header">
        <div class="header-top-bar">
            <span>B2B-Kundenservice: +49 (0) 30 12345678 | Mo-Fr 08:00-17:00 Uhr</span>
        </div>

        <div class="header-main container">
            <div class="logo">
                <a href="index.php">
                    <img src="../static/img/Bookfly-logo.png" alt="Bookfly Logo">
                </a>
                <span class="b2b-badge">B2B</span>
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
