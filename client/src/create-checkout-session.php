<?php
/**
 * Velletti Consulting - Create Checkout Session
 */
session_start();
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "Method Not Allowed";
    exit;
}

$stripeSecretKey = $_ENV['STRIPE_SECRET_KEY'] ?? null;
$priceId = $_ENV['STRIPE_PRICE_ID'] ?? null;
$domain = $_ENV['DOMAIN'] ?? 'http://localhost:8000';

if (!$stripeSecretKey || !$priceId) {
    http_response_code(500);
    echo "Server configuration error (missing environment variables).";
    exit;
}

\Stripe\Stripe::setApiKey($stripeSecretKey);

try {
    $checkout_session = \Stripe\Checkout\Session::create([
        'line_items' => [
            [
                'price' => $priceId,
                'quantity' => 1,
            ]
        ],
        'mode' => 'subscription',
        'success_url' => $domain . '/success.php?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => $domain . '/cancel.php',
    ]);

    header("HTTP/1.1 303 See Other");
    header("Location: " . $checkout_session->url);
} catch (Exception $e) {
    http_response_code(500);
    echo "An error occurred during checkout setup: " . htmlspecialchars($e->getMessage());
}
