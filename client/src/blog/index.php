<?php
/**
 * Blog Index — Lists all published posts.
 */
require_once __DIR__ . '/../includes/headers.php';
require_once __DIR__ . '/../includes/blog-helpers.php';

$posts = get_all_posts();
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost:8000';
$canonical = $scheme . '://' . $host . '/blog/';
$cssVersion = @filemtime(__DIR__ . '/../assets/css/app.css') ?: time();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog — Velletti Consulting</title>
    <meta name="description" content="Insights on AI automation, DevOps, and building tech for startups. By Amerigo Velletti, Munich.">
    <meta name="robots" content="index,follow">
    <link rel="canonical" href="<?php echo htmlspecialchars($canonical); ?>">

    <meta property="og:title" content="Blog — Velletti Consulting">
    <meta property="og:description" content="Insights on AI automation, DevOps, and building tech for startups.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo htmlspecialchars($canonical); ?>">

    <link rel="icon" type="image/svg+xml" href="../assets/favicon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/app.css?v=<?php echo $cssVersion; ?>">
    <!-- Privacy-friendly analytics by Plausible -->
    <script async src="https://plausible.io/js/pa-JqqQJVxsU6l36GPzFI8OK.js"></script>
    <script>window.plausible=window.plausible||function(){(plausible.q=plausible.q||[]).push(arguments)},plausible.init=plausible.init||function(i){plausible.o=i||{}};plausible.init()</script>

    <style>
        .blog-list { display: flex; flex-direction: column; gap: var(--space-8); }
        .blog-card {
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-lg);
            padding: var(--space-6) var(--space-8);
            transition: border-color var(--duration-base) var(--ease-out);
        }
        .blog-card:hover { border-color: var(--accent); }
        .blog-card a { text-decoration: none; color: inherit; display: block; }
        .blog-card__title {
            font-size: var(--text-2xl);
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: var(--space-2);
        }
        .blog-card__meta {
            font-size: var(--text-sm);
            color: var(--text-tertiary);
            font-family: var(--font-mono);
            margin-bottom: var(--space-3);
        }
        .blog-card__excerpt {
            color: var(--text-secondary);
            line-height: 1.7;
        }
        .blog-header { margin-bottom: var(--space-12); }
        .blog-header h1 { font-size: var(--text-4xl); margin-bottom: var(--space-4); }
        .blog-header p { color: var(--text-secondary); max-width: var(--max-width-prose); }
        .blog-empty { color: var(--text-tertiary); font-style: italic; }
    </style>
</head>
<body>
    <header class="header">
        <div class="container header__container">
            <a href="/" class="logo">Velletti Consulting</a>
            <nav class="nav" role="navigation" aria-label="Main navigation">
                <a href="/" class="nav__link">Home</a>
                <a href="/blog/" class="nav__link" aria-current="page">Blog</a>
                <a href="/#contact" class="nav__link">Contact</a>
            </nav>
        </div>
    </header>

    <main>
        <section class="section">
            <div class="container" style="max-width: var(--max-width-prose);">
                <div class="blog-header">
                    <h1>Blog</h1>
                    <p>Thoughts on building systems, AI automation, and the technical side of running a startup.</p>
                </div>

                <?php if (empty($posts)): ?>
                    <p class="blog-empty">No posts yet. Check back soon.</p>
                <?php else: ?>
                    <div class="blog-list">
                        <?php foreach ($posts as $post): ?>
                            <article class="blog-card">
                                <a href="/blog/post.php?slug=<?php echo urlencode($post['slug']); ?>">
                                    <h2 class="blog-card__title"><?php echo htmlspecialchars($post['meta']['title'] ?? $post['slug']); ?></h2>
                                    <div class="blog-card__meta">
                                        <?php echo htmlspecialchars($post['meta']['date'] ?? ''); ?>
                                        &middot; <?php echo reading_time($post['body']); ?> min read
                                    </div>
                                    <p class="blog-card__excerpt">
                                        <?php echo htmlspecialchars($post['meta']['description'] ?? get_excerpt($post['body'])); ?>
                                    </p>
                                </a>
                            </article>
                        <?php endforeach; ?>
                    </div>
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
</body>
</html>
