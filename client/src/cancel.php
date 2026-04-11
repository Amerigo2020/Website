<?php
/**
 * Velletti Consulting - Checkout Cancelled
 */
require_once __DIR__ . '/includes/headers.php';

$config = [
    'site_title' => 'Velletti Consulting | Zahlung abgebrochen',
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
            <div class="icon">ℹ️</div>
            <h2>Zahlungsvorgang abgebrochen</h2>
            <p>Du hast den Checkout-Prozess abgebrochen. Es wurde nichts berechnet.</p>
            <br>
            <a href="checkout.php" class="cta-button">Erneut versuchen</a>
        </div>
    </main>
</body>

</html>