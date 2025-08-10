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
    'site_title' => 'Velletti Consulting - Professional Business Solutions',
    'meta_description' => 'Expert consulting services for modern businesses. Strategic planning, digital transformation, and growth optimization.',
    'meta_keywords' => 'consulting, business strategy, digital transformation, professional services',
    'company_name' => 'Velletti Consulting',
    'company_email' => 'info@velletti-consulting.com',
    'company_phone' => '+1 (555) 123-4567',
    'company_address' => '123 Business District, Suite 100, Professional City, PC 12345'
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($config['meta_description']); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($config['meta_keywords']); ?>">
    <meta name="author" content="<?php echo htmlspecialchars($config['company_name']); ?>">
    
    <!-- Open Graph meta tags -->
    <meta property="og:title" content="<?php echo htmlspecialchars($config['site_title']); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($config['meta_description']); ?>">
    <meta property="og:type" content="website">
    
    <title><?php echo htmlspecialchars($config['site_title']); ?></title>
    
    <!-- Schema.org markup -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "ProfessionalService",
        "name": "<?php echo htmlspecialchars($config['company_name']); ?>",
        "description": "<?php echo htmlspecialchars($config['meta_description']); ?>",
        "email": "<?php echo htmlspecialchars($config['company_email']); ?>",
        "telephone": "<?php echo htmlspecialchars($config['company_phone']); ?>",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "<?php echo htmlspecialchars($config['company_address']); ?>"
        }
    }
    </script>
    
    <style>
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
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container header__container">
            <a href="#home" class="logo" aria-label="Velletti Consulting Home">
                <?php echo htmlspecialchars($config['company_name']); ?>
            </a>
            
            <nav class="nav" role="navigation" aria-label="Main navigation">
                <a href="#services" class="nav__link">Services</a>
                <a href="#contact" class="nav__link">Contact</a>
            </nav>
            
            <button class="mobile-menu-toggle" onclick="toggleMobileMenu()" aria-label="Toggle mobile menu" aria-expanded="false">
                ☰
            </button>
            
            <div class="mobile-menu" id="mobileMenu">
                <nav class="nav" role="navigation" aria-label="Mobile navigation">
                    <a href="#services" class="nav__link" onclick="closeMobileMenu()">Services</a>
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
                    <h1 class="hero__title">Transform Your Business with Expert Consulting</h1>
                    <p class="hero__subtitle">
                        We help modern businesses navigate digital transformation, optimize operations, 
                        and achieve sustainable growth through strategic consulting and innovative solutions.
                    </p>
                    <a href="#contact" class="cta-button" role="button">Get Started Today</a>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section id="services" class="section services">
            <div class="container">
                <h2>Our Services</h2>
                <p>We provide comprehensive consulting services tailored to your business needs.</p>
                
                <div class="services__grid">
                    <div class="service-card" tabindex="0">
                        <div class="service-icon" aria-hidden="true">🎯</div>
                        <h3>Strategic Planning</h3>
                        <p>
                            Develop comprehensive business strategies that align with your vision and market opportunities. 
                            We analyze your competitive landscape and create actionable roadmaps for sustainable growth.
                        </p>
                    </div>
                    
                    <div class="service-card" tabindex="0">
                        <div class="service-icon" aria-hidden="true">💻</div>
                        <h3>Digital Transformation</h3>
                        <p>
                            Modernize your operations with cutting-edge technology solutions. From process automation 
                            to digital workflows, we help you leverage technology for competitive advantage.
                        </p>
                    </div>
                    
                    <div class="service-card" tabindex="0">
                        <div class="service-icon" aria-hidden="true">📈</div>
                        <h3>Growth Optimization</h3>
                        <p>
                            Identify and capitalize on growth opportunities through data-driven insights and proven methodologies. 
                            Scale your business efficiently while maintaining operational excellence.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="section contact">
            <div class="container">
                <h2>Get In Touch</h2>
                <p>Ready to transform your business? Contact us today for a consultation.</p>
                
                <?php if ($form_success): ?>
                    <div class="contact-form">
                        <div class="form-success">
                            <strong>Thank you for your message!</strong><br>
                            We've received your inquiry and will get back to you within 24 hours.
                        </div>
                    </div>
                <?php else: ?>
                    <form class="contact-form" method="POST" action="#contact" novalidate>
                        <?php if (isset($form_errors['csrf']) || isset($form_errors['rate_limit'])): ?>
                            <div class="form-error">
                                <?php echo isset($form_errors['csrf']) ? htmlspecialchars($form_errors['csrf']) : htmlspecialchars($form_errors['rate_limit']); ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="form-group">
                            <label for="name" class="form-label">Name *</label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                class="form-input" 
                                value="<?php echo htmlspecialchars($form_data['name']); ?>"
                                required 
                                aria-describedby="name-error"
                                autocomplete="name"
                            >
                            <?php if (isset($form_errors['name'])): ?>
                                <div class="form-error" id="name-error"><?php echo htmlspecialchars($form_errors['name']); ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="form-group">
                            <label for="email" class="form-label">Email *</label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                class="form-input" 
                                value="<?php echo htmlspecialchars($form_data['email']); ?>"
                                required 
                                aria-describedby="email-error"
                                autocomplete="email"
                            >
                            <?php if (isset($form_errors['email'])): ?>
                                <div class="form-error" id="email-error"><?php echo htmlspecialchars($form_errors['email']); ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone" class="form-label">Phone</label>
                            <input 
                                type="tel" 
                                id="phone" 
                                name="phone" 
                                class="form-input" 
                                value="<?php echo htmlspecialchars($form_data['phone']); ?>"
                                aria-describedby="phone-error"
                                autocomplete="tel"
                            >
                            <?php if (isset($form_errors['phone'])): ?>
                                <div class="form-error" id="phone-error"><?php echo htmlspecialchars($form_errors['phone']); ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="form-group">
                            <label for="message" class="form-label">Message *</label>
                            <textarea 
                                id="message" 
                                name="message" 
                                class="form-textarea" 
                                required 
                                aria-describedby="message-error"
                                placeholder="Tell us about your project and how we can help..."
                            ><?php echo htmlspecialchars($form_data['message']); ?></textarea>
                            <?php if (isset($form_errors['message'])): ?>
                                <div class="form-error" id="message-error"><?php echo htmlspecialchars($form_errors['message']); ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Honeypot field for spam protection -->
                        <div class="honeypot">
                            <label for="website">Website (leave blank)</label>
                            <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                        </div>
                        
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                        <input type="hidden" name="contact_form" value="1">
                        
                        <button type="submit" class="form-submit">Send Message</button>
                    </form>
                <?php endif; ?>
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
                <p><a href="#privacy" onclick="alert('Privacy policy would be linked here')">Privacy Policy</a></p>
            </div>
        </div>
    </footer>

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
        
        // Handle form validation feedback
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.contact-form');
            if (form) {
                const inputs = form.querySelectorAll('.form-input, .form-textarea');
                inputs.forEach(input => {
                    input.addEventListener('input', function() {
                        // Remove error styling when user starts typing
                        const errorDiv = document.getElementById(this.getAttribute('aria-describedby'));
                        if (errorDiv) {
                            this.style.borderColor = '';
                        }
                    });
                });
            }
        });
    </script>
</body>
</html>