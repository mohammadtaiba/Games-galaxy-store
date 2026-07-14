# Games Galaxy

![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.x-4479A1?logo=mysql&logoColor=white)
![Status](https://img.shields.io/badge/Status-Hochschulprojekt-blue)
![License](https://img.shields.io/badge/Lizenz-CC%20BY--NC--ND%204.0-lightgrey)

Games Galaxy ist ein PHP-basierter Online-Shop für PC-Spiele. Das Projekt bildet typische Shop-Funktionen wie Spielekatalog, Suche, optionale erweiterte KI-Suche, Benutzerkonto, Wunschliste, Warenkorb, Checkout sowie eine Rollen- und Rechteverwaltung für administrative Bereiche ab.

## Inhaltsverzeichnis

- [Projektziel](#projektziel)
- [Aktueller Status](#aktueller-status)
- [Demo](#Demo)
- [Screenshots](#screenshots)
- [Features](#features)
- [Tech-Stack](#tech-stack)
- [Installation und lokaler Start](#installation-und-lokaler-start)
- [Optionale erweiterte KI-Suche](#optionale-erweiterte-ki-suche)
- [Nutzung](#nutzung)
- [Rollen und Rechte](#rollen-und-rechte)
- [Tests](#tests)
- [Projektstruktur](#projektstruktur)
- [Roadmap](#roadmap)
- [License](#License)

## Projektziel

![Games Galaxy Demo](docs/demo/games-galaxy-demo.mp4)


Ziel des Projekts ist die Umsetzung eines strukturierten Webshops für PC-Games mit klarer Navigation, responsivem Layout und rollen- sowie rechtebasierten Funktionen. Neben der Produktansicht stehen zentrale E-Commerce-Abläufe wie Registrierung, Login, Wunschliste, Warenkorb und Kaufabwicklung im Fokus.

## Aktueller Status

Das Projekt ist ein lauffähiger Prototyp aus einem Hochschulkontext. Die Anwendung nutzt PHP, MySQL und eine einfache MVC-Struktur. Die Datenbankstruktur und Beispielinhalte liegen als SQL-Datei im Repository.

## Demo

<a href="docs/demo/games-galaxy-demo.mp4">
    <img
        src="docs/screenshots/games-galaxy-demo.gif"
        alt="Games Galaxy Demo"
        width="480"
    >
</a>

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
- Optionale erweiterte KI-Suche mit Elasticsearch, Embeddings und exakten Filtern für Preis, Genre, Plattform sowie Online- und Offline-Modus
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
- **Optionale Suche:** Elasticsearch 8.x und Ollama für lokale Embeddings
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

   Alternativ können die Werte über Umgebungsvariablen gesetzt werden:

   ```powershell
   $env:GG_DB_HOST = "localhost"
   $env:GG_DB_NAME = "gg_dbms"
   $env:GG_DB_USER = "root"
   $env:GG_DB_PASSWORD = ""
   ```

4. Anwendung im Browser öffnen.

   ```text
   http://localhost/dwp_ws2324_rkt/gamesgalaxy/Startseite/Show
   ```

## Optionale erweiterte KI-Suche

Die Standardsuche unter `/Search/Show?q=...` bleibt unverändert. Die erweiterte KI-Suche ist zusätzlich über den Header neben der normalen Suche und unter folgendem Pfad erreichbar:

```text
http://localhost/dwp_ws2324_rkt/gamesgalaxy/AdvancedSearch/Show
```

Sie verarbeitet natürliche Anfragen wie:

```text
Shooter unter 50 Euro, online und offline spielbar
```

Elasticsearch übernimmt Volltext-, Vektor- und Filtersuche. Preis, Genre, Plattform sowie Online- und Offline-Modus werden als exakte Filter behandelt. Die KI erzeugt kein SQL. Die Embeddings werden lokal über Ollama erzeugt, sodass kein externer Embedding-API-Key nötig ist. Optional kann ein lokales Ollama-Chatmodell natürliche Nutzeranfragen zuerst in ein festes JSON-Format mit Suchabsicht umformen. Wenn der Query-Interpreter nicht konfiguriert ist oder ausfällt, wird der technische Parser als Fallback genutzt. Wenn Elasticsearch oder Ollama für Embeddings nicht erreichbar ist, fällt die Anwendung automatisch auf die bestehende Standardsuche zurück.

### Konfiguration

Zugangsdaten werden über Umgebungsvariablen gesetzt und nicht im Repository gespeichert. Eine Vorlage liegt in `.env.example`.

Für lokale Embeddings muss Ollama laufen und ein Embedding-Modell lokal vorhanden sein:

```powershell
ollama pull nomic-embed-text
```

Für die optionale mehrsprachige Umformulierung natürlicher Anfragen wird zusätzlich ein lokales Chatmodell benötigt, zum Beispiel:

```powershell
ollama pull llama3.2:3b
```

Elasticsearch kann lokal über Docker Compose gestartet werden:

```powershell
docker compose up -d elasticsearch
```

```powershell
$env:GG_ELASTICSEARCH_URL = "http://localhost:9200"
$env:GG_ELASTICSEARCH_INDEX = "games_galaxy_games"
$env:GG_ELASTICSEARCH_USERNAME = ""
$env:GG_ELASTICSEARCH_PASSWORD = ""
$env:GG_ELASTICSEARCH_API_KEY = ""

$env:GG_EMBEDDING_PROVIDER = "ollama"
$env:GG_EMBEDDING_ENDPOINT = "http://localhost:11434/api/embed"
$env:GG_EMBEDDING_MODEL = "nomic-embed-text"
$env:GG_EMBEDDING_DIMENSIONS = "0"

$env:GG_QUERY_INTERPRETER_ENABLED = "1"
$env:GG_QUERY_INTERPRETER_ENDPOINT = "http://localhost:11434/api/chat"
$env:GG_QUERY_INTERPRETER_MODEL = "llama3.2:3b"
$env:GG_QUERY_INTERPRETER_TIMEOUT = "15"

$env:GG_ADVANCED_SEARCH_INDEX_TOKEN = "<lokales-token>"
```

### Indexierung

Nach dem Datenbankimport und gesetzter Konfiguration kann der Elasticsearch-Index erzeugt werden:

```text
http://localhost/dwp_ws2324_rkt/gamesgalaxy/AdvancedSearch/Index?token=<lokales-token>
```

Die Indexierung liest die Spiele aus MySQL, erzeugt lokale Ollama-Embeddings und schreibt die Dokumente mit Vektorfeld in Elasticsearch. Wenn bereits ein Index ohne Vektorfeld existiert, kann er mit `reset=1` neu aufgebaut werden:

```text
http://localhost/dwp_ws2324_rkt/gamesgalaxy/AdvancedSearch/Index?token=<lokales-token>&reset=1
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

Automatisierte Tests für die optionale erweiterte Suche können lokal mit dem PHP-Binary aus XAMPP ausgeführt werden:

```powershell
C:\xampp\php\php.exe tests\AdvancedSearchTest.php
```

Die Tests prüfen Parser, exakte Filter, Fehlerfälle und den Rückfall auf die Standardsuche. Zusätzlich sollten die wichtigsten Funktionen nach Änderungen manuell geprüft werden:

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
├── tests/
├── .env.example
├── .htaccess
└── README.md
```

## License

Copyright (c) 2026 Mohammad Taiba. All rights reserved.

This project is published for portfolio and review purposes only. See [LICENSE](./LICENSE).
