CREATE TABLE haendler (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firma VARCHAR(255) NOT NULL,
    ansprechpartner VARCHAR(255),
    email VARCHAR(255) NOT NULL UNIQUE,
    passwort_hash VARCHAR(255) NOT NULL,
    ust_idnr VARCHAR(50),
    
    -- Adresse
    strasse_hausnummer VARCHAR(255),
    plz VARCHAR(20),
    ort VARCHAR(255),
    land VARCHAR(100) DEFAULT 'Deutschland',
    
    -- B2B Konditionen
    kreditlimit DECIMAL(10, 2) DEFAULT 1000.00,
    
    -- Sicherheit & Status
    status ENUM('pending', 'active', 'suspended') DEFAULT 'pending',
    reset_token VARCHAR(64) NULL,
    reset_expires_at DATETIME NULL,
    letzter_login DATETIME NULL,
    
    -- Timestamps
    erstellt_am TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    aktualisiert_am TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    passwort_hash VARCHAR(255) NOT NULL,
    erstellt_am TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    isbn VARCHAR(20) NOT NULL UNIQUE,
    titel VARCHAR(255) NOT NULL,
    autor VARCHAR(255),
    verlag VARCHAR(255),
    kategorie ENUM('Belletristik', 'Fachbücher', 'Schulbücher', 'Kinderbücher') NOT NULL,
    verpackungseinheit INT NOT NULL DEFAULT 1,
    lagerbestand INT NOT NULL DEFAULT 0,
    nettopreis_uvp DECIMAL(10, 2) NOT NULL,
    b2b_preis DECIMAL(10, 2) NOT NULL,
    cover_bild VARCHAR(255),
    erstellt_am TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT IGNORE INTO books (isbn, titel, autor, verlag, kategorie, verpackungseinheit, lagerbestand, nettopreis_uvp, b2b_preis, cover_bild) VALUES
('978-3-16-148410-0', 'Der Schatten des Windes', 'Carlos Ruiz Zafón', 'Fischer', 'Belletristik', 10, 120, 12.15, 8.50, 'beispiel.png'),
('978-3-12-345678-9', 'Grundlagen der BWL', 'Thomas Schmidt', 'Springer', 'Fachbücher', 5, 45, 39.90, 29.90, 'beispiel.png'),
('978-3-06-000000-1', 'Mathematik 7. Klasse', 'Verlagsteam', 'Cornelsen', 'Schulbücher', 25, 300, 19.95, 15.00, 'beispiel.png'),
('978-3-55-123456-7', 'Der kleine Drache Kokosnuss', 'Ingo Siegner', 'cbj', 'Kinderbücher', 10, 80, 9.99, 6.50, 'beispiel.png'),
('978-3-42-198765-4', 'Sturmhöhe', 'Emily Brontë', 'Reclam', 'Belletristik', 10, 0, 6.80, 4.20, 'beispiel.png');

