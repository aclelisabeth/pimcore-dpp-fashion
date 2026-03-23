# Anleitung: IT Support Anfrage für Prerequisites

## 📧 Schritt 1: Email an IT Support

Kopiere diese Email und sende sie an dein IT-Support Team:

---

### Email Vorlage

**An:** it-support@[dein-unternehmen].de  
**Betreff:** Installation anfordert: Docker, Git, WSL2 für Entwicklungsprojekt

---

**Liebe IT-Support Team,**

ich arbeite an einem Softwareentwicklungsprojekt und benötige die Installation von 3 Tools auf meinem Windows-Computer:

1. **WSL 2** (Windows Subsystem for Linux 2)
2. **Docker Desktop** 
3. **Git for Windows**

Diese Tools brauche ich für ein **Pimcore 10 CMS Projekt** im Modebereich.

Detaillierte Informationen zur Installation findet ihr in der angehängten Datei: **IT-SUPPORT-REQUEST.md**

**Kurz zusammengefasst:**
- WSL 2: Windows-Feature (kostenlos)
- Docker: Kostenlos für Entwicklung
- Git: Open Source (kostenlos)
- Alle Tools sind in der Industrie Standard
- Installation: ~30-45 Minuten

**Danke für eure Unterstützung!**

---

**Anhänge:** `IT-SUPPORT-REQUEST.md` aus dem Projektverzeichnis

---

## 📁 Schritt 2: Die Datei vorbereiten

Die Datei `IT-SUPPORT-REQUEST.md` liegt bereits im Projektverzeichnis:

```
C:\Users\elisabeth.schallerl\Downloads\testfolderEli\pimcore-dpp-fashion\
└── IT-SUPPORT-REQUEST.md
```

### So schickst du sie mit:

**Option A: Als Email-Anhang**
1. Öffne deine Email
2. Anhang hinzufügen
3. Wähle: `IT-SUPPORT-REQUEST.md`
4. Sende die Email

**Option B: Inhalt kopieren**
1. Öffne die Datei mit Notepad
2. Kopiere den kompletten Inhalt
3. Füge ihn in die Email ein

**Option C: Link teilen**
1. Wenn dein Unternehmen OneDrive/SharePoint nutzt
2. Upload die Datei dorthin
3. Teile den Link mit IT Support

---

## 💬 Schritt 3: Was IT Support antworten könnte

### Szenario A: Positive Antwort ✅
**"Kein Problem, werden wir instalieren"**

Dann: Warte auf Benachrichtigung, dass die Installation abgeschlossen ist und starte dann dein Projekt!

### Szenario B: Nachfragen ❓
**"Warum brauchst du das genau?"**

Antworte dann mit:
> "Ich entwickle ein Pimcore CMS Projekt. Docker ist der Standard für lokale Entwicklung, da es Datenbank und Services in Containern isoliert laufen lässt. Das ist sicherer als lokale Installationen."

### Szenario C: Sicherheitsbedenken 🔒
**"Ist das sicher? Was ist Docker?"**

Antworte:
> "Docker ist ein Industry-Standard Tool, das von Microsoft, Google, Amazon etc. verwendet wird. Es läuft nur lokal auf meinem Computer und verbindet sich nicht nach außen. Es ist eigentlich sicherer als traditionelle Installation, da alles isoliert ist."

### Szenario D: Ablehnung ❌
**"Das können wir nicht installieren"**

Dann Optionen:
- Frag nach einer **virtuellen Maschine** (VirtualMachine mit Linux)
- Oder: Frag nach **Online-Umgebung** (Cloud-basiert)
- Oder: Arbeite mit **älteren Tools** (ohne Container)

---

## 🎯 Was passiert danach?

Sobald die Tools installiert sind:

1. **Öffne PowerShell / Command Prompt**
2. **Navigiere zum Projektverzeichnis:**
   ```bash
   cd C:\Users\elisabeth.schallerl\Downloads\testfolderEli\pimcore-dpp-fashion
   ```

3. **Starte das Projekt:**
   ```bash
   docker-compose up -d
   ```

4. **Warte 1-2 Minuten** (Container starten)

5. **Öffne im Browser:**
   ```
   http://localhost:8080/admin
   ```

6. **Login:**
    - Verwende die Zugangsdaten aus der `.env` Datei (Lokal auf dem Computer, nicht in GitHub)

Fertig! Dann kannst du direkt mit dem Projekt arbeiten.

---

## 📞 Häufige Fragen an IT Support

### F: "Was ist WSL 2?"
**A:** Ein Windows-Feature, das Linux auf Windows laufen lässt. Windows 11 hat das schon eingebaut, bei Windows 10 muss man es aktivieren.

### F: "Ist Docker sicher?"
**A:** Ja, Docker ist ein Industry-Standard. Microsoft, Google, Amazon, alle großen Firmen nutzen es. Es isoliert Anwendungen voneinander.

### F: "Kostet Docker Geld?"
**A:** Nein, Docker Desktop ist kostenlos für Entwicklung. Enterprise-Versionen kosten, aber die brauchen wir nicht.

### F: "Nimmt Docker viel Platz weg?"
**A:** ~2-4 GB für die Docker Desktop Installation. Mit den Pimcore Containern dann ~5-8 GB. Das ist normal für moderne Entwicklung.

### F: "Kann ich das wieder deinstallieren?"
**A:** Ja, einfach über "Programme deinstallieren" oder die Docker Desktop Uninstaller nutzen.

---

## ✅ Checkliste zum Absenden

- [ ] Email verfasst
- [ ] `IT-SUPPORT-REQUEST.md` angehängt oder Link geteilt
- [ ] IT Support Email-Adresse korrekt
- [ ] Email versendet
- [ ] Ablage-Kopie für dich behalten (im Email-Postfach)

---

## 📅 Was jetzt?

**Während du wartest:**
1. Lese die **README.md** im Projekt (Dokumentation)
2. Schau dir die **Demo-Daten** an (demo-data.json)
3. Lese die **API-Dokumentation** (docs/API.md)

**Das hilft dir später, wenn die Tools installiert sind, schneller zu starten!**

---

## 🤝 Brauchst du Hilfe?

Falls IT Support Fragen hat, die ich beantworten kann:
- Maile mir die Fragen
- Ich helfe dann mit technischen Details

Oder du kannst direkt sagen:
> "Das ist ein Open-Source Projekt (Pimcore 10), basiert auf Symfony Framework, und läuft in standardisierten Docker Containern."

---

**Viel Glück mit deiner IT Support Anfrage! 🚀**

Du machst das schon richtig - viele große Projekte brauchen diese Prerequisites!

