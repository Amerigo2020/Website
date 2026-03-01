# Phase 1: CSS Foundation Reset - Research

**Researched:** 2026-03-01
**Domain:** CSS custom properties, dark-mode-first design tokens, Google Fonts, PHP inline style elimination
**Confidence:** HIGH — all findings based on direct codebase inspection

---

## Summary

The codebase has three independent color systems operating simultaneously: `app.css` defines a `:root` token block, a `<style id="migrated-inline-styles" media="not all">` tag duplicates the full CSS with PHP-injected color values, and a second bare `<style>` tag re-injects only the color tokens again via PHP. On top of this, the inline `<script>` block in `<head>` dynamically sets `data-theme` on `<html>` at runtime, and a theme toggle in the page JS can flip it. The result is that no single file is authoritative — cascade order and `data-theme` state determine which values win.

This phase eliminates all three competing sources and replaces them with a single `app.css` file that is dark-first by default. No `data-theme` attribute will exist. The PHP `$colors[]` array is deleted. All `<style>` tags in `index.php` are removed. The WebGL canvas particle animation (fully implemented in inline `<script>`) is deleted and replaced with a `body::before` CSS grid. The theme toggle button and its JS are removed from the HTML and the inline `<script>`.

Both `theme-manager.js` and `webgl.js` are confirmed to be 0-byte files (empty stubs). They are deleted.

**Primary recommendation:** Replace all three CSS sources with a single rewritten `app.css` using the new dark-first token layer. Edit `index.php` to remove all `<style>` blocks, the `<canvas id="hero-canvas">`, the `#themeToggle` button, and the inline theme/WebGL scripts.

---

## Standard Stack

### Core

| Tool | Version | Purpose | Why Standard |
|------|---------|---------|--------------|
| CSS Custom Properties | Native | Design token layer | Already used; no dependency |
| Google Fonts CDN | N/A | Inter + JetBrains Mono delivery | Free, fast, preconnect supported |
| `body::before` CSS grid | Native | Replace WebGL hero background | Zero JS, zero GPU, renders on first paint |

### Supporting

| Tool | Version | Purpose | When to Use |
|------|---------|---------|-------------|
| `preconnect` hints | Native | Font load performance | Required alongside Google Fonts link |
| `font-display: swap` | Native (via GF URL param) | Prevent invisible text during load | Google Fonts applies this automatically via `&display=swap` |

### Alternatives Considered

| Instead of | Could Use | Tradeoff |
|------------|-----------|----------|
| Google Fonts CDN | Self-hosted font files | Self-hosting removes external dependency but requires manual font subsetting and version management — overkill for this stack |
| `body::before` grid | SVG background-image | SVG approach is equivalent; CSS gradient requires no file |
| CSS Custom Properties | Sass variables | Sass requires a build step; no build toolchain exists and none should be added |

**Installation:**
```html
<!-- In <head>, before app.css link -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
```

---

## Exact Current State: What Needs to Change

### CSS Source 1: `app.css` (lines 1–897)

**File:** `/client/src/assets/css/app.css`

**What it contains:**
- `:root` token block (lines 5–57) with the old color palette:
  - `--color-bg-dark: #0A0E1A` (not the same name as the new tokens)
  - `--color-primary: #00E5FF` (electric cyan — replaced by mint `#6EE7B7`)
  - `--color-secondary: #FFAB00` (amber — eliminated)
  - `--color-bg-subtle: #F8F9FB` (light background — eliminated)
  - `--font-family-base: system font stack` — replaced by Inter via CSS variable
- Dark theme overrides via `:root[data-theme='dark']` (line 566–573) — entire block deleted
- Theme toggle CSS (`.social-btn`, `.theme-toggle`, lines 587–618) — `.theme-toggle` selector deleted; `.social-btn` kept
- Dark-mode-specific overrides via `:root[data-theme='dark']` selectors (lines 602–811) — all deleted

**What survives from app.css:** Reset, layout primitives (`.container`, `.section`), form classes, modal classes, `.cards-grid`, `.event-card`, `.profile-card`, `.chip`, `.visually-hidden`, `@media` queries, print styles, `@media (prefers-reduced-motion)`. These are structural, not color-dependent, and carry forward with color values replaced.

### CSS Source 2: `<style id="migrated-inline-styles" media="not all">` in index.php

**Location:** `index.php` lines 263–1217

**What it contains:** A complete duplicate of `app.css` — full `:root` block with PHP-injected color values, all layout/component CSS, `:root[data-theme='dark']` overrides, dark theme component patches. This is ~950 lines of CSS duplicating `app.css`.

**Note:** `media="not all"` prevents this block from applying in normal browser rendering. It was likely added as a migration artifact. Despite being inert, it bloats the HTML payload and causes confusion.

**Action:** Delete lines 263–1217 entirely from `index.php`.

### CSS Source 3: Second bare `<style>` tag in index.php

**Location:** `index.php` lines 1218–1251

**What it contains:**
```php
<style>
    :root {
        --color-primary:   <?php echo $colors['primary']; ?>;   /* #F87060 coral */
        --color-secondary: <?php echo $colors['secondary']; ?>; /* #102542 navy */
        --color-background:<?php echo $colors['background']; ?>;/* #F7F7FF light */
        --color-accent1:   <?php echo $colors['accent1']; ?>;   /* #B5BFE2 */
        --color-accent2:   <?php echo $colors['accent2']; ?>;   /* #22223B */
        --color-text:      <?php echo $colors['text']; ?>;      /* #23272F */
        --color-white: #ffffff;
        --color-success: #22c55e;
        --color-error: #ef4444;
    }

    :root[data-theme='light'] {
        --color-background: <?php echo $colors['background']; ?>;
        --color-text:       <?php echo $colors['text']; ?>;
    }
</style>
```

This block IS active (no `media="not all"`). It overrides `app.css`'s `:root` block and locks in the light-mode color palette on every page load. This is the primary reason the page renders light despite `app.css` having dark tokens.

**Action:** Delete lines 1218–1251 entirely from `index.php`.

### PHP Color Injection: `$colors[]` array

**Location:** `index.php` lines 31–38

```php
$colors = [
    'primary'    => '#F87060',
    'secondary'  => '#102542',
    'background' => '#F7F7FF',
    'accent1'    => '#B5BFE2',
    'accent2'    => '#22223B',
    'text'       => '#23272F'
];
```

This array only exists to feed the two `<style>` blocks above. Once those blocks are deleted, this array has no consumers and is deleted.

**Action:** Delete lines 31–38 from `index.php`.

### Theme Initialization Script in `<head>`

**Location:** `index.php` lines 1252–1262

```javascript
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
```

This FOUC-prevention script sets `data-theme` on `<html>` before CSS renders. Since dark is now permanent and `data-theme` is no longer used, this script is deleted.

**Action:** Delete lines 1252–1262 from `index.php`.

### Theme Toggle Button in HTML

**Location:** `index.php` line 1299–1304

```html
<button id="themeToggle" class="theme-toggle" aria-label="Toggle dark mode" aria-pressed="false">
    <svg id="iconSun" viewBox="0 0 24 24" aria-hidden="true">
        <path fill="currentColor" d="M6.76 4.84l-1.8-1.79..."/>
    </svg>
</button>
```

**Action:** Delete lines 1299–1304 from `index.php`.

### Theme Toggle JavaScript in Inline `<script>`

**Location:** `index.php` lines 1828–1837 (inside the DOMContentLoaded block)

```javascript
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
```

**Action:** Delete lines 1828–1837 from `index.php`.

### WebGL Canvas Element

**Location:** `index.php` line 1325

```html
<canvas id="hero-canvas"></canvas>
```

**Action:** Delete line 1325 from `index.php`.

### WebGL Particle Animation Script

**Location:** `index.php` lines 1981–2126

This is the neural constellation animation — a full particle system with mouse interaction using canvas 2D API. It creates colored particles (electric cyan `rgba(0, 229, 255, 0.4)` and amber `rgba(255, 171, 0, 0.4)`) connected by lines, responding to mouse movement. Runs on `requestAnimationFrame`.

**Action:** Delete lines 1981–2126 from `index.php`. Note: there is a syntax error on line 1981 (`<!-- Neural Constellation Hero Animation -->` appearing inside a `<script>` block after the closing `});` of the form handler). The entire second `<script>` block (lines 1981–2126) is deleted.

### CSS Hero Container Styles for Canvas

**Location:** `index.php` lines 400–414 (inside `<style id="migrated-inline-styles">`, already being deleted)

```css
#hero-canvas {
    position: absolute; top: 0; left: 0;
    width: 100%; height: 100%;
    z-index: 0; pointer-events: none;
}
.hero-container-inner {
    position: relative; z-index: 1; pointer-events: auto;
}
```

Also present in `app.css`: Not present (canvas styles were only in the inline block). Once the canvas element and the inline `<style>` block are removed, `.hero-container-inner` class becomes unused. Remove from HTML or leave as harmless orphan — remove for cleanliness.

**Action:** Remove `class="hero-container-inner"` from the hero `<div>` at line 1326. The `<div class="container hero-container-inner">` becomes `<div class="container">`.

---

## Architecture Patterns

### Recommended Project Structure (Target State)

```
client/src/
├── index.php              # PHP logic + HTML; zero <style> blocks
├── assets/
│   ├── css/
│   │   └── app.css        # Single source of truth — all styles
│   └── js/
│       ├── animations.js  # Currently 0 bytes — out of scope for Phase 1
│       ├── form-handler.js # Currently 0 bytes — out of scope
│       ├── navigation.js  # Currently 0 bytes — out of scope
│       ├── theme-manager.js # DELETE
│       └── webgl.js       # DELETE
├── contact.php            # Keep as-is
├── checkout.php           # Keep as-is
└── webhook.php            # Keep as-is
```

### Pattern: Dark-First Token Layer

Write `app.css` `:root` block with dark as the one and only default. No `[data-theme]` overrides. No fallback light values. The CSS renders correctly on first paint without any JavaScript.

```css
/* ============================================================
   LAYER 1: DESIGN TOKENS — Dark-first, permanent
   ============================================================ */
:root {
  /* --- Backgrounds ----------------------------------------- */
  --bg-base:     #0a0a0a;   /* Page canvas */
  --bg-surface:  #111111;   /* Cards, panels */
  --bg-elevated: #1a1a1a;   /* Inputs, hover states */

  /* --- Text ------------------------------------------------ */
  --text-primary:   #f0f0f0;
  --text-secondary: #a0a0a0;
  --text-tertiary:  #5a5a5a;
  --text-disabled:  #333333;

  /* --- Accent ---------------------------------------------- */
  --accent:          #6EE7B7;               /* mint */
  --accent-dim:      rgba(110,231,183,0.12);
  --accent-glow:     rgba(110,231,183,0.06);

  /* --- Borders --------------------------------------------- */
  --border-subtle: rgba(255,255,255,0.07);

  /* --- Typography ------------------------------------------ */
  --font-sans: 'Inter', system-ui, sans-serif;
  --font-mono: 'JetBrains Mono', 'Fira Code', monospace;

  /* --- Type scale ------------------------------------------ */
  --text-xs:   0.75rem;
  --text-sm:   0.875rem;
  --text-base: 1rem;
  --text-lg:   1.125rem;
  --text-xl:   1.25rem;
  --text-2xl:  1.5rem;
  --text-3xl:  1.875rem;
  --text-4xl:  2.25rem;
  --text-hero: clamp(2.25rem, 6vw, 4rem);

  /* --- Spacing --------------------------------------------- */
  --space-1:  0.25rem;
  --space-2:  0.5rem;
  --space-3:  0.75rem;
  --space-4:  1rem;
  --space-6:  1.5rem;
  --space-8:  2rem;
  --space-12: 3rem;
  --space-16: 4rem;
  --space-24: 6rem;

  /* --- Layout ---------------------------------------------- */
  --max-width:       1100px;
  --max-width-prose: 680px;
  --nav-height:      64px;

  /* --- Motion ---------------------------------------------- */
  --ease-out:        cubic-bezier(0.22, 1, 0.36, 1);
  --ease-in:         cubic-bezier(0.64, 0, 0.78, 0);
  --duration-fast:   150ms;
  --duration-base:   250ms;
  --duration-slow:   400ms;
  --duration-enter:  600ms;

  /* --- Borders --------------------------------------------- */
  --radius-sm:   4px;
  --radius-md:   8px;
  --radius-lg:   12px;
  --radius-full: 9999px;

  /* --- Functional ------------------------------------------ */
  --color-success: #22c55e;
  --color-error:   #ef4444;
  --color-white:   #ffffff;
}
```

### Pattern: CSS Grid Background (Replaces WebGL)

```css
/* body::before — subtle grid, no JS, no GPU */
body::before {
  content: '';
  position: fixed;
  inset: 0;
  background-image:
    linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
  background-size: 40px 40px;
  pointer-events: none;
  z-index: 0;
}

/* Ensure page content sits above the grid */
body > * {
  position: relative;
  z-index: 1;
}
```

**Opacity constraint:** Keep grid lines at `rgba(255,255,255,0.025)`. Do not increase beyond `0.04` — higher values create graph-paper effect rather than subtle texture.

### Pattern: Eliminating PHP Color Injection

Old pattern (deleted):
```php
$colors = ['primary' => '#F87060', ...]; // PHP array
// then in <head>:
<style>:root { --color-primary: <?php echo $colors['primary']; ?>; }</style>
```

New pattern (all color values hardcoded in app.css):
```css
:root {
  --accent: #6EE7B7;  /* hardcoded, no PHP */
}
```

PHP retains `$config[]` (site metadata) and all form/CSRF/session logic. Only `$colors[]` is deleted.

### Pattern: Font Loading in `<head>`

Add these three lines immediately before the `app.css` `<link>` tag (currently line 190):

```html
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
```

Then in `app.css` `:root`:
```css
--font-sans: 'Inter', system-ui, sans-serif;
--font-mono: 'JetBrains Mono', 'Fira Code', monospace;
```

And in base styles:
```css
body {
  font-family: var(--font-sans);
  background-color: var(--bg-base);
  color: var(--text-secondary);
}
```

**JetBrains Mono scope — apply only to:**
```css
/* Section eyebrow labels */
.eyebrow { font-family: var(--font-mono); }

/* Capability category labels */
.capability-label { font-family: var(--font-mono); }

/* Date/metadata chips */
.chip--date { font-family: var(--font-mono); }

/* Navigation wordmark */
.logo { font-family: var(--font-mono); }

/* Pre/code elements */
pre, code { font-family: var(--font-mono); }
```

**Do NOT apply `--font-mono` to:** body text, headings, service descriptions, form labels, button text, footer copy.

### Anti-Patterns to Avoid

- **Do not use `data-theme` attribute anywhere.** Dark is permanent. If `data-theme` appears in CSS or JS, it is dead code to be removed.
- **Do not preserve the `$colors[]` PHP array** even partially. Colors are CSS concerns, not PHP data.
- **Do not leave `media="not all"` style blocks.** This is a migration artifact that means "never apply this." Remove it entirely.
- **Do not add the WebGL canvas back.** The `<canvas id="hero-canvas">` element and its `requestAnimationFrame` loop are deleted permanently.
- **Do not write duplicate CSS.** After this phase, `app.css` is the one and only CSS file. No inline `<style>` blocks remain in `index.php`.

---

## Don't Hand-Roll

| Problem | Don't Build | Use Instead | Why |
|---------|-------------|-------------|-----|
| Font loading | Custom font-face @font-face blocks | Google Fonts CDN + preconnect | GF handles subsetting, caching headers, format negotiation |
| CSS grid background | Canvas 2D or image files | `body::before` with `linear-gradient` | Native CSS, zero JS, no request |
| Dark-mode default | `prefers-color-scheme` media query + JS toggle | Hard-coded dark `:root` values | No JS needed; no flash; no toggle complexity |
| Token naming | Ad-hoc class-level color values | CSS Custom Properties in `:root` | Already proven in this codebase; cascade is the right tool |

**Key insight:** The existing codebase already understood CSS Custom Properties as the right tool. The problem is not the pattern — it is the three competing implementations of that pattern. Phase 1 is consolidation, not replacement.

---

## Common Pitfalls

### Pitfall 1: Leaving Orphan `data-theme` References in app.css

**What goes wrong:** If any `:root[data-theme='dark']` selectors survive in `app.css` after Phase 1, they silently win over `:root` rules when any code (even a browser extension) sets `data-theme`. The cascade conflict is invisible until tested with dark mode tooling.

**How to avoid:** Search `app.css` for `data-theme` after the rewrite. Result must be zero matches.

**Warning signs:** DevTools shows `data-theme='dark'` on `<html>`. Page color looks inconsistent across browsers.

### Pitfall 2: `body` Background and `color` Not Set on `:root`

**What goes wrong:** If `background-color` and `color` are not set on `body` (referencing the new tokens), the browser renders a white background with black text until CSS parses. Even if `app.css` defines `:root` tokens correctly, the flash occurs if `body { background-color }` is missing or set to `var(--color-background)` (old token name).

**How to avoid:** Immediately after the `:root` token block, write:
```css
body {
  background-color: var(--bg-base);
  color: var(--text-secondary);
}
```

**Warning signs:** Brief white flash on first load (FOUC). Visible in browser with cache disabled.

### Pitfall 3: Old Token Names Still Referenced in Component CSS

**What goes wrong:** `app.css` currently uses old token names throughout component rules: `var(--color-primary)`, `var(--color-secondary)`, `var(--color-background)`, `var(--color-text)`. After the `:root` block is rewritten, these references resolve to `undefined` (inherit). The component CSS must be updated to use the new token names (`--accent`, `--bg-surface`, `--text-secondary`, etc.).

**How to avoid:** After rewriting `:root`, run a search for `var(--color-` in `app.css`. Every match is a broken reference that needs updating to a new token name.

**Warning signs:** Cards rendering transparent. Text invisible. Border colors missing.

### Pitfall 4: The Second `<style>` Tag Overrides New app.css Tokens

**What goes wrong:** If the second bare `<style>` tag (index.php lines 1218–1251) is not deleted, it will override the new `:root` block in `app.css` on every page load, restoring `--color-background: #F7F7FF` (light) and `--color-primary: #F87060` (coral). The site will appear light despite app.css being correct.

**How to avoid:** Delete lines 1218–1251 from `index.php` before testing.

**Warning signs:** Page renders light despite app.css showing dark values in DevTools sources tab.

### Pitfall 5: `z-index` Conflict with `body::before` Grid

**What goes wrong:** If `body::before` is `position: fixed; z-index: 0` and page sections have `position: relative` without a stacking context, the grid may render above content on some browsers.

**How to avoid:** The grid uses `z-index: 0` and `pointer-events: none`. Ensure `body > *` have `position: relative; z-index: 1` or that the `<header>` has `z-index: 1000` (already exists). Test by hovering interactive elements — they must be clickable.

---

## Code Examples

### Hero Section (Post-Phase-1 HTML)

```html
<!-- Before (lines 1324-1338): -->
<section id="home" class="section section--hero">
    <canvas id="hero-canvas"></canvas>
    <div class="container hero-container-inner">
        <div class="hero__content">...</div>
    </div>
</section>

<!-- After: -->
<section id="home" class="section section--hero">
    <div class="container">
        <div class="hero__content">...</div>
    </div>
</section>
```

### `<head>` Tag Order (Post-Phase-1)

```html
<head>
    <!-- meta tags, Schema.org scripts — unchanged -->

    <!-- NEW: Font preconnect + load (before app.css) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <!-- EXISTING: app.css (rewritten for dark-first) -->
    <link rel="stylesheet" href="assets/css/app.css?v=<?php echo $cssVersion; ?>">

    <!-- DELETED: <style id="migrated-inline-styles"> block -->
    <!-- DELETED: bare <style> block with PHP color injection -->
    <!-- DELETED: theme initialization <script> -->

    <!-- EXISTING: Stripe (unchanged) -->
    <script async src="https://js.stripe.com/v3/buy-button.js"></script>
</head>
```

### app.css Layer Structure (Post-Phase-1)

```css
/* LAYER 1: DESIGN TOKENS */
:root { /* dark-first values */ }

/* LAYER 2: RESET + BASE */
*, body, html { /* box-sizing, font-family, background-color */ }

/* LAYER 3: TYPOGRAPHY */
h1, h2, h3, p { /* sizes referencing new tokens */ }

/* LAYER 4: LAYOUT PRIMITIVES */
.container { max-width: var(--max-width); }
.section { padding: var(--space-16) 0; }
.section--hero { /* background: var(--bg-base) + body::before grid */ }

/* LAYER 5: COMPONENTS */
/* .header, .hero, .services, .experience, .contact, .footer */
/* All using new token names: --bg-base, --bg-surface, --accent, etc. */

/* LAYER 6: UTILITIES */
.visually-hidden { }

/* LAYER 7: REDUCED MOTION — always last */
@media (prefers-reduced-motion: reduce) { }
```

### body::before Grid (Exact CSS)

```css
/* Source: STACK.md research, established pattern */
body::before {
  content: '';
  position: fixed;
  inset: 0;
  background-image:
    linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
  background-size: 40px 40px;
  pointer-events: none;
  z-index: 0;
}
```

### Token Name Mapping: Old to New

| Old token (deleted) | New token | New value |
|---------------------|-----------|-----------|
| `--color-primary: #F87060` | `--accent` | `#6EE7B7` |
| `--color-secondary: #102542` | (removed — was used for headings) | headings use `--text-primary` |
| `--color-background: #F7F7FF` | `--bg-base` | `#0a0a0a` |
| `--color-accent1: #B5BFE2` | (removed) | use `--bg-elevated` for elevated surfaces |
| `--color-accent2: #22223B` | (removed) | not needed |
| `--color-text: #23272F` | `--text-secondary` | `#a0a0a0` |
| `--color-bg-dark: #0A0E1A` | `--bg-base` | `#0a0a0a` |
| `--color-bg-medium: #141824` | `--bg-surface` | `#111111` |
| `--color-bg-light: #1A1F2E` | `--bg-elevated` | `#1a1a1a` |
| `--color-text-primary: #E8EBF0` | `--text-primary` | `#f0f0f0` |
| `--color-text-secondary: #9CA3B0` | `--text-secondary` | `#a0a0a0` |
| `--color-text-tertiary: #5F6672` | `--text-tertiary` | `#5a5a5a` |
| `--font-family-base: system stack` | `--font-sans` | `'Inter', system-ui, sans-serif` |
| `--spacing-xs: 0.5rem` | `--space-2` | `0.5rem` |
| `--spacing-sm: 1rem` | `--space-4` | `1rem` |
| `--spacing-md: 1.5rem` | `--space-6` | `1.5rem` |
| `--spacing-lg: 2rem` | `--space-8` | `2rem` |
| `--spacing-xl: 3rem` | `--space-12` | `3rem` |
| `--spacing-2xl: 4rem` | `--space-16` | `4rem` |
| `--transition-fast: 0.2s ease` | `--duration-fast` + `--ease-out` | `150ms` + `cubic-bezier(0.22,1,0.36,1)` |
| `--transition-normal: 0.3s ease` | `--duration-base` + `--ease-out` | `250ms` + same |

---

## State of the Art

| Old Approach | Current Approach | Changed | Impact |
|--------------|------------------|---------|--------|
| `[data-theme='dark']` overrides | Dark-first `:root` only | This phase | Eliminates JS dependency for color |
| PHP `$colors[]` injecting CSS vars | Hardcoded CSS Custom Properties | This phase | CSS is self-contained |
| `media="not all"` style block | Deleted | This phase | Removes ~950 lines dead HTML |
| Canvas WebGL particle animation | `body::before` CSS grid | This phase | Faster first paint, no GPU use on mobile |
| System font stack (`-apple-system, BlinkMacSystemFont...`) | `Inter` variable font | This phase | Consistent rendering across platforms |

**Deprecated/outdated:**
- `--color-bg-subtle: #F8F9FB`: Light background token, no longer needed
- `:root[data-theme='dark']` selectors: All deleted; dark is base state
- `:root[data-theme='light']` selector in PHP block: Deleted
- `$colors[]` PHP array: Deleted

---

## Files Deleted vs Modified

### Files to DELETE

| File | Reason |
|------|--------|
| `/client/src/assets/js/theme-manager.js` | 0-byte file; theme toggle concept eliminated |
| `/client/src/assets/js/webgl.js` | 0-byte file; WebGL concept eliminated |

### Files to MODIFY

| File | Changes |
|------|---------|
| `/client/src/assets/css/app.css` | Rewrite `:root` block; remove all `:root[data-theme]` overrides; remove `.theme-toggle` CSS; update all `var(--color-*)` references to new token names; add `body::before` grid; add `body { background-color: var(--bg-base); }` |
| `/client/src/index.php` | Delete `$colors[]` (lines 31–38); delete `<style id="migrated-inline-styles">` (lines 263–1217); delete bare `<style>` with PHP injection (lines 1218–1251); delete theme init `<script>` (lines 1252–1262); add Google Fonts links (before app.css link at line 190); delete `#themeToggle` button (lines 1299–1304); delete theme toggle JS (lines 1828–1837); delete `<canvas id="hero-canvas">` (line 1325); remove `hero-container-inner` class from div (line 1326); delete WebGL `<script>` block (lines 1981–2126) |

---

## Open Questions

1. **`container` max-width: 1200px vs 1100px**
   - What we know: `app.css` currently uses `max-width: 1200px`. STACK.md recommends `1100px` for more visual breathing room.
   - What's unclear: Whether this is a Phase 1 concern or Phase 2 (layout primitives).
   - Recommendation: Change to `1100px` in Phase 1 since it is a token-level decision (`--max-width: 1100px`), not a layout change.

2. **Heading color mapping**
   - What we know: Current `h1, h2, h3` use `color: var(--color-secondary)` which was `#102542` (navy). On dark backgrounds, this would be near-invisible.
   - What's unclear: Whether Phase 1 should fix heading colors or leave for Phase 2.
   - Recommendation: Fix in Phase 1 — broken heading colors would make the result unreviewable. Map to `--text-primary` (`#f0f0f0`).

3. **LinkedIn badge `data-theme` attribute**
   - What we know: The LinkedIn badge at line 1762 sets `data-theme="light"`. The `initLinkedIn()` function updates this based on `document.documentElement.getAttribute('data-theme')`.
   - What's unclear: After removing `data-theme` from `<html>`, this attribute lookup returns `null`, so `theme === 'dark'` is false, meaning badge always gets `data-theme="light"`.
   - Recommendation: Leave LinkedIn badge with `data-theme="light"` (the Calendly/LinkedIn iframes have their own styling; the badge will just render light-themed which is acceptable). Remove the `data-theme` check from `initLinkedIn()` in the inline script — simplify to always set `data-theme="dark"` on the badge element, or leave it at `light` since the modal visuals are secondary.

---

## Sources

### Primary (HIGH confidence)

- Direct inspection of `/client/src/index.php` — all line numbers verified
- Direct inspection of `/client/src/assets/css/app.css` — all token names and selectors verified
- Direct inspection of `/client/src/assets/js/` — all 5 files confirmed as 0-byte stubs
- `/client/src/.planning/research/STACK.md` — design token values, font CDN URLs, grid CSS
- `/client/src/.planning/research/ARCHITECTURE.md` — CSS layer structure, token naming

### Secondary (MEDIUM confidence)

- Google Fonts combined URL format: `family=Inter:ital,opsz,wght@...&family=JetBrains+Mono:wght@400;500&display=swap` — standard GF URL syntax, confirmed working as of training data (August 2025). The `opsz` (optical size) axis for Inter is the current best-practice load format.

---

## Metadata

**Confidence breakdown:**

| Area | Level | Reason |
|------|-------|--------|
| Exact line numbers for deletions | HIGH | Read directly from source files |
| Old token names | HIGH | Read from app.css and index.php |
| New token values | HIGH | From STACK.md + ARCHITECTURE.md |
| Google Fonts CDN URL | MEDIUM | Stable API but format not re-verified against live docs this session |
| CSS grid background opacity | HIGH | Documented in STACK.md with rationale |
| WebGL implementation | HIGH | Read in full from inline script (lines 1981–2126) |

**Research date:** 2026-03-01
**Valid until:** 2026-04-01 (stable domain — CSS standards and Google Fonts CDN do not change rapidly)
