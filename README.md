# Games Galaxy

![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.x-4479A1?logo=mysql&logoColor=white)
![Status](https://img.shields.io/badge/Status-Hochschulprojekt-blue)
![License](https://img.shields.io/badge/Lizenz-CC%20BY--NC--ND%204.0-lightgrey)

Games Galaxy ist ein PHP-basierter Online-Shop für PC-Spiele. Das Projekt bildet typische Shop-Funktionen wie Spielekatalog, Suche, Benutzerkonto, Wunschliste, Warenkorb, Checkout sowie eine Rollen- und Rechteverwaltung für administrative Bereiche ab.

## Inhaltsverzeichnis

- [Projektziel](#projektziel)
- [Aktueller Status](#aktueller-status)
- [Screenshots](#screenshots)
- [Features](#features)
- [Tech-Stack](#tech-stack)
- [Installation und lokaler Start](#installation-und-lokaler-start)
- [Nutzung](#nutzung)
- [Rollen und Rechte](#rollen-und-rechte)
- [Tests](#tests)
- [Projektstruktur](#projektstruktur)
- [Roadmap](#roadmap)
- [License](#License)

## Projektziel

Ziel des Projekts ist die Umsetzung eines strukturierten Webshops für PC-Games mit klarer Navigation, responsivem Layout und rollen- sowie rechtebasierten Funktionen. Neben der Produktansicht stehen zentrale E-Commerce-Abläufe wie Registrierung, Login, Wunschliste, Warenkorb und Kaufabwicklung im Fokus.

## Aktueller Status

Das Projekt ist ein lauffähiger Prototyp aus einem Hochschulkontext. Die Anwendung nutzt PHP, MySQL und eine einfache MVC-Struktur. Die Datenbankstruktur und Beispielinhalte liegen als SQL-Datei im Repository.

## Screenshots

### Startseite

![Games Galaxy Startseite](docs/screenshots/games_galaxy-home-page.png)

### Figma-Ansichten

| Desktop | Mobil |
| --- | --- |
| ![Desktop-Ansicht in Figma](docs/screenshots/desktop-ansicht-figma.png) | ![Mobile Ansicht in Figma](docs/screenshots/mobile-ansicht-figma.png) |

### Dokumentation

| Sitemap | Flussdiagramm | ER-Modell |
| --- | --- | --- |
| ![Sitemap](docs/screenshots/Sitemap_games_galaxy.png) | ![Flussdiagramm](docs/screenshots/Flussdiagramm_games_galaxy.png) | ![ER-Modell](docs/screenshots/ER-Modell_games_galaxy.png) |

## Features

- Spielekatalog mit Plattformbereichen für Steam, Battle.net und Epic Games
- Detailseiten für einzelne Spiele
- Suche nach Spielen
- Registrierung und Login
- Profilbearbeitung
- Wunschliste
- Warenkorb und Checkout
- Kaufverlauf
- Rollen- und Rechteverwaltung über definierte Berechtigungen
- Verwaltungsfunktionen für Benutzer und Spiele abhängig von den zugewiesenen Rechten
- Kontakt-, FAQ-, Impressums- und Dokumentationsseiten
- Responsives Layout mit Desktop- und Mobilnavigation

## Tech-Stack

- **Frontend:** HTML, CSS, JavaScript
- **Backend:** PHP 8.x
- **Datenbank:** MySQL 8.x
- **Webserver:** Apache, zum Beispiel über XAMPP
- **Architektur:** MVC-orientierte Projektstruktur

## Installation und lokaler Start

### Voraussetzungen

- PHP 8.x
- MySQL 8.x oder MariaDB
- Apache mit aktiviertem `mod_rewrite`
- Lokale Entwicklungsumgebung wie XAMPP, MAMP oder eine vergleichbare PHP/MySQL-Installation

### Einrichtung

1. Repository in das lokale Webserver-Verzeichnis legen.

   Beispiel für XAMPP unter Windows:

   ```powershell
   C:\xampp\htdocs\dwp_ws2324_rkt
   ```

2. Datenbank importieren.

   ```sql
   SOURCE gamesgalaxy/GG_DBMS.sql;
   ```

   Alternativ kann die Datei `gamesgalaxy/GG_DBMS.sql` über phpMyAdmin importiert werden.

3. Datenbankverbindung prüfen.

   Die Verbindung ist in `gamesgalaxy/lib/DatabaseConnection.php` definiert und nutzt lokal standardmäßig:

   ```text
   Host: localhost
   Datenbank: gg_dbms
   Benutzer: root
   Passwort: leer
   ```

4. Anwendung im Browser öffnen.

   ```text
   http://localhost/dwp_ws2324_rkt/gamesgalaxy/Startseite/Show
   ```

## Nutzung

Die Anwendung wird über die Navigation bedient. Besucher können Spiele durchsuchen und Detailseiten ansehen. Registrierte Benutzer können zusätzlich Wunschliste, Warenkorb, Checkout und Kaufverlauf nutzen. Benutzer mit erweiterten Rechten erhalten Zugriff auf geschützte Verwaltungsfunktionen für Spiele und Benutzer.

## Rollen und Rechte

Nach dem Import der SQL-Datei stehen zwei Beispielkonten zur Verfügung, mit denen sich die Rechteverwaltung direkt testen lässt:

- `Admin User` mit `admin@example.com` / `adminpass`
- `Regular User` mit `user@example.com` / `userpass`

Die Rechte werden in der Tabelle `user_authority` verwaltet. Dort sind einzelne Berechtigungen wie `create_user`, `change_user`, `delete_user`, `create_game`, `change_game` und `delete_game` hinterlegt.

Dadurch sind Verwaltungsbereiche nicht nur über den Login geschützt, sondern zusätzlich an konkrete Berechtigungen gebunden. Der Admin-Testnutzer besitzt Vollzugriff auf Benutzer- und Spieleverwaltung. Der zweite Testnutzer deckt einen eingeschränkten Rechtefall ab und kann damit vom vollständigen Administrationszugriff unterschieden werden.

## Tests

Automatisierte Tests sind aktuell nicht eingerichtet. Die wichtigsten Funktionen sollten nach Änderungen manuell geprüft werden:

- Startseite und Navigation
- Registrierung und Login
- Suche und Spielefilter
- Wunschliste
- Warenkorb und Checkout
- Admin-Funktionen
- Responsives Verhalten auf Desktop und Mobilgeräten

## Projektstruktur

```text
.
├── docs/
│   └── screenshots/
├── gamesgalaxy/
│   ├── controller/
│   ├── images/
│   ├── js/
│   ├── lib/
│   ├── model/
│   ├── static/
│   ├── view/
│   ├── GG_DBMS.sql
│   └── index.php
├── .htaccess
└── README.md
```

## License

Copyright (c) 2026 Mohammad Taiba. All rights reserved.

This project is published for portfolio and review purposes only. See [LICENSE](./LICENSE).
