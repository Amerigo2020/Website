<?php
/**
 * Shared security and performance headers.
 * Include at the top of every public-facing PHP page (before any output).
 */

header_remove('X-Powered-By');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('Referrer-Policy: strict-origin-when-cross-origin');
header('Permissions-Policy: camera=(), microphone=(), geolocation=()');

$requestUri = $_SERVER['REQUEST_URI'] ?? '';
$isStaticAsset = preg_match('/\.(css|js|jpg|jpeg|png|webp|avif|svg|woff2?|ico)(\?|$)/', $requestUri);

if ($isStaticAsset) {
    header('Cache-Control: public, max-age=31536000, immutable');
} else {
    header('Cache-Control: public, max-age=3600, must-revalidate');
}

session_cache_limiter('none');
header('Vary: Accept-Encoding');
