# Store-Submission-Checkliste: Remtio & LensGuard

Angaben für Google Play Console (Data Safety) und App Store Connect (App Privacy).
Diese Formulare werden in den Consoles ausgefüllt — nicht auf der Website.

## URLs für die Store-Listings

| Zweck | URL |
|---|---|
| Remtio Privacy Policy | `https://ame.velletti.de/apps/remtio/datenschutz` (EN: `/en`) |
| LensGuard Privacy Policy | `https://ame.velletti.de/apps/lensguard/datenschutz` (EN: `/en`) |
| LensGuard Account Deletion URL (Play-Pflicht) | `https://ame.velletti.de/apps/lensguard/konto-loeschen` |

---

## Remtio

### Google Play — Data Safety
- **Erhoben & übermittelt:** Suchanfragen (App-Aktivität → Suchverlauf, Zweck: App-Funktionalität), Klick-Interaktionen (App-Interaktionen, Zweck: Analyse — anonym, nur offerId + source: mobile), Name & E-Mail (optional, nur bei Auth0-Login, Zweck: Kontoverwaltung)
- **Nicht erhoben:** Standort, Kontakte, Gerätekennungen/Werbe-IDs
- **Sicherheit:** „Daten werden verschlüsselt übertragen" ✅ (HTTPS)
- **„Nutzer können Löschung beantragen":** nur ankreuzen, wenn der interne Löschprozess existiert (aktuell nur manuell auf E-Mail-Anfrage)
- **Weitergabe an Dritte:** Nein (Auth0 = Auftragsverarbeiter, zählt nicht als „Sharing")

### Apple — App Privacy (Nutrition Label)
- **Data Linked to You:** Name, E-Mail (nur bei Login; falls iOS ohne Auth0 launcht → entfällt)
- **Data Not Linked to You:** Suchverlauf, Produkt-Interaktion (Klick-Events)
- **Tracking (ATT):** None — kein IDFA, keine Cross-App-Verknüpfung, kein ATT-Prompt nötig
- Merkliste rein lokal → nicht deklarationspflichtig
- [ ] Prüfen: speichert das Backend IP/User-Agent bei Klick-Events serverseitig mit? Falls ja, als „nicht verknüpft" prüfen

### To-dos vor Einreichung (Remtio)
- [ ] Privacy-Policy-Link in App-Einstellungen einbauen (Pflicht in beiden Stores)
- [ ] Speicherfristen für Such-/Klick-/Lead-Daten festlegen ODER Löschroutine bauen; Platzhalter in der Datenschutzerklärung ausfüllen
- [ ] Dash0-Angaben (Anschrift, AVV, Speicherort) ergänzen
- [ ] AWS-/Bedrock-Region + Drittlandtransfer-Mechanismus klären
- [ ] Für iOS klären: Launch mit oder ohne Login
- [ ] Interner Löschprozess für Nutzeranfragen definieren

---

## LensGuard

### Google Play — Data Safety
- **Erhoben:** E-Mail (Kontoverwaltung), Gesundheitsdaten (Dioptrien — Kategorie „Health info"), App-Interaktionen (Analytics), Crash-Logs, Geräte-IDs, Performance-Daten
- **Verschlüsselt übertragen:** Ja (Firebase/TLS)
- **Löschung anfragbar:** Ja — in-App-Kontolöschung vorhanden; Account-Deletion-URL (siehe oben) im Listing angeben
- **Weitergabe an Dritte:** Google/Firebase als Auftragsverarbeiter

### Apple — App Privacy (Nutrition Label)
- **Data Linked to You:** E-Mail, Gesundheitsdaten (Sehstärke), Nutzungsdaten (Analytics), Kennungen (User-ID, Geräte-ID), Diagnosedaten (Crashlytics)
- **Tracking:** None (keine Ads-SDKs, keine Verknüpfung mit Drittanbieter-Daten)

### To-dos vor Einreichung (LensGuard)
- [ ] Privacy-Policy-Link in App einbauen
- [ ] Firebase-/Firestore-Region in der Console prüfen (EU-Region? z. B. europe-west3) → Platzhalter in Datenschutzerklärung ausfüllen
- [ ] Analytics ist hardcoded aktiviert ohne Consent-Dialog — für die EU heikel: Consent-Flow einbauen (empfohlen) oder Rechtsgrundlage sauber dokumentieren
- [ ] Dioptrien = Art.-9-Gesundheitsdaten: explizite Einwilligung im Onboarding/Profil-Flow sicherstellen
