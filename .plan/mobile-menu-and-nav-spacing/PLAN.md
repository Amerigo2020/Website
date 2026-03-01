# Feature: Mobile Menu & Nav Spacing Fixes

> Erstellt: 2026-01-03
> Status: 🟡 In Planung

## Ziel
Fix the mobile menu visibility issue (options not showing when toggled) and correct the spacing between the logo/title ("Velletti Consulting") and the "Services" menu item on desktop.

## Anforderungen
- [ ] Mobile menu options must be visible when the hamburger button is clicked on screens < 770px.
- [ ] Mobile menu should work independently of the desktop menu visibility.
- [ ] Increase margin/padding between "Velletti Consulting" and "Services" link in the navigation bar.

## Scope
**In Scope:**
- `client/src/assets/css/app.css` (Nav styling)
- `client/src/index.php` (Nav HTML/JS)

**Out of Scope:**
- Other page layout changes.

## Technischer Ansatz
- Analyze `toggleMobileMenu` function in `index.php`.
- Check `.mobile-menu` or equivalent class in `app.css` for `display` or `height` properties.
- Adjust flex gap or margin for the nicgation links container to fix spacing.

## Betroffene Dateien
- `client/src/assets/css/app.css`
- `client/src/index.php`

## Abhängigkeiten
- None.

## Offene Fragen
- Are there any JS errors in the console? (Will investigate)
