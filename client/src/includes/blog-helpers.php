<?php
/**
 * Blog helper functions.
 * Handles Markdown front-matter parsing, post listing, and rendering.
 */

require_once __DIR__ . '/../../../vendor/autoload.php';

function get_posts_dir(): string {
    return __DIR__ . '/../content/posts';
}

/**
 * Parse YAML-like front matter from a Markdown file.
 * Expects --- delimiters at the top of the file.
 * Returns ['meta' => [...], 'body' => '...']
 */
function parse_post(string $filepath): ?array {
    $raw = file_get_contents($filepath);
    if ($raw === false) return null;

    $meta = [];
    $body = $raw;

    if (str_starts_with(trim($raw), '---')) {
        $parts = preg_split('/^---\s*$/m', $raw, 3);
        if (count($parts) >= 3) {
            $frontMatter = trim($parts[1]);
            $body = trim($parts[2]);

            foreach (explode("\n", $frontMatter) as $line) {
                $line = trim($line);
                if ($line === '' || !str_contains($line, ':')) continue;
                $colonPos = strpos($line, ':');
                $key = trim(substr($line, 0, $colonPos));
                $value = trim(substr($line, $colonPos + 1));
                $value = trim($value, '"\'');
                $meta[$key] = $value;
            }
        }
    }

    return ['meta' => $meta, 'body' => $body];
}

/**
 * Get all published posts sorted by date (newest first).
 */
function get_all_posts(): array {
    $dir = get_posts_dir();
    $posts = [];

    foreach (glob($dir . '/*.md') as $file) {
        $parsed = parse_post($file);
        if (!$parsed) continue;

        $slug = pathinfo($file, PATHINFO_FILENAME);
        $parsed['slug'] = $slug;
        $parsed['file'] = $file;
        $posts[] = $parsed;
    }

    usort($posts, function ($a, $b) {
        $dateA = $a['meta']['date'] ?? '1970-01-01';
        $dateB = $b['meta']['date'] ?? '1970-01-01';
        return strcmp($dateB, $dateA);
    });

    return $posts;
}

/**
 * Get a single post by slug.
 */
function get_post_by_slug(string $slug): ?array {
    $slug = preg_replace('/[^a-zA-Z0-9_-]/', '', $slug);
    $file = get_posts_dir() . '/' . $slug . '.md';
    if (!file_exists($file)) return null;

    $parsed = parse_post($file);
    if ($parsed) $parsed['slug'] = $slug;
    return $parsed;
}

/**
 * Render Markdown body to HTML via Parsedown.
 */
function render_markdown(string $markdown): string {
    $parsedown = new Parsedown();
    $parsedown->setSafeMode(true);
    return $parsedown->text($markdown);
}

/**
 * Generate an excerpt from a Markdown body.
 */
function get_excerpt(string $body, int $length = 160): string {
    $text = strip_tags(render_markdown($body));
    if (mb_strlen($text) <= $length) return $text;
    return mb_substr($text, 0, $length) . '…';
}

/**
 * Estimated reading time in minutes.
 */
function reading_time(string $body): int {
    $words = str_word_count(strip_tags(render_markdown($body)));
    return max(1, (int) ceil($words / 200));
}
