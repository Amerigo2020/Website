<?php
/**
 * Velletti Consulting - Checkout Success
 */
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
    <style>
        .msg-box {
            max-width: 500px;
            margin: var(--spacing-2xl) auto;
            text-align: center;
            padding: var(--spacing-xl);
            background: var(--color-white);
            border-radius: 12px;
            box-shadow: var(--shadow-lg);
        }

        :root[data-theme='dark'] .msg-box {
            background: #0f172a;
        }

        .icon {
            font-size: 4rem;
            margin-bottom: var(--spacing-md);
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
            <h2>Vielen Dank für dein Abo!</h2>
            <p>Deine Zahlung war erfolgreich. Wir haben dir eine Bestätigung per E-Mail gesendet und werden uns in Kürze
                bei dir melden, um das Onboarding zu starten.</p>
            <br>
            <a href="/" class="cta-button">Zurück zur Startseite</a>
        </div>
    </main>
</body>

</html>