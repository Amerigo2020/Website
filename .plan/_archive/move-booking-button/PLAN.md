# Feature: move-booking-button

> Erstellt: 2026-02-22
> Status: 🟡 In Planung

## Ziel
Den Booking-Button aus der Hero-Sektion in die Services-Sektion verschieben und den Text/die Intention anpassen, um einen MVP und Kostenvoranschlag basierend auf dem Stundensatz (50€) anzubieten.

## Anforderungen
- [ ] Button aus `index.php` (Hero-Sektion) entfernen.
- [ ] Button unterhalb oder innerhalb der Services-Sektion platzieren.
- [ ] Beschreibung on `book-consultation.php` anpassen, um den neuen MVP/Estimate-Fokus (50€) widerzuspiegeln.
- [ ] Button-Text auf der `index.php` anpassen.

## Scope
**In Scope:**
- Umzug des Buttons im HTML (`index.php`).
- Textanpassungen in PHP und HTML.

**Out of Scope:**
- Neue Stripe-Produkte (wir bleiben bei dynamischen Checkout-Sessions).

## Technischer Ansatz
1. HTML in `index.php` ändern: Link aus dem `.hero__content` entfernen und nach `.services__grid` einfügen.
2. PHP in `book-consultation.php` anpassen: Beschreibungstext ändern (Preis ist schon auf 50€).

## Betroffene Dateien
- `client/src/index.php`
- `client/src/book-consultation.php`
