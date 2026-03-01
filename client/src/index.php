<?php
/**
 * Velletti Consulting Landing Page
 * Pure PHP implementation with responsive design and security features
 * 
 * @author Generated for Velletti Consulting
 * @version 1.0.0
 * @date 2025-07-07
 */

// Start session for CSRF protection
session_start();

// Generate CSRF token if not exists
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Configuration
$config = [
    'site_title' => 'Velletti Consulting | AI, Automatisierung, Websites & Hosting',
    'meta_description' => 'Velletti Consulting in München – AI (Künstliche Intelligenz), Automatisierung, Aufbau und Hosting moderner Websites. Beratung, Entwicklung und Betrieb.',
    'meta_keywords' => 'Velletti Consulting, AI, Künstliche Intelligenz, Automatisierung, Webentwicklung, Webseiten, Website Hosting, DevOps, München, Beratung',
    'company_name' => 'Velletti Consulting',
    'company_email' => 'vel-consulting@ame.velletti.de',
    'company_phone' => '+49 176 45531533',
    'company_address' => 'Munich, Bavaria, Germany'
];

// Cache-busting for CSS
$cssVersion = @filemtime(__DIR__ . '/assets/css/app.css') ?: time();

// Canonical URL (home)
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost:8000';
$canonical = $scheme . '://' . $host . '/';

// Form processing
$form_errors = [];
$form_success = false;
$form_data = [
    'name' => '',
    'email' => '',
    'phone' => '',
    'message' => ''
];

// Simple rate limiting
$rate_limit_key = 'contact_form_' . $_SERVER['REMOTE_ADDR'];
if (!isset($_SESSION[$rate_limit_key])) {
    $_SESSION[$rate_limit_key] = ['count' => 0, 'last_submit' => 0];
}

/**
 * Sanitize input data
 */
function sanitize_input($data)
{
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

/**
 * Validate email format
 */
function validate_email($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Validate phone format (basic)
 */
function validate_phone($phone)
{
    return preg_match('/^[\+]?[0-9\s\-\(\)]{10,}$/', $phone);
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_form'])) {
    // Rate limiting check
    $current_time = time();
    $rate_data = $_SESSION[$rate_limit_key];

    if ($current_time - $rate_data['last_submit'] < 60 && $rate_data['count'] >= 3) {
        $form_errors['rate_limit'] = 'Too many submissions. Please wait before trying again.';
    } else {
        // CSRF protection
        if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            $form_errors['csrf'] = 'Security validation failed. Please try again.';
        } else {
            // Honeypot check
            if (!empty($_POST['website'])) {
                // Silent fail - likely spam
                $form_success = true;
            } else {
                // Validate and sanitize inputs
                $form_data['name'] = sanitize_input($_POST['name'] ?? '');
                $form_data['email'] = sanitize_input($_POST['email'] ?? '');
                $form_data['phone'] = sanitize_input($_POST['phone'] ?? '');
                $form_data['message'] = sanitize_input($_POST['message'] ?? '');

                // Validation
                if (strlen($form_data['name']) < 2) {
                    $form_errors['name'] = 'Name must be at least 2 characters long.';
                }

                if (empty($form_data['email']) || !validate_email($form_data['email'])) {
                    $form_errors['email'] = 'Please enter a valid email address.';
                }

                if (!empty($form_data['phone']) && !validate_phone($form_data['phone'])) {
                    $form_errors['phone'] = 'Please enter a valid phone number.';
                }

                if (strlen($form_data['message']) < 10) {
                    $form_errors['message'] = 'Message must be at least 10 characters long.';
                }

                // If no errors, process form
                if (empty($form_errors)) {
                    // Here you would typically send email or save to database
                    // For now, we'll just show success message
                    $form_success = true;

                    // Update rate limiting
                    $_SESSION[$rate_limit_key] = [
                        'count' => $rate_data['count'] + 1,
                        'last_submit' => $current_time
                    ];

                    // Clear form data on success
                    $form_data = ['name' => '', 'email' => '', 'phone' => '', 'message' => ''];

                    // Regenerate CSRF token
                    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($config['meta_description']); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($config['meta_keywords']); ?>">
    <meta name="author" content="<?php echo htmlspecialchars($config['company_name']); ?>">
    <meta name="robots" content="index,follow">
    <meta name="google-site-verification" content="S8XgRO3zITWu2fLmLr5jS7O_vZM_sEskdm2DiaGHrzc" />

    <!-- Open Graph meta tags -->
    <meta property="og:title" content="<?php echo htmlspecialchars($config['site_title']); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($config['meta_description']); ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?php echo htmlspecialchars($config['company_name']); ?>">
    <meta property="og:locale" content="de_DE">
    <meta property="og:url" content="<?php echo htmlspecialchars($canonical); ?>">
    <meta property="og:locale:alternate" content="en_US">
    <meta property="og:image"
        content="<?php echo htmlspecialchars($scheme . '://' . $host . '/assets/portrait.jpg'); ?>">
    <meta property="og:image:alt" content="Porträt – Velletti Consulting">
    <meta name="twitter:image"
        content="<?php echo htmlspecialchars($scheme . '://' . $host . '/assets/portrait.jpg'); ?>">
    <meta name="twitter:image:alt" content="Porträt – Velletti Consulting">

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($config['site_title']); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($config['meta_description']); ?>">
    <meta name="twitter:url" content="<?php echo htmlspecialchars($canonical); ?>">

    <title><?php echo htmlspecialchars($config['site_title']); ?></title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="assets/favicon.svg">
    <link rel="canonical" href="<?php echo htmlspecialchars($canonical); ?>">
    <link rel="stylesheet" href="assets/css/app.css?v=<?php echo $cssVersion; ?>">

    <!-- Schema.org markup -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "ProfessionalService",
        "name": "<?php echo htmlspecialchars($config['company_name']); ?>",
        "description": "<?php echo htmlspecialchars($config['meta_description']); ?>",
        "email": "<?php echo htmlspecialchars($config['company_email']); ?>",
        "telephone": "<?php echo htmlspecialchars($config['company_phone']); ?>",
        "url": "<?php echo htmlspecialchars($canonical); ?>",
        "image": "<?php echo htmlspecialchars($scheme . '://' . $host . '/assets/portrait.jpg'); ?>",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "<?php echo htmlspecialchars($config['company_address']); ?>"
        },
        "areaServed": "Munich, Bavaria, Germany",
        "sameAs": [
            "https://github.com/Amerigo2020",
            "https://www.linkedin.com/in/amerigo-velletti-b888a9304"
        ],
        "knowsAbout": [
            "Artificial Intelligence",
            "AI",
            "Künstliche Intelligenz",
            "Automation",
            "Automatisierung",
            "Web Development",
            "Webseiten",
            "Web Hosting",
            "DevOps"
        ],
        "hasOfferCatalog": {
            "@type": "OfferCatalog",
            "name": "Services",
            "itemListElement": [
                {
                    "@type": "Offer",
                    "name": "AI & Automatisierung"
                },
                {
                    "@type": "Offer",
                    "name": "Websites & Hosting"
                },
                {
                    "@type": "Offer",
                    "name": "DevOps Enablement"
                }
            ]
        }
    }
    </script>

    <!-- Organization JSON-LD -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "@id": "<?php echo htmlspecialchars($canonical); ?>#organization",
      "name": "<?php echo htmlspecialchars($config['company_name']); ?>",
      "url": "<?php echo htmlspecialchars($canonical); ?>",
      "logo": {
        "@type": "ImageObject",
        "url": "<?php echo htmlspecialchars($scheme . '://' . $host . '/assets/portrait.jpg'); ?>"
      },
      "sameAs": [
        "https://github.com/Amerigo2020",
        "https://www.linkedin.com/in/amerigo-velletti-b888a9304"
      ]
    }
    </script>

    <!-- Prefers color scheme initialization (prevents FOUC) -->
    <script>
        (function () {
            try {
                const stored = localStorage.getItem('theme');
                const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                const theme = stored || (prefersDark ? 'dark' : 'light');
                document.documentElement.setAttribute('data-theme', theme);
            } catch (e) { }
        })();
    </script>
    <script async src="https://js.stripe.com/v3/buy-button.js"></script>
</head>

<body>
    <!-- Header -->
    <header class="header">
        <div class="container header__container">
            <a href="#home" class="logo" aria-label="<?php echo htmlspecialchars($config['company_name']); ?> Home">
                <?php echo htmlspecialchars($config['company_name']); ?>
            </a>

            <nav class="nav" role="navigation" aria-label="Main navigation">
                <a href="#services" class="nav__link">Services</a>
                <a href="#experience" class="nav__link">Events</a>
                <a href="#contact" class="nav__link">Contact</a>
            </nav>

            <div class="header__actions">
                <div class="social-buttons">
                    <a id="btnLinkedIn" class="social-btn" href="https://www.linkedin.com/in/amerigo-velletti-b888a9304"
                        target="_blank" rel="noopener" aria-label="Open LinkedIn profile (opens in new tab)"
                        data-modal-target="#linkedinModal">
                        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                            <path fill="currentColor"
                                d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14zm-9.5 6H7v8h2.5V9zm.13-2.75a1.38 1.38 0 1 0-2.76 0 1.38 1.38 0 0 0 2.76 0zM20 13.25c0-2.52-1.35-3.7-3.16-3.7-1.46 0-2.12.8-2.49 1.37v-1.17H12v8h2.5v-4.46c0-1.17.22-2.3 1.67-2.3 1.43 0 1.45 1.33 1.45 2.37V17H20v-3.75z" />
                        </svg>
                    </a>
                    <a id="btnGitHub" class="social-btn" href="https://github.com/Amerigo2020" target="_blank"
                        rel="noopener" aria-label="Open GitHub profile (opens in new tab)"
                        data-modal-target="#githubModal">
                        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                            <path fill="currentColor"
                                d="M12 .5A11.5 11.5 0 0 0 .5 12.3c0 5.23 3.4 9.66 8.12 11.23.59.12.8-.26.8-.58v-2.2c-3.3.73-3.99-1.43-3.99-1.43-.54-1.38-1.33-1.75-1.33-1.75-1.09-.74.08-.72.08-.72 1.2.09 1.84 1.27 1.84 1.27 1.07 1.86 2.8 1.32 3.48 1.01.11-.8.42-1.32.76-1.62-2.64-.31-5.42-1.36-5.42-6.06 0-1.34.47-2.43 1.24-3.28-.12-.3-.54-1.54.12-3.21 0 0 1.01-.33 3.3 1.25a11.1 11.1 0 0 1 6 0c2.28-1.58 3.29-1.25 3.29-1.25.67 1.67.25 2.9.13 3.21.77.85 1.24 1.94 1.24 3.28 0 4.71-2.79 5.75-5.45 6.05.43.37.81 1.1.81 2.22v3.29c0 .32.21.71.81.58A11.52 11.52 0 0 0 23.5 12.3 11.5 11.5 0 0 0 12 .5z" />
                        </svg>
                    </a>
                </div>
                <button id="themeToggle" class="theme-toggle" aria-label="Toggle dark mode" aria-pressed="false">
                    <svg id="iconSun" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill="currentColor"
                            d="M6.76 4.84l-1.8-1.79-1.41 1.41 1.79 1.8 1.42-1.42zM1 13h3v-2H1v2zm10 10h2v-3h-2v3zm7.04-19.95l1.79-1.79 1.41 1.41-1.79 1.79-1.41-1.41zM20 11v2h3v-2h-3zM4.96 19.95l-1.79 1.79 1.41 1.41 1.79-1.79-1.41-1.41zM17 20.24l1.8 1.79 1.41-1.41-1.79-1.8-1.42 1.42zM12 6a6 6 0 100 12 6 6 0 000-12z" />
                    </svg>
                </button>
            </div>

            <button class="mobile-menu-toggle" onclick="toggleMobileMenu()" aria-label="Toggle mobile menu"
                aria-expanded="false">
                ☰
            </button>

            <div class="mobile-menu" id="mobileMenu">
                <nav class="nav" role="navigation" aria-label="Mobile navigation">
                    <a href="#services" class="nav__link" onclick="closeMobileMenu()">Services</a>
                    <a href="#experience" class="nav__link" onclick="closeMobileMenu()">Events</a>
                    <a href="#contact" class="nav__link" onclick="closeMobileMenu()">Contact</a>
                </nav>
            </div>
        </div>
    </header>

    <main>
        <!-- Hero Section -->
        <section id="home" class="section section--hero">
            <canvas id="hero-canvas"></canvas>
            <div class="container hero-container-inner">
                <div class="hero__content">
                    <h1 class="hero__title">Software. KI. Automatisierung.</h1>
                    <p class="hero__subtitle">
                        Wir entwickeln zukunftssichere digitale Lösungen für Ihr Unternehmen.
                        <br>Von der ersten Idee bis zum Betrieb maßgeschneiderter Systeme.
                    </p>
                    <div style="display: flex; gap: var(--spacing-sm); justify-content: center; flex-wrap: wrap;">
                        <a href="#contact" class="cta-button" role="button">Projektanfrage starten</a>
                        <a href="#services" class="cta-button cta-button--outline" role="button">Unsere Leistungen</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section id="services" class="section services">
            <div class="container">
                <h2>Leistungen</h2>
                <p>Beratung, Entwicklung und Betrieb – klar fokussiert auf AI, Automatisierung sowie moderne Websites &
                    Hosting.</p>

                <div class="services__grid">
                    <div class="service-card" tabindex="0">
                        <div class="service-icon" aria-hidden="true">🤖</div>
                        <h3>AI & Automatisierung</h3>
                        <p>
                            Von Proof-of-Concept bis Produktion: KI-gestützte Workflows, Automatisierung von Prozessen,
                            Integrationen und agentische Systeme zur Effizienzsteigerung.
                        </p>
                    </div>

                    <div class="service-card" tabindex="0">
                        <div class="service-icon" aria-hidden="true">🌐</div>
                        <h3>Websites & Hosting</h3>
                        <p>
                            Moderne Unternehmens-Websites: Performance, SEO, Barrierefreiheit – inkl. Hosting, Domain,
                            Deployment und Monitoring für einen stabilen Betrieb.
                        </p>
                    </div>

                    <div class="service-card" tabindex="0">
                        <div class="service-icon" aria-hidden="true">⚙️</div>
                        <h3>DevOps Enablement</h3>
                        <p>
                            Build-/Release-Pipelines, Infrastruktur als Code, Observability und Automatisierung –
                            damit Teams schneller und sicherer liefern.
                        </p>
                    </div>
                </div>

                <div
                    style="display: flex; gap: var(--spacing-sm); justify-content: center; margin-top: var(--spacing-xl);">
                    <stripe-buy-button buy-button-id="buy_btn_1T3floGp8U9WNcTwB18bEreC"
                        publishable-key="pk_live_51SfJ7WGp8U9WNcTwCBs0VztMWzn1vAY8wi7LVVGOWUz7riLbxLHv0hqfFgqFWxbwqp87ctg1pBCvFOYlGYsorUVU00qcw1TIXV">
                    </stripe-buy-button>
                </div>
            </div>
        </section>

        <!-- Experience / Events Section -->
        <section id="experience" class="section experience">
            <div class="container">
                <h2>Auszeichnungen & Expertise</h2>
                <p>Unsere Erfahrung aus branchenübergreifenden Projekten, Hackathons und Auszeichnungen.</p>

                <!-- Contact & Location Card -->
                <div class="cards-grid" style="margin-bottom: var(--spacing-md);">
                    <a id="btnLinkedIn2" class="profile-card"
                        href="https://www.linkedin.com/in/amerigo-velletti-b888a9304" target="_blank" rel="noopener"
                        aria-label="Open LinkedIn profile (opens in new tab)">
                        <div class="profile-card__header">
                            <svg class="profile-card__icon" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill="currentColor"
                                    d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14zm-9.5 6H7v8h2.5V9zm.13-2.75a1.38 1.38 0 1 0-2.76 0 1.38 1.38 0 0 0 2.76 0zM20 13.25c0-2.52-1.35-3.7-3.16-3.7-1.46 0-2.12.8-2.49 1.37v-1.17H12v8h2.5v-4.46c0-1.17.22-2.3 1.67-2.3 1.43 0 1.45 1.33 1.45 2.37V17H20v-3.75z" />
                            </svg>
                            <div>
                                <strong>LinkedIn</strong>
                                <p class="small">linkedin.com/in/amerigo-velletti-b888a9304</p>
                            </div>
                        </div>
                        <span class="chip">Profile</span>
                    </a>
                    <a id="btnGitHub2" class="profile-card" href="https://github.com/Amerigo2020" target="_blank"
                        rel="noopener" aria-label="Open GitHub profile (opens in new tab)">
                        <div class="profile-card__header">
                            <svg class="profile-card__icon" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill="currentColor"
                                    d="M12 .5A11.5 11.5 0 0 0 .5 12.3c0 5.23 3.4 9.66 8.12 11.23.59.12.8-.26.8-.58v-2.2c-3.3.73-3.99-1.43-3.99-1.43-.54-1.38-1.33-1.75-1.33-1.75-1.09-.74.08-.72.08-.72 1.2.09 1.84 1.27 1.84 1.27 1.07 1.86 2.8 1.32 3.48 1.01.11-.8.42-1.32.76-1.62-2.64-.31-5.42-1.36-5.42-6.06 0-1.34.47-2.43 1.24-3.28-.12-.3-.54-1.54.12-3.21 0 0 1.01-.33 3.3 1.25a11.1 11.1  0 0 1 6 0c2.28-1.58 3.29-1.25 3.29-1.25.67 1.67.25 2.9.13 3.21.77.85 1.24 1.94 1.24 3.28 0 4.71-2.79 5.75-5.45 6.05.43.37.81 1.1.81 2.22v3.29c0 .32.21.71.81.58A11.52 11.52 0 0 0 23.5 12.3 11.5 11.5 0 0 0 12 .5z" />
                            </svg>
                            <div>
                                <strong>GitHub</strong>
                                <p class="small">github.com/Amerigo2020</p>
                            </div>
                        </div>
                        <span class="chip">Repos</span>
                    </a>
                </div>

                <div class="cards-grid">
                    <div class="event-card">
                        <div class="title">Blaise Pascal Quantum Challenge</div>
                        <div class="meta">
                            <span class="chip">Top 10</span>
                            <span class="chip">2025</span>
                        </div>
                    </div>
                    <div class="event-card">
                        <div class="title">Scenario Factory 2.0</div>
                        <div class="meta">
                            <span class="chip">Grade 1.0</span>
                            <span class="chip">2025</span>
                        </div>
                    </div>
                    <div class="event-card">
                        <div class="title">EuroTeQ Collider Challenge</div>
                        <div class="meta">
                            <span class="chip">Top 10</span>
                            <span class="chip">2025</span>
                        </div>
                    </div>
                    <div class="event-card">
                        <div class="title">Helmut Schmidt Zukunftsfestival</div>
                        <div class="meta">
                            <span class="chip">Participant</span>
                            <span class="chip">2025</span>
                        </div>
                    </div>
                    <div class="event-card">
                        <div class="title">UnternehmerTUM Innovationsprint</div>
                        <div class="meta">
                            <span class="chip">Participant</span>
                            <span class="chip">2025</span>
                        </div>
                    </div>
                    <div class="event-card">
                        <div class="title">MSG Hackathon — Code & Create</div>
                        <div class="meta">
                            <span class="chip">Top 3</span>
                            <span class="chip">2025</span>
                        </div>
                    </div>
                    <div class="event-card">
                        <div class="title">YFN EU Hackathon</div>
                        <div class="meta">
                            <span class="chip">Top 10</span>
                            <span class="chip">2025</span>
                        </div>
                    </div>
                    <div class="event-card">
                        <div class="title">Vibecoding Hackathon — Windsurf & Aparavi</div>
                        <div class="meta">
                            <span class="chip">Participant</span>
                            <span class="chip">2025</span>
                        </div>
                    </div>
                    <div class="event-card">
                        <div class="title">Founder Speedrun Hackathon — Google Cloud</div>
                        <div class="meta">
                            <span class="chip">Participant</span>
                            <span class="chip">2025</span>
                        </div>
                    </div>
                    <div class="event-card">
                        <div class="title">Hack Nation Global AI Hackathon</div>
                        <div class="meta">
                            <span class="chip">Round 4</span>
                            <span class="chip">MIT Sloan AI Club</span>
                        </div>
                    </div>
                    <div class="event-card">
                        <div class="title">Co-Organizer — LeRobot Hackathon Munich</div>
                        <div class="meta">
                            <span class="chip">Organizer</span>
                            <span class="chip">2025</span>
                        </div>
                    </div>
                    <div class="event-card">
                        <div class="title">Enactus Germany NC</div>
                        <div class="meta">
                            <span class="chip">Innovation Winner</span>
                            <span class="chip">2025</span>
                        </div>
                    </div>
                    <div class="event-card">
                        <div class="title">Hack the Case | Celonis | Lovable</div>
                        <div class="meta">
                            <span class="chip">Top 2</span>
                            <span class="chip">Academy Consult</span>
                        </div>
                    </div>
                    <div class="event-card">
                        <div class="title">Enactus Germany Worldcup</div>
                        <div class="meta">
                            <span class="chip">Winner</span>
                            <span class="chip">Bangkok 2025</span>
                        </div>
                    </div>
                </div>

                <h3 style="margin-top: var(--spacing-lg); margin-bottom: var(--spacing-md);">Akademischer Hintergrund
                </h3>
                <div class="cards-grid">
                    <div class="event-card">
                        <div class="title">Technische Universität Munich (TUM)</div>
                        <div class="meta">
                            <span class="chip">B.Sc. Information Systems</span>
                        </div>
                        <p class="small">Semester 7 • Until March 2026</p>
                    </div>
                    <div class="event-card">
                        <div class="title">Gymnasium Fürstenried West</div>
                        <div class="meta">
                            <span class="chip">Abitur</span>
                        </div>
                        <p class="small">Until Jul 2022</p>
                    </div>
                </div>

                <h3 style="margin-top: var(--spacing-lg); margin-bottom: var(--spacing-md);">Agentur- &
                    Industrieerfahrung
                </h3>
                <div class="cards-grid">
                    <div class="event-card">
                        <div class="title">EY</div>
                        <div class="meta">
                            <span class="chip">Transfer Pricing</span>
                        </div>
                        <p class="small">Intern → Working Student • March 2025 – Today</p>
                    </div>
                    <div class="event-card">
                        <div class="title">Bavaria LB</div>
                        <div class="meta">
                            <span class="chip">IT Service Desk</span>
                        </div>
                        <p class="small">Working Student • Feb 2024 – Dec 2024</p>
                    </div>
                    <div class="event-card">
                        <div class="title">Jörg Velletti EDV Service</div>
                        <div class="meta">
                            <span class="chip">EDV-Service</span>
                        </div>
                        <p class="small">Temporary Assistant • Jan 2020 – Feb 2024</p>
                    </div>
                </div>

                <h3 style="margin-top: var(--spacing-lg); margin-bottom: var(--spacing-md);">Netzwerk & Mitgliedschaften
                </h3>
                <div class="cards-grid">
                    <div class="event-card">
                        <div class="title">TUM EuroTeQ</div>
                        <div class="meta">
                            <span class="chip">Ambassador</span>
                        </div>
                        <p class="small">Aug 2025 – Today</p>
                    </div>
                    <div class="event-card">
                        <div class="title">MingaMentor</div>
                        <div class="meta">
                            <span class="chip">Ambassador</span>
                        </div>
                        <p class="small">Aug 2025 – Today</p>
                    </div>
                    <div class="event-card">
                        <div class="title">Enactus Munich</div>
                        <div class="meta">
                            <span class="chip">Finance & Relations Teamlead</span>
                        </div>
                        <p class="small">Oct 2024 – Today</p>
                    </div>
                    <div class="event-card">
                        <div class="title">Evolve — Early-stage Startup</div>
                        <div class="meta">
                            <span class="chip">Business Dev, Tech & Robotics</span>
                        </div>
                        <p class="small">March 2025 – Today</p>
                    </div>
                    <div class="event-card">
                        <div class="title">Active Member: AIM, FFI, YFN Munich</div>
                        <div class="meta">
                            <span class="chip">Networking & Innovation</span>
                        </div>
                        <p class="small">Sep 2024 – Today</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="section contact">
            <div class="container">
                <h2>Projektanfrage starten</h2>
                <p>Bereit für das nächste Projekt? Schreiben Sie uns und wir melden uns zeitnah bei Ihnen.</p>

                <div id="contactResponse" class="form-success" style="display:none"></div>

                <form id="contactForm" class="contact-form" method="POST" action="contact.php" novalidate>
                    <div class="form-group">
                        <label for="name" class="form-label">Name *</label>
                        <input type="text" id="name" name="name" class="form-input" required autocomplete="name">
                        <div class="form-error visually-hidden" id="name-error"></div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" id="email" name="email" class="form-input" required autocomplete="email">
                        <div class="form-error visually-hidden" id="email-error"></div>
                    </div>

                    <div class="form-group">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="tel" id="phone" name="phone" class="form-input" autocomplete="tel">
                        <div class="form-error visually-hidden" id="phone-error"></div>
                    </div>

                    <div class="form-group">
                        <label for="message" class="form-label">Message *</label>
                        <textarea id="message" name="message" class="form-textarea" required
                            placeholder="How can I help?"></textarea>
                        <div class="form-error visually-hidden" id="message-error"></div>
                    </div>

                    <!-- Honeypot -->
                    <div class="honeypot">
                        <label for="website">Website (leave blank)</label>
                        <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                    </div>

                    <input type="hidden" name="csrf_token"
                        value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                    <button type="submit" class="form-submit">Send Message</button>
                </form>
            </div>
        </section>

        <!-- Legal: Impressum (Germany) -->
        <section id="impressum" class="section legal">
            <div class="container">
                <h2>Impressum</h2>
                <p>Dienstanbieter gemäß § 5 TMG</p>
                <p>
                    <strong><?php echo htmlspecialchars($config['company_name']); ?></strong><br>
                    <?php echo htmlspecialchars($config['company_address']); ?><br>
                    Telefon: <a
                        href="tel:<?php echo htmlspecialchars($config['company_phone']); ?>"><?php echo htmlspecialchars($config['company_phone']); ?></a><br>
                    E-Mail: <a
                        href="mailto:<?php echo htmlspecialchars($config['company_email']); ?>"><?php echo htmlspecialchars($config['company_email']); ?></a>
                </p>
                <h3>Haftung für Inhalte</h3>
                <p>Als Diensteanbieter sind wir gemäß § 7 Abs. 1 TMG für eigene Inhalte auf diesen Seiten nach den
                    allgemeinen Gesetzen verantwortlich. Nach §§ 8 bis 10 TMG sind wir jedoch nicht verpflichtet,
                    übermittelte oder gespeicherte fremde Informationen zu überwachen oder nach Umständen zu forschen,
                    die auf eine rechtswidrige Tätigkeit hinweisen.</p>
                <h3>Haftung für Links</h3>
                <p>Unser Angebot enthält Links zu externen Websites Dritter, auf deren Inhalte wir keinen Einfluss
                    haben. Für diese fremden Inhalte übernehmen wir keine Gewähr. Für die Inhalte der verlinkten Seiten
                    ist stets der jeweilige Anbieter oder Betreiber verantwortlich.</p>
                <h3>Urheberrecht</h3>
                <p>Die durch die Seitenbetreiber erstellten Inhalte und Werke auf diesen Seiten unterliegen dem
                    deutschen Urheberrecht. Vervielfältigung, Bearbeitung, Verbreitung und jede Art der Verwertung
                    außerhalb der Grenzen des Urheberrechts bedürfen der schriftlichen Zustimmung des jeweiligen Autors
                    bzw. Erstellers.</p>
            </div>
        </section>

        <!-- Legal: Datenschutz (Privacy Policy) -->
        <section id="privacy" class="section legal">
            <div class="container">
                <h2>Datenschutzerklärung</h2>
                <p>Verantwortlicher im Sinne der DSGVO:</p>
                <p>
                    <strong><?php echo htmlspecialchars($config['company_name']); ?></strong><br>
                    <?php echo htmlspecialchars($config['company_address']); ?><br>
                    E-Mail: <a
                        href="mailto:<?php echo htmlspecialchars($config['company_email']); ?>"><?php echo htmlspecialchars($config['company_email']); ?></a>
                </p>
                <h3>Allgemeines</h3>
                <p>Wir verarbeiten personenbezogene Daten nur, soweit dies zur Bereitstellung einer funktionsfähigen
                    Website sowie unserer Inhalte und Leistungen erforderlich ist. Rechtsgrundlagen sind insbesondere
                    Art. 6 Abs. 1 lit. a, b und f DSGVO.</p>
                <h3>Server-Logs</h3>
                <p>Beim Aufruf dieser Website können durch den Hoster technisch notwendige Daten (z. B. IP-Adresse,
                    Zeitpunkt, abgerufene Seiten) in Logfiles verarbeitet werden. Die Speicherung erfolgt aus
                    Sicherheitsgründen und zur Sicherstellung der Funktionsfähigkeit.</p>
                <h3>Kontaktformular</h3>
                <p>Bei Nutzung des Kontaktformulars verarbeiten wir die von Ihnen eingegebenen Daten (Name, E-Mail,
                    Nachricht; optional Telefon) zur Bearbeitung Ihrer Anfrage. Rechtsgrundlage ist Art. 6 Abs. 1 lit. b
                    DSGVO. Die Daten werden nur so lange gespeichert, wie es zur Bearbeitung erforderlich ist.</p>
                <h3>Externe Dienste</h3>
                <p>Beim Öffnen der verlinkten LinkedIn- oder GitHub-Profile werden Daten an die jeweiligen Anbieter
                    übertragen. Es gelten die Datenschutzbestimmungen dieser Anbieter.</p>
                <h3>Ihre Rechte</h3>
                <p>Sie haben Rechte auf Auskunft, Berichtigung, Löschung, Einschränkung der Verarbeitung,
                    Datenübertragbarkeit sowie Widerspruch (Art. 15–21 DSGVO). Zudem besteht ein Beschwerderecht bei
                    einer Aufsichtsbehörde.</p>
                <p>Stand: <?php echo date('Y-m-d'); ?></p>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer__content">
                <div class="footer__contact">
                    <p><strong><?php echo htmlspecialchars($config['company_name']); ?></strong></p>
                    <p><?php echo htmlspecialchars($config['company_address']); ?></p>
                    <p>Phone: <a
                            href="tel:<?php echo htmlspecialchars($config['company_phone']); ?>"><?php echo htmlspecialchars($config['company_phone']); ?></a>
                    </p>
                    <p>Email: <a
                            href="mailto:<?php echo htmlspecialchars($config['company_email']); ?>"><?php echo htmlspecialchars($config['company_email']); ?></a>
                    </p>
                </div>

                <p>&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($config['company_name']); ?>. All rights
                    reserved.</p>
                <p>
                    <a href="#impressum">Impressum</a> ·
                    <a href="#privacy">Datenschutz</a>
                </p>
            </div>
        </div>
    </footer>

    <!-- LinkedIn Modal -->
    <div class="modal" id="linkedinModal" aria-hidden="true" role="dialog" aria-labelledby="linkedinTitle">
        <div class="modal__overlay" data-close-modal></div>
        <div class="modal__content" role="document">
            <div class="modal__header">
                <h3 class="modal__title" id="linkedinTitle">LinkedIn Preview</h3>
                <button class="modal__close" aria-label="Close" data-close-modal>&times;</button>
            </div>
            <div class="modal__body">
                <div id="linkedinBadgeContainer">
                    <div class="LI-profile-badge" data-version="v1" data-size="medium" data-locale="en_US"
                        data-type="vertical" data-theme="light" data-vanity="amerigo-velletti-b888a9304">
                        <a class="LI-simple-link" href="https://www.linkedin.com/in/amerigo-velletti-b888a9304">Amerigo
                            Velletti</a>
                    </div>
                </div>
                <div id="linkedinFallback" class="badge-fallback" style="display:none">
                    <div class="fallback-avatar" aria-hidden="true">AV</div>
                    <div>
                        <strong>Amerigo Velletti</strong>
                        <p>B.Sc. Information Systems (Semester 6), Technische Universität München</p>
                        <p>Munich, Bavaria, Germany</p>
                        <p>
                            <a class="cta-button" href="https://www.linkedin.com/in/amerigo-velletti-b888a9304"
                                target="_blank" rel="noopener">Open on LinkedIn</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- GitHub Modal -->
    <div class="modal" id="githubModal" aria-hidden="true" role="dialog" aria-labelledby="githubTitle">
        <div class="modal__overlay" data-close-modal></div>
        <div class="modal__content" role="document">
            <div class="modal__header">
                <h3 class="modal__title" id="githubTitle">GitHub Preview</h3>
                <button class="modal__close" aria-label="Close" data-close-modal>&times;</button>
            </div>
            <div class="modal__body" id="githubContent">
                <p>Loading GitHub profile…</p>
            </div>
        </div>
    </div>

    <script>
        // Mobile menu toggle (minimal JavaScript as requested)
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            const toggle = document.querySelector('.mobile-menu-toggle');
            const isOpen = menu.style.display === 'block';

            menu.style.display = isOpen ? 'none' : 'block';
            toggle.setAttribute('aria-expanded', !isOpen);
        }

        function closeMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            const toggle = document.querySelector('.mobile-menu-toggle');
            menu.style.display = 'none';
            toggle.setAttribute('aria-expanded', 'false');
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function (event) {
            const menu = document.getElementById('mobileMenu');
            const toggle = document.querySelector('.mobile-menu-toggle');

            if (!toggle.contains(event.target) && !menu.contains(event.target)) {
                closeMobileMenu();
            }
        });

        // Enhancements
        document.addEventListener('DOMContentLoaded', function () {
            // Theme toggle
            const themeToggle = document.getElementById('themeToggle');
            const setTheme = (t) => {
                document.documentElement.setAttribute('data-theme', t);
                localStorage.setItem('theme', t);
                themeToggle?.setAttribute('aria-pressed', String(t === 'dark'));
            };
            themeToggle?.addEventListener('click', () => {
                const current = document.documentElement.getAttribute('data-theme') || 'light';
                setTheme(current === 'light' ? 'dark' : 'light');
            });

            // Social buttons open modal on primary click, otherwise follow link
            function wireModalButton(btnId, modalSelector) {
                const btn = document.getElementById(btnId);
                const modal = document.querySelector(modalSelector);
                if (!btn || !modal) return;
                btn.addEventListener('click', (e) => {
                    if (e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return; // let default open in new tab
                    e.preventDefault();
                    openModal(modal);
                });
            }
            wireModalButton('btnLinkedIn', '#linkedinModal');
            wireModalButton('btnGitHub', '#githubModal');
            wireModalButton('btnLinkedIn2', '#linkedinModal');
            wireModalButton('btnGitHub2', '#githubModal');

            // Modal open/close utilities
            function openModal(modal) {
                const previouslyFocused = document.activeElement;
                modal.dataset.prevFocus = previouslyFocused ? previouslyFocused.id || '' : '';
                modal.setAttribute('aria-hidden', 'false');
                // focus first focusable
                const focusable = modal.querySelector('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
                focusable && focusable.focus();
                if (modal.id === 'linkedinModal') initLinkedIn();
                if (modal.id === 'githubModal') initGitHub();
            }
            function closeModal(modal) {
                modal.setAttribute('aria-hidden', 'true');
                const prevId = modal.dataset.prevFocus;
                if (prevId) {
                    const prev = document.getElementById(prevId);
                    prev && prev.focus();
                }
            }
            document.querySelectorAll('[data-close-modal]').forEach(el => {
                el.addEventListener('click', (e) => {
                    const modal = e.currentTarget.closest('.modal');
                    modal && closeModal(modal);
                });
            });
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    document.querySelectorAll('.modal[aria-hidden="false"]').forEach(m => closeModal(m));
                }
            });

            // LinkedIn badge lazy init with fallback
            let liLoaded = false, liTried = false;
            function initLinkedIn() {
                const container = document.getElementById('linkedinBadgeContainer');
                const fallback = document.getElementById('linkedinFallback');
                const theme = (document.documentElement.getAttribute('data-theme') || 'light');
                // Ensure theme on badge
                const badge = container.querySelector('.LI-profile-badge');
                if (badge) badge.setAttribute('data-theme', theme === 'dark' ? 'dark' : 'light');
                if (liLoaded) return;
                if (liTried) { fallback.style.display = 'block'; return; }
                liTried = true;
                const s = document.createElement('script');
                s.src = 'https://platform.linkedin.com/badges/js/profile.js';
                s.async = true; s.defer = true; s.onload = () => { liLoaded = true; };
                s.onerror = () => { fallback.style.display = 'block'; };
                document.body.appendChild(s);
                // Fallback if not rendered within 2s
                setTimeout(() => {
                    if (!liLoaded) fallback.style.display = 'block';
                }, 2000);
            }

            // GitHub profile + repos
            let ghLoaded = false;
            async function initGitHub() {
                if (ghLoaded) return;
                ghLoaded = true;
                const el = document.getElementById('githubContent');
                try {
                    const [userRes, repoRes] = await Promise.all([
                        fetch('https://api.github.com/users/Amerigo2020'),
                        fetch('https://api.github.com/users/Amerigo2020/repos?per_page=100')
                    ]);
                    if (!userRes.ok) throw new Error('Failed to load profile');
                    const user = await userRes.json();
                    const reposAll = repoRes.ok ? await repoRes.json() : [];
                    const repos = Array.isArray(reposAll) ? reposAll : [];
                    repos.sort((a, b) => (b.stargazers_count || 0) - (a.stargazers_count || 0));
                    const top = repos.filter(r => !r.fork).slice(0, 5);
                    const repoHtml = top.map(r => `
        <div class="repo-card">
            <a href="${r.html_url}" target="_blank" rel="noopener">${r.name}</a>
            <p>${r.description ? r.description : ''}</p>
            <div class="chip">⭐ ${r.stargazers_count || 0}${r.language ? ` • ${r.language}` : ''}</div>
        </div>
        `).join('');
                    el.innerHTML = `
        <div class="gh-profile">
            <img src="${user.avatar_url}" alt="GitHub avatar of ${user.login}" width="96" height="96" style="border-radius:50%" />
            <div>
                <strong>${user.name || user.login}</strong>
                <p>${user.bio || ''}</p>
                <p>
                    <a class="cta-button" href="${user.html_url}" target="_blank" rel="noopener">Open on GitHub</a>
                </p>
            </div>
        </div>
        <div class="repo-list">${repoHtml}</div>
                    `;
                } catch (err) {
                    el.innerHTML = '<p class="form-error">Failed to load GitHub data. <a href="https://github.com/Amerigo2020" target="_blank" rel="noopener">Open GitHub</a></p>';
                }
            }

            // Contact form AJAX with graceful fallback
            const form = document.getElementById('contactForm');
            const responseBox = document.getElementById('contactResponse');
            form?.addEventListener('submit', async (e) => {
                e.preventDefault();
                responseBox.style.display = 'none';
                const fd = new FormData(form);
                try {
                    const res = await fetch(form.action, { method: 'POST', body: fd, headers: { 'X-Requested-With': 'fetch' } });
                    const data = await res.json();
                    if (data.success) {
                        responseBox.className = 'form-success';
                        responseBox.textContent = 'Thank you! Your message has been sent.';
                        responseBox.style.display = 'block';
                        form.reset();
                        if (data.csrf_token) {
                            const csrfEl = form.querySelector('input[name="csrf_token"]');
                            if (csrfEl) csrfEl.value = data.csrf_token;
                        }
                    } else {
                        responseBox.className = 'form-error';
                        responseBox.textContent = data.message || 'Please check the form fields and try again.';
                        responseBox.style.display = 'block';
                    }
                } catch (_) {
                    // Fallback to normal submit if fetch fails
                    form.submit();
                }
            });
        });
        <!-- Neural Constellation Hero Animation -->
        <script>
        document.addEventListener('DOMContentLoaded', () => {
            const canvas = document.getElementById('hero-canvas');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');

            let width, height;
            let particles = [];
            const connectionDistance = 150;
            const mouseInteractionDistance = 200;

            let mouse = {
                x: null,
            y: null
            };

            function resize() {
                width = canvas.width = window.innerWidth;
            const heroSection = document.querySelector('.section--hero');
            height = canvas.height = heroSection ? heroSection.offsetHeight : window.innerHeight;
            }

            window.addEventListener('resize', resize);
            resize();

            const heroSection = document.querySelector('.section--hero');
            if (heroSection) {
                heroSection.addEventListener('mousemove', (e) => {
                    const rect = canvas.getBoundingClientRect();
                    mouse.x = e.clientX - rect.left;
                    mouse.y = e.clientY - rect.top;
                });

                heroSection.addEventListener('mouseleave', () => {
                mouse.x = null;
            mouse.y = null;
                });
            }

            class Particle {
                constructor() {
                this.x = Math.random() * width;
            this.y = Math.random() * height;
            this.vx = (Math.random() - 0.5) * 1.5;
            this.vy = (Math.random() - 0.5) * 1.5;
            this.radius = Math.random() * 2 + 1;
                    // Randomly assign primary or secondary color accent for the particle
                    this.isPrimary = Math.random() > 0.5;
                }

            update() {
                this.x += this.vx;
            this.y += this.vy;

            if (this.x < 0 || this.x > width) this.vx *= -1;
            if (this.y < 0 || this.y > height) this.vy *= -1;

            // Mouse interaction
            if (mouse.x !== null) {
                        const dx = mouse.x - this.x;
            const dy = mouse.y - this.y;
            const distance = Math.sqrt(dx * dx + dy * dy);

            if (distance < mouseInteractionDistance) {
                            const forceDirectionX = dx / distance;
            const forceDirectionY = dy / distance;
            const force = (mouseInteractionDistance - distance) / mouseInteractionDistance;

            // Slight attraction to mouse
            this.vx += forceDirectionX * force * 0.05;
            this.vy += forceDirectionY * force * 0.05;

            // Limit speed
            const speed = Math.sqrt(this.vx * this.vx + this.vy * this.vy);
                            if (speed > 3) {
                this.vx = (this.vx / speed) * 3;
            this.vy = (this.vy / speed) * 3;
                            }
                        }
                    }
                }

            draw() {
                ctx.beginPath();
            ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
            // Standard color is primary (cyan) or secondary (amber) with low opacity
            ctx.fillStyle = this.isPrimary ? 'rgba(0, 229, 255, 0.4)' : 'rgba(255, 171, 0, 0.4)';
            ctx.fill();
                }
            }

            function init() {
                particles = [];
            // Number of particles depends on screen size (density)
            const numberOfParticles = Math.floor((width * height) / 12000); // slightly denser
            for (let i = 0; i < numberOfParticles; i++) {
                particles.push(new Particle());
                }
            }

            function animate() {
                ctx.clearRect(0, 0, width, height);

            for (let i = 0; i < particles.length; i++) {
                particles[i].update();
            particles[i].draw();

            for (let j = i + 1; j < particles.length; j++) {
                        const dx = particles[i].x - particles[j].x;
            const dy = particles[i].y - particles[j].y;
            const distance = Math.sqrt(dx * dx + dy * dy);

            if (distance < connectionDistance) {
                ctx.beginPath();
            const opacity = 1 - (distance / connectionDistance);

            // Check if dark mode is active to adjust line color
            const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
            const baseColor = isDark ? '255, 255, 255' : '16, 37, 66';

            ctx.strokeStyle = `rgba(${baseColor}, ${opacity * 0.15})`;
            ctx.lineWidth = 1;
            ctx.moveTo(particles[i].x, particles[i].y);
            ctx.lineTo(particles[j].x, particles[j].y);
            ctx.stroke();
                        }
                    }
                }

            requestAnimationFrame(animate);
            }

            init();
            animate();

            // Re-init on resize to adjust particle count
            let resizeTimeout;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(() => {
                init();
                }, 200);
            });
        });
    </script>
</body>

</html>