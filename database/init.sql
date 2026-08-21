CREATE TABLE haendler (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firma VARCHAR(255) NOT NULL,
    ansprechpartner VARCHAR(255),
    email VARCHAR(255) NOT NULL UNIQUE,
    passwort_hash VARCHAR(255) NOT NULL,
    ust_idnr VARCHAR(50),
    status ENUM('pending', 'active', 'suspended') DEFAULT 'pending',
    erstellt_am TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    aktualisiert_am TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
