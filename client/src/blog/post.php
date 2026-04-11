<?php
/**
 * Single Blog Post — Renders a Markdown post by slug.
 */
require_once __DIR__ . '/../includes/headers.php';
require_once __DIR__ . '/../includes/blog-helpers.php';

$slug = $_GET['slug'] ?? '';
$post = get_post_by_slug($slug);

if (!$post) {
    http_response_code(404);
    $pageTitle = '404 — Post Not Found';
    $content = '<p>This post does not exist. <a href="/blog/">Back to blog</a>.</p>';
} else {
    $meta = $post['meta'];
    $pageTitle = htmlspecialchars($meta['title'] ?? $slug) . ' — Velletti Consulting';
    $content = render_markdown($post['body']);
}

$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost:8000';
$canonical = $scheme . '://' . $host . '/blog/post.php?slug=' . urlencode($slug);
$cssVersion = @filemtime(__DIR__ . '/../assets/css/app.css') ?: time();
$description = htmlspecialchars($meta['description'] ?? get_excerpt($post['body'] ?? '', 160));
$author = htmlspecialchars($meta['author'] ?? 'Amerigo Velletti');
$date = $meta['date'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <?php if ($post): ?>
    <meta name="description" content="<?php echo $description; ?>">
    <meta name="author" content="<?php echo $author; ?>">
    <link rel="canonical" href="<?php echo htmlspecialchars($canonical); ?>">

    <meta property="og:title" content="<?php echo $pageTitle; ?>">
    <meta property="og:description" content="<?php echo $description; ?>">
    <meta property="og:type" content="article">
    <meta property="og:url" content="<?php echo htmlspecialchars($canonical); ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo $pageTitle; ?>">
    <meta name="twitter:description" content="<?php echo $description; ?>">

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BlogPosting",
        "headline": "<?php echo htmlspecialchars($meta['title'] ?? $slug, ENT_QUOTES); ?>",
        "description": "<?php echo $description; ?>",
        "datePublished": "<?php echo htmlspecialchars($date); ?>",
        "author": {
            "@type": "Person",
            "name": "<?php echo $author; ?>",
            "url": "https://ame.velletti.de/"
        },
        "publisher": {
            "@type": "Organization",
            "name": "Velletti Consulting",
            "url": "https://ame.velletti.de/"
        },
        "mainEntityOfPage": "<?php echo htmlspecialchars($canonical); ?>"
    }
    </script>
    <?php endif; ?>

    <link rel="icon" type="image/svg+xml" href="../assets/favicon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/app.css?v=<?php echo $cssVersion; ?>">
    <!-- Privacy-friendly analytics by Plausible -->
    <script async src="https://plausible.io/js/pa-JqqQJVxsU6l36GPzFI8OK.js"></script>
    <script>window.plausible=window.plausible||function(){(plausible.q=plausible.q||[]).push(arguments)},plausible.init=plausible.init||function(i){plausible.o=i||{}};plausible.init()</script>

    <style>
        .post-header { margin-bottom: var(--space-8); padding-bottom: var(--space-6); border-bottom: 1px solid var(--border-subtle); }
        .post-header h1 { font-size: var(--text-4xl); line-height: 1.2; margin-bottom: var(--space-4); }
        .post-meta { font-size: var(--text-sm); color: var(--text-tertiary); font-family: var(--font-mono); }

        .post-body { line-height: 1.8; color: var(--text-primary); }
        .post-body h2 { font-size: var(--text-2xl); margin-top: var(--space-12); margin-bottom: var(--space-4); color: var(--text-primary); }
        .post-body h3 { font-size: var(--text-xl); margin-top: var(--space-8); margin-bottom: var(--space-3); color: var(--text-primary); }
        .post-body p { margin-bottom: var(--space-4); color: var(--text-secondary); }
        .post-body ul, .post-body ol { margin-bottom: var(--space-4); padding-left: var(--space-6); color: var(--text-secondary); }
        .post-body li { margin-bottom: var(--space-2); }
        .post-body code { font-family: var(--font-mono); font-size: var(--text-sm); background: var(--bg-elevated); padding: 2px 6px; border-radius: var(--radius-sm); }
        .post-body pre { background: var(--bg-elevated); padding: var(--space-4); border-radius: var(--radius-md); overflow-x: auto; margin-bottom: var(--space-6); }
        .post-body pre code { background: none; padding: 0; }
        .post-body blockquote { border-left: 3px solid var(--accent); padding-left: var(--space-4); margin: var(--space-6) 0; color: var(--text-secondary); font-style: italic; }
        .post-body a { color: var(--accent); text-decoration: underline; text-underline-offset: 3px; }
        .post-body strong { color: var(--text-primary); }

        .post-nav { margin-top: var(--space-16); padding-top: var(--space-6); border-top: 1px solid var(--border-subtle); }
        .post-nav a { color: var(--accent); text-decoration: none; font-family: var(--font-mono); font-size: var(--text-sm); }
        .post-nav a:hover { text-decoration: underline; }

        .post-cta {
            margin-top: var(--space-12);
            padding: var(--space-8);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-lg);
            text-align: center;
        }
        .post-cta h3 { margin-bottom: var(--space-3); }
        .post-cta p { color: var(--text-secondary); margin-bottom: var(--space-4); }
    </style>
</head>
<body>
    <header class="header">
        <div class="container header__container">
            <a href="/" class="logo">Velletti Consulting</a>
            <nav class="nav" role="navigation" aria-label="Main navigation">
                <a href="/" class="nav__link">Home</a>
                <a href="/blog/" class="nav__link">Blog</a>
                <a href="/#contact" class="nav__link">Contact</a>
            </nav>
        </div>
    </header>

    <main>
        <section class="section">
            <div class="container" style="max-width: var(--max-width-prose);">
                <?php if ($post): ?>
                    <article>
                        <div class="post-header">
                            <h1><?php echo htmlspecialchars($meta['title'] ?? $slug); ?></h1>
                            <div class="post-meta">
                                <?php echo htmlspecialchars($date); ?>
                                &middot; <?php echo reading_time($post['body']); ?> min read
                                &middot; <?php echo $author; ?>
                            </div>
                        </div>
                        <div class="post-body">
                            <?php echo $content; ?>
                        </div>

                        <div class="post-cta">
                            <h3>Need help building this?</h3>
                            <p>I build complete systems for startups — from backend to deployment.</p>
                            <a href="/#contact" class="btn btn--primary" onclick="if(typeof plausible!=='undefined')plausible('cta_click',{props:{label:'blog_post_cta'}})">Start a project</a>
                        </div>
                    </article>

                    <div class="post-nav">
                        <a href="/blog/">&larr; All posts</a>
                    </div>
                <?php else: ?>
                    <h1>404 — Post Not Found</h1>
                    <?php echo $content; ?>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer__content">
                <p>&copy; <?php echo date('Y'); ?> Velletti Consulting. All rights reserved.</p>
                <p><a href="/#impressum">Impressum</a> · <a href="/#privacy">Datenschutz</a></p>
            </div>
        </div>
    </footer>
    <script src="../assets/js/scroll-animations.js" defer></script>
</body>
</html>
