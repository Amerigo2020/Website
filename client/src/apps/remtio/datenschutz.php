<?php
require_once __DIR__ . '/../../includes/app-page.php';

page_top([
    'title' => 'Datenschutzerklärung Remtio App | Velletti Consulting',
    'path' => '/apps/remtio/datenschutz',
    'lang' => 'de',
    'alternates' => [
        'de' => '/apps/remtio/datenschutz',
        'en' => '/apps/remtio/datenschutz/en',
    ],
]);
?>

    <main>
        <section class="section legal" style="padding-top: calc(var(--nav-height) + var(--space-16));">
            <div class="container">
                <p class="legal__breadcrumb"><a href="/">Home</a> / <a href="/apps/">Apps</a> / Remtio / Datenschutz</p>
                <p><a href="/apps/remtio/datenschutz/en">English version</a></p>
                <h1>Datenschutzerkl&auml;rung &ndash; Remtio Mobile-App</h1>

                <h2>1. Verantwortlicher</h2>
                <p>
                    <strong>Velletti Consulting</strong><br>
                    Munich, Bavaria, Germany<br>
                    E-Mail: <a href="mailto:vel-consulting@ame.velletti.de">vel-consulting@ame.velletti.de</a><br>
                    Weitere Angaben: <a href="/impressum.php">Impressum</a>
                </p>
                <p><strong>[PLATZHALTER: Datenschutzbeauftragter ja/nein &ndash; falls ja, Kontaktdaten erg&auml;nzen]</strong></p>

                <h2>2. &Uuml;berblick</h2>
                <p>Die Remtio-App (Android und iOS) ist ein KI-Kaufberater f&uuml;r refurbished Technik. Sie erm&ouml;glicht
                    Freitextsuche &uuml;ber einen Angebotskatalog, ein Swipe-Deck zum Entdecken von Angeboten und eine
                    lokal gespeicherte Merkliste. Diese Erkl&auml;rung beschreibt, welche personenbezogenen Daten die App
                    verarbeitet.</p>

                <h2>3. Daten, die nur auf Ihrem Ger&auml;t bleiben</h2>
                <p>Ihre Merkliste und die Liste &uuml;bersprungener Angebote werden ausschlie&szlig;lich lokal auf Ihrem
                    Ger&auml;t gespeichert (Android: SharedPreferences, iOS: UserDefaults). Diese Daten werden nicht an
                    unsere Server &uuml;bertragen und mit der Deinstallation der App gel&ouml;scht.</p>

                <h2>4. Daten, die an unsere Server &uuml;bertragen werden</h2>
                <h3>Suchanfragen</h3>
                <p>Ihre Freitext-Suchanfragen werden zur Verarbeitung an unser Backend &uuml;bertragen und dort gespeichert,
                    um Suchergebnisse bereitzustellen und die Suchqualit&auml;t zu verbessern. Zur KI-gest&uuml;tzten
                    Auswertung werden Suchanfragen an AWS Bedrock (Amazon Web Services) weitergegeben.
                    Rechtsgrundlage: Art. 6 Abs. 1 lit. b und f DSGVO.
                    Speicherdauer: <strong>[PLATZHALTER: Speicherfrist f&uuml;r Suchanfragen festlegen]</strong>.</p>
                <h3>Klick- und Interaktionsdaten</h3>
                <p>Beim Antippen eines Angebots erfassen wir das Angebot (Offer-ID) und die Quelle (&bdquo;mobile&ldquo;),
                    um die Relevanz unseres Katalogs zu analysieren. Diese Daten sind nicht mit Ihrer Person verkn&uuml;pft.
                    Rechtsgrundlage: Art. 6 Abs. 1 lit. f DSGVO.
                    Speicherdauer: <strong>[PLATZHALTER: Speicherfrist f&uuml;r Klick-Daten festlegen]</strong>.</p>
                <h3>Beratungs-Chat</h3>
                <p>Nutzen Sie den KI-Beratungs-Chat, werden Ihre Nachrichten zur Beantwortung an AWS Bedrock &uuml;bermittelt.
                    Roh-Dialoge werden nach 30 Tagen automatisch gel&ouml;scht; strukturierte Anforderungen und Ergebnisse
                    speichern wir bis zu 12 Monate. Rechtsgrundlage: Art. 6 Abs. 1 lit. b DSGVO.</p>

                <h2>5. Anmeldung (nur Android)</h2>
                <p>Die Anmeldung erfolgt optional &uuml;ber Auth0 (Okta, Inc.). Dabei verarbeitet Auth0 Ihre E-Mail-Adresse
                    und Ihren Namen. Unser Backend erh&auml;lt Ihre Identit&auml;t nur als pseudonymisierten Hash
                    (HMAC-SHA256) &ndash; Ihre E-Mail-Adresse und Ihr Name werden nicht an unsere Server &uuml;bertragen.
                    Die Anmeldung wird nicht dauerhaft auf dem Ger&auml;t gespeichert.
                    Rechtsgrundlage: Art. 6 Abs. 1 lit. b DSGVO.
                    Datenschutzerkl&auml;rung von Auth0: <a href="https://www.okta.com/privacy-policy/" target="_blank" rel="noopener">okta.com/privacy-policy</a>.</p>

                <h2>6. Server-Logs und Telemetrie</h2>
                <p>Bei jeder Anfrage an unser Backend verarbeiten wir technisch notwendige Daten (IP-Adresse, User-Agent,
                    Request-Header) in Server-Logs (AWS CloudWatch, Aufbewahrung ca. 30 Tage) sowie in
                    Observability-Traces beim Dienstleister Dash0
                    <strong>[PLATZHALTER: Dash0-Firmenanschrift, AVV-Status, Speicherort und Aufbewahrungsfrist]</strong>.
                    Die Traces k&ouml;nnen Suchanfragen als Teil von URLs enthalten.
                    Rechtsgrundlage: Art. 6 Abs. 1 lit. f DSGVO (Betriebssicherheit und Fehleranalyse).</p>

                <h2>7. Empf&auml;nger und Drittlandtransfer</h2>
                <p>Empf&auml;nger im Rahmen der Auftragsverarbeitung: Amazon Web Services (Hosting, Datenbank, KI-Dienste
                    via Bedrock), Auth0/Okta (Anmeldung), Dash0 (Telemetrie).
                    <strong>[PLATZHALTER: AWS-Region der Datenverarbeitung inkl. Bedrock-Region; Drittlandtransfer-Mechanismus
                    (z.&nbsp;B. EU-Standardvertragsklauseln / EU-US Data Privacy Framework) f&uuml;r AWS, Auth0 und Dash0]</strong></p>

                <h2>8. Keine Analytics- oder Werbe-SDKs</h2>
                <p>Die App enth&auml;lt keine Analyse-, Werbe- oder Crash-Reporting-SDKs von Drittanbietern und ben&ouml;tigt
                    als einzige Berechtigung den Internetzugriff.</p>

                <h2>9. Ihre Rechte</h2>
                <p>Sie haben Rechte auf Auskunft, Berichtigung, L&ouml;schung, Einschr&auml;nkung der Verarbeitung,
                    Daten&uuml;bertragbarkeit sowie Widerspruch (Art. 15 bis 21 DSGVO). Zur Aus&uuml;bung gen&uuml;gt eine
                    E-Mail an <a href="mailto:vel-consulting@ame.velletti.de">vel-consulting@ame.velletti.de</a>.
                    Zudem besteht ein Beschwerderecht bei einer Datenschutz-Aufsichtsbeh&ouml;rde.</p>

                <p>Stand: 2026-07-12</p>
            </div>
        </section>
    </main>

<?php page_bottom(); ?>
