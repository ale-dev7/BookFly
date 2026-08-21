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


