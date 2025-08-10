# Velletti Consulting Landing Page - Detaillierte Anforderungen

## Projektübersicht
Entwicklung einer modernen, professionellen Landing Page für Velletti Consulting mit reiner PHP-Implementierung. Die Seite soll responsive, benutzerfreundlich und suchmaschinenoptimiert sein.

## Technische Vorgaben
- **Ausschließlich PHP**: Alle Logik, Rendering und Styling erfolgt über PHP
- **Keine externen Abhängigkeiten**: Kein JavaScript, keine Frameworks, keine CDN-Ressourcen
- **Single-File-Lösung**: Gesamte Anwendung in einer einzigen PHP-Datei
- **PHP-Version**: Kompatibel mit PHP 7.4+ und PHP 8.x
- **Responsive Design**: Mobile-first Ansatz mit CSS Grid/Flexbox

## Farbschema
```
Primary (Hauptfarbe):     #F87060  (Coral/Orange-Rot)
Secondary (Sekundär):     #102542  (Dunkelblau)
Background (Hintergrund): #F7F7FF  (Sehr helles Grau)
Accent 1 (Akzent 1):      #B5BFE2  (Helles Blau)
Accent 2 (Akzent 2):      #22223B  (Dunkelviolett)
Text (Textfarbe):         #23272F  (Dunkelgrau)
```

## Strukturelle Komponenten

### 1. Header-Bereich
- **Logo**: Velletti Consulting (als Text-Logo mit spezieller Typografie)
- **Navigation**: Smooth-Scroll Links zu Sektionen (Services, Kontakt)
- **Responsive Mobile Menu**: Hamburger-Menü für mobile Geräte
- **Sticky Header**: Bleibt beim Scrollen sichtbar

### 2. Hero/Einleitungsbereich
- **Überschrift**: Prägnante Hauptbotschaft
- **Untertitel**: Kurze Beschreibung der Unternehmensphilosophie
- **Call-to-Action Button**: Führt direkt zum Kontaktformular
- **Visuelles Element**: CSS-basierte grafische Akzente

### 3. Services-Sektion
- **3 Hauptdienstleistungen** mit jeweils:
  - Aussagekräftige Bezeichnung
  - Detaillierte Beschreibung (2-3 Sätze)
  - Icon/Symbol (CSS-basiert)
- **Responsive Layout**: Grid-Anordnung für Desktop, Stack für Mobile

### 4. Kontaktformular
- **Eingabefelder**:
  - Name (Pflichtfeld, min. 2 Zeichen)
  - E-Mail (Pflichtfeld, E-Mail-Validierung)
  - Telefon (optional, Format-Validierung)
  - Nachricht (Pflichtfeld, min. 10 Zeichen)
- **PHP-Validierung**:
  - Server-seitige Eingabeprüfung
  - Schutz vor XSS und SQL-Injection
  - CSRF-Schutz mit Session-Token
- **Feedback-System**:
  - Erfolgs- und Fehlermeldungen
  - Feldspezifische Validierungsfehler
  - Honeypot-Feld gegen Spam

### 5. Footer
- **Kontaktinformationen**:
  - Adresse
  - Telefonnummer
  - E-Mail-Adresse
- **Copyright-Vermerk**
- **Datenschutz-Hinweis**

## CSS-Styling (PHP-generiert)

### Design-Prinzipien
- **Moderne Typografie**: Saubere, gut lesbare Schriftarten
- **Generous Whitespace**: Ausreichend Weißraum für Eleganz
- **Subtile Animationen**: Hover-Effekte und Transitions
- **Accessibility**: Hohe Kontraste und klare Fokus-Indikatoren

### Responsive Breakpoints
```css
Mobile:  bis 768px
Tablet:  769px - 1024px
Desktop: ab 1025px
```

### Styling-Komponenten
- **Buttons**: Einheitliche Gestaltung mit Hover-Effekten
- **Formulare**: Moderne Input-Felder mit Floating Labels
- **Cards**: Services-Karten mit Schatten und Hover-Effekten
- **Layout**: CSS Grid für Hauptlayout, Flexbox für Komponenten

## Technische Implementierung

### Sicherheit
- **Input-Sanitization**: Alle Benutzereingaben werden bereinigt
- **CSRF-Protection**: Session-basierte Token-Validierung
- **XSS-Prevention**: Ausgabe-Escaping für alle dynamischen Inhalte
- **Rate Limiting**: Einfacher Schutz vor Spam-Submissions

### Performance
- **Minimaler HTML-Output**: Optimierte Struktur ohne unnötige Elemente
- **Inline CSS**: Alle Styles in `<style>`-Tag für schnelle Ladezeiten
- **Bildoptimierung**: CSS-basierte Grafiken statt externe Bilder

### SEO-Optimierung
- **Semantic HTML**: Korrekte HTML5-Struktur
- **Meta-Tags**: Title, Description, Keywords
- **Structured Data**: Schema.org Markup für Unternehmensinformationen
- **Alt-Texte**: Für alle CSS-basierten visuellen Elemente

## Funktionale Anforderungen

### Kontaktformular-Workflow
1. **Eingabevalidierung**: Echtzeit-Feedback bei Fehlern
2. **Datenverarbeitung**: Sichere Übertragung und Speicherung
3. **E-Mail-Versand**: Automatische Bestätigung (optional)
4. **Erfolgsrückmeldung**: Benutzerfreundliche Erfolgsmeldung

### Browser-Kompatibilität
- **Modern Browsers**: Chrome, Firefox, Safari, Edge (aktuelle Versionen)
- **Mobile Browser**: iOS Safari, Android Chrome
- **Graceful Degradation**: Funktionsfähigkeit auch in älteren Browsern

## Qualitätskriterien

### Code-Qualität
- **Clean Code**: Gut strukturierter, kommentierter PHP-Code
- **Wartbarkeit**: Modularer Aufbau mit wiederverwendbaren Funktionen
- **Dokumentation**: Inline-Kommentare für komplexe Logik

### User Experience
- **Intuitive Navigation**: Selbsterklärende Benutzerführung
- **Schnelle Ladezeiten**: Optimierte Performance
- **Mobile Usability**: Touchscreen-optimierte Bedienung

### Accessibility (WCAG 2.1)
- **Tastaturnavigation**: Vollständige Bedienbarkeit ohne Maus
- **Screenreader-Kompatibilität**: Korrekte ARIA-Labels
- **Farbkontraste**: Mindestens AA-Level Kontraste

## Lieferumfang
1. **Einzelne PHP-Datei** (z.B. `index.php`) mit kompletter Funktionalität
2. **Dokumentation** mit Installations- und Konfigurationshinweisen
3. **Testdaten** für Entwicklung und Demonstration
4. **Deployment-Anleitung** für verschiedene Hosting-Umgebungen