# IT Support Request - Software Installation

**Betreff:** Installation von Docker, Git und WSL2 für Entwicklungsprojekt

---

## Anfrage

Ich benötige die Installation der folgenden Tools für ein Softwareentwicklungsprojekt:

### 1. **WSL 2 (Windows Subsystem for Linux 2)**
- **Zweck:** Lokale Linux-Umgebung auf Windows
- **Version:** WSL 2 (neueste)
- **Größe:** ~1 GB
- **Installation:** Windows Feature aktivieren
- **Dokumentation:** https://docs.microsoft.com/de-de/windows/wsl/install

### 2. **Docker Desktop**
- **Zweck:** Container-Virtualisierung (Pimcore, MySQL, Redis)
- **Version:** Neueste stabile Version
- **Größe:** ~2-4 GB
- **Voraussetzungen:** WSL 2
- **Download:** https://www.docker.com/products/docker-desktop
- **Lizenz:** Kostenlos für Bildung & Entwicklung

### 3. **Git for Windows**
- **Zweck:** Versionskontrolle
- **Version:** Neueste (2.40+)
- **Größe:** ~300 MB
- **Download:** https://git-scm.com/download/win
- **Lizenz:** Kostenlos (Open Source)

---

## Warum ist das nötig?

Ich arbeite an einem **Pimcore 10 Projekt** für die digitale Produktkennzeichnung (Digital Product Passport - DPP) im Modebereich.

Das Projekt erfordert:
- **Docker:** Um Pimcore CMS, MySQL Datenbank und Redis Cache in Containern zu starten
- **Git:** Um Quellcode zu verwalten und mit GitHub zu synchronisieren
- **WSL 2:** Um Docker auf Windows auszuführen

---

## Installationsschritte (einfach)

Mit diesen Tools kann ich dann nur einen Befehl ausführen und das ganze System startet:
```bash
docker-compose up -d
```

Das ist **einfacher und sicherer** als traditionelle Installation, da alles isoliert in Containern läuft.

---

## Sicherheit & Lizenzierung

✅ **Alle Tools sind kostenlos**
- Docker Desktop: Kostenlos für Entwicklung
- Git: Open Source (MIT Lizenz)
- WSL 2: Windows Feature (kein Download nötig)

✅ **Sicherheit:**
- Docker ist in der Industrie standard
- Git ist weit verbreitet
- WSL 2 ist offiziell von Microsoft
- Nur lokale Nutzung (keine externe Verbindung erforderlich)

---

## Kontakt & Hilfe

Wenn ihr Fragen habt:
- Docker Doku: https://docs.docker.com
- Git Doku: https://git-scm.com/doc
- WSL Doku: https://docs.microsoft.com/de-de/windows/wsl

---

**Geschätzter Zeitaufwand:** 30-45 Minuten Installation

**Danke für eure Unterstützung!**

