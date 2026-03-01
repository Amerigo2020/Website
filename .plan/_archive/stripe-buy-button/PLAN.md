# Feature: stripe-buy-button

> Erstellt: 2026-02-22
> Status: 🟡 In Planung

## Ziel
Den manuell erstellten Anchor-Link (`<a>`) durch das offizielle `<stripe-buy-button>` Web Component Element von Stripe ersetzen, das vom Nutzer bereitgestellt wurde.

## Anforderungen
- [ ] Integration des Stripe JavaScripts (`https://js.stripe.com/v3/buy-button.js`).
- [ ] Einfügen des `<stripe-buy-button>` HTML-Tags in der Services-Section.
- [ ] Den alten Anchor-Link entfernen/kommentieren.

## Scope
**In Scope:**
- Änderungen an der Startseite (`index.php`).

**Out of Scope:**
- Gestaltung des Stripe-Buy-Buttons (dieser wird von Stripe per iFrame gesteuert und ist nur sehr begrenzt über CSS anpassbar).

## Technischer Ansatz
1. Das Stripe-Skript im `<head>` der `index.php` ablegen.
2. Das `<stripe-buy-button>`-Element an die Stelle des bisherigen Buttons packen.

## Betroffene Dateien
- `client/src/index.php`
