<?php
require_once __DIR__ . '/includes/headers.php';
http_response_code(404);

$cssVersion = @filemtime(__DIR__ . '/assets/css/app.css') ?: time();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex">
    <title>404 – Seite nicht gefunden | Velletti Consulting</title>
    <link rel="icon" type="image/svg+xml" href="assets/favicon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/app.css?v=<?php echo $cssVersion; ?>">
    <!-- Privacy-friendly analytics by Plausible -->
    <script async src="https://plausible.io/js/pa-JqqQJVxsU6l36GPzFI8OK.js"></script>
    <script>window.plausible=window.plausible||function(){(plausible.q=plausible.q||[]).push(arguments)},plausible.init=plausible.init||function(i){plausible.o=i||{}};plausible.init()</script>
</head>
<body>
    <header class="header">
        <div class="container header__container">
            <a href="/" class="logo" aria-label="Velletti Consulting – Startseite">Velletti Consulting</a>
        </div>
    </header>

    <main style="min-height: calc(100vh - 5rem); display: flex; align-items: center; justify-content: center; padding: 3rem 1.5rem;">
        <div style="text-align: center; max-width: 36rem; margin: 0 auto;">
            <h1 style="font-size: clamp(3.5rem, 12vw, 6rem); font-weight: 800; line-height: 1; letter-spacing: -0.04em; margin: 0 0 1rem;">404</h1>
            <p style="font-size: var(--text-xl, 1.25rem); font-weight: 600; color: var(--text-primary, inherit); margin: 0 0 0.75rem;">Seite nicht gefunden</p>
            <p style="color: var(--text-secondary, #64748b); line-height: 1.6; margin: 0 0 2rem;">Die angeforderte Seite existiert nicht oder wurde verschoben.</p>
            <div style="display: flex; flex-wrap: wrap; gap: 0.75rem; justify-content: center;">
                <a href="/" class="btn btn--primary">Zurück zur Startseite</a>
                <a href="/blog/" class="btn btn--ghost">Blog lesen</a>
            </div>
        </div>
    </main>
</body>
</html>
