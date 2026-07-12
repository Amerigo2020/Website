<?php
/**
 * Shared page shell for /apps/* pages (header, nav, footer).
 * Usage: set $page array, include this file, call page_top() / page_bottom().
 */

require_once __DIR__ . '/headers.php';

const APP_PAGE_COMPANY = [
    'name' => 'Velletti Consulting',
    'email' => 'vel-consulting@ame.velletti.de',
    'phone' => '+49 176 45531533',
    'address' => 'Munich, Bavaria, Germany',
];

/**
 * @param array{title: string, description?: string, path: string, lang?: string, alternates?: array<string,string>} $p
 *   alternates: map of lang code => absolute path (for hreflang pairs)
 */
function page_top(array $p): void
{
    $c = APP_PAGE_COMPANY;
    $lang = $p['lang'] ?? 'de';
    $cssVersion = @filemtime(__DIR__ . '/../assets/css/app.css') ?: time();
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost:8000';
    $origin = $scheme . '://' . $host;
?>
<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($lang); ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($p['title']); ?></title>
    <?php if (!empty($p['description'])): ?>
    <meta name="description" content="<?php echo htmlspecialchars($p['description']); ?>">
    <?php endif; ?>
    <link rel="icon" type="image/svg+xml" href="/assets/favicon.svg">
    <link rel="canonical" href="<?php echo htmlspecialchars($origin . $p['path']); ?>">
    <?php foreach ($p['alternates'] ?? [] as $altLang => $altPath): ?>
    <link rel="alternate" hreflang="<?php echo htmlspecialchars($altLang); ?>" href="<?php echo htmlspecialchars($origin . $altPath); ?>">
    <?php endforeach; ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/app.css?v=<?php echo $cssVersion; ?>">
    <script async src="https://plausible.io/js/pa-JqqQJVxsU6l36GPzFI8OK.js"></script>
    <script>window.plausible=window.plausible||function(){(plausible.q=plausible.q||[]).push(arguments)},plausible.init=plausible.init||function(i){plausible.o=i||{}};plausible.init()</script>
</head>

<body>
    <header class="header">
        <div class="container header__container">
            <a href="/" class="logo" aria-label="<?php echo htmlspecialchars($c['name']); ?> Home">
                <?php echo htmlspecialchars($c['name']); ?>
            </a>
            <nav class="nav" role="navigation" aria-label="Main navigation">
                <a href="/" class="nav__link">Home</a>
                <a href="/#services" class="nav__link">Services</a>
                <a href="/apps/" class="nav__link">Apps</a>
                <a href="/blog/" class="nav__link">Blog</a>
                <a href="/#contact" class="nav__link">Contact</a>
            </nav>
            <button class="mobile-menu-toggle" onclick="toggleMobileMenu()" aria-label="Toggle mobile menu" aria-expanded="false">&#9776;</button>
            <div class="mobile-menu" id="mobileMenu">
                <nav class="nav" role="navigation" aria-label="Mobile navigation">
                    <a href="/" class="nav__link" onclick="closeMobileMenu()">Home</a>
                    <a href="/#services" class="nav__link" onclick="closeMobileMenu()">Services</a>
                    <a href="/apps/" class="nav__link" onclick="closeMobileMenu()">Apps</a>
                    <a href="/blog/" class="nav__link" onclick="closeMobileMenu()">Blog</a>
                    <a href="/#contact" class="nav__link" onclick="closeMobileMenu()">Contact</a>
                </nav>
            </div>
        </div>
    </header>
<?php
}

function page_bottom(): void
{
    $c = APP_PAGE_COMPANY;
?>
    <footer class="footer">
        <div class="container">
            <div class="footer__content">
                <div class="footer__brand">
                    <span class="footer__brand-name"><?php echo htmlspecialchars($c['name']); ?></span>
                    <p class="footer__tagline">Systems, automation, and deployment for startups.</p>
                    <p style="margin-bottom:0;">
                        <a href="mailto:<?php echo htmlspecialchars($c['email']); ?>"><?php echo htmlspecialchars($c['email']); ?></a><br>
                        <a href="tel:<?php echo htmlspecialchars($c['phone']); ?>"><?php echo htmlspecialchars($c['phone']); ?></a>
                    </p>
                </div>
                <div>
                    <p class="footer__col-title">Navigate</p>
                    <ul class="footer__links">
                        <li><a href="/">Home</a></li>
                        <li><a href="/#services">Services</a></li>
                        <li><a href="/apps/">Apps</a></li>
                        <li><a href="/blog/">Blog</a></li>
                        <li><a href="/#contact">Contact</a></li>
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
                <span>&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($c['name']); ?></span>
                <span><?php echo htmlspecialchars($c['address']); ?></span>
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
<?php
}
