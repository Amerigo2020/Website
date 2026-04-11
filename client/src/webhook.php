<?php
/**
 * Velletti Consulting - Stripe Webhook Handler
 */
require_once __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->safeLoad();

// The library needs to be configured with your account's secret key.
// Ensure the key is kept out of any version control system you might be using.
\Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

// You can find your endpoint's secret in your webhook settings
$endpoint_secret = $_ENV['STRIPE_WEBHOOK_SECRET'];

$payload = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? '';
$event = null;

try {
    $event = \Stripe\Webhook::constructEvent(
        $payload,
        $sig_header,
        $endpoint_secret
    );
} catch (\UnexpectedValueException $e) {
    // Invalid payload
    http_response_code(400);
    exit();
} catch (\Stripe\Exception\SignatureVerificationException $e) {
    // Invalid signature
    http_response_code(400);
    exit();
}

// Handle the event (one-time payment for consultation booking)
switch ($event->type) {
    case 'checkout.session.completed':
        $session = $event->data->object;
        error_log("Consultation booked: " . ($session->customer_email ?? $session->customer));
        break;

    case 'payment_intent.succeeded':
        $intent = $event->data->object;
        error_log("Payment received: " . $intent->id . " (" . $intent->amount . " " . $intent->currency . ")");
        break;

    case 'payment_intent.payment_failed':
        $intent = $event->data->object;
        error_log("Payment failed: " . $intent->id);
        break;

    default:
        echo 'Received unknown event type ' . $event->type;
}

http_response_code(200);
