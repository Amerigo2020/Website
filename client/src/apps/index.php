<?php
require_once __DIR__ . '/../includes/app-page.php';

page_top([
    'title' => 'Apps | Velletti Consulting',
    'description' => 'Mobile Apps von Velletti Consulting: Remtio – KI-Kaufberater für refurbished Technik, und LensGuard – Tragezeit-Tracker und Preisalarm für Kontaktlinsen.',
    'path' => '/apps/',
]);
?>

    <main>
        <section class="section" style="padding-top: calc(var(--nav-height) + var(--space-16));">
            <div class="container">
                <p class="legal__breadcrumb"><a href="/">Home</a> / Apps</p>
                <h1>Unsere Apps</h1>
                <p style="max-width: 65ch;">Mobile Apps aus eigener Entwicklung &ndash; f&uuml;r Android und iOS.</p>

                <div class="cards" style="display: grid; gap: var(--space-8); grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); margin-top: var(--space-12);">

                    <article class="card">
                        <h2>Remtio</h2>
                        <p>KI-Kaufberater f&uuml;r refurbished Technik. Freitextsuche &uuml;ber einen kuratierten
                            Angebotskatalog, Swipe-Deck zum Entdecken und eine lokale Merkliste &ndash; die App
                            findet das passende Ger&auml;t zum besten Preis.</p>
                        <p>
                            <!-- [PLATZHALTER: App Store Link] -->
                            <!-- [PLATZHALTER: Google Play Link] -->
                            <em>Bald im App Store und bei Google Play.</em>
                        </p>
                        <p>
                            <a href="https://remtio.com" target="_blank" rel="noopener">Website</a> &middot;
                            <a href="/apps/remtio/datenschutz">Datenschutz</a> &middot;
                            <a href="/apps/remtio/datenschutz/en">Privacy Policy (EN)</a> &middot;
                            <a href="/impressum.php">Impressum</a>
                        </p>
                    </article>

                    <article class="card">
                        <h2>LensGuard</h2>
                        <p>Der Begleiter f&uuml;r Kontaktlinsentr&auml;ger: Tragezeit-Tracking, Wechsel-Erinnerungen,
                            Preisalarme f&uuml;r Ihre Linsenmodelle und ein Sehst&auml;rken-Profil &ndash; alles in einer App.</p>
                        <p>
                            <!-- [PLATZHALTER: App Store Link] -->
                            <!-- [PLATZHALTER: Google Play Link] -->
                            <em>Bald im App Store und bei Google Play.</em>
                        </p>
                        <p>
                            <a href="/apps/lensguard/datenschutz">Datenschutz</a> &middot;
                            <a href="/apps/lensguard/datenschutz/en">Privacy Policy (EN)</a> &middot;
                            <a href="/apps/lensguard/konto-loeschen">Konto l&ouml;schen</a> &middot;
                            <a href="/impressum.php">Impressum</a>
                        </p>
                    </article>

                </div>
            </div>
        </section>
    </main>

<?php page_bottom(); ?>
