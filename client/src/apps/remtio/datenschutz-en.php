<?php
require_once __DIR__ . '/../../includes/app-page.php';

page_top([
    'title' => 'Privacy Policy Remtio App | Velletti Consulting',
    'path' => '/apps/remtio/datenschutz/en',
    'lang' => 'en',
    'alternates' => [
        'de' => '/apps/remtio/datenschutz',
        'en' => '/apps/remtio/datenschutz/en',
    ],
]);
?>

    <main>
        <section class="section legal" style="padding-top: calc(var(--nav-height) + var(--space-16));">
            <div class="container">
                <p class="legal__breadcrumb"><a href="/">Home</a> / <a href="/apps/">Apps</a> / Remtio / Privacy Policy</p>
                <p><a href="/apps/remtio/datenschutz">Deutsche Version</a></p>
                <h1>Privacy Policy &ndash; Remtio Mobile App</h1>

                <h2>1. Controller</h2>
                <p>
                    <strong>Velletti Consulting</strong><br>
                    Munich, Bavaria, Germany<br>
                    Email: <a href="mailto:vel-consulting@ame.velletti.de">vel-consulting@ame.velletti.de</a><br>
                    Further details: <a href="/impressum.php">Legal notice (Impressum)</a>
                </p>
                <p><strong>[PLACEHOLDER: Data protection officer yes/no &ndash; add contact details if yes]</strong></p>

                <h2>2. Overview</h2>
                <p>The Remtio app (Android and iOS) is an AI shopping assistant for refurbished tech. It offers free-text
                    search across an offer catalog, a swipe deck for discovering offers, and a locally stored watchlist.
                    This policy describes which personal data the app processes.</p>

                <h2>3. Data that stays on your device</h2>
                <p>Your watchlist and the list of skipped offers are stored exclusively on your device (Android:
                    SharedPreferences, iOS: UserDefaults). This data is never sent to our servers and is deleted when
                    you uninstall the app.</p>

                <h2>4. Data sent to our servers</h2>
                <h3>Search queries</h3>
                <p>Your free-text search queries are sent to our backend and stored there to provide search results and
                    improve search quality. For AI-assisted processing, queries are passed to AWS Bedrock (Amazon Web
                    Services). Legal basis: Art. 6(1)(b) and (f) GDPR.
                    Retention: <strong>[PLACEHOLDER: define retention period for search queries]</strong>.</p>
                <h3>Click and interaction data</h3>
                <p>When you tap an offer, we record the offer ID and the source ("mobile") to analyse catalog relevance.
                    This data is not linked to your identity. Legal basis: Art. 6(1)(f) GDPR.
                    Retention: <strong>[PLACEHOLDER: define retention period for click data]</strong>.</p>
                <h3>Advisory chat</h3>
                <p>If you use the AI advisory chat, your messages are transmitted to AWS Bedrock to generate responses.
                    Raw dialogues are deleted automatically after 30 days; structured requirements and outcomes are
                    stored for up to 12 months. Legal basis: Art. 6(1)(b) GDPR.</p>

                <h2>5. Sign-in (Android only)</h2>
                <p>Sign-in is optional and handled by Auth0 (Okta, Inc.), which processes your email address and name.
                    Our backend receives your identity only as a pseudonymised hash (HMAC-SHA256) &ndash; your email
                    address and name are never transmitted to our servers. The session is not persisted on the device.
                    Legal basis: Art. 6(1)(b) GDPR.
                    Auth0 privacy policy: <a href="https://www.okta.com/privacy-policy/" target="_blank" rel="noopener">okta.com/privacy-policy</a>.</p>

                <h2>6. Server logs and telemetry</h2>
                <p>Each request to our backend involves processing of technically necessary data (IP address, user agent,
                    request headers) in server logs (AWS CloudWatch, retained for approx. 30 days) and in observability
                    traces at our provider Dash0
                    <strong>[PLACEHOLDER: Dash0 company address, DPA status, storage location and retention]</strong>.
                    Traces may contain search queries as part of URLs.
                    Legal basis: Art. 6(1)(f) GDPR (operational security and troubleshooting).</p>

                <h2>7. Recipients and international transfers</h2>
                <p>Processors: Amazon Web Services (hosting, database, AI services via Bedrock), Auth0/Okta (sign-in),
                    Dash0 (telemetry).
                    <strong>[PLACEHOLDER: AWS processing region incl. Bedrock region; transfer mechanism
                    (e.g. EU Standard Contractual Clauses / EU-US Data Privacy Framework) for AWS, Auth0 and Dash0]</strong></p>

                <h2>8. No analytics or advertising SDKs</h2>
                <p>The app contains no third-party analytics, advertising, or crash-reporting SDKs, and its only
                    permission is internet access.</p>

                <h2>9. Your rights</h2>
                <p>You have the rights of access, rectification, erasure, restriction of processing, data portability,
                    and objection (Art. 15&ndash;21 GDPR). To exercise them, email
                    <a href="mailto:vel-consulting@ame.velletti.de">vel-consulting@ame.velletti.de</a>.
                    You also have the right to lodge a complaint with a data protection supervisory authority.</p>

                <p>Last updated: 2026-07-12</p>
            </div>
        </section>
    </main>

<?php page_bottom(); ?>
