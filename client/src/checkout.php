<?php
/**
 * Velletti Consulting - Stripe Checkout
 */
session_start();
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

// Config
$config = [
    'site_title' => 'Velletti Consulting | Subscription Checkout',
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
    <!-- Stripe.js -->
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        .checkout-box {
            max-width: 450px;
            margin: var(--spacing-2xl) auto;
            background: var(--color-white);
            padding: var(--spacing-xl);
            border-radius: 12px;
            box-shadow: var(--shadow-lg);
            text-align: center;
            border: 1px solid rgba(16, 37, 66, 0.1);
        }

        :root[data-theme='dark'] .checkout-box {
            background: #0f172a;
            border-color: rgba(255, 255, 255, 0.1);
        }

        .price {
            font-size: 3rem;
            font-weight: 800;
            color: var(--color-primary);
            margin: var(--spacing-md) 0;
        }

        .price span {
            font-size: 1.2rem;
            color: var(--color-text-secondary);
        }

        .features {
            text-align: left;
            margin-bottom: var(--spacing-lg);
            list-style: none;
        }

        .features li {
            margin-bottom: var(--spacing-xs);
            padding-left: 24px;
            position: relative;
        }

        .features li::before {
            content: "✓";
            color: var(--color-success);
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
            <h2>Premium Service</h2>
            <p>Sichere dir exklusiven Zugang zu unseren DevOps und AI Services.</p>

            <div class="price">
                €99<span>/Monat</span>
            </div>

            <ul class="features">
                <li>Persönlicher Ansprechpartner</li>
                <li>Prio-Support via Slack</li>
                <li>Monatliches Architektur-Review</li>
                <li>KI-Automatisierungs-Konzepte</li>
            </ul>

            <form action="create-checkout-session.php" method="POST">
                <!-- Add a hidden input if you want to pass dynamic price IDs, 
                     but for security it's better to hardcode the price ID in the backend -->
                <button type="submit" class="cta-button" style="width: 100%;">
                    Jetzt abonnieren
                </button>
            </form>
            <p style="margin-top: var(--spacing-sm); font-size: 0.85rem; opacity: 0.7;">
                Sichere Zahlung via Stripe. Jederzeit kündbar.
            </p>
        </div>
    </main>

</body>

</html>