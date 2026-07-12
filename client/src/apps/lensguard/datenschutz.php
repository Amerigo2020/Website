<?php
require_once __DIR__ . '/../../includes/app-page.php';

page_top([
    'title' => 'Datenschutzerklärung LensGuard App | Velletti Consulting',
    'path' => '/apps/lensguard/datenschutz',
    'lang' => 'de',
    'alternates' => [
        'de' => '/apps/lensguard/datenschutz',
        'en' => '/apps/lensguard/datenschutz/en',
    ],
]);
?>

    <main>
        <section class="section legal" style="padding-top: calc(var(--nav-height) + var(--space-16));">
            <div class="container">
                <p class="legal__breadcrumb"><a href="/">Home</a> / <a href="/apps/">Apps</a> / LensGuard / Datenschutz</p>
                <p><a href="/apps/lensguard/datenschutz/en">English version</a></p>
                <h1>Datenschutzerkl&auml;rung &ndash; LensGuard App</h1>

                <h2>1. Verantwortlicher</h2>
                <p>
                    <strong>Velletti Consulting</strong><br>
                    Munich, Bavaria, Germany<br>
                    E-Mail: <a href="mailto:vel-consulting@ame.velletti.de">vel-consulting@ame.velletti.de</a><br>
                    Weitere Angaben: <a href="/impressum.php">Impressum</a>
                </p>

                <h2>2. &Uuml;berblick</h2>
                <p>LensGuard hilft Kontaktlinsentr&auml;gern bei Tragezeit-Tracking, Wechsel-Erinnerungen, Preisalarmen
                    und der Verwaltung eines Sehst&auml;rken-Profils. Die App nutzt Dienste von Google Firebase.
                    Diese Erkl&auml;rung beschreibt, welche personenbezogenen Daten dabei verarbeitet werden.</p>

                <h2>3. Konto und Anmeldung</h2>
                <p>Die Anmeldung erfolgt &uuml;ber Firebase Authentication per E-Mail/Passwort oder Google Sign-In. Dabei
                    werden Ihre E-Mail-Adresse, eine Nutzer-ID sowie bei Google Sign-In Ihre Google-Kontodaten (E-Mail,
                    Name, Profilbild) verarbeitet. Rechtsgrundlage: Art. 6 Abs. 1 lit. b DSGVO.</p>

                <h2>4. Gesundheitsdaten (Sehst&auml;rke)</h2>
                <p>Wenn Sie Ihr Sehst&auml;rken-Profil anlegen, speichern wir Ihre Dioptrien-Werte (links/rechts) sowie
                    Ihre bevorzugte Linsenmarke und Ihr Linsenmodell in Cloud Firestore. Dioptrien-Werte sind
                    Gesundheitsdaten im Sinne von Art. 9 DSGVO. Wir verarbeiten sie ausschlie&szlig;lich auf Grundlage
                    Ihrer ausdr&uuml;cklichen Einwilligung (Art. 9 Abs. 2 lit. a DSGVO), die Sie durch die freiwillige
                    Eingabe dieser Werte erteilen. Sie k&ouml;nnen die Einwilligung jederzeit widerrufen, indem Sie die
                    Werte l&ouml;schen oder Ihr Konto l&ouml;schen (siehe Abschnitt 8).</p>

                <h2>5. Gespeicherte Kontodaten</h2>
                <p>In Ihrem Nutzerprofil (Cloud Firestore) speichern wir: E-Mail-Adresse, Dioptrien-Werte, bevorzugte
                    Linsenmarke/-modell, das Startdatum Ihres aktuellen Linsenpaars, den zuletzt gemeldeten Preis, das
                    Ger&auml;te-Token f&uuml;r Push-Benachrichtigungen (FCM-Token) und das Erstellungsdatum des Kontos.
                    <strong>[PLATZHALTER: Firebase-/Firestore-Region pr&uuml;fen und angeben, z.&nbsp;B. europe-west3]</strong></p>

                <h2>6. Push-Benachrichtigungen und lokale Erinnerungen</h2>
                <p>Preisalarme senden wir &uuml;ber Firebase Cloud Messaging; hierzu wird ein Ger&auml;te-Token in Ihrem
                    Profil gespeichert. T&auml;gliche Wechsel- und Austausch-Erinnerungen erfolgen als lokale
                    Benachrichtigungen direkt auf Ihrem Ger&auml;t; Erinnerungs-Einstellungen werden nur lokal gespeichert
                    und nicht &uuml;bertragen.</p>

                <h2>7. Absturzberichte, Analyse und Performance</h2>
                <p>Die App nutzt Firebase Crashlytics (Absturzberichte, Stacktraces, Ger&auml;teinformationen),
                    Firebase Analytics (App-Interaktionen, Ger&auml;te-Kennungen, ungef&auml;hre Standortdaten) und
                    Firebase Performance Monitoring (App-Startzeiten, Netzwerk-Latenzen).
                    Rechtsgrundlage: Art. 6 Abs. 1 lit. f DSGVO (berechtigtes Interesse an Stabilit&auml;t und
                    Verbesserung der App)
                    <strong>[PLATZHALTER: Consent-Dialog f&uuml;r Analytics einbauen und Rechtsgrundlage auf Einwilligung
                    umstellen &ndash; berechtigtes Interesse ist f&uuml;r Analytics in der EU rechtlich wackelig]</strong>.
                    Es werden keine Werbe-SDKs eingesetzt und keine Daten f&uuml;r Werbezwecke mit Dritten geteilt.</p>

                <h2>8. Kontol&ouml;schung</h2>
                <p>Sie k&ouml;nnen Ihr Konto jederzeit direkt in der App l&ouml;schen. Dabei werden Ihr Nutzerprofil in
                    Cloud Firestore und Ihr Authentifizierungskonto vollst&auml;ndig entfernt (Art. 17 DSGVO).
                    Anleitung: <a href="/apps/lensguard/konto-loeschen">Konto l&ouml;schen</a>.</p>

                <h2>9. Empf&auml;nger und Drittlandtransfer</h2>
                <p>Auftragsverarbeiter ist Google LLC bzw. Google Ireland Ltd. (Firebase-Dienste). Dabei k&ouml;nnen Daten
                    in die USA &uuml;bertragen werden. Google ist unter dem EU-US Data Privacy Framework zertifiziert;
                    erg&auml;nzend gelten EU-Standardvertragsklauseln.
                    Weitere Informationen: <a href="https://firebase.google.com/support/privacy" target="_blank" rel="noopener">firebase.google.com/support/privacy</a>.</p>

                <h2>10. Ihre Rechte</h2>
                <p>Sie haben Rechte auf Auskunft, Berichtigung, L&ouml;schung, Einschr&auml;nkung der Verarbeitung,
                    Daten&uuml;bertragbarkeit sowie Widerspruch (Art. 15 bis 21 DSGVO). Zur Aus&uuml;bung gen&uuml;gt eine
                    E-Mail an <a href="mailto:vel-consulting@ame.velletti.de">vel-consulting@ame.velletti.de</a>.
                    Zudem besteht ein Beschwerderecht bei einer Datenschutz-Aufsichtsbeh&ouml;rde.</p>

                <p>Stand: 2026-07-12</p>
            </div>
        </section>
    </main>

<?php page_bottom(); ?>
