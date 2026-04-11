<?php
/**
 * Velletti Consulting - Checkout Success
 */
require_once __DIR__ . '/includes/headers.php';
session_start();

$config = [
    'site_title' => 'Velletti Consulting | Zahlung erfolgreich',
    'company_name' => 'Velletti Consulting',
];
$cssVersion = @filemtime(__DIR__ . '/assets/css/app.css') ?: time();
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo htmlspecialchars($config['site_title']); ?>
    </title>
    <link rel="stylesheet" href="assets/css/app.css?v=<?php echo $cssVersion; ?>">
    <!-- Privacy-friendly analytics by Plausible -->
    <script async src="https://plausible.io/js/pa-JqqQJVxsU6l36GPzFI8OK.js"></script>
    <script>window.plausible=window.plausible||function(){(plausible.q=plausible.q||[]).push(arguments)},plausible.init=plausible.init||function(i){plausible.o=i||{}};plausible.init()</script>
    <style>
        .msg-box {
            max-width: 500px;
            margin: calc(var(--nav-height) + var(--space-16)) auto var(--space-16);
            text-align: center;
            padding: var(--space-12);
            background: var(--bg-surface);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border-subtle);
        }

        .icon {
            font-size: 4rem;
            margin-bottom: var(--space-4);
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="container header__container">
            <a href="/" class="logo">
                <?php echo htmlspecialchars($config['company_name']); ?>
            </a>
        </div>
    </header>

    <main class="container">
        <div class="msg-box">
            <div class="icon">🎉</div>
            <h2>Vielen Dank für deine Buchung!</h2>
            <p>Deine Zahlung war erfolgreich. Wir haben dir eine Bestätigung per E-Mail gesendet und melden uns innerhalb von 24 Stunden, um einen Termin für die Erstberatung zu vereinbaren.</p>
            <br>
            <a href="/" class="cta-button">Zurück zur Startseite</a>
        </div>
    </main>
    <script>if(typeof plausible!=='undefined')plausible('payment_success');</script>
</body>

</html>