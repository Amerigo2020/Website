<?php
/**
 * Velletti Consulting - Stripe Checkout
 */
require_once __DIR__ . '/includes/headers.php';
session_start();

// Config
$config = [
    'site_title' => 'Erstberatung buchen | Velletti Consulting',
    'company_name' => 'Velletti Consulting',
];
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost:8000';
$canonical = $scheme . '://' . $host . '/checkout.php';
$cssVersion = @filemtime(__DIR__ . '/assets/css/app.css') ?: time();

?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($config['site_title']); ?></title>
    <link rel="stylesheet" href="assets/css/app.css?v=<?php echo $cssVersion; ?>">
    <!-- Privacy-friendly analytics by Plausible -->
    <script async src="https://plausible.io/js/pa-JqqQJVxsU6l36GPzFI8OK.js"></script>
    <script>window.plausible=window.plausible||function(){(plausible.q=plausible.q||[]).push(arguments)},plausible.init=plausible.init||function(i){plausible.o=i||{}};plausible.init()</script>
    <!-- Stripe.js -->
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        .checkout-box {
            max-width: 450px;
            margin: var(--space-24) auto;
            background: var(--bg-surface);
            padding: var(--space-12);
            border-radius: var(--radius-lg);
            text-align: center;
            border: 1px solid var(--border-subtle);
        }

        .price {
            font-size: 3rem;
            font-weight: 800;
            color: var(--accent);
            margin: var(--space-4) 0;
        }

        .price span {
            font-size: 1.2rem;
            color: var(--text-secondary);
        }

        .features {
            text-align: left;
            margin-bottom: var(--space-8);
            list-style: none;
        }

        .features li {
            margin-bottom: var(--space-2);
            padding-left: 24px;
            position: relative;
            color: var(--text-secondary);
        }

        .features li::before {
            content: "\2713";
            color: var(--accent);
            position: absolute;
            left: 0;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <header class="header">
        <div class="container header__container">
            <a href="/" class="logo"><?php echo htmlspecialchars($config['company_name']); ?></a>
        </div>
    </header>

    <main class="container">
        <div class="checkout-box">
            <h2>Erstberatung + Projektplanung</h2>
            <p>Eine Stunde, in der wir dein Vorhaben durchgehen, die technischen Anforderungen klären und einen konkreten Projektplan erstellen.</p>

            <div class="price">
                €99<span> einmalig</span>
            </div>

            <ul class="features">
                <li>60 Minuten 1:1 Beratung</li>
                <li>Technische Anforderungsanalyse</li>
                <li>Konkreter Projektplan mit Meilensteinen</li>
                <li>Kostenschätzung für die Umsetzung</li>
            </ul>

            <form action="create-checkout-session.php" method="POST" onsubmit="if(typeof plausible!=='undefined')plausible('checkout_click')">
                <button type="submit" class="cta-button" style="width: 100%;">
                    Beratung buchen
                </button>
            </form>
            <p style="margin-top: var(--space-3); font-size: 0.85rem; opacity: 0.7;">
                Sichere Zahlung via Stripe. Weitere Projektkosten werden individuell besprochen.
            </p>
        </div>
    </main>

</body>

</html>