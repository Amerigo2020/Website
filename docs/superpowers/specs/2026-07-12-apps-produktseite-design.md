# Design: Apps-Produktseite + Store-Rechtsseiten

**Datum:** 2026-07-12
**Ziel:** Öffentliche Produkt- und Rechtsseiten für die Mobile-Apps **Remtio** und **LensGuard**, damit die Pflicht-URLs (Datenschutz, Kontolöschung) in Apple App Store Connect und Google Play Console eingetragen werden können.

## Seiten

Alle Seiten sind PHP-Dateien im bestehenden Stil (nutzen `includes/headers.php`, bestehendes Design-System aus `app.css`, Dark Mode, kein neues CSS-Framework).

| URL | Datei | Inhalt |
|---|---|---|
| `/apps` | `client/src/apps/index.php` | Produktübersicht: eine Karte pro App mit Kurzbeschreibung, Store-Badges (`[PLATZHALTER: Store-Links]`), Links zu Datenschutz und Impressum |
| `/apps/remtio/datenschutz` | `client/src/apps/remtio/datenschutz.php` | Datenschutzerklärung Remtio Mobile-App (DE) |
| `/apps/remtio/datenschutz/en` | `client/src/apps/remtio/datenschutz-en.php` | Privacy Policy Remtio (EN) |
| `/apps/lensguard/datenschutz` | `client/src/apps/lensguard/datenschutz.php` | Datenschutzerklärung LensGuard (DE) |
| `/apps/lensguard/datenschutz/en` | `client/src/apps/lensguard/datenschutz-en.php` | Privacy Policy LensGuard (EN) |
| `/apps/lensguard/konto-loeschen` | `client/src/apps/lensguard/konto-loeschen.php` | Anleitung Kontolöschung (Google Play „Account deletion URL"): in-App-Weg beschreiben + E-Mail-Fallback |

**Impressum:** kein neues — alle App-Seiten verlinken auf das bestehende `/impressum`.

## Inhalte der Datenschutzerklärungen

### Remtio (Mobile-App, KMP Android + iOS)
- Verantwortlicher, Verweis auf `/impressum`
- Verarbeitete Daten: Freitext-Suchanfragen, Klick-Events (offerId, source: mobile), optional Auth0-Login (nur Android; E-Mail/Name bei Auth0, Backend erhält nur HMAC-Hash), IP/User-Agent in Server-Logs (CloudWatch ~30 Tage) und Telemetrie (Dash0)
- Lokal auf dem Gerät: Merkliste + geskippte IDs (kein Backend-Sync)
- Empfänger: AWS (Aurora, Bedrock — Suchtext geht an Bedrock), Auth0/Okta, Dash0
- Speicherfristen: Chat-Rohdialog 30 Tage; `[PLATZHALTER: Fristen für Suchanfragen/Klick-/Lead-Daten]`
- Betroffenenrechte, Löschung auf Anfrage per E-Mail
- `[PLATZHALTER: Dash0-Firmenanschrift/AVV, AWS-Region/Drittlandtransfer, Datenschutzbeauftragter ja/nein]`

### LensGuard (Flutter, Firebase)
- Verantwortlicher, Verweis auf `/impressum`
- Firebase Authentication (E-Mail/Passwort, Google Sign-In), Cloud Firestore (E-Mail, **Dioptrien = Gesundheitsdaten Art. 9 DSGVO → Rechtsgrundlage Einwilligung**, Linsenmarke/-modell, FCM-Token), Cloud Messaging (Preisalarme), Crashlytics, Firebase Analytics, Performance Monitoring
- Lokal: Erinnerungs-Einstellungen, lokale Benachrichtigungen
- Drittlandtransfer USA (Google) → EU-US Data Privacy Framework
- Kontolöschung: in-App vorhanden (Firestore-Dokument + Auth-Konto)
- `[PLATZHALTER: Firebase-Region der Firestore-Instanz, Verantwortlicher-Details falls abweichend]`

Alle offenen Punkte erscheinen als sichtbar markierte `[PLATZHALTER: …]`-Blöcke im Text.

## Technik

- **Rewrites** in `client/src/.htaccess` nach dem Muster der Blog-Regel (saubere URLs ohne `.php`, `/en`-Varianten)
- **Sitemap:** neue URLs in `client/src/sitemap.xml`
- **Navigation:** „Apps"-Link in die bestehende Navigation
- **hreflang:** de/en-Paare der Datenschutzseiten verweisen aufeinander
- **SEO:** Rechtsseiten bekommen `noindex` nicht — sie bleiben indexierbar (Stores prüfen Erreichbarkeit); normale Meta-Tags über `headers.php`

## Bewusst nicht enthalten

- **Data-Safety-/App-Privacy-Angaben** (Play Console / App Store Connect Formulare): keine Webseiten — werden als Checkliste in `docs/store-submission-checklist.md` abgelegt (inkl. der bekannten Angaben aus der Analyse beider Apps)
- **Consent-Flow für Firebase Analytics** in LensGuard: anderes Repo, nur Hinweis in der Checkliste
- **Löschroutinen im Remtio-Backend:** anderes Repo, nur Hinweis in der Checkliste

## Erfolgskriterien

- Alle 6 Seiten erreichbar unter den sauberen URLs, im Website-Design, mobil nutzbar
- Datenschutztexte inhaltlich vollständig gemäß obiger Datenlage; offene Punkte ausschließlich als markierte Platzhalter
- Checkliste `docs/store-submission-checklist.md` enthält Data-Safety-/Nutrition-Label-Angaben + To-dos vor Einreichung
