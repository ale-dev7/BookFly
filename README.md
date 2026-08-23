# Bookfly

Bookfly B2B-Portal für den Buchgroßhandel – Web-Anwendung, mit der
registrierte Geschäftskunden (Buchhandlungen) online bestellen können.

## Schulprojekt
Dieses Projekt entsteht im Rahmen der Ausbildung nach IHK-Vorgaben.
Die vollständige Projektdokumentation (Projektantrag, Lastenheft,
Pflichtenheft, ER-Diagramm, Klassendiagramm, Use-Case-Diagramm etc.)
befindet sich im Ordner [`doc/`](doc/).

## Geplante Funktionen
* **Händler-Login & Registrierung:** Inklusive Verifizierung und Status-System (`pending`, `active`, `suspended`).
* **Admin-Login & Gast-Zugang:** Spezielle Rechteverwaltung für Administratoren und eingeschränkte Sicht für Gäste.
* **ISBN-Schnellbestellung:** Direktes Hinzufügen von Büchern über die ISBN.
* **B2B-Katalog:** Anzeige von Nettopreisen und dynamischen Staffelrabatten.
* **Warenkorb & Checkout:** B2B-Bestellabwicklung.
* **Zahlungsart:** Kauf auf Rechnung.

## Tech-Stack (Verbindlich)
* **Technologien:** Nur reines **SQL, PHP, JavaScript, HTML, CSS**
* *Hinweis:* Dies ist eine strikte Vorgabe des Schulprojekts, keine bloße Präferenz.

## Konventionen & Architektur
* **Authentifizierung:** Session-basiert über PHP.
  * `$isLoggedIn = isset($_SESSION['b2b_user_id'])`
  * Wichtig: Die Session wird zentral in `index.php` gesetzt/geprüft.
  * Das Rendering erfolgt modular in `header.php` / `footer.php` via `require_once __DIR__ . '/...'`.
* **CSS-Styling:** Einheitlicher CSS-Klassen-Präfix `b2b-*` (z. B. `b2b-header`, `b2b-hero`, `b2b-table`).
* **Prompts / Kommunikation:** Prompts an die KI sollen bevorzugt auf **Englisch** verfasst werden.

## Datenbank-Umgebung

MySQL läuft in einer **Ubuntu-VM in VMware Fusion** und nicht direkt auf dem Mac-Host.

* **VM-IP:** über Avahi Localhost — erreichbar als `datenbank.local` (mDNS); das Nachverfolgen der reinen IP entfällt, da sich diese nach einem Neustart ändert
* **Datenbankname:** `bookfly`
* PHP (läuft auf dem Mac über `php -S localhost:8000`) verbindet sich über diese Netzwerkgrenze zwischen Mac und VM mit MySQL. Daher muss `includes/db.php` `datenbank.local` als Host verwenden.
* Übertragung von Dateien vom Mac zur VM (z. B. Schema-Dateien) via `scp` direkt aus dem Mac-Terminal

## Projektstruktur
```
BookFly/
├── database/
│   └── init.sql
├── doc/
│   ├── 01. Projektantrag.pdf
│   ├── 02. Git-Repository
│   ├── 03. Anforderungsanalyse.pdf
│   ├── 04. Lastenheft (Was?).pdf
│   ├── 05.ER-Diagramm.pdf
│   ├── 06. Pflichtenheft (Wie?).pdf
│   ├── 07. Arbeitspakete & Projektstrukturplan.pdf
│   ├── 08. Meilensteine & Netzplan.pdf
│   ├── 09. UML Use-Case-Diagramm.pdf
│   └── 10. Klassendiagramm.pdf
├── includes/
│   ├── db.php
│   └── functions.php
├── static/
│   ├── css/
│   │   └── style.css
│   ├── img/
│   │   └── Bookfly-logo.png
│   └── js/
│       └── script.js
├── templates/
│   ├── footer.php
│   ├── header.php
│   ├── index.php
│   ├── login.php
│   └── logout.php
├── main.php
├── Phasen.txt
└── README.md
```

## Autor
Ale 
