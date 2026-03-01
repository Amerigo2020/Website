# Phase 3: Navigation & Layout Primitives — Research

**Researched:** 2026-03-02
**Domain:** HTML/CSS/JS — fixed navigation, hero section, footer, mobile menu
**Confidence:** HIGH — all findings from direct codebase inspection

---

## Summary

Phase 3 has three distinct jobs: (1) update navigation link labels and remove Impressum/Datenschutz from the nav, (2) rebuild the hero section so the portrait is visible above the fold alongside name, positioning statement, and CTA, and (3) verify the mobile menu covers the updated links and closes on nav. All prior phases are complete and verified. Phase 1 established the dark token foundation in app.css. Phase 2 rewrote all marketing copy to first-person English.

The current codebase is clean. There are no inline `<style>` blocks in index.php. app.css is the single CSS source of truth. The mobile menu JS is fully inline in index.php (no external file). Both `navigation.js` and `animations.js` in `assets/js/` are empty stub files (1 line, no content).

**Primary recommendation:** Make surgical changes — update nav link labels, add portrait slot to hero HTML, add `.hero--two-col` CSS layout, expand footer. Do not rebuild from scratch what works.

---

## Current State: Exact HTML Inventory

### Current Navigation HTML (index.php lines 248–294)

```html
<header class="header">
    <div class="container header__container">
        <a href="#home" class="logo" aria-label="Velletti Consulting Home">
            Velletti Consulting
        </a>

        <nav class="nav" role="navigation" aria-label="Main navigation">
            <a href="#services" class="nav__link">Services</a>
            <a href="#experience" class="nav__link">Events</a>
            <a href="#contact" class="nav__link">Contact</a>
        </nav>

        <div class="header__actions">
            <div class="social-buttons">
                <a id="btnLinkedIn" class="social-btn" ...><!-- LinkedIn SVG --></a>
                <a id="btnGitHub" class="social-btn" ...><!-- GitHub SVG --></a>
            </div>
        </div>

        <button class="mobile-menu-toggle" onclick="toggleMobileMenu()" aria-expanded="false">
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
```

**Key observations:**
- Logo text is "Velletti Consulting" — the ARCHITECTURE.md recommends changing to just the name wordmark in mono font, but this is constrained by the logo being the PHP config value. Existing CSS `.logo` already applies `--font-mono`. Keep as-is or change to "AV" or "Amerigo Velletti".
- Three current nav links: `#services`, `#experience`, `#contact` — labeled "Services", "Events", "Contact"
- NO Impressum or Datenschutz links in nav — they already only exist in the footer (lines 696–698). NAV-02 is already satisfied. Verify confirms this before any work.
- Social buttons (LinkedIn, GitHub) are in `.header__actions` — these open modals. Decided: keep in nav.
- Mobile menu toggle uses `onclick="toggleMobileMenu()"` — inline JS defined at lines 751–765 of index.php.

**What NAV-01 requires:** Change link labels:
- `#services` → label "What I build" (matches the section h2 at line 316)
- `#experience` → label "About" (maps to "Background & Proof" section at line 345, id="experience")
- `#contact` → label "Contact" (no change needed)

**Section IDs currently in index.php:**
| Section | ID | Current h2 |
|---------|-----|-----------|
| Hero | `home` | (no h2, has h1) |
| Services | `services` | "What I build" |
| Experience/Background | `experience` | "Background & Proof" |
| Contact | `contact` | "Start a conversation" |
| Legal | `impressum` | "Impressum" |
| Legal | `privacy` | "Datenschutzerklärung" |

The nav anchor hrefs must match existing section IDs. Do NOT change section IDs — that would break scroll behavior.

### Current Hero HTML (index.php lines 297–311)

```html
<section id="home" class="section section--hero">
    <div class="container">
        <div class="hero__content">
            <h1 class="hero__title">I build complete systems — from backend to UI — for startups
            that need one person to own the technical side.</h1>
            <p class="hero__subtitle">
                From the first conversation to production. I own the architecture, the code,
                and the deployment — so you don't have to manage a developer.
            </p>
            <div style="display: flex; gap: var(--spacing-sm); justify-content: center; flex-wrap: wrap;">
                <a href="#contact" class="cta-button" role="button">Start a project</a>
                <a href="#services" class="cta-button cta-button--outline" role="button">What I build</a>
            </div>
        </div>
    </div>
</section>
```

**Key observations:**
- No portrait `<img>` slot exists. SEC-01 requires portrait visible without scrolling.
- The CTA row uses `style="display: flex; gap: var(--spacing-sm);"` — uses `--spacing-sm` which does NOT exist in the current token system (tokens use `--space-2`, `--space-4` etc). This is a broken token reference. Fix in this phase.
- `class="cta-button cta-button--outline"` — `cta-button--outline` has NO CSS rule in app.css. Ghost button has no visual distinction from primary. Must add CSS for this modifier.
- `.hero__content` is centered, single column with `max-width: 900px; margin: 0 auto`.
- `.section--hero` CSS (lines 187–193 of app.css): `min-height: 100vh; display: flex; align-items: center;` — the section already fills the viewport. The portrait just needs to be added inside it.
- Current h1 copy (approved in Phase 2): "I build complete systems — from backend to UI — for startups that need one person to own the technical side."

**Portrait asset:** `assets/portrait.jpg` confirmed present (also `portrait.png`). Use `portrait.jpg`.

### Current Footer HTML (index.php lines 678–701)

```html
<footer class="footer">
    <div class="container">
        <div class="footer__content">
            <div class="footer__contact">
                <p><strong>Velletti Consulting</strong></p>
                <p>Munich, Bavaria, Germany</p>
                <p>Phone: <a href="tel:+49...">+49 176 45531533</a></p>
                <p>Email: <a href="mailto:...">vel-consulting@ame.velletti.de</a></p>
            </div>
            <p>&copy; 2026 Velletti Consulting. All rights reserved.</p>
            <p>
                <a href="#impressum">Impressum</a> ·
                <a href="#privacy">Datenschutz</a>
            </p>
        </div>
    </div>
</footer>
```

**Key observations:**
- Impressum and Datenschutz links are ALREADY in the footer (lines 696–698). NAV-02 is a verification task, not a build task.
- The footer has contact info (name, address, phone, email) which is fine for legal compliance.
- `.footer` CSS (app.css lines 490–516): `background: var(--bg-surface)` — this needs to change to `var(--bg-base)` per ARCHITECTURE.md ("blends with contact section").
- The footer is reasonably slim already. No major restructuring needed.

### Current Mobile Menu JS (index.php lines 750–775)

```javascript
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

// Close on outside click
document.addEventListener('click', function(event) {
    const menu = document.getElementById('mobileMenu');
    const toggle = document.querySelector('.mobile-menu-toggle');
    if (!toggle.contains(event.target) && !menu.contains(event.target)) {
        closeMobileMenu();
    }
});
```

**Key observations:**
- JS is inline in index.php, NOT in navigation.js (navigation.js is empty stub).
- Toggle uses `menu.style.display` — this works but is fragile (initial state is `""` not `"none"`, so `isOpen` is false on first call, which is correct).
- Each `<a>` in mobile menu has `onclick="closeMobileMenu()"` already — clicking a link closes the menu.
- `aria-expanded` is set correctly.
- After updating nav links, the mobile menu `<nav>` block must receive the same updated labels as the desktop nav. No JS changes needed — just HTML label updates.

---

## Standard Stack

No external libraries needed for this phase. All changes are vanilla HTML/CSS/JS.

| Tool | Version | Purpose |
|------|---------|---------|
| CSS Custom Properties | N/A (browser built-in) | All tokens already defined in app.css :root |
| CSS Grid | N/A (browser built-in) | Hero two-column layout |
| CSS Flexbox | N/A (browser built-in) | Nav layout (already used) |
| `backdrop-filter: blur()` | N/A (browser built-in) | Nav glassmorphism (already in app.css) |
| IntersectionObserver | N/A (browser built-in) | Nav scroll transparency (optional enhancement) |

**Installation:** None required.

---

## Architecture Patterns

### Nav Link Mapping (NAV-01)

The redesigned section structure per Phase 2 and ARCHITECTURE.md:

| Section | ID | New Nav Label | Old Nav Label |
|---------|-----|--------------|--------------|
| Hero | `#home` | (logo link, not in nav) | — |
| Background & Proof | `#experience` | About | Events |
| What I build | `#services` | What I build | Services |
| Start a conversation | `#contact` | Contact | Contact |
| Impressum | `#impressum` | (footer only) | (already footer only) |
| Datenschutz | `#privacy` | (footer only) | (already footer only) |

**Nav order:** About | What I build | Contact — left to right, matching page scroll order.

### Proposed New Nav HTML

Exact replacement for lines 254–258 (desktop nav) and lines 287–291 (mobile nav):

```html
<!-- Desktop nav (replace existing <nav> block) -->
<nav class="nav" role="navigation" aria-label="Main navigation">
    <a href="#experience" class="nav__link">About</a>
    <a href="#services" class="nav__link">What I build</a>
    <a href="#contact" class="nav__link">Contact</a>
</nav>

<!-- Mobile nav (replace existing mobile <nav> block) -->
<nav class="nav" role="navigation" aria-label="Mobile navigation">
    <a href="#experience" class="nav__link" onclick="closeMobileMenu()">About</a>
    <a href="#services" class="nav__link" onclick="closeMobileMenu()">What I build</a>
    <a href="#contact" class="nav__link" onclick="closeMobileMenu()">Contact</a>
</nav>
```

**No changes needed to:** logo, header__actions, social buttons, mobile-menu-toggle button, mobile-menu div wrapper, mobile menu JS.

### Hero Section — Proposed New HTML Structure

SEC-01 requires: photo visible without scrolling, name, positioning statement (CP-02), primary CTA.

The current hero has H1 = positioning statement (already approved in Phase 2). "Name" needs to be added as an eyebrow or sub-element. The portrait needs a slot.

**Two-column layout (desktop):** Portrait right, text left. Stacked on mobile (text first, portrait below).

```html
<section id="home" class="section section--hero">
    <div class="container">
        <div class="hero__grid">
            <div class="hero__text">
                <p class="hero__eyebrow">Amerigo Velletti · Munich</p>
                <h1 class="hero__title">I build complete systems — from backend to UI — for startups that need one person to own the technical side.</h1>
                <p class="hero__subtitle">
                    From the first conversation to production. I own the architecture, the code,
                    and the deployment — so you don't have to manage a developer.
                </p>
                <div class="hero__actions">
                    <a href="#contact" class="btn btn--primary">Start a project</a>
                    <a href="#services" class="btn btn--ghost">What I build</a>
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
```

**Key decisions in this structure:**
- `hero__grid` replaces `hero__content` — becomes a CSS Grid two-column wrapper.
- `hero__eyebrow` — monospace small label with name + location. The H1 is the positioning statement, not the name. This satisfies SEC-01 "name" requirement.
- `hero__text` — left column, contains all text and CTAs.
- `hero__portrait-wrap` — right column, contains portrait with aspect-ratio container.
- `btn btn--primary` / `btn btn--ghost` — replace the old `cta-button` / `cta-button--outline` class names. This fixes the broken `--spacing-sm` token reference and the missing `cta-button--outline` CSS.
- `loading="eager"` — portrait is above the fold; eager is correct (not lazy).
- `width="400" height="500"` — explicit dimensions prevent layout shift. Aspect ratio is portrait-oriented.

### CSS Additions Required

The following CSS must be added to app.css. Group under a `/* === HERO === */` comment block.

#### Hero Grid Layout

```css
/* Hero two-column grid */
.hero__grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: var(--space-16);
  align-items: center;
}

.hero__text {
  display: flex;
  flex-direction: column;
  gap: var(--space-6);
}

/* Eyebrow — monospace name label */
.hero__eyebrow {
  font-family: var(--font-mono);
  font-size: var(--text-sm);
  color: var(--text-tertiary);
  letter-spacing: 0.06em;
  margin-bottom: 0;
}

/* Portrait container */
.hero__portrait-wrap {
  display: flex;
  justify-content: center;
  align-items: center;
}

.hero__portrait {
  width: 100%;
  max-width: 380px;
  height: auto;
  border-radius: var(--radius-lg);
  display: block;
  /* No box-shadow — dark bg makes portrait pop naturally */
}

/* Hero actions row */
.hero__actions {
  display: flex;
  gap: var(--space-4);
  flex-wrap: wrap;
}
```

#### Button System (replace cta-button)

The current `cta-button` and `cta-button--outline` classes have no outline variant CSS. Replace with proper two-class system:

```css
/* Primary button */
.btn--primary {
  display: inline-block;
  background: var(--accent);
  color: var(--bg-base);
  padding: var(--space-4) var(--space-8);
  border-radius: var(--radius-md);
  font-weight: 600;
  font-size: var(--text-base);
  text-decoration: none;
  transition: opacity var(--duration-fast) var(--ease-out),
              transform var(--duration-fast) var(--ease-out);
}

.btn--primary:hover,
.btn--primary:focus {
  opacity: 0.88;
  transform: scale(1.02);
  outline: 2px solid var(--accent);
  outline-offset: 2px;
  color: var(--bg-base);
}

/* Ghost button */
.btn--ghost {
  display: inline-block;
  background: transparent;
  color: var(--text-primary);
  padding: var(--space-4) var(--space-8);
  border-radius: var(--radius-md);
  font-weight: 500;
  font-size: var(--text-base);
  text-decoration: none;
  border: 1px solid var(--border-subtle);
  transition: border-color var(--duration-fast) var(--ease-out),
              color var(--duration-fast) var(--ease-out);
}

.btn--ghost:hover,
.btn--ghost:focus {
  border-color: rgba(255,255,255,0.25);
  color: var(--text-primary);
  outline: 2px solid var(--accent);
  outline-offset: 2px;
}
```

**Note:** The old `.cta-button` class is used in ONE other place: the LinkedIn fallback modal (`<a class="cta-button" href="...">Open on LinkedIn</a>` at line 726) and the GitHub initGitHub function JS (line 880). Do NOT remove the old `.cta-button` rule. Add `.btn--primary` and `.btn--ghost` as new classes. The old class stays for backward compatibility in the modals.

#### Mobile Hero Layout

```css
@media (max-width: 768px) {
  .hero__grid {
    grid-template-columns: 1fr;
    gap: var(--space-8);
  }

  /* On mobile: portrait renders below text */
  .hero__portrait-wrap {
    order: 2;
  }

  .hero__text {
    order: 1;
  }

  .hero__portrait {
    max-width: 240px;
    margin: 0 auto;
  }

  .hero__actions {
    flex-direction: column;
  }

  .hero__actions .btn--primary,
  .hero__actions .btn--ghost {
    text-align: center;
    width: 100%;
  }
}
```

#### Section Hero Height Fix (Mobile)

Current app.css line 548–551:
```css
.section--hero {
  padding: calc(80px + var(--space-8)) 0 var(--space-12);
  min-height: auto;
}
```

The `min-height: auto` on mobile already removes the 100vh constraint, which is correct. Keep as-is.

#### Nav CSS — No Changes Required

The current nav CSS in app.css is already correct:
- `.header` (lines 196–206): `position: fixed; backdrop-filter: blur(10px); background: rgba(10,10,10,0.95); border-bottom: 1px solid var(--border-subtle);` — glassmorphism already implemented.
- `.nav` (lines 228–231): `display: flex; gap: var(--space-8);`
- `.nav__link` (lines 233–245): proper hover states.
- Mobile media query (lines 519–521): `display: none` on `.nav` at `max-width: 768px` — already correct.

**No nav CSS changes are needed.** Only HTML label text changes.

#### Footer CSS Change

```css
/* Change .footer background from --bg-surface to --bg-base */
/* Current (line 491): background: var(--bg-surface); */
/* Change to: */
.footer {
  background: var(--bg-base);   /* was var(--bg-surface) */
}
```

---

## Don't Hand-Roll

| Problem | Don't Build | Use Instead | Why |
|---------|-------------|-------------|-----|
| Scroll-triggered nav transparency | Custom scroll event listener throttling | IntersectionObserver on a sentinel element | IO is more performant than scroll events; already recommended in ARCHITECTURE.md |
| Portrait aspect ratio | Padding-hack or JavaScript sizing | `aspect-ratio: 4/5` CSS property | Supported in all modern browsers; eliminates layout shift |
| Mobile menu animation | JS-driven height animation | `CSS max-height` transition from 0 to auto | No JS required; simpler; respects reduced-motion |
| Ghost button border | SVG border or box-shadow trick | CSS `border: 1px solid var(--border-subtle)` | Direct, readable, composable |

---

## Common Pitfalls

### Pitfall 1: Changing Section IDs and Breaking Scroll Links

**What goes wrong:** If `id="experience"` is renamed to `id="about"` or `id="background"`, all existing anchor links `href="#experience"` break silently. Smooth scroll stops working. Any external links to `#experience` also break.
**Why it happens:** The natural instinct is to align IDs with new section labels. But section IDs are anchor targets used throughout the file.
**How to avoid:** ONLY change nav link display text and href targets. Do NOT change the `id` attributes on section elements unless the plan explicitly calls for it.
**Warning signs:** Run `grep -n "href=\"#experience\"\|href=\"#services\"\|href=\"#contact\"\|href=\"#home\"" index.php` before and after — counts must match.

### Pitfall 2: Removing cta-button class and Breaking Modal Fallback

**What goes wrong:** The LinkedIn fallback div (line 726) and GitHub JS (line 880) use class `cta-button`. If you delete the `.cta-button` CSS rule while switching the hero to `btn--primary`, the modal buttons lose all styling.
**Why it happens:** The class appears in hero HTML, suggesting it's hero-specific, but it's also used in dynamically inserted modal content.
**How to avoid:** Retain `.cta-button` CSS rule in app.css. Add `.btn--primary` and `.btn--ghost` as new classes. Update ONLY the hero HTML to use the new classes.

### Pitfall 3: portrait loading="lazy" Above the Fold

**What goes wrong:** Setting `loading="lazy"` on the portrait means the browser defers loading until the image is near the viewport. Since the portrait IS in the viewport on first load, this causes a visible blank space during page load.
**Why it happens:** Lazy loading is a best practice for below-fold images, incorrectly applied to above-fold images.
**How to avoid:** Use `loading="eager"` on `hero__portrait`. Use `decoding="async"` which is safe for all images.

### Pitfall 4: Broken --spacing-sm Token Reference

**What goes wrong:** The current hero CTA div uses `style="gap: var(--spacing-sm);"`. The token `--spacing-sm` does NOT exist in the current app.css :root block. The gap silently falls back to 0.
**Why it happens:** Legacy code from before the Phase 1 token cleanup.
**How to avoid:** Remove the inline style entirely. Move the flex behavior to `.hero__actions` CSS class (which is part of this phase's work anyway).

### Pitfall 5: hero__title gradient clip on Mobile

**What goes wrong:** The current `.hero__title` CSS uses `-webkit-background-clip: text; -webkit-text-fill-color: transparent;` for a gradient text effect. On some Android browsers, this clips incorrectly when the element wraps to multiple lines.
**Why it happens:** The gradient text technique using `-webkit-text-fill-color` is broadly supported but has edge cases on line wraps.
**How to avoid:** Test on mobile viewport. If clipping occurs, replace with `color: var(--text-primary)` and remove the gradient. The positioning statement is content — readability trumps decoration. Alternatively: keep the gradient but set an explicit `background-size: 200% 100%` to control the gradient across wrapped lines.

### Pitfall 6: NAV-02 Verification Before Any Changes

**What goes wrong:** Assuming NAV-02 (move legal links to footer) requires work when they are already in the footer only. Doing unnecessary work.
**How to avoid:** Before touching the footer, verify: `grep -n "impressum\|privacy\|Impressum\|Datenschutz" index.php` and confirm all matches inside the nav range (lines 248–294) are zero. They already are — NAV-02 is purely a verification step, not a build step.

---

## Code Examples

### Mobile-Responsive Hero Grid

```css
/* Source: Direct codebase analysis + CSS Grid specification */

/* Desktop: two column */
.hero__grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: var(--space-16);
  align-items: center;
}

/* Mobile: single column, text above portrait */
@media (max-width: 768px) {
  .hero__grid {
    grid-template-columns: 1fr;
    gap: var(--space-8);
  }
  .hero__portrait-wrap { order: 2; }
  .hero__text { order: 1; }
}
```

### Portrait with Aspect Ratio

```css
/* Source: CSS spec — aspect-ratio supported since Chrome 88, Firefox 89, Safari 15 */
.hero__portrait {
  width: 100%;
  max-width: 380px;
  height: auto;
  aspect-ratio: 4 / 5;        /* optional — explicit width/height on img handles this */
  border-radius: var(--radius-lg);
  object-fit: cover;
  display: block;
}
```

### Nav Scroll Transparency (Optional Enhancement)

This is not in the requirements but referenced in ARCHITECTURE.md. Include only if time permits; it is not a blocker for NAV-01, NAV-02, NAV-03, SEC-01.

```javascript
// Optional: add to navigation.js (currently empty stub)
// Adds .header--scrolled class when page scrolled > 80px
const header = document.querySelector('.header');
const onScroll = () => {
  if (window.scrollY > 80) {
    header.classList.add('header--scrolled');
  } else {
    header.classList.remove('header--scrolled');
  }
};
window.addEventListener('scroll', onScroll, { passive: true });
```

```css
/* CSS companion — in app.css */
/* At 0 scroll: nav is near-invisible on dark bg */
.header {
  background: rgba(10, 10, 10, 0);   /* transparent at top */
  transition: background var(--duration-base) var(--ease-out);
}
.header--scrolled {
  background: rgba(10, 10, 10, 0.95); /* glass on scroll */
}
```

**Warning:** This changes the `.header` background from static to dynamic. The current static `rgba(10,10,10,0.95)` already works fine. Only implement if explicitly wanted.

---

## State of the Art

| Old Approach | Current/New Approach | Impact |
|--------------|---------------------|--------|
| `cta-button--outline` with no CSS | `btn--ghost` with explicit border | Ghost button actually visible |
| `style="gap: var(--spacing-sm)"` inline | `.hero__actions { gap: var(--space-4) }` in app.css | Token uses correct name; no broken reference |
| Portrait absent from hero | `<img class="hero__portrait">` in `.hero__grid` right column | SEC-01 satisfied |
| Nav: "Services", "Events" | Nav: "What I build", "About" | Labels match actual content (NAV-01) |
| Footer: `background: var(--bg-surface)` | Footer: `background: var(--bg-base)` | Dark consistency — footer blends with contact |

---

## Open Questions

1. **Logo text: keep "Velletti Consulting" or change?**
   - What we know: Current logo text is PHP config value `$config['company_name']` = "Velletti Consulting". ARCHITECTURE.md suggests wordmark in mono font (already applied via `.logo { font-family: var(--font-mono) }`).
   - What's unclear: Whether the planner wants "Velletti Consulting", "AV", "Amerigo Velletti", or just "AV" as a mono logotype.
   - Recommendation: Keep "Velletti Consulting" — changing it requires a PHP config value change and raises brand consistency questions beyond this phase's scope.

2. **Portrait: jpg or png?**
   - What we know: Both `portrait.jpg` and `portrait.png` exist in `assets/`.
   - Recommendation: Use `portrait.jpg` — smaller file size, sufficient for photos. `portrait.png` is lossless and likely larger without visual benefit for a photographic image.

3. **Nav scroll transparency enhancement: in scope or deferred?**
   - What we know: `navigation.js` is an empty stub file. ARCHITECTURE.md describes the scroll transparency enhancement. NAV-03 only says "verify mobile-responsive layout holds."
   - Recommendation: Defer to Phase 7 (animation layer). Phase 3 focus is labels and hero — the static glassmorphism nav already works.

---

## Sources

### Primary (HIGH confidence)

- Direct analysis of `client/src/index.php` lines 142–924 — nav HTML (248–294), hero HTML (297–311), footer HTML (678–701), mobile menu JS (750–775)
- Direct analysis of `client/src/assets/css/app.css` lines 1–848 — nav CSS (196–280), hero CSS (281–333), footer CSS (489–516), mobile breakpoint (519–557)
- `.planning/phases/01-css-foundation-reset/01-VERIFICATION.md` — confirms token system is live, dark mode established, no inline styles
- `.planning/phases/02-copy-and-voice-rewrite/02-VERIFICATION.md` — confirms all section h2 copy, section IDs, approved H1 copy
- `client/src/assets/js/navigation.js` — confirmed empty (1-line stub)
- `client/src/assets/js/animations.js` — confirmed empty (1-line stub)
- `client/src/assets/` directory listing — confirms `portrait.jpg` and `portrait.png` both exist

### Secondary (MEDIUM confidence)

- `.planning/research/ARCHITECTURE.md` — nav structure recommendations, hero layout pattern, footer minimization guidance

---

## Metadata

**Confidence breakdown:**
- Current HTML structure: HIGH — read directly from file with line numbers
- Current CSS rules: HIGH — read directly from app.css
- Proposed new HTML: HIGH — derived directly from existing patterns and confirmed section IDs
- Proposed new CSS: HIGH — uses only tokens already defined in :root; no new tokens needed
- Mobile responsiveness: HIGH — existing breakpoints at 768px already defined and working
- NAV-02 status (already satisfied): HIGH — grep of nav range confirms zero legal link matches

**Research date:** 2026-03-02
**Valid until:** 2026-04-01 (stable codebase — no active changes between phases)
