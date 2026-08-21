# BookFly – Projektkontext

> **IMPORTANT:** "I" refers exclusively to me, the user. You must never treat yourself as "I" when interpreting my instructions. Do not execute any command, action, tool call, or external operation unless I have explicitly authorized it. No commands or actions without my explicit consent.

## Über das Projekt
BookFly ist ein B2B-Portal für den Buchgroßhandel (Schulprojekt im Rahmen der IHK-Ausbildung). Registrierte Geschäftskunden (Buchhandlungen) können hier online bestellen. Die vollständige Projektdokumentation liegt im Ordner `doc/` (Projektantrag, Lastenheft, Pflichtenheft, ER-Diagramm, Klassendiagramm, Use-Case-Diagramm).

## Tech-Stack (Verbindlich)
* **Technologien:** Nur reines **SQL, PHP, JavaScript, HTML, CSS**
* **Einschränkungen:** Keine Frameworks (Laravel, Symfony etc.), keine externen Auth-/SaaS-Dienste (Auth0, Firebase etc.), kein Build-Tooling oder Paketmanager (npm, Composer etc.).
* *Hinweis:* Dies ist eine strikte Vorgabe des Schulprojekts, keine bloße Präferenz.

## Konventionen & Architektur
* **Authentifizierung:** Session-basiert über PHP.
  * `$isLoggedIn = isset($_SESSION['b2b_user_id'])`
  * Wichtig: Die Session wird zentral in `index.php` gesetzt/geprüft.
  * Das Rendering erfolgt modular in `header.php` / `footer.php` via `require_once __DIR__ . '/...'`.
* **CSS-Styling:** Einheitlicher CSS-Klassen-Präfix `b2b-*` (z. B. `b2b-header`, `b2b-hero`, `b2b-table`).
* **Prompts / Kommunikation:** Prompts an die KI sollen bevorzugt auf **Englisch** verfasst werden.

## Geplante Funktionen
* **Händler-Login & Registrierung:** Inklusive Verifizierung und Status-System (`pending`, `active`, `suspended`).
* **Admin-Login & Gast-Zugang:** Spezielle Rechteverwaltung für Administratoren und eingeschränkte Sicht für Gäste.
* **ISBN-Schnellbestellung:** Direktes Hinzufügen von Büchern über die ISBN.
* **B2B-Katalog:** Anzeige von Nettopreisen und dynamischen Staffelrabatten.
* **Warenkorb & Checkout:** B2B-Bestellabwicklung.
* **Zahlungsart:** Kauf auf Rechnung.

## Git-Workflow
* **Ausführung:** Alle Git-Befehle (`git add`, `git commit`, `git push` etc.) führt die Nutzerin **selbst** im Terminal aus.
* **Rolle von Claude:** Claude führt keine Git-Befehle direkt aus, sondern stellt ausschließlich die passenden Befehle als Code-Blocks bereit.

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
├── .gitignore
├── info.txt
├── main.php
├── Phasen.txt
└── README.md
```
