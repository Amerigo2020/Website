<?php
require_once __DIR__ . '/includes/headers.php';

$config = [
    'site_title' => 'Impressum | Velletti Consulting',
    'company_name' => 'Velletti Consulting',
    'company_email' => 'vel-consulting@ame.velletti.de',
    'company_phone' => '+49 176 45531533',
    'company_address' => 'Munich, Bavaria, Germany'
];

$cssVersion = @filemtime(__DIR__ . '/assets/css/app.css') ?: time();
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost:8000';
$canonical = $scheme . '://' . $host . '/impressum.php';
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
                <p class="legal__breadcrumb"><a href="/">Home</a> / Impressum</p>
                <h1>Impressum</h1>
                <p>Dienstanbieter gem&auml;&szlig; &sect; 5 TMG</p>
                <p>
                    <strong><?php echo htmlspecialchars($config['company_name']); ?></strong><br>
                    <?php echo htmlspecialchars($config['company_address']); ?><br>
                    Telefon: <a href="tel:<?php echo htmlspecialchars($config['company_phone']); ?>"><?php echo htmlspecialchars($config['company_phone']); ?></a><br>
                    E-Mail: <a href="mailto:<?php echo htmlspecialchars($config['company_email']); ?>"><?php echo htmlspecialchars($config['company_email']); ?></a>
                </p>
                <h2>Haftung f&uuml;r Inhalte</h2>
                <p>Als Diensteanbieter sind wir gem&auml;&szlig; &sect; 7 Abs. 1 TMG f&uuml;r eigene Inhalte auf diesen Seiten nach den
                    allgemeinen Gesetzen verantwortlich. Nach &sect;&sect; 8 bis 10 TMG sind wir jedoch nicht verpflichtet,
                    &uuml;bermittelte oder gespeicherte fremde Informationen zu &uuml;berwachen oder nach Umst&auml;nden zu forschen,
                    die auf eine rechtswidrige T&auml;tigkeit hinweisen.</p>
                <h2>Haftung f&uuml;r Links</h2>
                <p>Unser Angebot enth&auml;lt Links zu externen Websites Dritter, auf deren Inhalte wir keinen Einfluss
                    haben. F&uuml;r diese fremden Inhalte &uuml;bernehmen wir keine Gew&auml;hr. F&uuml;r die Inhalte der verlinkten Seiten
                    ist stets der jeweilige Anbieter oder Betreiber verantwortlich.</p>
                <h2>Urheberrecht</h2>
                <p>Die durch die Seitenbetreiber erstellten Inhalte und Werke auf diesen Seiten unterliegen dem
                    deutschen Urheberrecht. Vervielf&auml;ltigung, Bearbeitung, Verbreitung und jede Art der Verwertung
                    au&szlig;erhalb der Grenzen des Urheberrechts bed&uuml;rfen der schriftlichen Zustimmung des jeweiligen Autors
                    bzw. Erstellers.</p>
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
