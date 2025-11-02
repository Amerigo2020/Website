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

// Color scheme variables
$colors = [
    'primary' => '#F87060',
    'secondary' => '#102542',
    'background' => '#F7F7FF',
    'accent1' => '#B5BFE2',
    'accent2' => '#22223B',
    'text' => '#23272F'
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
function sanitize_input($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

/**
 * Validate email format
 */
function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Validate phone format (basic)
 */
function validate_phone($phone) {
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
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
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
    <meta property="og:image" content="<?php echo htmlspecialchars($scheme . '://' . $host . '/assets/portrait.jpg'); ?>">
    <meta property="og:image:alt" content="Porträt – Velletti Consulting">
    <meta name="twitter:image" content="<?php echo htmlspecialchars($scheme . '://' . $host . '/assets/portrait.jpg'); ?>">
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
    
    <style id="migrated-inline-styles" media="not all">
        /* CSS Custom Properties (Variables) */
        :root {
            --color-primary: <?php echo $colors['primary']; ?>;
            --color-secondary: <?php echo $colors['secondary']; ?>;
            --color-background: <?php echo $colors['background']; ?>;
            --color-accent1: <?php echo $colors['accent1']; ?>;
            --color-accent2: <?php echo $colors['accent2']; ?>;
            --color-text: <?php echo $colors['text']; ?>;
            --color-white: #ffffff;
            --color-success: #22c55e;
            --color-error: #ef4444;
            
            /* Typography */
            --font-family-base: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            --font-size-base: 16px;
            --line-height-base: 1.6;
            
            /* Spacing */
            --spacing-xs: 0.5rem;
            --spacing-sm: 1rem;
            --spacing-md: 1.5rem;
            --spacing-lg: 2rem;
            --spacing-xl: 3rem;
            --spacing-2xl: 4rem;
            
            /* Breakpoints */
            --breakpoint-tablet: 769px;
            --breakpoint-desktop: 1025px;
            
            /* Shadows */
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            
            /* Transitions */
            --transition-fast: 0.2s ease;
            --transition-normal: 0.3s ease;
        }
        
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html {
            scroll-behavior: smooth;
            font-size: var(--font-size-base);
        }
        
        body {
            font-family: var(--font-family-base);
            line-height: var(--line-height-base);
            color: var(--color-text);
            background-color: var(--color-background);
            overflow-x: hidden;
        }
        
        /* Typography */
        h1, h2, h3, h4, h5, h6 {
            line-height: 1.2;
            margin-bottom: var(--spacing-sm);
            font-weight: 700;
        }
        
        h1 {
            font-size: 2.5rem;
            color: var(--color-secondary);
        }
        
        h2 {
            font-size: 2rem;
            color: var(--color-secondary);
        }
        
        h3 {
            font-size: 1.5rem;
            color: var(--color-secondary);
        }
        
        p {
            margin-bottom: var(--spacing-sm);
        }
        
        a {
            color: var(--color-primary);
            text-decoration: none;
            transition: color var(--transition-fast);
        }
        
        a:hover, a:focus {
            color: var(--color-secondary);
            outline: 2px solid var(--color-primary);
            outline-offset: 2px;
        }
        
        /* Layout Components */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 var(--spacing-sm);
        }
        
        .section {
            padding: var(--spacing-2xl) 0;
        }
        
        .section--hero {
            padding: calc(80px + var(--spacing-xl)) 0 var(--spacing-2xl);
            background: linear-gradient(135deg, var(--color-background) 0%, var(--color-accent1) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        
        /* Header Styles */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(247, 247, 255, 0.95);
            backdrop-filter: blur(10px);
            z-index: 1000;
            padding: var(--spacing-sm) 0;
            border-bottom: 1px solid rgba(16, 37, 66, 0.1);
        }
        
        .header__container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--color-secondary);
            text-decoration: none;
            letter-spacing: -0.025em;
        }
        
        .logo:hover, .logo:focus {
            color: var(--color-primary);
            outline: none;
        }
        
        .nav {
            display: flex;
            gap: var(--spacing-lg);
        }
        
        .nav__link {
            font-weight: 500;
            padding: var(--spacing-xs) var(--spacing-sm);
            border-radius: 4px;
            transition: all var(--transition-fast);
        }
        
        .nav__link:hover, .nav__link:focus {
            background-color: var(--color-primary);
            color: var(--color-white);
            outline: none;
        }
        
        /* Mobile Menu */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--color-secondary);
            cursor: pointer;
            padding: var(--spacing-xs);
        }
        
        .mobile-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: var(--color-white);
            border-bottom: 1px solid rgba(16, 37, 66, 0.1);
            box-shadow: var(--shadow-lg);
        }
        
        .mobile-menu .nav {
            flex-direction: column;
            padding: var(--spacing-sm);
            gap: 0;
        }
        
        .mobile-menu .nav__link {
            display: block;
            padding: var(--spacing-sm);
            border-bottom: 1px solid rgba(16, 37, 66, 0.1);
        }
        
        /* Hero Section */
        .hero__content {
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .hero__title {
            font-size: 3rem;
            margin-bottom: var(--spacing-md);
            background: linear-gradient(135deg, var(--color-secondary) 0%, var(--color-primary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .hero__subtitle {
            font-size: 1.25rem;
            color: var(--color-text);
            margin-bottom: var(--spacing-xl);
            opacity: 0.8;
        }
        
        /* Hero avatar (circular image) */
        .hero-avatar {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            object-fit: cover;
            display: block;
            margin: 0 auto var(--spacing-md);
            border: 4px solid var(--color-white);
            box-shadow: var(--shadow-lg);
            background: var(--color-white);
        }
        @media (max-width: 480px) {
            .hero-avatar { width: 128px; height: 128px; }
            
            /* Mobile: Profile Cards - 1 Spalte, gestapelt */
            .cards-grid:first-of-type {
                grid-template-columns: 1fr;
            }
            
            .profile-card, .event-card {
                text-align: center;
                padding: var(--spacing-md);
            }
            
            .profile-card__header {
                flex-direction: column;
                text-align: center;
            }
            
            .profile-card__icon {
                width: 32px;
                height: 32px;
                margin-bottom: var(--spacing-sm);
            }
            
            .profile-card__title {
                font-size: 1rem;
            }
            
            .profile-card__link {
                font-size: 0.9rem;
            }
        }
        
        .cta-button {
            display: inline-block;
            background: var(--color-primary);
            color: var(--color-white);
            padding: var(--spacing-md) var(--spacing-xl);
            border-radius: 8px;
            font-weight: 600;
            font-size: 1.1rem;
            text-decoration: none;
            transition: all var(--transition-normal);
            box-shadow: var(--shadow-md);
        }
        
        .cta-button:hover, .cta-button:focus {
            background: var(--color-secondary);
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            outline: none;
        }
        
        /* Services Section */
        .services {
            background: var(--color-white);
        }
        
        .services__grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: var(--spacing-xl);
            margin-top: var(--spacing-xl);
        }
        
        .service-card {
            background: var(--color-background);
            padding: var(--spacing-xl);
            border-radius: 12px;
            text-align: center;
            transition: all var(--transition-normal);
            border: 1px solid rgba(16, 37, 66, 0.1);
        }
        
        .service-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }
        
        .service-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto var(--spacing-md);
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--color-white);
        }
        
        .service-card h3 {
            color: var(--color-secondary);
            margin-bottom: var(--spacing-sm);
        }
        
        .service-card p {
            color: var(--color-text);
            opacity: 0.8;
        }
        
        /* Contact Section */
        .contact {
            background: var(--color-background);
        }
        
        .contact-form {
            max-width: 600px;
            margin: var(--spacing-xl) auto 0;
            background: var(--color-white);
            padding: var(--spacing-xl);
            border-radius: 12px;
            box-shadow: var(--shadow-md);
        }
        
        .form-group {
            margin-bottom: var(--spacing-md);
        }
        
        .form-label {
            display: block;
            margin-bottom: var(--spacing-xs);
            font-weight: 600;
            color: var(--color-secondary);
        }
        
        .form-input,
        .form-textarea {
            width: 100%;
            padding: var(--spacing-sm);
            border: 2px solid rgba(16, 37, 66, 0.1);
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color var(--transition-fast);
            background: var(--color-white);
        }
        
        .form-input:focus,
        .form-textarea:focus {
            outline: none;
            border-color: var(--color-primary);
        }
        
        .form-textarea {
            resize: vertical;
            min-height: 120px;
        }
        
        .form-error {
            color: var(--color-error);
            font-size: 0.875rem;
            margin-top: var(--spacing-xs);
        }
        
        .form-success {
            background: rgba(34, 197, 94, 0.1);
            color: var(--color-success);
            padding: var(--spacing-md);
            border-radius: 6px;
            margin-bottom: var(--spacing-md);
            border: 1px solid rgba(34, 197, 94, 0.2);
        }
        
        .form-submit {
            background: var(--color-primary);
            color: var(--color-white);
            border: none;
            padding: var(--spacing-sm) var(--spacing-xl);
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition-normal);
            font-size: 1rem;
        }
        
        .form-submit:hover, .form-submit:focus {
            background: var(--color-secondary);
            outline: none;
        }
        
        .honeypot {
            position: absolute;
            left: -9999px;
            width: 1px;
            height: 1px;
            overflow: hidden;
        }
        
        /* Legal Sections */
        .legal { background: var(--color-background); }
        .legal h2 { margin-bottom: var(--spacing-sm); }
        .legal h3 { margin-top: var(--spacing-sm); }
        .legal p { opacity: 0.9; }
        
        /* Footer */
        .footer {
            background: var(--color-secondary);
            color: var(--color-white);
            padding: var(--spacing-xl) 0;
            text-align: center;
        }
        
        .footer__content {
            margin-bottom: var(--spacing-md);
        }
        
        .footer__contact {
            margin-bottom: var(--spacing-md);
        }
        
        .footer__contact p {
            margin-bottom: var(--spacing-xs);
        }
        
        .footer a {
            color: var(--color-accent1);
        }
        
        .footer a:hover, .footer a:focus {
            color: var(--color-white);
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .nav {
                display: none;
            }
            
            .mobile-menu-toggle {
                display: block;
            }
            
            .hero__title {
                font-size: 2rem;
            }
            
            h1 {
                font-size: 2rem;
            }
            
            h2 {
                font-size: 1.5rem;
            }
            
            .container {
                padding: 0 var(--spacing-md);
            }
            
            .section {
                padding: var(--spacing-xl) 0;
            }
            
            .section--hero {
                padding: calc(80px + var(--spacing-lg)) 0 var(--spacing-xl);
                min-height: auto;
            }
            
            .contact-form {
                margin: var(--spacing-lg) auto 0;
                padding: var(--spacing-lg);
            }
            
            /* Tablet: Profile Cards - 2 Spalten oder 1 Spalte */
            .cards-grid:first-of-type {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .profile-card, .event-card {
                text-align: center;
            }
            
            .profile-card__header {
                flex-direction: column;
                text-align: center;
            }
            
            .profile-card__icon {
                width: 36px;
                height: 36px;
            }
        }
        
        @media (min-width: 769px) {
            .services__grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        
        @media (min-width: 1025px) {
            .container {
                padding: 0 var(--spacing-lg);
            }
            
            .hero__title {
                font-size: 3.5rem;
            }
            
            h1 {
                font-size: 3rem;
            }
        }
        
        /* Accessibility */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
            
            html {
                scroll-behavior: auto;
            }
        }
        
        /* Focus styles for keyboard navigation */
        .service-card:focus {
            outline: 2px solid var(--color-primary);
            outline-offset: 2px;
        }
        
        /* Print styles */
        @media print {
            .header, .mobile-menu {
                display: none;
            }
            
            .section--hero {
                padding: var(--spacing-lg) 0;
                min-height: auto;
                background: none;
            }
            
            * {
                background: transparent !important;
                color: black !important;
                box-shadow: none !important;
            }
        }
        
        /* Dark theme support */
        :root[data-theme='light'] {
            --color-background: <?php echo $colors['background']; ?>;
            --color-text: <?php echo $colors['text']; ?>;
        }
        :root[data-theme='dark'] {
            --color-background: #0d1117;
            --color-text: #e6edf3;
            --color-secondary: #e6edf3;
            --color-accent1: #1f2937;
            --color-accent2: #0b1220;
            --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.5);
        }

        /* Header actions */
        .header__actions { display: flex; align-items: center; gap: var(--spacing-sm); }
        .social-buttons { display: flex; gap: var(--spacing-xs); }
        .social-btn, .theme-toggle {
            display: inline-flex; align-items: center; justify-content: center;
            width: 40px; height: 40px; border-radius: 8px; border: 1px solid rgba(16,37,66,0.12);
            background: var(--color-white); color: var(--color-secondary);
            box-shadow: var(--shadow-sm); transition: transform var(--transition-fast), background var(--transition-fast);
        }
        :root[data-theme='dark'] .social-btn, :root[data-theme='dark'] .theme-toggle {
            background: #161b22; border-color: rgba(255,255,255,0.1); color: var(--color-text);
        }
        .social-btn:hover, .theme-toggle:hover { transform: translateY(-1px); }
        .social-btn svg, .theme-toggle svg { width: 20px; height: 20px; }

        /* Modals */
        .modal { position: fixed; inset: 0; display: none; align-items: center; justify-content: center; z-index: 2000; }
        .modal[aria-hidden='false'] { display: flex; }
        .modal__overlay { position: absolute; inset: 0; background: rgba(0,0,0,0.45); backdrop-filter: blur(2px); }
        .modal__content { position: relative; max-width: 720px; width: calc(100% - 2rem); background: var(--color-white); color: var(--color-text); border-radius: 12px; box-shadow: var(--shadow-lg); padding: var(--spacing-lg); z-index: 1; }
        :root[data-theme='dark'] .modal__content { background: #0f172a; }
        .modal__header { display:flex; align-items:center; justify-content: space-between; margin-bottom: var(--spacing-md); }
        .modal__title { font-size: 1.25rem; }
        .modal__close { background: transparent; border: none; font-size: 1.5rem; line-height: 1; cursor: pointer; color: inherit; }
        .modal__body { max-height: 70vh; overflow: auto; }
        .badge-fallback { border: 1px solid rgba(16,37,66,0.12); border-radius: 12px; padding: var(--spacing-md); display: grid; grid-template-columns: 72px 1fr; gap: var(--spacing-md); align-items: center; }
        .fallback-avatar { width:72px; height:72px; border-radius: 50%; background: linear-gradient(135deg,var(--color-accent1), var(--color-primary)); display:flex; align-items:center; justify-content:center; color:#fff; font-weight:700; }
        .gh-profile { display:grid; grid-template-columns: 96px 1fr; gap: var(--spacing-md); align-items:flex-start; }
        .repo-list { margin-top: var(--spacing-sm); display:grid; gap: var(--spacing-sm); }
        .repo-card { border:1px solid rgba(16,37,66,0.12); border-radius:10px; padding: var(--spacing-sm); }
        .repo-card a { font-weight:600; }
        .chip { display:inline-flex; align-items:center; gap:6px; padding:2px 8px; border-radius:999px; background: rgba(16,37,66,0.06); font-size: 0.85rem; }
        :root[data-theme='dark'] .repo-card { border-color: rgba(255,255,255,0.1); }
        
        /* Dark theme readability fixes */
        :root[data-theme='dark'] .contact-form { background: #0f172a; color: var(--color-text); }
        :root[data-theme='dark'] .form-input,
        :root[data-theme='dark'] .form-textarea { background: #0b1220; color: var(--color-text); border-color: rgba(255,255,255,0.1); }
        :root[data-theme='dark'] .form-input::placeholder,
        :root[data-theme='dark'] .form-textarea::placeholder { color: rgba(230,237,243,0.6); }
        :root[data-theme='dark'] .form-label { color: var(--color-text); }
        :root[data-theme='dark'] .form-error { color: #fca5a5; }
        :root[data-theme='dark'] .form-success { background: rgba(34,197,94,0.12); border-color: rgba(34,197,94,0.25); color: #86efac; }

        :root[data-theme='dark'] .footer { background: #0b1220; color: var(--color-text); }
        :root[data-theme='dark'] .footer a { color: var(--color-primary); }
        :root[data-theme='dark'] .footer a:hover,
        :root[data-theme='dark'] .footer a:focus { color: var(--color-white); }

        /* Header & nav in dark mode */
        :root[data-theme='dark'] .header { background: rgba(13,17,23,0.95); border-bottom: 1px solid rgba(255,255,255,0.08); }
        :root[data-theme='dark'] .logo { color: var(--color-text); }
        :root[data-theme='dark'] .nav__link { color: var(--color-text); }
        :root[data-theme='dark'] .mobile-menu { background: #0f172a; border-bottom: 1px solid rgba(255,255,255,0.08); }
        :root[data-theme='dark'] .mobile-menu .nav__link { border-bottom: 1px solid rgba(255,255,255,0.08); }

        /* Services wrapper in dark mode */
        :root[data-theme='dark'] .services { background: #0f172a; }

        /* Experience/Events cards */
        .cards-grid { display:grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: var(--spacing-md); }
        .cards-grid:first-of-type { grid-template-columns: repeat(3, 1fr); align-items: stretch; margin-bottom: var(--spacing-md); }
        .profile-card, .event-card { border:1px solid rgba(16,37,66,0.12); border-radius:12px; padding: var(--spacing-md); background: var(--color-white); display: flex; flex-direction: column; justify-content: center; }
        :root[data-theme='dark'] .profile-card, :root[data-theme='dark'] .event-card { background: #0f172a; border-color: rgba(255,255,255,0.1); }
        .profile-card__header { display:flex; align-items:center; justify-content: center; gap: var(--spacing-sm); margin-bottom: var(--spacing-sm); flex-direction: column; text-align: center; }
        .profile-card__icon { width:40px; height:40px; }
        .event-card .title { font-weight:600; }
        .event-card .meta { margin-top: 6px; display:flex; gap:8px; flex-wrap:wrap; }
        .event-card .actions { margin-top: var(--spacing-sm); }
        .small { font-size: 0.9rem; opacity: 0.85; }

        .visually-hidden { position:absolute !important; height:1px; width:1px; overflow:hidden; clip:rect(1px,1px,1px,1px); white-space:nowrap; }
    </style>
    <style>
      :root {
          --color-primary: <?php echo $colors['primary']; ?>;
          --color-secondary: <?php echo $colors['secondary']; ?>;
          --color-background: <?php echo $colors['background']; ?>;
          --color-accent1: <?php echo $colors['accent1']; ?>;
          --color-accent2: <?php echo $colors['accent2']; ?>;
          --color-text: <?php echo $colors['text']; ?>;
          --color-white: #ffffff;
          --color-success: #22c55e;
          --color-error: #ef4444;
      }
      :root[data-theme='light'] {
          --color-background: <?php echo $colors['background']; ?>;
          --color-text: <?php echo $colors['text']; ?>;
      }
    </style>
    <!-- Prefers color scheme initialization (prevents FOUC) -->
    <script>
      (function() {
        try {
          const stored = localStorage.getItem('theme');
          const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
          const theme = stored || (prefersDark ? 'dark' : 'light');
          document.documentElement.setAttribute('data-theme', theme);
        } catch (e) {}
      })();
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
                <a href="#services" class="nav__link">Services</a>
                <a href="#experience" class="nav__link">Events</a>
                <a href="#contact" class="nav__link">Contact</a>
            </nav>
            
            <div class="header__actions">
                <div class="social-buttons">
                    <a id="btnLinkedIn" class="social-btn" href="https://www.linkedin.com/in/amerigo-velletti-b888a9304" target="_blank" rel="noopener" aria-label="Open LinkedIn profile (opens in new tab)" data-modal-target="#linkedinModal">
                        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path fill="currentColor" d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14zm-9.5 6H7v8h2.5V9zm.13-2.75a1.38 1.38 0 1 0-2.76 0 1.38 1.38 0 0 0 2.76 0zM20 13.25c0-2.52-1.35-3.7-3.16-3.7-1.46 0-2.12.8-2.49 1.37v-1.17H12v8h2.5v-4.46c0-1.17.22-2.3 1.67-2.3 1.43 0 1.45 1.33 1.45 2.37V17H20v-3.75z"/></svg>
                    </a>
                    <a id="btnGitHub" class="social-btn" href="https://github.com/Amerigo2020" target="_blank" rel="noopener" aria-label="Open GitHub profile (opens in new tab)" data-modal-target="#githubModal">
                        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path fill="currentColor" d="M12 .5A11.5 11.5 0 0 0 .5 12.3c0 5.23 3.4 9.66 8.12 11.23.59.12.8-.26.8-.58v-2.2c-3.3.73-3.99-1.43-3.99-1.43-.54-1.38-1.33-1.75-1.33-1.75-1.09-.74.08-.72.08-.72 1.2.09 1.84 1.27 1.84 1.27 1.07 1.86 2.8 1.32 3.48 1.01.11-.8.42-1.32.76-1.62-2.64-.31-5.42-1.36-5.42-6.06 0-1.34.47-2.43 1.24-3.28-.12-.3-.54-1.54.12-3.21 0 0 1.01-.33 3.3 1.25a11.1 11.1 0 0 1 6 0c2.28-1.58 3.29-1.25 3.29-1.25.67 1.67.25 2.9.13 3.21.77.85 1.24 1.94 1.24 3.28 0 4.71-2.79 5.75-5.45 6.05.43.37.81 1.1.81 2.22v3.29c0 .32.21.71.81.58A11.52 11.52 0 0 0 23.5 12.3 11.5 11.5 0 0 0 12 .5z"/></svg>
                    </a>
                </div>
                <button id="themeToggle" class="theme-toggle" aria-label="Toggle dark mode" aria-pressed="false">
                    <svg id="iconSun" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M6.76 4.84l-1.8-1.79-1.41 1.41 1.79 1.8 1.42-1.42zM1 13h3v-2H1v2zm10 10h2v-3h-2v3zm7.04-19.95l1.79-1.79 1.41 1.41-1.79 1.79-1.41-1.41zM20 11v2h3v-2h-3zM4.96 19.95l-1.79 1.79 1.41 1.41 1.79-1.79-1.41-1.41zM17 20.24l1.8 1.79 1.41-1.41-1.79-1.8-1.42 1.42zM12 6a6 6 0 100 12 6 6 0 000-12z"/></svg>
                </button>
            </div>
            
            <button class="mobile-menu-toggle" onclick="toggleMobileMenu()" aria-label="Toggle mobile menu" aria-expanded="false">
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
            <div class="container">
                <div class="hero__content">
                    <img class="hero-avatar" src="assets/portrait.jpg" alt="Profile photo" loading="eager"/>
                    <h1 class="hero__title">Velletti Consulting</h1>
                    <p class="hero__subtitle">
                        AI & Automatisierung · Websites & Hosting · Modern Software
                        <br>Velletti Consulting · München, Bayern
                        <br>LinkedIn & GitHub: gerne vernetzen oder direkt schreiben.
                    </p>
                    <a href="#contact" class="cta-button" role="button">Contact Me</a>
                </div>
            </div>
        </section>
        
        <!-- Services Section -->
        <section id="services" class="section services">
            <div class="container">
                <h2>Leistungen</h2>
                <p>Beratung, Entwicklung und Betrieb – klar fokussiert auf AI, Automatisierung sowie moderne Websites & Hosting.</p>
                
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
            </div>
        </section>

        <!-- Experience / Events Section -->
        <section id="experience" class="section experience">
            <div class="container">
                <h2>About Amerigo Velletti</h2>
                <p>Events, hackathons, and professional experience in 2025. Use the header icons for LinkedIn and GitHub previews.</p>

                <!-- Contact & Location Card -->
                <div class="cards-grid" style="margin-bottom: var(--spacing-md);">
                    <a id="btnLinkedIn2" class="profile-card" href="https://www.linkedin.com/in/amerigo-velletti-b888a9304" target="_blank" rel="noopener" aria-label="Open LinkedIn profile (opens in new tab)">
                        <div class="profile-card__header">
                            <svg class="profile-card__icon" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14zm-9.5 6H7v8h2.5V9zm.13-2.75a1.38 1.38 0 1 0-2.76 0 1.38 1.38 0 0 0 2.76 0zM20 13.25c0-2.52-1.35-3.7-3.16-3.7-1.46 0-2.12.8-2.49 1.37v-1.17H12v8h2.5v-4.46c0-1.17.22-2.3 1.67-2.3 1.43 0 1.45 1.33 1.45 2.37V17H20v-3.75z"/></svg>
                            <div>
                                <strong>LinkedIn</strong>
                                <p class="small">linkedin.com/in/amerigo-velletti-b888a9304</p>
                            </div>
                        </div>
                        <span class="chip">Profile</span>
                    </a>
                    <a id="btnGitHub2" class="profile-card" href="https://github.com/Amerigo2020" target="_blank" rel="noopener" aria-label="Open GitHub profile (opens in new tab)">
                        <div class="profile-card__header">
                            <svg class="profile-card__icon" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M12 .5A11.5 11.5 0 0 0 .5 12.3c0 5.23 3.4 9.66 8.12 11.23.59.12.8-.26.8-.58v-2.2c-3.3.73-3.99-1.43-3.99-1.43-.54-1.38-1.33-1.75-1.33-1.75-1.09-.74.08-.72.08-.72 1.2.09 1.84 1.27 1.84 1.27 1.07 1.86 2.8 1.32 3.48 1.01.11-.8.42-1.32.76-1.62-2.64-.31-5.42-1.36-5.42-6.06 0-1.34.47-2.43 1.24-3.28-.12-.3-.54-1.54.12-3.21 0 0 1.01-.33 3.3 1.25a11.1 11.1  0 0 1 6 0c2.28-1.58 3.29-1.25 3.29-1.25.67 1.67.25 2.9.13 3.21.77.85 1.24 1.94 1.24 3.28 0 4.71-2.79 5.75-5.45 6.05.43.37.81 1.1.81 2.22v3.29c0 .32.21.71.81.58A11.52 11.52 0 0 0 23.5 12.3 11.5 11.5 0 0 0 12 .5z"/></svg>
                            <div>
                                <strong>GitHub</strong>
                                <p class="small">github.com/Amerigo2020</p>
                            </div>
                        </div>
                        <span class="chip">Repos</span>
                    </a>
                    <div class="profile-card">
                        <div class="profile-card__header">
                            <svg class="profile-card__icon" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/></svg>
                            <div>
                                <strong>Contact</strong>
                                <p class="small">amerigo@velletti.de</p>
                                <p class="small">+49 176 45531533</p>
                            </div>
                        </div>
                        <span class="chip">Munich, Bavaria</span>
                    </div>
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

                <h3 style="margin-top: var(--spacing-lg); margin-bottom: var(--spacing-md);">Education</h3>
                <div class="cards-grid">
                    <div class="event-card">
                        <div class="title">Technische Universität Munich (TUM)</div>
                        <div class="meta">
                            <span class="chip">B.Sc. Information Systems</span>
                        </div>
                        <p class="small">Semester 7 • Grade 2.6 • Until March 2026</p>
                    </div>
                    <div class="event-card">
                        <div class="title">Gymnasium Fürstenried West</div>
                        <div class="meta">
                            <span class="chip">Abitur</span>
                        </div>
                        <p class="small">Grade 2.1 • Until Jul 2022</p>
                    </div>
                </div>

                <h3 style="margin-top: var(--spacing-lg); margin-bottom: var(--spacing-md);">Professional Experience</h3>
                <div class="cards-grid">
                    <div class="event-card">
                        <div class="title">EY / Ernst & Young</div>
                        <div class="meta">
                            <span class="chip">Transfer Pricing</span>
                        </div>
                        <p class="small">Intern → Working Student • March 2025 – Today</p>
                    </div>
                    <div class="event-card">
                        <div class="title">Bavaria LB / univativ GmbH</div>
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

                <h3 style="margin-top: var(--spacing-lg); margin-bottom: var(--spacing-md);">Leadership & Memberships</h3>
                <div class="cards-grid">
                    <div class="event-card">
                        <div class="title">TUM EuroTeQ & MingaMentor</div>
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
                <h2>Get In Touch</h2>
                <p>Ready to collaborate or just say hi? I’ll get back to you soon.</p>

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
                        <textarea id="message" name="message" class="form-textarea" required placeholder="How can I help?"></textarea>
                        <div class="form-error visually-hidden" id="message-error"></div>
                    </div>

                    <!-- Honeypot -->
                    <div class="honeypot">
                        <label for="website">Website (leave blank)</label>
                        <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                    </div>

                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
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
                    Telefon: <a href="tel:<?php echo htmlspecialchars($config['company_phone']); ?>"><?php echo htmlspecialchars($config['company_phone']); ?></a><br>
                    E-Mail: <a href="mailto:<?php echo htmlspecialchars($config['company_email']); ?>"><?php echo htmlspecialchars($config['company_email']); ?></a>
                </p>
                <h3>Haftung für Inhalte</h3>
                <p>Als Diensteanbieter sind wir gemäß § 7 Abs. 1 TMG für eigene Inhalte auf diesen Seiten nach den allgemeinen Gesetzen verantwortlich. Nach §§ 8 bis 10 TMG sind wir jedoch nicht verpflichtet, übermittelte oder gespeicherte fremde Informationen zu überwachen oder nach Umständen zu forschen, die auf eine rechtswidrige Tätigkeit hinweisen.</p>
                <h3>Haftung für Links</h3>
                <p>Unser Angebot enthält Links zu externen Websites Dritter, auf deren Inhalte wir keinen Einfluss haben. Für diese fremden Inhalte übernehmen wir keine Gewähr. Für die Inhalte der verlinkten Seiten ist stets der jeweilige Anbieter oder Betreiber verantwortlich.</p>
                <h3>Urheberrecht</h3>
                <p>Die durch die Seitenbetreiber erstellten Inhalte und Werke auf diesen Seiten unterliegen dem deutschen Urheberrecht. Vervielfältigung, Bearbeitung, Verbreitung und jede Art der Verwertung außerhalb der Grenzen des Urheberrechts bedürfen der schriftlichen Zustimmung des jeweiligen Autors bzw. Erstellers.</p>
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
                    E-Mail: <a href="mailto:<?php echo htmlspecialchars($config['company_email']); ?>"><?php echo htmlspecialchars($config['company_email']); ?></a>
                </p>
                <h3>Allgemeines</h3>
                <p>Wir verarbeiten personenbezogene Daten nur, soweit dies zur Bereitstellung einer funktionsfähigen Website sowie unserer Inhalte und Leistungen erforderlich ist. Rechtsgrundlagen sind insbesondere Art. 6 Abs. 1 lit. a, b und f DSGVO.</p>
                <h3>Server-Logs</h3>
                <p>Beim Aufruf dieser Website können durch den Hoster technisch notwendige Daten (z. B. IP-Adresse, Zeitpunkt, abgerufene Seiten) in Logfiles verarbeitet werden. Die Speicherung erfolgt aus Sicherheitsgründen und zur Sicherstellung der Funktionsfähigkeit.</p>
                <h3>Kontaktformular</h3>
                <p>Bei Nutzung des Kontaktformulars verarbeiten wir die von Ihnen eingegebenen Daten (Name, E-Mail, Nachricht; optional Telefon) zur Bearbeitung Ihrer Anfrage. Rechtsgrundlage ist Art. 6 Abs. 1 lit. b DSGVO. Die Daten werden nur so lange gespeichert, wie es zur Bearbeitung erforderlich ist.</p>
                <h3>Externe Dienste</h3>
                <p>Beim Öffnen der verlinkten LinkedIn- oder GitHub-Profile werden Daten an die jeweiligen Anbieter übertragen. Es gelten die Datenschutzbestimmungen dieser Anbieter.</p>
                <h3>Ihre Rechte</h3>
                <p>Sie haben Rechte auf Auskunft, Berichtigung, Löschung, Einschränkung der Verarbeitung, Datenübertragbarkeit sowie Widerspruch (Art. 15–21 DSGVO). Zudem besteht ein Beschwerderecht bei einer Aufsichtsbehörde.</p>
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
                    <p>Phone: <a href="tel:<?php echo htmlspecialchars($config['company_phone']); ?>"><?php echo htmlspecialchars($config['company_phone']); ?></a></p>
                    <p>Email: <a href="mailto:<?php echo htmlspecialchars($config['company_email']); ?>"><?php echo htmlspecialchars($config['company_email']); ?></a></p>
                </div>
                
                <p>&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($config['company_name']); ?>. All rights reserved.</p>
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
                    <div class="LI-profile-badge" data-version="v1" data-size="medium" data-locale="en_US" data-type="vertical" data-theme="light" data-vanity="amerigo-velletti-b888a9304">
                        <a class="LI-simple-link" href="https://www.linkedin.com/in/amerigo-velletti-b888a9304">Amerigo Velletti</a>
                    </div>
                </div>
                <div id="linkedinFallback" class="badge-fallback" style="display:none">
                    <div class="fallback-avatar" aria-hidden="true">AV</div>
                    <div>
                        <strong>Amerigo Velletti</strong>
                        <p>B.Sc. Information Systems (Semester 6), Technische Universität München</p>
                        <p>Munich, Bavaria, Germany</p>
                        <p>
                            <a class="cta-button" href="https://www.linkedin.com/in/amerigo-velletti-b888a9304" target="_blank" rel="noopener">Open on LinkedIn</a>
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
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('mobileMenu');
            const toggle = document.querySelector('.mobile-menu-toggle');
            
            if (!toggle.contains(event.target) && !menu.contains(event.target)) {
                closeMobileMenu();
            }
        });
        
        // Enhancements
        document.addEventListener('DOMContentLoaded', function() {
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
                    repos.sort((a,b)=> (b.stargazers_count||0)-(a.stargazers_count||0));
                    const top = repos.filter(r=>!r.fork).slice(0,5);
                    const repoHtml = top.map(r => `
                        <div class="repo-card">
                            <a href="${r.html_url}" target="_blank" rel="noopener">${r.name}</a>
                            <p>${r.description ? r.description : ''}</p>
                            <div class="chip">⭐ ${r.stargazers_count||0}${r.language ? ` • ${r.language}` : ''}</div>
                        </div>
                    `).join('');
                    el.innerHTML = `
                        <div class="gh-profile">
                            <img src="${user.avatar_url}" alt="GitHub avatar of ${user.login}" width="96" height="96" style="border-radius:50%"/>
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
    </script>
</body>
</html>