<?php
require_once __DIR__ . '/../../includes/app-page.php';

page_top([
    'title' => 'Privacy Policy LensGuard App | Velletti Consulting',
    'path' => '/apps/lensguard/datenschutz/en',
    'lang' => 'en',
    'alternates' => [
        'de' => '/apps/lensguard/datenschutz',
        'en' => '/apps/lensguard/datenschutz/en',
    ],
]);
?>

    <main>
        <section class="section legal" style="padding-top: calc(var(--nav-height) + var(--space-16));">
            <div class="container">
                <p class="legal__breadcrumb"><a href="/">Home</a> / <a href="/apps/">Apps</a> / LensGuard / Privacy Policy</p>
                <p><a href="/apps/lensguard/datenschutz">Deutsche Version</a></p>
                <h1>Privacy Policy &ndash; LensGuard App</h1>

                <h2>1. Controller</h2>
                <p>
                    <strong>Velletti Consulting</strong><br>
                    Munich, Bavaria, Germany<br>
                    Email: <a href="mailto:vel-consulting@ame.velletti.de">vel-consulting@ame.velletti.de</a><br>
                    Further details: <a href="/impressum.php">Legal notice (Impressum)</a>
                </p>

                <h2>2. Overview</h2>
                <p>LensGuard helps contact lens wearers with wear-time tracking, replacement reminders, price alerts,
                    and managing a prescription profile. The app uses Google Firebase services. This policy describes
                    which personal data is processed.</p>

                <h2>3. Account and sign-in</h2>
                <p>Sign-in uses Firebase Authentication via email/password or Google Sign-In. This processes your email
                    address, a user ID, and &ndash; with Google Sign-In &ndash; your Google account data (email, name,
                    profile picture). Legal basis: Art. 6(1)(b) GDPR.</p>

                <h2>4. Health data (prescription)</h2>
                <p>If you set up your prescription profile, we store your dioptre values (left/right) and your preferred
                    lens brand and model in Cloud Firestore. Dioptre values are health data under Art. 9 GDPR. We process
                    them solely on the basis of your explicit consent (Art. 9(2)(a) GDPR), which you give by voluntarily
                    entering these values. You may withdraw consent at any time by deleting the values or your account
                    (see section 8).</p>

                <h2>5. Stored account data</h2>
                <p>Your user profile (Cloud Firestore) contains: email address, dioptre values, preferred lens
                    brand/model, the start date of your current lens pair, the last notified price, the device token for
                    push notifications (FCM token), and the account creation date.
                    <strong>[PLACEHOLDER: verify and state the Firebase/Firestore region, e.g. europe-west3]</strong></p>

                <h2>6. Push notifications and local reminders</h2>
                <p>Price alerts are delivered via Firebase Cloud Messaging; a device token is stored in your profile for
                    this purpose. Daily replacement reminders are local notifications generated directly on your device;
                    reminder settings are stored locally only and never transmitted.</p>

                <h2>7. Crash reports, analytics, and performance</h2>
                <p>The app uses Firebase Crashlytics (crash reports, stack traces, device information), Firebase
                    Analytics (app interactions, device identifiers, approximate location), and Firebase Performance
                    Monitoring (app start times, network latencies).
                    Legal basis: Art. 6(1)(f) GDPR (legitimate interest in app stability and improvement)
                    <strong>[PLACEHOLDER: add an analytics consent dialog and switch the legal basis to consent &ndash;
                    legitimate interest is legally shaky for analytics in the EU]</strong>.
                    No advertising SDKs are used and no data is shared with third parties for advertising purposes.</p>

                <h2>8. Account deletion</h2>
                <p>You can delete your account at any time directly in the app. This fully removes your user profile in
                    Cloud Firestore and your authentication account (Art. 17 GDPR).
                    Instructions: <a href="/apps/lensguard/konto-loeschen">Delete account</a>.</p>

                <h2>9. Recipients and international transfers</h2>
                <p>Google LLC / Google Ireland Ltd. acts as processor (Firebase services). Data may be transferred to
                    the United States. Google is certified under the EU-US Data Privacy Framework; EU Standard
                    Contractual Clauses apply in addition.
                    More information: <a href="https://firebase.google.com/support/privacy" target="_blank" rel="noopener">firebase.google.com/support/privacy</a>.</p>

                <h2>10. Your rights</h2>
                <p>You have the rights of access, rectification, erasure, restriction of processing, data portability,
                    and objection (Art. 15&ndash;21 GDPR). To exercise them, email
                    <a href="mailto:vel-consulting@ame.velletti.de">vel-consulting@ame.velletti.de</a>.
                    You also have the right to lodge a complaint with a data protection supervisory authority.</p>

                <p>Last updated: 2026-07-12</p>
            </div>
        </section>
    </main>

<?php page_bottom(); ?>
