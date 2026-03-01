# Architecture Patterns: Dark Minimal Developer Personal Brand Site

**Domain:** Developer personal brand / consulting site redesign
**Researched:** 2026-03-01
**Confidence:** HIGH (based on direct codebase analysis + established CSS architecture patterns)

---

## Current State Assessment

The existing site (`client/src/index.php`) is a single-file PHP page with:
- All CSS duplicated across `assets/css/app.css` AND a large inline `<style>` block in the PHP file (causing maintenance confusion — two sources of truth)
- Color variables defined in PHP `$colors[]` array AND re-emitted in multiple inline `<style>` blocks
- Light-mode-first design with a bolted-on dark theme via `[data-theme='dark']` overrides
- Current palette: light background (#F7F7FF), coral accent (#F87060), navy secondary (#102542) — not dark-first
- Theme toggle exists but is cosmetic — the true design intent for the redesign is dark-first

**Key constraint:** No build toolchain. All CSS must be single-file or vanilla CDN-deliverable. PHP handles form processing, CSRF, Stripe.

---

## Recommended Architecture

### File Structure (Target State)

```
client/src/
├── index.php              # PHP logic top, HTML below — no inline <style> blocks
├── assets/
│   ├── css/
│   │   └── app.css        # Single source of truth for all styles
│   └── js/
│       ├── scroll.js      # IntersectionObserver entrance animations
│       ├── nav.js         # Fixed nav scroll behavior + mobile menu
│       └── form.js        # Contact form async submit (preserve existing logic)
├── contact.php            # Existing — keep as-is
├── checkout.php           # Existing — keep as-is
└── webhook.php            # Existing — keep as-is
```

**Rule:** Remove all `<style>` tags from `index.php`. CSS lives in `app.css` only. PHP color variables in `$colors[]` are eliminated — colors become pure CSS custom properties in `app.css`.

---

## CSS Architecture

### Custom Properties Structure

Organize `app.css` into named layers using comment blocks. Order matters — each layer depends on the previous.

```css
/* ============================================================
   LAYER 1: DESIGN TOKENS
   The atomic values. Nothing else in the codebase uses
   hard-coded values — everything references these tokens.
   ============================================================ */
:root {
  /* Backgrounds — stacked depth model */
  --bg-base:     #0a0a0a;   /* Page canvas — deepest layer */
  --bg-surface:  #111111;   /* Cards, panels — one step up */
  --bg-elevated: #1a1a1a;   /* Hover states, focused elements */
  --bg-overlay:  #222222;   /* Modal backdrops, dropdowns */

  /* Text hierarchy — 4 levels */
  --text-primary:   #f0f0f0;  /* Headings, high-emphasis content */
  --text-secondary: #a0a0a0;  /* Body copy, descriptions */
  --text-tertiary:  #5a5a5a;  /* Metadata, labels, captions */
  --text-disabled:  #333333;  /* Placeholder, inactive states */

  /* Accent — single color, multiple intensities */
  --accent:        #e8e8e8;            /* Primary interactive accent (near-white on dark) */
  --accent-dim:    rgba(232,232,232,0.15); /* Subtle tint for backgrounds */
  --accent-border: rgba(232,232,232,0.08); /* Card borders, dividers */

  /* Monospace accent — for code aesthetics */
  --font-mono: 'JetBrains Mono', 'Fira Code', 'Cascadia Code', monospace;
  --font-sans: -apple-system, BlinkMacSystemFont, 'Inter', 'Segoe UI', sans-serif;

  /* Type scale — fluid using clamp() */
  --text-xs:   clamp(0.7rem,  1vw, 0.75rem);
  --text-sm:   clamp(0.8rem,  1.2vw, 0.875rem);
  --text-base: clamp(0.9rem,  1.5vw, 1rem);
  --text-lg:   clamp(1rem,    2vw, 1.125rem);
  --text-xl:   clamp(1.1rem,  2.5vw, 1.25rem);
  --text-2xl:  clamp(1.3rem,  3vw, 1.5rem);
  --text-3xl:  clamp(1.6rem,  4vw, 2rem);
  --text-hero: clamp(2.2rem,  6vw, 4rem);

  /* Spacing — 4px grid base */
  --space-1: 0.25rem;   /* 4px */
  --space-2: 0.5rem;    /* 8px */
  --space-3: 0.75rem;   /* 12px */
  --space-4: 1rem;      /* 16px */
  --space-6: 1.5rem;    /* 24px */
  --space-8: 2rem;      /* 32px */
  --space-12: 3rem;     /* 48px */
  --space-16: 4rem;     /* 64px */
  --space-24: 6rem;     /* 96px */

  /* Layout */
  --container-max: 1100px;
  --container-narrow: 680px;  /* For text-heavy sections */
  --nav-height: 64px;

  /* Motion */
  --ease-out:   cubic-bezier(0.22, 1, 0.36, 1);
  --ease-in:    cubic-bezier(0.64, 0, 0.78, 0);
  --duration-fast:   150ms;
  --duration-base:   250ms;
  --duration-slow:   400ms;
  --duration-enter:  600ms;  /* Entrance animations */

  /* Borders */
  --radius-sm:  4px;
  --radius-md:  8px;
  --radius-lg:  12px;
  --radius-full: 9999px;

  /* Subtle border — used on all cards/sections */
  --border-subtle: 1px solid var(--accent-border);
}

/* ============================================================
   LAYER 2: RESET + BASE
   ============================================================ */

/* ============================================================
   LAYER 3: TYPOGRAPHY SYSTEM
   ============================================================ */

/* ============================================================
   LAYER 4: LAYOUT PRIMITIVES
   .container, .section, .grid-*, .stack-*
   ============================================================ */

/* ============================================================
   LAYER 5: COMPONENTS
   .nav, .hero, .about, .capabilities, .services, .social-proof, .cta, .contact, .footer
   Each section in its own comment block
   ============================================================ */

/* ============================================================
   LAYER 6: UTILITIES
   .sr-only, .visually-hidden, .animate-on-scroll, .is-visible
   ============================================================ */

/* ============================================================
   LAYER 7: REDUCED MOTION OVERRIDE
   Must be last — overrides everything above
   ============================================================ */
```

### Naming Convention

Use BEM for components, flat utility classes for one-off helpers.

```css
/* Component: block__element--modifier */
.nav {}
.nav__link {}
.nav__link--active {}

.hero {}
.hero__eyebrow {}   /* small label above headline */
.hero__title {}
.hero__sub {}
.hero__actions {}

.service-card {}
.service-card__label {}   /* monospace category tag */
.service-card__title {}
.service-card__body {}

/* Utility classes — prefixed with u- */
.u-mono {}      /* font-family: var(--font-mono) */
.u-dim {}       /* opacity: 0.5 */
.u-accent {}    /* color: var(--accent) */
```

---

## Section Breakdown

Seven sections, ordered to match the story flow: person → story → capabilities → services → proof → CTA → contact. Each has a specific structural purpose.

### Section 1: `<header>` — Fixed Navigation

**Purpose:** Orientation, never gets in the way.

**Structure:**
- Fixed top, full-width, `z-index: 100`
- Background: `rgba(10,10,10,0.85)` with `backdrop-filter: blur(12px)` — glass effect without full opacity
- Left: wordmark / name in `--font-mono`, small, no logo image
- Right: anchor links + GitHub icon + (optional) theme toggle removed in dark-first design
- Border bottom: `var(--border-subtle)` — barely visible separator
- Scroll behavior: at 0px, nav is fully transparent; after 80px scroll, glass background fades in via JS class toggle

**Dark design note:** On `#0a0a0a` page background, a `rgba(10,10,10,0.85)` nav is essentially invisible until scrolled. This creates a "the page IS the nav" feel above the fold.

### Section 2: `#hero` — Identity Statement

**Purpose:** Answer "who is this, why should I care" in under 5 seconds.

**Structure (left-text / right-portrait on desktop, stacked on mobile):**
```
[ Eyebrow: monospace small label — "Software Engineer & Consultant, Munich" ]
[ H1: name or bold value statement — 4rem, white ]
[ Sub: 1-2 sentence positioning — secondary text color ]
[ CTA row: primary button + ghost button ]
```

**Design specifics:**
- Background: `--bg-base` (#0a0a0a) with a very faint radial gradient (`radial-gradient(ellipse 80% 60% at 50% 0%, rgba(232,232,232,0.04) 0%, transparent 70%)`) — creates subtle depth without WebGL
- Portrait image: grayscale or very desaturated, `border-radius: var(--radius-lg)`, no box shadow (dark bg makes it pop naturally)
- The existing WebGL canvas (`#hero-canvas`) should be evaluated carefully — if it doesn't perform on low-end devices, replace with the CSS radial gradient approach above
- No animations blocking content — hero text is immediately visible, no fade-in on first paint

**Eyebrow pattern (monospace accent):**
```css
.hero__eyebrow {
  font-family: var(--font-mono);
  font-size: var(--text-sm);
  color: var(--text-tertiary);
  letter-spacing: 0.08em;
  text-transform: none; /* lowercase looks cleaner */
}
```

### Section 3: `#about` — Story / Background

**Purpose:** Brief personal narrative. Humanizes the capabilities listed next.

**Structure:**
- Narrow container (`--container-narrow`, 680px max)
- 2–3 short paragraphs. No headers needed — section label ("about" or "_about") in tiny monospace above
- One inline pull-quote or stat ("7 hackathons, 3 top placements in 2025") in accent color
- Background: `--bg-base` — same as hero, no visual break. The sections flow together.

**Key principle:** This section should feel like a page of a well-designed book, not a "box." No card wrapper, no border. Just text on dark.

### Section 4: `#capabilities` — Skills / Tech

**Purpose:** Scannable proof of what tools and domains are covered.

**Structure:**
- Section label (monospace, tertiary color): `// capabilities`
- H2: "What I Work With"
- Skill groups as rows, not icon grids:
  ```
  Languages     TypeScript · Python · PHP · SQL
  Infrastructure  Docker · CI/CD · GCP · Linux
  AI / ML       LangChain · OpenAI · RAG · Agents
  Web           React · Vanilla JS · CSS · REST APIs
  ```
- Each row: category label in `--font-mono` `--text-tertiary`, items in `--text-secondary`
- No skill bars, no percentages — they communicate nothing and look dated
- Background: `--bg-base`

**Dot separator pattern:**
```css
.capability-row {
  display: grid;
  grid-template-columns: 140px 1fr;
  gap: var(--space-4);
  padding: var(--space-3) 0;
  border-bottom: var(--border-subtle);
}
```

### Section 5: `#services` — What I Build

**Purpose:** Convert interest into action. Specific offerings, tangible outcomes.

**Structure:**
- 3 service cards in a grid (existing: AI & Automation, Websites & Hosting, DevOps Enablement)
- Cards on `--bg-surface` (#111111) against `--bg-base` (#0a0a0a) — subtle lift
- Each card: monospace category tag top-left, H3, 2-sentence description, no icon (remove emoji icons — they break the aesthetic)
- Stripe buy button lives here (existing — preserve)
- Background: `--bg-base` — no alternating white sections

**Card structure:**
```css
.service-card {
  background: var(--bg-surface);
  border: var(--border-subtle);
  border-radius: var(--radius-lg);
  padding: var(--space-8);
  /* No box-shadow — dark bg makes shadow invisible */
  /* Hover: border color brightens slightly */
  transition: border-color var(--duration-base) var(--ease-out);
}
.service-card:hover {
  border-color: rgba(232,232,232,0.20);
}
```

### Section 6: `#proof` — Social Proof (Hackathons / Awards)

**Purpose:** Demonstrate credibility without claiming it directly.

**Structure:**
- Existing event cards restructured as a compact list, not a large grid
- Group by significance: "Selected Highlights" (top 3-5 wins) in a featured strip, then a collapsed list or secondary grid for the rest
- LinkedIn + GitHub profile cards stay, but redesigned as slim horizontal rows (not center-aligned icon stacks)
- Education and work history moved here from the current #experience section
- Background: `--bg-surface` — this is the one section that shifts background to create visual rhythm

**Pattern for highlight items:**
```
2025 · Enactus Germany Worldcup · Bangkok         [ Winner ]
2025 · MSG Hackathon — Code & Create              [ Top 3  ]
2025 · Hack the Case | Celonis | Lovable          [ Top 2  ]
```
Monospace date + event name, right-aligned chip. Clean, data-table aesthetic.

### Section 7: `#contact` — CTA + Form

**Purpose:** Remove friction from reaching out. Single clear action.

**Structure:**
- Heading: direct and imperative ("Start a Project" or "Let's Work Together")
- 1-sentence subtext max
- Contact form: existing PHP form preserved, restyled for dark
- Form inputs: `background: var(--bg-elevated)`, `border: var(--border-subtle)`, focus state brightens border to `rgba(232,232,232,0.4)`
- No separate CTA section before the form — the heading IS the CTA

**Form dark-mode styles (existing dark overrides simplified):**
```css
.form-input,
.form-textarea {
  background: var(--bg-elevated);
  border: var(--border-subtle);
  color: var(--text-primary);
  border-radius: var(--radius-md);
  transition: border-color var(--duration-fast);
}
.form-input:focus,
.form-textarea:focus {
  border-color: rgba(232,232,232,0.4);
  outline: none;
}
```

### Footer

**Purpose:** Legal, links, nothing more.

**Structure:**
- 2 lines max: copyright + impressum/datenschutz links
- Background: `--bg-base` — blends with contact section
- Remove existing colored footer background — it breaks the dark consistency

---

## Dark Design System Specifics

### Background Layer Model

Three layers create perceived depth without color:

| Layer | Token | Value | Used For |
|-------|-------|-------|----------|
| Base | `--bg-base` | `#0a0a0a` | Page canvas, hero, about, capabilities, services CTA |
| Surface | `--bg-surface` | `#111111` | Cards, proof section background |
| Elevated | `--bg-elevated` | `#1a1a1a` | Form inputs, hover states |

**Rule:** Never use white, never use color fills on sections. Section separation comes from `--bg-base` vs `--bg-surface` alternation, not color blocking.

### Text Hierarchy

| Level | Token | Value | Used For |
|-------|-------|-------|----------|
| Primary | `--text-primary` | `#f0f0f0` | H1, H2, strong emphasis |
| Secondary | `--text-secondary` | `#a0a0a0` | Body copy, descriptions |
| Tertiary | `--text-tertiary` | `#5a5a5a` | Labels, metadata, monospace accents |
| Disabled | `--text-disabled` | `#333333` | Placeholders, inactive |

**Contrast check:** `#f0f0f0` on `#0a0a0a` = ~17:1 (exceeds WCAG AAA). `#a0a0a0` on `#0a0a0a` = ~7:1 (passes WCAG AA).

### Accent Color Strategy

A near-white (`#e8e8e8`) accent on dark backgrounds is more premium than a vivid color (cyan, purple, green) for a professional consulting brand. It signals restraint.

Reserve a single warm accent (the existing `#F87060` coral or a refined version) for exactly one use: the primary CTA button. One accent color, one use = maximum impact.

```css
/* Primary CTA — only place accent color appears */
.btn-primary {
  background: #e85d4a;   /* refined coral, less saturated than current #F87060 */
  color: #ffffff;
  border: none;
}
.btn-ghost {
  background: transparent;
  border: var(--border-subtle);
  color: var(--text-primary);
}
```

### Monospace Accent Deployment

Use `--font-mono` sparingly for code-adjacent credibility signals:

- Section labels: `// section_name` or `_section` in small monospace, tertiary color
- Capability categories: "Languages", "Infrastructure" labels
- Stats or data points: "7 hackathons · 3 wins · 2025"
- Nav wordmark (name/brand)

Do NOT use monospace for: body copy, service descriptions, form labels. Over-deployment kills the effect.

### Faint Background Texture (Optional)

A dot grid at extremely low opacity creates depth without WebGL:

```css
body::before {
  content: '';
  position: fixed;
  inset: 0;
  background-image: radial-gradient(
    circle,
    rgba(255,255,255,0.04) 1px,
    transparent 1px
  );
  background-size: 32px 32px;
  pointer-events: none;
  z-index: -1;
}
```

**Threshold:** If this is visible at arm's length from the screen, it's too strong. It should only be noticeable when you're looking for it.

---

## Animation Strategy

### Principle: Content First, Motion Second

The current WebGL canvas and existing animation JS (`animations.js` is empty — 1 line file) suggest intentions that weren't implemented. The redesign should implement animations that enhance without delaying.

**Hard rules:**
1. Hero text is visible on first paint — no opacity:0 entrance on H1
2. No animation that delays interactivity
3. Animations trigger on scroll, not on load
4. `prefers-reduced-motion: reduce` disables all animations (already in existing CSS — keep it)
5. No animation should run longer than 600ms

### Entrance Animation Pattern

Use `IntersectionObserver` in `scroll.js`. Add class `animate-on-scroll` to elements. When in viewport, add `is-visible`.

```css
/* Base state — barely visible, slightly below */
.animate-on-scroll {
  opacity: 0;
  transform: translateY(16px);
  transition:
    opacity var(--duration-enter) var(--ease-out),
    transform var(--duration-enter) var(--ease-out);
}

/* Triggered state */
.animate-on-scroll.is-visible {
  opacity: 1;
  transform: translateY(0);
}

/* Stagger children — add delay via inline style or nth-child */
.animate-on-scroll:nth-child(2) { transition-delay: 80ms; }
.animate-on-scroll:nth-child(3) { transition-delay: 160ms; }
.animate-on-scroll:nth-child(4) { transition-delay: 240ms; }

@media (prefers-reduced-motion: reduce) {
  .animate-on-scroll {
    opacity: 1;
    transform: none;
    transition: none;
  }
}
```

```javascript
// scroll.js — minimal IntersectionObserver
const observer = new IntersectionObserver(
  (entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
        observer.unobserve(entry.target); // fire once
      }
    });
  },
  { threshold: 0.1, rootMargin: '0px 0px -40px 0px' }
);

document.querySelectorAll('.animate-on-scroll').forEach((el) => {
  observer.observe(el);
});
```

### What Animates

| Element | Animation | Why |
|---------|-----------|-----|
| Section headings | Fade + translateY(16px) | Orients visitor as they scroll |
| Service cards | Staggered fade in | Grid items feel intentional, not dumped |
| Capability rows | Sequential fade | Implies a list being read |
| Event/proof cards | Staggered fade | Same as service cards |
| Nav | Background opacity on scroll | Glass effect, not jarring |
| CTA button | None at load, hover scale(1.02) | Micro-interaction only |

### What Does NOT Animate

| Element | Reason |
|---------|--------|
| Hero H1 | Content first — visible immediately |
| Form fields | Distracting during task-focused interaction |
| Footer | Below the fold, animation wasted |
| Navigation links | Should feel instant |
| Portrait image | Already the focal point, no need to add motion |

### Hover Micro-interactions

```css
/* Card hover — border brightens, no lift */
.service-card { transition: border-color var(--duration-base) var(--ease-out); }
.service-card:hover { border-color: rgba(232,232,232,0.25); }

/* Link hover — color shift, no underline jump */
a { transition: color var(--duration-fast) var(--ease-out); }

/* Button hover — very slight scale */
.btn-primary { transition: transform var(--duration-fast), opacity var(--duration-fast); }
.btn-primary:hover { transform: scale(1.02); opacity: 0.92; }
```

Avoid: `translateY(-4px)` card lifts — they feel light and toylike. Border brightening is more precise and premium.

---

## Build Order (Dependencies)

Each phase must be complete before the next is buildable or reviewable.

```
Phase 1: CSS Token Foundation
  ├── Establish :root token block in app.css
  ├── Remove all inline <style> blocks from index.php
  ├── Remove PHP $colors[] injection into CSS
  └── Verify: page renders with dark base, no missing variables

Phase 2: Layout Primitives + Typography
  ├── Container, section padding, grid helpers
  ├── Typography scale (h1–h4, body, mono)
  └── Verify: all existing text is readable, hierarchy clear

Phase 3: Navigation
  ├── Nav HTML structure (minimal — wordmark + 3 links + GitHub icon)
  ├── Nav CSS (fixed, glass, scroll-trigger class)
  ├── nav.js (scroll class toggle + mobile menu)
  └── Verify: nav works on mobile, scroll behavior correct

Phase 4: Hero Section
  ├── Hero HTML (eyebrow + H1 + sub + CTA row)
  ├── Hero CSS (full-height, radial gradient bg, portrait placement)
  ├── Decision: keep WebGL canvas or replace with CSS gradient (performance test)
  └── Verify: above-fold looks complete — this is what visitors see first

Phase 5: Content Sections (can be done in any order once Phase 2 complete)
  ├── #about — text section, minimal new CSS needed
  ├── #capabilities — grid/table layout, monospace row pattern
  ├── #services — card grid, dark card styles, Stripe button preserved
  └── #proof — event list, highlight strip, profile rows

Phase 6: Contact Section + Form
  ├── Form HTML preserved from existing (CSRF, honeypot, validation)
  ├── Dark form input styles
  ├── form.js — async submit (preserve existing PHP contact.php endpoint)
  └── Verify: form submits, errors display, success state works

Phase 7: Animation Layer
  ├── Add animate-on-scroll classes to section children
  ├── scroll.js IntersectionObserver
  ├── Verify: animations fire correctly, reduced-motion disables them
  └── Verify: no CLS (Cumulative Layout Shift) from animation starting states

Phase 8: Polish + Legal
  ├── Footer (2 lines — copyright + legal links)
  ├── Impressum / Datenschutz sections styled to match
  ├── Print styles (existing — keep)
  └── Final accessibility audit (focus states, contrast ratios)
```

**Critical dependency:** Phase 1 (CSS tokens) must be done before any other phase. Every section's CSS references these tokens. Building a section without them means doing the work twice.

**Independent:** Phases 5 (content sections) can run concurrently once Phase 2 is complete. They share the same token and primitive foundations but don't depend on each other.

**Do not skip to animations (Phase 7) early.** Animations on poorly structured content expose layout problems rather than hiding them.

---

## Anti-Patterns to Avoid

### Anti-Pattern 1: Alternating Section Backgrounds
**What it is:** Hero = dark, Services = white, Proof = dark, Contact = white...
**Why bad:** Destroys the premium dark aesthetic. Looks like a generic agency template.
**Instead:** Use `--bg-base` for most sections, `--bg-surface` for one section (proof/credentials) as the only visual break.

### Anti-Pattern 2: Emoji Service Icons
**What it is:** Current site uses 🤖, 🌐, ⚙️ as service card icons.
**Why bad:** Renders differently across OS/browser, inconsistent weight, breaks dark minimalism.
**Instead:** Remove icons entirely, or use a single SVG icon set (Lucide, Heroicons) at consistent 20px size. Or use the monospace category label as the visual anchor.

### Anti-Pattern 3: Multiple CSS Sources of Truth
**What it is:** Current site has `app.css` + `<style id="migrated-inline-styles">` + `<style>` (PHP injection).
**Why bad:** Impossible to know which rule wins without devtools, makes theming fragile.
**Instead:** `app.css` only. PHP color injection eliminated. Dark mode is the default — no theme toggle needed.

### Anti-Pattern 4: Overlaying Dark Theme on Light Foundation
**What it is:** Current `[data-theme='dark']` overrides patch a light-mode-first design.
**Why bad:** Creates specificity conflicts, requires 2x the CSS, dark overrides are always fighting the base.
**Instead:** Write dark-first from the start. If light mode is needed later, light is the override.

### Anti-Pattern 5: Scroll Animations on Every Element
**What it is:** Adding `animate-on-scroll` to every paragraph, every chip, every link.
**Why bad:** Feels janky, delays content, looks like a portfolio template from 2019.
**Instead:** Animate section-level containers and direct children only. 3–4 animated elements per section maximum.

### Anti-Pattern 6: Preserved PHP Color Injection
**What it is:** The `$colors[]` PHP array emitting CSS variables into `<style>` tags.
**Why bad:** Runtime color injection through PHP is fragile, complicates the CSS layer, and was designed for a theme-switching system that is being replaced.
**Instead:** Hardcode design tokens in `app.css`. Colors are a design decision, not a data value.

---

## Sources

- Direct analysis of `/client/src/index.php` (codebase — HIGH confidence)
- Direct analysis of `/client/src/assets/css/app.css` (codebase — HIGH confidence)
- CSS Custom Properties cascade behavior — established spec (HIGH confidence)
- IntersectionObserver API — well-documented Web API, widely supported (HIGH confidence)
- WCAG 2.1 contrast ratios — official spec (HIGH confidence)
- BEM naming methodology — established pattern (HIGH confidence)
- Performance principle "content first, motion second" — established best practice (HIGH confidence)
