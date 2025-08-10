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
    echo "<!DOCTYPE html><html lang=\"en\"><head><meta charset=\"utf-8\"><meta name=\"viewport\" content=\"width=device-width, initial-scale=1\"><title>" . htmlspecialchars($title) . "</title><style>body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen,Ubuntu,Cantarell,sans-serif;line-height:1.6;padding:2rem;background:#f7f7ff;color:#23272f} .card{max-width:640px;margin:2rem auto;background:#fff;padding:1.5rem;border-radius:12px;border:1px solid rgba(16,37,66,.12)} a.btn{display:inline-block;margin-top:1rem;padding:.5rem 1rem;border-radius:8px;background:#F87060;color:#fff;text-decoration:none} a.btn:hover{background:#102542}</style></head><body><div class=\"card\"><h1>" . htmlspecialchars($title) . "</h1><p>" . htmlspecialchars($message) . "</p><p><a class=\"btn\" href=\"/index.php#contact\">Back</a></p></div></body></html>";
    exit;
}

function sanitize($v): string { return htmlspecialchars(trim((string)$v), ENT_QUOTES, 'UTF-8'); }
function validate_email($e): bool { return filter_var($e, FILTER_VALIDATE_EMAIL) !== false; }
function validate_phone($p): bool { return $p === '' || preg_match('/^[\+]?[-0-9\s()]{10,}$/', $p) === 1; }

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

// Optionally send email (uncomment and configure if mail() is available)
$sendTo = 'amerigo@velletti.de';
$subject = 'Website Contact — ' . $name;
$body = "Name: $name\nEmail: $email\nPhone: $phone\nIP: $ip\n\n$message\n";
$headers = 'From: noreply@' . ($_SERVER['SERVER_NAME'] ?? 'localhost') . "\r\nReply-To: $email\r\nX-Mailer: PHP/" . phpversion();
//$sent = mail($sendTo, $subject, $body, $headers);

// Update rate limit
$_SESSION[$key] = ['count' => $rate['count'] + 1, 'last_submit' => $now];
// Regenerate CSRF token for next submission
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

if (is_ajax_request()) {
    json_response(['success' => true, 'message' => 'Thank you! Your message has been sent.']);
}

html_response('Thank you', 'Your message has been sent successfully.');
