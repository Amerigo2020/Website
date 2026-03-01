<?php
/**
 * Velletti Consulting - Stripe Webhook Handler
 */
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
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

// Handle the event
switch ($event->type) {
    case 'checkout.session.completed':
        $session = $event->data->object;
        // Optionally save to DB or send welcome email
        error_log("Checkout Session completed for customer: " . $session->customer);
        break;

    case 'invoice.paid':
        $invoice = $event->data->object;
        error_log("Invoice paid for subscription: " . $invoice->subscription);
        break;

    case 'invoice.payment_failed':
        $invoice = $event->data->object;
        error_log("Invoice payment failed for subscription: " . $invoice->subscription);
        break;

    case 'customer.subscription.deleted':
        $subscription = $event->data->object;
        error_log("Subscription deleted: " . $subscription->id);
        break;

    default:
        echo 'Received unknown event type ' . $event->type;
}

http_response_code(200);
