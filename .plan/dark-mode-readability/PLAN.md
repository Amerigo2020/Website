# Feature: Dark Mode Readability

> Erstellt: 2026-01-03
> Status: 🟡 In Planung

## Ziel
Improve text readability in Dark Mode by brightening text colors (White for primary, Lighter Grey for secondary).

## Anforderungen
- [ ] Header Logo "Velletti Consulting" must be white (brighter).
- [ ] Body text (e.g., "Events, hackathons...") must be readable (brighter).
- [ ] Footer text and Copyright must be readable.
- [ ] Changes must apply specifically to Dark Mode.

## Technischer Ansatz
- Add `:root[data-theme='dark']` block to `app.css` to override CSS variables with higher specificity than inline styles.
- Set `--color-text`, `--color-text-primary` to `#ffffff`.
- Set `--color-text-secondary` to `#e2e8f0` (or similar light grey).

## Betroffene Dateien
- `client/src/assets/css/app.css`

## Offene Fragen
- None.
