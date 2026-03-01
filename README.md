<div align="center">
  <img src="client/src/assets/portrait.jpg" alt="Velletti Consulting Logo" width="120" style="border-radius: 50%; border: 4px solid #00E5FF; margin-bottom: 20px;" />
  
  # Velletti Consulting
  **AI • Automatisierung • Webentwicklung • DevOps**
  
  [![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net/)
  [![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)](https://developer.mozilla.org/en-US/docs/Web/HTML)
  [![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)](https://developer.mozilla.org/en-US/docs/Web/CSS)
  [![Zero Dependencies](https://img.shields.io/badge/Dependencies-0-success?style=for-the-badge)](#)
</div>

<br />

> Die offizielle Corporate Website und Landing Page für **Velletti Consulting**, einer in München ansässigen Agentur für moderne IT-Lösungen. Dieses Projekt demonstriert unseren Ansatz: **Brutaler Minimalismus, höchste Sicherheit und maximale Performance.**

---

## 🌟 Highlights & Features

- **🎨 Brutally Minimal Design System**: Ein maßgeschneidertes, komponentenbasiertes Design-System ohne externe CSS-Frameworks. Verwendet moderne CSS-Variablen ("Midnight Graphite + Electric Cyan").
- **🌗 Native Dark Mode**: Vollständige und automatische Unterstützung für System-Dark-Mode Theme-Präferenzen, um die Lesbarkeit und das Nutzererlebnis zu maximieren.
- **🔒 Enterprise-Grade Security**: Das integrierte Kontaktformular in purem PHP bietet modernsten Schutz:
  - CSRF-Token Validierung
  - Rate-Limiting gegen Spam-Attacken
  - Honeypot-Techniken zur Bot-Abwehr
  - Strikte Input-Sanitisierung
- **⚡ Zero-Dependency Architektur**: Keine unnötigen NPM-Pakete, kein Frontend-Bloat. Reines, semantisches HTML5, CSS3 und PHP für rasend schnelle Ladezeiten.
- **🔍 SEO & Accessibility**: Integriertes Schema.org JSON-LD Markup, Open Graph Tags für Social Media Sharing und 100% Tastatur-Navigierbarkeit.

## 📁 Projektstruktur

```text
📦 Website
 ┣ 📂 client
 ┃ ┗ 📂 src
 ┃   ┣ 📂 assets
 ┃   ┃ ┣ 📂 css
 ┃   ┃ ┃ ┗ 📜 app.css         # Maßgeschneidertes CSS & Design System
 ┃   ┃ ┣ 📂 js                # Frontend Logik (z.B. Mobile Menu)
 ┃   ┃ ┗ 🖼️ portrait.jpg     # Medien
 ┃   ┣ 📜 index.php           # Haupt-Landingpage (inkl. CSRF & Form-Logik)
 ┃   ┣ 📜 contact.php         # Kontaktformular-Verarbeitung
 ┃   ┣ 📜 robots.txt          # SEO Richtlinien
 ┃   ┗ 📜 sitemap.xml         # XML Sitemap
 ┣ 📂 .plan                   # Feature- und Projektmanagement
 ┗ 📜 README.md
```

## 🚀 Lokales Setup & Entwicklung

Da dieses Projekt auf purem PHP basiert, ist das Setup extrem unkompliziert. Es wird keine Node.js-Umgebung oder ein Build-Schritt benötigt.

### Voraussetzungen
- PHP 8.0 oder höher

### Starten des Entwicklungs-Servers
1. Repository klonen:
   ```bash
   git clone https://github.com/Amerigo2020/Website.git
   cd Website
   ```
2. PHP Build-in Server starten:
   ```bash
   php -S localhost:8000 -t client/src
   ```
3. Im Browser öffnen:
   [http://localhost:8000](http://localhost:8000)

## 💼 Über Velletti Consulting

Wir bauen digitale Lösungen, die funktionieren. Von der Automatisierung mühsamer Geschäftsprozesse durch modernste **KI (Künstliche Intelligenz)** bis zur Entwicklung und dem extrem stabilen Hosting von Webseiten. 

Einen besonderen Fokus legen wir auf **DevOps Enablement**, um Entwickler-Teams schneller und reibungsloser ans Ziel zu bringen.

📫 **Kontakt:** vel-consulting@ame.velletti.de  
📍 **Standort:** München, Bayern
🔗 **LinkedIn:** [Amerigo Velletti](https://www.linkedin.com/in/amerigo-velletti-b888a9304)

---
<div align="center">
  <i>Made with precision in Munich. © <?php echo date('Y'); ?> Velletti Consulting.</i>
</div>
