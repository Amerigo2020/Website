<?php
// Simple contact form handler
// - Validates input
// - CSRF + honeypot + rate limit
// - Returns JSON for AJAX; HTML fallback otherwise

session_start();

header_remove('X-Powered-By');

function is_ajax_request(): bool {
    $rh = getallheaders();
    $xrw = $rh['X-Requested-With'] ?? $rh['x-requested-with'] ?? '';
    return strtolower($xrw) === 'xmlhttprequest' || strtolower($xrw) === 'fetch';
}

function json_response(array $payload, int $status = 200): void {
    http_response_code($status);
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode($payload);
    exit;
}

function html_response(string $title, string $message, int $status = 200): void {
    http_response_code($status);
    header('Content-Type: text/html; charset=UTF-8');
    $cssVersion = @filemtime(__DIR__ . '/assets/css/app.css') ?: time();
    echo "<!DOCTYPE html><html lang=\"de\"><head><meta charset=\"utf-8\"><meta name=\"viewport\" content=\"width=device-width, initial-scale=1\"><title>" . htmlspecialchars($title) . "</title><link rel=\"icon\" type=\"image/svg+xml\" href=\"assets/favicon.svg\"><link rel=\"stylesheet\" href=\"assets/css/app.css?v=" . $cssVersion . "\"></head><body><div class=\"card\"><h1>" . htmlspecialchars($title) . "</h1><p>" . htmlspecialchars($message) . "</p><p><a class=\"btn\" href=\"/index.php#contact\">Zurück</a></p></div></body></html>";
    exit;
}

function sanitize($v): string { return htmlspecialchars(trim((string)$v), ENT_QUOTES, 'UTF-8'); }
function validate_email($e): bool { return filter_var($e, FILTER_VALIDATE_EMAIL) !== false; }
function validate_phone($p): bool { return $p === '' || preg_match('/^[\+]?[-0-9\s()]{10,}$/', $p) === 1; }

// Capture warnings from mail() so they don't output before headers
function send_mail_safely(string $to, string $subject, string $body, string $headers): array {
    $warning = null;
    $prev = set_error_handler(function ($errno, $errstr) use (&$warning) {
        // store and suppress warning output
        $warning = $errstr;
        return true;
    });
    $ok = mail($to, $subject, $body, $headers);
    if ($prev !== null) {
        set_error_handler($prev);
    } else {
        restore_error_handler();
    }
    return [$ok, $warning];
}

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
if ($method !== 'POST') {
    if (is_ajax_request()) json_response(['success' => false, 'message' => 'Method not allowed'], 405);
    html_response('Method Not Allowed', 'Please submit the form using POST.', 405);
}

// Rate limit per IP via session
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$key = 'contact_form_' . $ip;
if (!isset($_SESSION[$key])) {
    $_SESSION[$key] = ['count' => 0, 'last_submit' => 0];
}
$rate = $_SESSION[$key];
$now  = time();
if ($now - $rate['last_submit'] < 60 && $rate['count'] >= 3) {
    $msg = 'Too many submissions. Please wait a minute and try again.';
    if (is_ajax_request()) json_response(['success' => false, 'message' => $msg], 429);
    html_response('Slow Down', $msg, 429);
}

// CSRF
$csrf = $_POST['csrf_token'] ?? '';
if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $csrf)) {
    $msg = 'Security validation failed. Please reload the page and try again.';
    if (is_ajax_request()) json_response(['success' => false, 'message' => $msg], 400);
    html_response('Security Check Failed', $msg, 400);
}

// Honeypot
if (!empty($_POST['website'] ?? '')) {
    // silently succeed
    if (is_ajax_request()) json_response(['success' => true, 'message' => 'Thanks!'], 200);
    html_response('Thank you', 'Thanks for your message!', 200);
}

$name = sanitize($_POST['name'] ?? '');
$email = sanitize($_POST['email'] ?? '');
$phone = sanitize($_POST['phone'] ?? '');
$message = sanitize($_POST['message'] ?? '');

$errors = [];
if (strlen($name) < 2) $errors['name'] = 'Please enter your name (min 2 characters).';
if (!validate_email($email)) $errors['email'] = 'Please enter a valid email address.';
if (!validate_phone($phone)) $errors['phone'] = 'Please enter a valid phone number.';
if (strlen($message) < 10) $errors['message'] = 'Please enter a longer message (min 10 characters).';

if (!empty($errors)) {
    $msg = 'Please correct the highlighted fields and try again.';
    if (is_ajax_request()) json_response(['success' => false, 'message' => $msg, 'errors' => $errors], 422);
    html_response('Form Error', $msg, 422);
}

// Send email via PHP mail(); simulate success on localhost/dev to avoid warnings
$from = 'server@ame.velletti.de';
$to   = 'info@ame.velletti.de';
$nameSafe = str_replace(["\r", "\n"], '', $name);
$subject = 'Website Contact - ' . $nameSafe;
$body  = "This is a contact request from the website.\n\n";
$body .= "Form Data:\n";
$body .= "Name: $name\n";
$body .= "Email: $email\n";
$body .= "Phone: $phone\n";
$body .= "IP: $ip\n\n";
$body .= "Message:\n$message\n";

// Prevent header injection in Reply-To
$emailSafe = str_replace(["\r", "\n"], '', $email);

$headers  = "From: $from\r\n";
$headers .= "Reply-To: $emailSafe\r\n";
$headers .= 'X-Mailer: PHP/' . phpversion() . "\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
$headers .= "Content-Transfer-Encoding: 8bit\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "X-Priority: 3\r\n";

$host = $_SERVER['SERVER_NAME'] ?? '';
$isDev = (PHP_SAPI === 'cli-server') || $host === 'localhost' || $host === '127.0.0.1' || $host === '::1';

if ($isDev) {
    // Simulate success locally to avoid SMTP setup; log the message for debugging
    $sent = true;
    error_log('[DEV] Simulated email send to ' . $to . ' | subject: ' . $subject . ' | reply-to: ' . $emailSafe);
} else {
    // Real send with warning capture (prevents "headers already sent")
    $warn = null; $sent = false;
    list($sent, $warn) = send_mail_safely($to, $subject, $body, $headers);
    if (!$sent && $warn) {
        error_log('mail() warning: ' . $warn);
    }
}

if (!$sent) {
    $failMsg = 'We could not send your message at this time. Please try again later.';
    if (is_ajax_request()) json_response(['success' => false, 'message' => $failMsg], 500);
    html_response('Delivery Failed', $failMsg, 500);
}

// Update rate limit
$_SESSION[$key] = ['count' => $rate['count'] + 1, 'last_submit' => $now];
// Regenerate CSRF token for next submission and return it for AJAX clients
$newToken = bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $newToken;

if (is_ajax_request()) {
    json_response(['success' => true, 'message' => 'Thank you! Your message has been sent.', 'csrf_token' => $newToken]);
}

html_response('Thank you', 'Your message has been sent successfully.');
