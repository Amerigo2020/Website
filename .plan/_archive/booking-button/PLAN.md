# Feature: booking-button

> Erstellt: 2026-02-22
> Status: 🟡 In Planung

## Ziel
Integration eines einfachen "Booking Buttons" (Stripe Payment Link) auf der Webseite, damit Kunden 1 Stunde Beratungsdienstleistung (DL) direkt buchen können. Orientalierung am vorhandenen `stripe-payment-link-boilerplate`.

## Anforderungen
- [ ] Button-Design im Stil von Velletti Consulting (passend zur `app.css`).
- [ ] Verlinkung zum Stripe Payment Link (welcher in `secrets.php` oder der `.env` definiert sein sollte).
- [ ] Platzierung auf der Startseite (`index.php`), idealerweise in der Services-Section oder in der Hero-Section.

## Scope
**In Scope:**
- Hinzufügen des Buttons ins HTML (`index.php`).
- Abgreifen des Secrets/Payment Links aus dem Lern-Repo.

**Out of Scope:**
- Komplexe Checkout Session Logic (wurde bereits für Abonnements gebaut).
- Eigene Backend-Anbindung für diesen konkreten Button, da Stripe Payment Links direkt zu Stripe weiterleiten.

## Technischer Ansatz
1. Auslesen des Payment Links aus `C:\Users\ameri\Documents\Programming\_cloned\learning\stripe\stripe-payment-link-boilerplate` (bzw. `secrets.php`).
2. Implementierung eines simplen Anchor-Tags `<a>` im Design des Primary-Buttons auf `index.php`.

## Betroffene Dateien
- `client/src/index.php`
- `.env` (Hinzufügen des Links)

## Abhängigkeiten
- [ ] Vorhandener Stripe Payment Link.

## Offene Fragen
- [ ] Gibt es für diese 1h Dienstleistung einen speziellen Namen / Beschreibungstext, der auf der Seite platziert werden soll?
