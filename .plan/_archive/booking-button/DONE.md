# Abschluss: booking-button

> Abgeschlossen: 2026-02-22

## Zusammenfassung
Der Button zum Buchen einer 1-stündigen Dienstleistung wurde erfolgreich in die `index.php` integriert. Da in der Vorlage kein fest codierter Link vorhanden war, wurde ein neues PHP-Skript (`book-consultation.php`) erstellt, welches das von dir geänderte Stripe Secret (aus dem `secrets.php`-File des Learning-Folders) nutzt, um On-The-Fly eine Stripe Checkout Session für die Dienstleistung zu generieren.

## Finale Implementierung
- Hauptdateien:
  - `client/src/index.php` (Button und Outline-CSS-Klasse hinzugefügt)
  - `client/src/book-consultation.php` (Neues Backend-Skript für die Checkout-Erstellung)

## Lessons Learned
- Durch das On-The-Fly Generieren der Session mittels `price_data` muss man das Produkt nicht vorher zwingend im Stripe Dashboard anlegen, es reicht die Stripe API Key Authentifizierung.

## Follow-ups
- [ ] Sobald du live gehst, muss der Secret-Key in `book-consultation.php` mit dem echten Live-Key ersetzt oder über die `.env` geladen werden (wurde für den Test hartcodiert wie gewünscht).
