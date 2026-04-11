---
title: "CSRF Protection: The Attack Every Web Developer Should Understand"
description: "Cross-Site Request Forgery is one of the most common web vulnerabilities, and most AI-generated code doesn't protect against it. Here's how it works and how to fix it."
date: "2026-04-10"
author: "Amerigo Velletti"
tags: "Security, CSRF, Web Development, PHP"
---

I review a lot of code that AI assistants generate. The most common security hole I find is missing CSRF protection. The code works, the forms submit, the data saves. But any attacker can forge requests on behalf of your users, and your application will happily execute them.

## What CSRF Actually Is

Cross-Site Request Forgery tricks a user's browser into making a request to your application without the user's knowledge. The attack exploits a simple fact: browsers automatically attach cookies (including session cookies) to every request sent to a domain.

Here's the scenario:

1. Your user is logged into your app at `app.example.com`
2. They visit a malicious page (or a compromised ad, or a forum post)
3. That page contains a hidden form that submits to `app.example.com/delete-account`
4. The browser sends the request with the user's session cookie attached
5. Your server sees a valid session and executes the action

The user never clicked anything on your site. They never intended to delete their account. But your server can't tell the difference between a legitimate request and a forged one.

## Why AI-Generated Code Gets This Wrong

When you ask an AI to "build a contact form with PHP," it generates a form with `method="POST"` and a handler that reads `$_POST` values. It works. But there's no CSRF token, because the AI optimizes for functionality, not security.

The same applies to frameworks. If you vibecode a Laravel controller, the AI usually remembers `@csrf` in Blade templates. But in vanilla PHP, Express.js, or any setup without a framework handling it automatically? It's missing almost every time.

## How CSRF Tokens Work

The fix is straightforward. Before rendering a form, generate a random token and store it in the user's session. Include that token as a hidden field in the form. When the form submits, compare the submitted token against the session token.

An attacker can't forge this token because they don't have access to the user's session. They can make the browser send cookies, but they can't read them or generate values that match them.

### PHP Implementation

```php
// Start session and generate token
session_start();
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// In your form
echo '<input type="hidden" name="csrf_token" value="' . 
     htmlspecialchars($_SESSION['csrf_token']) . '">';

// When processing the form
if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
    http_response_code(403);
    die('Invalid request.');
}
```

Key details:

- **Use `random_bytes()`**, not `rand()` or `mt_rand()`. Cryptographically secure randomness matters here.
- **Use `hash_equals()`** for comparison, not `===`. This prevents timing attacks where an attacker can guess the token one character at a time by measuring response times.
- **Regenerate the token** after successful form submission to prevent replay attacks.

## Beyond Tokens: SameSite Cookies

Modern browsers support the `SameSite` cookie attribute, which provides a second layer of defense:

```php
setcookie('session_id', $value, [
    'samesite' => 'Strict',
    'secure' => true,
    'httponly' => true,
]);
```

`SameSite=Strict` tells the browser to never send this cookie on cross-site requests. This blocks CSRF at the browser level. But don't rely on it alone: older browsers don't support it, and `Strict` can break legitimate flows like OAuth redirects.

`SameSite=Lax` is a middle ground: it allows cookies on top-level navigations (clicking a link) but blocks them on form submissions and AJAX requests from other sites. Most applications should use `Lax` as a minimum.

## AJAX and API Endpoints

For API endpoints that accept JSON, CSRF is less of a risk because browsers enforce CORS. A cross-origin `fetch()` with `Content-Type: application/json` triggers a preflight request, and your server can reject it.

But if your API accepts `application/x-www-form-urlencoded` or `multipart/form-data`, it's vulnerable. These content types don't trigger preflight checks.

The safest approach for APIs: require a custom header (like `X-Requested-With: fetch`) that only JavaScript from your own origin can set.

## The Checklist

Every form and state-changing endpoint in your application should have:

1. A CSRF token in the form, validated on the server
2. `SameSite=Lax` or `SameSite=Strict` on session cookies
3. `Secure` and `HttpOnly` flags on session cookies
4. Custom header validation for AJAX endpoints

This takes 20 minutes to implement correctly. Skipping it means any website on the internet can perform actions as your users. That's not a theoretical risk. It's one of the OWASP Top 10 for a reason.

---

**Weitere Artikel:** [CI/CD for Small Teams: Ship Without Fear in Under a Day](/blog/post.php?slug=cicd-for-small-teams) | [Tech Stack Decisions as a Solo Founder: What Actually Matters](/blog/post.php?slug=tech-stack-decisions-solo-founder)
