# Feature: hero-nature-animation

> Erstellt: 2026-02-24
> Status: 🟡 In Planung

## Ziel
Den Hero-Bereich durch eine beeindruckende, von der Natur inspirierte Animation aufwerten, die gleichzeitig das moderne, hochwertige Agentur-Branding (KI, Software, Automatisierung) unterstreicht.

## Anforderungen
- [ ] Implementierung einer visuell beeindruckenden Hintergrund-Animation in der Hero-Section.
- [ ] Subtil und elegant, darf nicht vom Text oder der Haupt-Call-to-Action ablenken.
- [ ] Performance-sicher (Hardware-beschleunigt, belastet CPU/GPU im Leerlauf nicht zu stark).
- [ ] Natur-inspirierte Konzepte, die zum Tech-Theme passen.

## Scope
**In Scope:**
- HTML/JS/CSS Erweiterung in `index.php` bzw. `app.css`.
- Eventuell Einbindung einer leichtgewichtigen thư viện (Library) wie `particles.js` oder reines Canvas/CSS.

**Out of Scope:**
- Umbau der restlichen Seitenstruktur.

## Technischer Ansatz (Zwei Vorschläge)

### Option 1: Digital Aurora (Nordlichter)
**Idee:** Eine fließende, organische Bewegung von weichen, leuchtenden Farbverläufen im Hintergrund, ähnlich den Nordlichtern.
**Technik:** CSS-Animationen mit großen, stark weichgezeichneten (`filter: blur()`) DOM-Elementen, die durch CSS-Keyframes weich über den Hintergrund gleiten.
**Vorteil:** Sehr edel, modern ("Glassmorphism/Apple-Style"), absolut performant da via GPU beschleunigt (CSS Transforms) und komplett ohne JavaScript umsetzbar.
**Wirkung (Natur):** Sanft, wie Wasser, Wind oder Polarlichter.

### Option 2: Neural Constellation (Neuronal-Netz / Sternbild)
**Idee:** Kleine, interagierende Partikel (wie Glühwürmchen oder Sterne), die sich naturgemäß wie ein Schwarm bewegen und Verbindungslinien aufbauen, wenn sie sich nahe kommen oder von der Maus angezogen werden.
**Technik:** Ein leichtes HTML5 Canvas Skript (Vanilla JS oder particles.js).
**Vorteil:** Sehr interaktiv, bringt das KI- und Software-Thema durch die Netzstruktur direkt auf den Punkt, behält aber durch die fließende Schwarm-Bewegung den Natur-Aspekt.
**Wirkung (Natur):** Neuronales Netz im Gehirn, Sternbilder, Schwarmverhalten (Vögel/Fische).

## Betroffene Dateien
- `src/index.php`
- `src/assets/css/app.css`

## Abhängigkeiten
- Keine neuen Abhängigkeiten bei Option 1 (Reines CSS).
- Eventuell ein kleines Vanilla-JS Script inline bei Option 2.

## Offene Fragen
- [ ] **Welche Option sagt dem User mehr zu? (Aurora oder Constellation)?**
- [ ] Sollen die Primärfarben (Electric Cyan & Vibrant Amber) aufgegriffen werden?
