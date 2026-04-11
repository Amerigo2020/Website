<?php
/**
 * Velletti Consulting Landing Page
 * Pure PHP implementation with responsive design and security features
 * 
 * @author Generated for Velletti Consulting
 * @version 1.0.0
 * @date 2025-07-07
 */

// Shared security & cache headers
require_once __DIR__ . '/includes/headers.php';

// Start session for CSRF protection
session_start();

// Generate CSRF token if not exists
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// A/B test variant (persisted via cookie for 30 days)
$ab_variant = $_COOKIE['ab_hero'] ?? null;
if (!$ab_variant || !in_array($ab_variant, ['a', 'b'], true)) {
    $ab_variant = random_int(0, 1) ? 'a' : 'b';
    setcookie('ab_hero', $ab_variant, time() + 86400 * 30, '/', '', true, true);
}

$hero_cta_primary = $ab_variant === 'a' ? 'Start a project' : 'Let\'s talk';
$hero_cta_secondary = $ab_variant === 'a' ? 'What I build' : 'See my work';

// Configuration
$config = [
    'site_title' => 'Amerigo Velletti | Freelance Entwickler München, AI & Full-Stack',
    'meta_description' => 'Freelance Entwickler und Founding Engineer in München. Ich baue komplette Systeme (Backend, Frontend, DevOps) für Startups. AI-Automatisierung, Webentwicklung und Deployment aus einer Hand. TUM Wirtschaftsinformatik.',
    'meta_keywords' => 'Amerigo Velletti, Freelance Entwickler München, Full-Stack Developer Munich, Startup Developer, AI Automatisierung, Webentwicklung München, DevOps Engineer, TUM Wirtschaftsinformatik, YC Startup, Founding Engineer',
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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($config['meta_description']); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($config['meta_keywords']); ?>">
    <meta name="geo.region" content="DE-BY">
    <meta name="geo.placename" content="Munich">
    <meta name="geo.position" content="48.137154;11.576124">
    <meta name="ICBM" content="48.137154, 11.576124">
    <meta name="author" content="<?php echo htmlspecialchars($config['company_name']); ?>">
    <meta name="robots" content="index,follow">
    <meta name="google-site-verification" content="S8XgRO3zITWu2fLmLr5jS7O_vZM_sEskdm2DiaGHrzc" />

    <!-- Open Graph meta tags -->
    <meta property="og:title" content="<?php echo htmlspecialchars($config['site_title']); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($config['meta_description']); ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?php echo htmlspecialchars($config['company_name']); ?>">
    <meta property="og:locale" content="en_US">
    <meta property="og:locale:alternate" content="de_DE">
    <meta property="og:url" content="<?php echo htmlspecialchars($canonical); ?>">
    <meta property="og:image"
        content="<?php echo htmlspecialchars($scheme . '://' . $host . '/assets/portrait.jpg'); ?>">
    <meta property="og:image:alt" content="Portrait of Amerigo Velletti">
    <meta name="twitter:image"
        content="<?php echo htmlspecialchars($scheme . '://' . $host . '/assets/portrait.jpg'); ?>">
    <meta name="twitter:image:alt" content="Portrait of Amerigo Velletti">

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($config['site_title']); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($config['meta_description']); ?>">
    <meta name="twitter:url" content="<?php echo htmlspecialchars($canonical); ?>">

    <title><?php echo htmlspecialchars($config['site_title']); ?></title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="assets/favicon.svg">
    <link rel="canonical" href="<?php echo htmlspecialchars($canonical); ?>">
    <link rel="alternate" hreflang="en" href="<?php echo htmlspecialchars($canonical); ?>">
    <link rel="alternate" hreflang="de" href="<?php echo htmlspecialchars($canonical); ?>">
    <link rel="alternate" hreflang="x-default" href="<?php echo htmlspecialchars($canonical); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/app.css?v=<?php echo $cssVersion; ?>">
    <link rel="preload" href="assets/css/app.css?v=<?php echo $cssVersion; ?>" as="style">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=JetBrains+Mono:wght@400;500&display=swap" as="style" crossorigin>

    <!-- Privacy-friendly analytics by Plausible -->
    <script async src="https://plausible.io/js/pa-JqqQJVxsU6l36GPzFI8OK.js"></script>
    <script>window.plausible=window.plausible||function(){(plausible.q=plausible.q||[]).push(arguments)},plausible.init=plausible.init||function(i){plausible.o=i||{}};plausible.init()</script>

    <!-- Schema.org markup -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "ProfessionalService",
        "@id": "https://ame.velletti.de/#business",
        "name": "<?php echo htmlspecialchars($config['company_name']); ?>",
        "description": "<?php echo htmlspecialchars($config['meta_description']); ?>",
        "email": "<?php echo htmlspecialchars($config['company_email']); ?>",
        "telephone": "<?php echo htmlspecialchars($config['company_phone']); ?>",
        "url": "<?php echo htmlspecialchars($canonical); ?>",
        "image": "<?php echo htmlspecialchars($scheme . '://' . $host . '/assets/portrait.jpg'); ?>",
        "priceRange": "€€",
        "address": {
            "@type": "PostalAddress",
            "addressLocality": "Munich",
            "addressRegion": "Bavaria",
            "addressCountry": "DE"
        },
        "geo": {
            "@type": "GeoCoordinates",
            "latitude": "48.137154",
            "longitude": "11.576124"
        },
        "areaServed": [
            {"@type": "City", "name": "Munich"},
            {"@type": "State", "name": "Bavaria"},
            {"@type": "Country", "name": "Germany"}
        ],
        "sameAs": [
            "https://github.com/Amerigo2020",
            "https://www.linkedin.com/in/amerigo-velletti-b888a9304"
        ],
        "knowsAbout": [
            "Artificial Intelligence",
            "Automation",
            "Web Development",
            "Web Hosting",
            "DevOps",
            "Full-Stack Development",
            "Systems Architecture"
        ],
        "hasOfferCatalog": {
            "@type": "OfferCatalog",
            "name": "What I Build",
            "itemListElement": [
                { "@type": "Offer", "name": "AI & Automation" },
                { "@type": "Offer", "name": "Web Applications & Hosting" },
                { "@type": "Offer", "name": "DevOps & Deployment" }
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

    <!-- FAQ Schema -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "FAQPage",
        "mainEntity": [
            {
                "@type": "Question",
                "name": "What services does Velletti Consulting offer?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "We build complete systems for startups: AI & Automation, Web Applications & Hosting, and DevOps & Deployment pipelines."
                }
            },
            {
                "@type": "Question",
                "name": "Where is Velletti Consulting based?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Velletti Consulting is based in Munich, Bavaria, Germany. We serve clients locally and remotely."
                }
            },
            {
                "@type": "Question",
                "name": "How can I start a project with Velletti Consulting?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Use the contact form on our website or send an email to vel-consulting@ame.velletti.de. We reply to every inquiry within 24 hours."
                }
            },
            {
                "@type": "Question",
                "name": "Welche Technologien nutzt Velletti Consulting?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "PHP, Python, JavaScript/TypeScript, React, Node.js, Docker, CI/CD Pipelines und AI-Frameworks wie LangChain und RAG-Systeme."
                }
            },
            {
                "@type": "Question",
                "name": "Was kostet ein Projekt bei Velletti Consulting?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Jedes Projekt beginnt mit einer Erstberatung für €99. Projektkosten werden individuell auf Basis des Umfangs kalkuliert."
                }
            }
        ]
    }
    </script>

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [
            {
                "@type": "ListItem",
                "position": 1,
                "name": "Home",
                "item": "https://ame.velletti.de/"
            }
        ]
    }
    </script>

</head>

<body>
    <!-- Header -->
    <header class="header">
        <div class="container header__container">
            <a href="#home" class="logo" aria-label="<?php echo htmlspecialchars($config['company_name']); ?> Home">
                <?php echo htmlspecialchars($config['company_name']); ?>
            </a>

            <nav class="nav" role="navigation" aria-label="Main navigation">
                <a href="#experience" class="nav__link">About</a>
                <a href="#services" class="nav__link">What I build</a>
                <a href="/blog/" class="nav__link">Blog</a>
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
            </div>

            <button class="mobile-menu-toggle" onclick="toggleMobileMenu()" aria-label="Toggle mobile menu"
                aria-expanded="false">
                ☰
            </button>

            <div class="mobile-menu" id="mobileMenu">
                <nav class="nav" role="navigation" aria-label="Mobile navigation">
                    <a href="#experience" class="nav__link" onclick="closeMobileMenu()">About</a>
                    <a href="#services" class="nav__link" onclick="closeMobileMenu()">What I build</a>
                    <a href="/blog/" class="nav__link" onclick="closeMobileMenu()">Blog</a>
                    <a href="#contact" class="nav__link" onclick="closeMobileMenu()">Contact</a>
                </nav>
            </div>
        </div>
    </header>

    <main>
        <!-- Hero Section -->
        <section id="home" class="section section--hero">
            <div class="container">
                <div class="hero__grid">
                    <div class="hero__text">
                        <p class="hero__eyebrow">Amerigo Velletti · Munich</p>
                        <h1 class="hero__title">I build complete systems, from backend to UI, for startups that need one person to own the technical side.</h1>
                        <p class="hero__subtitle">
                            From the first conversation to production. I own the architecture, the code,
                            and the deployment, so you don't have to manage a developer.
                        </p>
                        <div class="hero__actions">
                            <a href="#contact" class="btn btn--primary" onclick="if(typeof plausible!=='undefined'){var p=new URLSearchParams(location.search);plausible('cta_click',{props:{label:'hero_primary',variant:'<?php echo $ab_variant; ?>',source:p.get('utm_source')||'direct'}})}"><?php echo htmlspecialchars($hero_cta_primary); ?></a>
                            <a href="#services" class="btn btn--ghost" onclick="if(typeof plausible!=='undefined'){var p=new URLSearchParams(location.search);plausible('cta_click',{props:{label:'hero_secondary',variant:'<?php echo $ab_variant; ?>',source:p.get('utm_source')||'direct'}})}"><?php echo htmlspecialchars($hero_cta_secondary); ?></a>
                        </div>
                    </div>
                    <div class="hero__portrait-wrap">
                        <img
                            src="assets/portrait.jpg"
                            alt="Portrait of Amerigo Velletti"
                            class="hero__portrait"
                            width="400"
                            height="500"
                            loading="eager"
                            decoding="async"
                        >
                    </div>
                </div>
            </div>
        </section>

        <!-- About / Story Section -->
        <section id="experience" class="section about" data-reveal>
            <div class="container">
                <h2>About</h2>
                <div class="about__prose">
                    <p>I grew up helping run my family's IT services company, Jörg Velletti EDV Service, which meant debugging production systems long before I enrolled at university. At TUM studying Business Informatics, I developed the systems-thinking framing that connects technical decisions to business outcomes. Today I'm a Founding Engineer at a stealth-mode YC-backed SaaS studio and compete in hackathons to keep shipping under pressure. Our team won the Enactus World Cup (Bangkok 2025) and I placed top 3 at the MSG Hackathon.</p>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section id="services" class="section services" data-reveal>
            <div class="container">
                <h2>What I build</h2>
                <p class="services__intro">You describe a problem. Some weeks later, you have a system that runs: a backend that handles your business logic, a front end your team can actually use, and deployments that don't require you to call me at 2am.</p>

                <div class="capabilities" data-reveal-children>
                    <div class="capability">
                        <span class="capability-label">AI & Automation</span>
                        <p>I automate the workflows your team wastes hours on. AI-assisted processes that run without manual intervention, integrated into the systems you already use.</p>
                    </div>

                    <div class="capability">
                        <span class="capability-label">Web Applications & Hosting</span>
                        <p>A complete web presence: fast, accessible, and maintained. I handle the domain, the hosting, the deployment pipeline, and the monitoring, so the site stays up and you stay focused on your business.</p>
                    </div>

                    <div class="capability">
                        <span class="capability-label">DevOps & Deployment</span>
                        <p>I set up the pipelines that let you ship without fear. CI/CD, infrastructure as code, observability, so every release is predictable and every incident is visible.</p>
                    </div>
                </div>

            </div>
        </section>

        <!-- Proof Section -->
        <section id="proof" class="section proof" data-reveal>
            <div class="container">
                <h2>Selected proof</h2>

                <div class="proof__list" data-reveal-children>
                    <div class="proof-item">
                        <span class="proof-item__label">Enactus World Cup, Bangkok 2025</span>
                        <p class="proof-item__context">Represented Germany at the international Enactus competition and won. We built a working product under competition conditions in Bangkok.</p>
                    </div>
                    <div class="proof-item">
                        <span class="proof-item__label">MSG Hackathon, Code &amp; Create</span>
                        <p class="proof-item__context">Placed top 3 at the MSG Code & Create hackathon, shipping a functional prototype within 24 hours against a field of professional developers.</p>
                    </div>
                    <div class="proof-item">
                        <span class="proof-item__label">Founding Engineer, YC-backed SaaS Studio (Stealth)</span>
                        <p class="proof-item__context">Building B2B SaaS products at a Y Combinator-founded studio. Previously working student at EY Munich in Transfer Pricing.</p>
                    </div>
                    <div class="proof-item">
                        <span class="proof-item__label">Jörg Velletti EDV Service</span>
                        <p class="proof-item__context">Grew up maintaining production systems at the family IT business, which meant real accountability for real clients before starting university.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="section" style="padding: var(--space-8) 0;">
            <div class="container" style="text-align: center;">
                <p style="color: var(--text-secondary); margin-bottom: var(--space-3);">Looking for ongoing support?</p>
                <a href="checkout.php" class="btn btn--ghost">Erstberatung buchen, €99</a>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="section contact" data-reveal>
            <div class="container">
                <h2>Start a conversation</h2>
                <p>Tell me about your project. I reply to every inquiry within 24 hours.</p>

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

        <!-- FAQ Section -->
        <section id="faq" class="section" data-reveal>
            <div class="container">
                <h2>Frequently asked questions</h2>
                <div class="faq-list">
                    <details class="faq-item" open>
                        <summary class="faq-question">What services does Velletti Consulting offer?</summary>
                        <p class="faq-answer">I build complete systems for startups: AI & Automation to eliminate repetitive work, Web Applications & Hosting with full deployment pipelines, and DevOps & Deployment infrastructure so your team can ship without fear.</p>
                    </details>
                    <details class="faq-item">
                        <summary class="faq-question">Where is Velletti Consulting based?</summary>
                        <p class="faq-answer">I'm based in Munich, Bavaria, Germany and serve clients both locally and remotely. Most of my work is done asynchronously, so timezone differences are rarely a problem.</p>
                    </details>
                    <details class="faq-item">
                        <summary class="faq-question">How can I start a project?</summary>
                        <p class="faq-answer">Use the <a href="#contact">contact form</a> above or send an email to <a href="mailto:<?php echo htmlspecialchars($config['company_email']); ?>"><?php echo htmlspecialchars($config['company_email']); ?></a>. I reply to every inquiry within 24 hours. We'll have a short discovery call, then I'll send you a proposal.</p>
                    </details>
                    <details class="faq-item">
                        <summary class="faq-question">Welche Technologien nutzt Velletti Consulting?</summary>
                        <p class="faq-answer">Ich arbeite mit PHP, Python, JavaScript/TypeScript, React, Node.js, Docker, CI/CD Pipelines und modernen AI-Frameworks wie LangChain und RAG-Systemen. Die Technologie wird immer passend zum Projekt gewählt.</p>
                    </details>
                    <details class="faq-item">
                        <summary class="faq-question">Was kostet ein Projekt bei Velletti Consulting?</summary>
                        <p class="faq-answer">Jedes Projekt beginnt mit einer Erstberatung für €99, in der wir Anforderungen klären und einen konkreten Plan erstellen. Die Projektkosten werden dann individuell auf Basis des Umfangs kalkuliert.</p>
                    </details>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer__content">
                <div class="footer__brand">
                    <span class="footer__brand-name"><?php echo htmlspecialchars($config['company_name']); ?></span>
                    <p class="footer__tagline">Systems, automation, and deployment for startups.</p>
                    <p style="margin-bottom:0;">
                        <a href="mailto:<?php echo htmlspecialchars($config['company_email']); ?>"><?php echo htmlspecialchars($config['company_email']); ?></a><br>
                        <a href="tel:<?php echo htmlspecialchars($config['company_phone']); ?>"><?php echo htmlspecialchars($config['company_phone']); ?></a>
                    </p>
                </div>
                <div>
                    <p class="footer__col-title">Navigate</p>
                    <ul class="footer__links">
                        <li><a href="#home">Home</a></li>
                        <li><a href="#services">Services</a></li>
                        <li><a href="/blog/">Blog</a></li>
                        <li><a href="#contact">Contact</a></li>
                        <li><a href="checkout.php">Premium</a></li>
                    </ul>
                </div>
                <div>
                    <p class="footer__col-title">Legal</p>
                    <ul class="footer__links">
                        <li><a href="/impressum.php">Impressum</a></li>
                        <li><a href="/datenschutz.php">Datenschutz</a></li>
                    </ul>
                    <p class="footer__col-title" style="margin-top: var(--space-6);">Social</p>
                    <ul class="footer__links">
                        <li><a href="https://www.linkedin.com/in/amerigo-velletti-b888a9304" target="_blank" rel="noopener">LinkedIn</a></li>
                        <li><a href="https://github.com/Amerigo2020" target="_blank" rel="noopener">GitHub</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer__bottom">
                <span>&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($config['company_name']); ?></span>
                <span><?php echo htmlspecialchars($config['company_address']); ?></span>
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
                        <p>Business Informatics, Technische Universität München (TUM)</p>
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
                const theme = 'dark';
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
                        if (typeof plausible !== 'undefined') {
                            const params = new URLSearchParams(window.location.search);
                            const variant = document.cookie.match(/ab_hero=([ab])/)?.[1] || 'unknown';
                            plausible('contact_form_submit', {props: {
                                source: params.get('utm_source') || 'direct',
                                medium: params.get('utm_medium') || 'none',
                                variant: variant
                            }});
                        }
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
    </script>
    <script src="assets/js/scroll-animations.js" defer></script>
</body>

</html>