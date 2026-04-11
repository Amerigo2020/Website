# AGENTS.md

## Cursor Cloud specific instructions

### Overview

This is a PHP-based corporate website for **Velletti Consulting** (Munich). It is a single-product codebase with no build step, no Node.js, and no database. The frontend is vanilla HTML5/CSS3/JS served through PHP.

### Prerequisites

- **PHP 8.0+** (runtime + CLI built-in server)
- **Composer** (to install `stripe/stripe-php` and `vlucas/phpdotenv`)

### Running the dev server

```bash
composer install          # install PHP dependencies (idempotent)
php -S localhost:8000 -t client/src   # start the built-in dev server
```

The site is then accessible at `http://localhost:8000`.

### Key caveats

- **No linter or automated test suite** exists in this project. There is no `phpunit`, `phpcs`, or similar tooling configured.
- **Stripe integration** (`checkout.php`, `create-checkout-session.php`, `webhook.php`, `success.php`, `cancel.php`) requires `STRIPE_SECRET_KEY`, `STRIPE_PRICE_ID`, and `STRIPE_WEBHOOK_SECRET` environment variables in `client/.env`. The landing page and contact form work without Stripe keys.
- **Contact form** (`contact.php`) simulates email delivery on localhost (logs to `error_log` instead of sending). CSRF tokens are session-based; test submissions require first loading the page to get a valid token.
- The `.env.example` at the repo root is for Taskmaster (AI task management tool), not for the website itself.
- **JS syntax error**: The `index.php` has a minor pre-existing issue where a `<script>` tag is nested inside another `<script>` block (around line 1982), causing the dark mode toggle to break. This is a known issue in the codebase.
