<?php
require_once __DIR__ . '/../../includes/app-page.php';

page_top([
    'title' => 'LensGuard Konto löschen / Delete Account | Velletti Consulting',
    'path' => '/apps/lensguard/konto-loeschen',
    'lang' => 'de',
]);
?>

    <main>
        <section class="section legal" style="padding-top: calc(var(--nav-height) + var(--space-16));">
            <div class="container">
                <p class="legal__breadcrumb"><a href="/">Home</a> / <a href="/apps/">Apps</a> / LensGuard / Konto l&ouml;schen</p>
                <h1>LensGuard &ndash; Konto l&ouml;schen</h1>

                <h2>In der App (empfohlen)</h2>
                <ol>
                    <li>&Ouml;ffnen Sie die LensGuard-App und melden Sie sich an.</li>
                    <li>&Ouml;ffnen Sie die <strong>Einstellungen</strong> (Profil-Bereich).</li>
                    <li>W&auml;hlen Sie <strong>&bdquo;Konto l&ouml;schen&ldquo;</strong> und best&auml;tigen Sie.</li>
                </ol>
                <p>Dabei werden sofort und dauerhaft gel&ouml;scht: Ihr Nutzerprofil (E-Mail, Sehst&auml;rken-Werte,
                    Linsen-Pr&auml;ferenzen, Preisalarm-Daten, Ger&auml;te-Token) sowie Ihr Anmeldekonto. Lokal auf dem
                    Ger&auml;t gespeicherte Erinnerungs-Einstellungen entfernen Sie durch Deinstallation der App.</p>

                <h2>Per E-Mail</h2>
                <p>Alternativ senden Sie eine L&ouml;schanfrage von der in der App verwendeten E-Mail-Adresse an
                    <a href="mailto:vel-consulting@ame.velletti.de?subject=LensGuard%20Kontol%C3%B6schung">vel-consulting@ame.velletti.de</a>.
                    Wir l&ouml;schen Ihr Konto und alle zugeh&ouml;rigen Daten innerhalb von 30 Tagen und best&auml;tigen
                    die L&ouml;schung.</p>

                <hr>

                <h1 lang="en">LensGuard &ndash; Delete Account</h1>

                <h2 lang="en">In the app (recommended)</h2>
                <ol lang="en">
                    <li>Open the LensGuard app and sign in.</li>
                    <li>Open <strong>Settings</strong> (profile section).</li>
                    <li>Select <strong>"Delete account"</strong> and confirm.</li>
                </ol>
                <p lang="en">This immediately and permanently deletes your user profile (email, prescription values, lens
                    preferences, price alert data, device token) and your sign-in account. Reminder settings stored
                    locally are removed by uninstalling the app.</p>

                <h2 lang="en">By email</h2>
                <p lang="en">Alternatively, send a deletion request from the email address used in the app to
                    <a href="mailto:vel-consulting@ame.velletti.de?subject=LensGuard%20Account%20Deletion">vel-consulting@ame.velletti.de</a>.
                    We will delete your account and all associated data within 30 days and confirm the deletion.</p>

                <p>Stand / Last updated: 2026-07-12</p>
            </div>
        </section>
    </main>

<?php page_bottom(); ?>
