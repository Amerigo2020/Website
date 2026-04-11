<?php
require_once __DIR__ . '/includes/headers.php';

$config = [
    'site_title' => 'Datenschutzerklärung | Velletti Consulting',
    'company_name' => 'Velletti Consulting',
    'company_email' => 'vel-consulting@ame.velletti.de',
    'company_phone' => '+49 176 45531533',
    'company_address' => 'Munich, Bavaria, Germany'
];

$cssVersion = @filemtime(__DIR__ . '/assets/css/app.css') ?: time();
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost:8000';
$canonical = $scheme . '://' . $host . '/datenschutz.php';
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,follow">
    <title><?php echo htmlspecialchars($config['site_title']); ?></title>
    <link rel="icon" type="image/svg+xml" href="assets/favicon.svg">
    <link rel="canonical" href="<?php echo htmlspecialchars($canonical); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/app.css?v=<?php echo $cssVersion; ?>">
    <script async src="https://plausible.io/js/pa-JqqQJVxsU6l36GPzFI8OK.js"></script>
    <script>window.plausible=window.plausible||function(){(plausible.q=plausible.q||[]).push(arguments)},plausible.init=plausible.init||function(i){plausible.o=i||{}};plausible.init()</script>
</head>

<body>
    <header class="header">
        <div class="container header__container">
            <a href="/" class="logo" aria-label="<?php echo htmlspecialchars($config['company_name']); ?> Home">
                <?php echo htmlspecialchars($config['company_name']); ?>
            </a>
            <nav class="nav" role="navigation" aria-label="Main navigation">
                <a href="/" class="nav__link">Home</a>
                <a href="/#services" class="nav__link">Services</a>
                <a href="/blog/" class="nav__link">Blog</a>
                <a href="/#contact" class="nav__link">Contact</a>
            </nav>
            <button class="mobile-menu-toggle" onclick="toggleMobileMenu()" aria-label="Toggle mobile menu" aria-expanded="false">&#9776;</button>
            <div class="mobile-menu" id="mobileMenu">
                <nav class="nav" role="navigation" aria-label="Mobile navigation">
                    <a href="/" class="nav__link" onclick="closeMobileMenu()">Home</a>
                    <a href="/#services" class="nav__link" onclick="closeMobileMenu()">Services</a>
                    <a href="/blog/" class="nav__link" onclick="closeMobileMenu()">Blog</a>
                    <a href="/#contact" class="nav__link" onclick="closeMobileMenu()">Contact</a>
                </nav>
            </div>
        </div>
    </header>

    <main>
        <section class="section legal" style="padding-top: calc(var(--nav-height) + var(--space-16));">
            <div class="container">
                <p class="legal__breadcrumb"><a href="/">Home</a> / Datenschutz</p>
                <h1>Datenschutzerkl&auml;rung</h1>
                <p>Verantwortlicher im Sinne der DSGVO:</p>
                <p>
                    <strong><?php echo htmlspecialchars($config['company_name']); ?></strong><br>
                    <?php echo htmlspecialchars($config['company_address']); ?><br>
                    E-Mail: <a href="mailto:<?php echo htmlspecialchars($config['company_email']); ?>"><?php echo htmlspecialchars($config['company_email']); ?></a>
                </p>
                <h2>Allgemeines</h2>
                <p>Wir verarbeiten personenbezogene Daten nur, soweit dies zur Bereitstellung einer funktionsf&auml;higen
                    Website sowie unserer Inhalte und Leistungen erforderlich ist. Rechtsgrundlagen sind insbesondere
                    Art. 6 Abs. 1 lit. a, b und f DSGVO.</p>
                <h2>Server-Logs</h2>
                <p>Beim Aufruf dieser Website k&ouml;nnen durch den Hoster technisch notwendige Daten (z. B. IP-Adresse,
                    Zeitpunkt, abgerufene Seiten) in Logfiles verarbeitet werden. Die Speicherung erfolgt aus
                    Sicherheitsgr&uuml;nden und zur Sicherstellung der Funktionsf&auml;higkeit.</p>
                <h2>Kontaktformular</h2>
                <p>Bei Nutzung des Kontaktformulars verarbeiten wir die von Ihnen eingegebenen Daten (Name, E-Mail,
                    Nachricht; optional Telefon) zur Bearbeitung Ihrer Anfrage. Rechtsgrundlage ist Art. 6 Abs. 1 lit. b
                    DSGVO. Die Daten werden nur so lange gespeichert, wie es zur Bearbeitung erforderlich ist.</p>
                <h2>Webanalyse</h2>
                <p>Diese Website nutzt Plausible Analytics, einen datenschutzfreundlichen Analysedienst. Plausible
                    erhebt keine personenbezogenen Daten und ist vollst&auml;ndig DSGVO-konform.
                    Es werden ausschlie&szlig;lich anonymisierte, aggregierte Nutzungsdaten erfasst. Weitere Informationen:
                    <a href="https://plausible.io/data-policy" target="_blank" rel="noopener">plausible.io/data-policy</a>.</p>
                <h2>Cookies</h2>
                <p>Diese Website setzt ein technisch notwendiges Cookie (<code>ab_hero</code>) zur Optimierung der
                    Benutzeroberfl&auml;che. Es enth&auml;lt keine personenbezogenen Daten, sondern lediglich eine zuf&auml;llige
                    Variante (a/b) zur Anzeige unterschiedlicher Schaltfl&auml;chen-Texte. Das Cookie wird nach 30 Tagen
                    automatisch gel&ouml;scht. Rechtsgrundlage ist Art. 6 Abs. 1 lit. f DSGVO (berechtigtes Interesse an
                    der Optimierung des Webangebots).</p>
                <h2>Google Fonts</h2>
                <p>Diese Website nutzt Google Fonts zur einheitlichen Darstellung von Schriftarten. Beim Aufruf
                    der Seite stellt Ihr Browser eine Verbindung zu den Servern von Google LLC her. Dabei kann Ihre
                    IP-Adresse an Google &uuml;bertragen werden. Weitere Informationen:
                    <a href="https://policies.google.com/privacy" target="_blank" rel="noopener">Google Datenschutzerkl&auml;rung</a>.</p>
                <h2>Externe Dienste</h2>
                <p>Beim &Ouml;ffnen der LinkedIn- oder GitHub-Vorschau im Modal werden Daten an die jeweiligen Anbieter
                    &uuml;bertragen (LinkedIn: platform.linkedin.com; GitHub: api.github.com). Dies geschieht erst nach
                    aktivem Klick durch den Nutzer. Es gelten die Datenschutzbestimmungen dieser Anbieter.</p>
                <h2>Ihre Rechte</h2>
                <p>Sie haben Rechte auf Auskunft, Berichtigung, L&ouml;schung, Einschr&auml;nkung der Verarbeitung,
                    Daten&uuml;bertragbarkeit sowie Widerspruch (Art. 15 bis 21 DSGVO). Zudem besteht ein Beschwerderecht bei
                    einer Aufsichtsbeh&ouml;rde.</p>
                <p>Stand: <?php echo date('Y-m-d'); ?></p>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer__content">
                <div class="footer__brand">
                    <span class="footer__brand-name"><?php echo htmlspecialchars($config['company_name']); ?></span>
                    <p class="footer__tagline">Systems, automation, and deployment for startups.</p>
                    <p style="margin-bottom:0;">
                        <a href="mailto:<?php echo htmlspecialchars($config['company_email']); ?>"><?php echo htmlspecialchars($config['company_email']); ?></a><br>
                        <a href="tel:<?php echo htmlspecialchars($config['company_phone']); ?>"><?php echo htmlspecialchars($config['company_phone']); ?></a>
                    </p>
                </div>
                <div>
                    <p class="footer__col-title">Navigate</p>
                    <ul class="footer__links">
                        <li><a href="/">Home</a></li>
                        <li><a href="/#services">Services</a></li>
                        <li><a href="/blog/">Blog</a></li>
                        <li><a href="/#contact">Contact</a></li>
                        <li><a href="checkout.php">Premium</a></li>
                    </ul>
                </div>
                <div>
                    <p class="footer__col-title">Legal</p>
                    <ul class="footer__links">
                        <li><a href="/impressum.php">Impressum</a></li>
                        <li><a href="/datenschutz.php">Datenschutz</a></li>
                    </ul>
                    <p class="footer__col-title" style="margin-top: var(--space-6);">Social</p>
                    <ul class="footer__links">
                        <li><a href="https://www.linkedin.com/in/amerigo-velletti-b888a9304" target="_blank" rel="noopener">LinkedIn</a></li>
                        <li><a href="https://github.com/Amerigo2020" target="_blank" rel="noopener">GitHub</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer__bottom">
                <span>&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($config['company_name']); ?></span>
                <span><?php echo htmlspecialchars($config['company_address']); ?></span>
            </div>
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            const toggle = document.querySelector('.mobile-menu-toggle');
            const isOpen = menu.style.display === 'block';
            menu.style.display = isOpen ? 'none' : 'block';
            toggle.setAttribute('aria-expanded', !isOpen);
        }
        function closeMobileMenu() {
            document.getElementById('mobileMenu').style.display = 'none';
            document.querySelector('.mobile-menu-toggle').setAttribute('aria-expanded', 'false');
        }
    </script>
</body>

</html>
