# Feature: stripe-integration

> Erstellt: 2026-02-22
> Status: 🟡 In Planung

## Ziel
Integration einer Zahlungsseite für ein einfaches Abonnement (Single Subscription) unter Verwendung von Stripe Checkout. Basierend auf dem Referenz-System: `stripe-samples/checkout-single-subscription`.

## Anforderungen
- [ ] Preisseite / Checkout-Button im Frontend (UI)
- [ ] Backend-Endpunkt zur Erstellung einer Stripe Checkout Session (`create-checkout-session.php`)
- [ ] Erfolgsseite (Success Page) nach erfolgreicher Zahlung (`success.php`)
- [ ] Abbruchseite (Cancel Page) falls der User abricht (`cancel.php`)
- [ ] Webhook-Endpunkt zur Verarbeitung asynchroner Events (z.B. `checkout.session.completed`, `invoice.paid`, `invoice.payment_failed`)
- [ ] Integration der `stripe/stripe-php` Library
- [ ] Konfiguration der API-Keys über Umgebungsvariablen (`.env`)

## Scope
**In Scope:**
- Erstellung der dedizierten Checkout-Seite und Backend-Logik in PHP
- Webhook-Verarbeitung
- Basis-Styling passend zum aktuellen Design System

**Out of Scope:**
- Komplexes User-Management (Login/Registrierung vor Checkout), falls nicht explizit gefordert. Zunächst wird ein Gast-Checkout oder simpler E-Mail Checkout implementiert.
- Kundenportal (Customer Portal) zur Abo-Verwaltung (kann als separates Feature folgen).

## Technischer Ansatz
Da das Projekt aktuelles, reines PHP nutzt (Zero-Dependency Ansatz im Frontend):
1. **Composer Setup**: Hinzufügen von `stripe/stripe-php` per Composer (falls noch nicht vorhanden).
2. **Setup `.env`**: Hinzufügen von `STRIPE_PUBLISHABLE_KEY`, `STRIPE_SECRET_KEY` und `STRIPE_WEBHOOK_SECRET`.
3. **Frontend**: Eine simple `checkout.js` oder direkt ein Formular, das einen POST-Request an `create-checkout-session.php` sendet.
4. **Backend**: `create-checkout-session.php` instanziiert den Stripe Client, erstellt eine Session inkl. `price_id` und liefert die `url` für den Redirect zurück.
5. **Webhook**: `webhook.php` verifiziert die Signatur und verarbeitet die Events (z.B. Speichern in einer Datenbank oder Log-Datei, Freischaltung von Features).

## Betroffene Dateien
- `client/src/checkout.php` (Neu)
- `client/src/create-checkout-session.php` (Neu)
- `client/src/success.php` (Neu)
- `client/src/cancel.php` (Neu)
- `client/src/webhook.php` (Neu)
- `composer.json` (Neu / Update)
- `.env.example` / `.env`

## Abhängigkeiten
- [ ] Benötigt: Stripe Account und Preis-ID (Price ID) für das Abonnement.
- [ ] Benötigt: Composer auf dem System zur Installation der Stripe-PHP Library.

## Offene Fragen
- [ ] Sollen die Daten des Abonnements (Kunde, Status) in einer Datenbank gespeichert werden, oder reicht vorerst die Verwaltung im Stripe Dashboard?
- [ ] Gibt es schon Composer im Projekt, oder soll ich das Setup (`composer init`) mit einplanen?
- [ ] Welche genaue Dienstleistung / welches Produkt soll über das Abo abgerechnet werden?
