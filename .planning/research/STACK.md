# Technology Stack

**Project:** Velletti — Personal Brand & Consulting Site
**Researched:** 2026-03-01
**Confidence:** HIGH (verified against existing codebase + established browser standards; external tool access unavailable during this session)

---

## Context: What the Codebase Already Has

Reading the existing code before making recommendations:

- **CSS custom properties system** — `app.css` already defines a `:root` token layer. The foundation is right, the values are wrong for dark-first.
- **Light-first color palette** — Currently `#F7F7FF` background, coral primary `#F87060`, navy secondary `#102542`. All of this changes.
- **Dark theme toggle** — `[data-theme='dark']` on `:root` partially implemented, but dark should be the permanent default, not a toggle.
- **System font stack** — No external fonts loaded. This is the most visible gap relative to the design goal.
- **Empty JS modules** — `animations.js`, `webgl.js`, `theme-manager.js`, `navigation.js` all exist but are 1-line empty files. Stubs to be implemented.
- **Contact form** — Production-quality (CSRF, honeypot, rate limiting, AJAX + HTML fallback). Keep as-is.
- **No booking integration** — Not yet implemented. Calendly embed is the right call.
- **No build toolchain** — Intentional. Keep it. Everything via CDN or inline.

---

## Recommended Stack

### Color System

| Token | Value | Purpose |
|-------|-------|---------|
| `--bg-base` | `#0A0A0F` | Page background — near-black with faint blue cast, not pure black |
| `--bg-surface` | `#111118` | Cards, sections — slightly lifted from base |
| `--bg-border` | `rgba(255,255,255,0.07)` | Subtle dividers, card borders |
| `--text-primary` | `#E8E8F0` | Body text — warm white, not `#ffffff` |
| `--text-secondary` | `#7A7A90` | Captions, metadata, subtext |
| `--text-muted` | `#3A3A50` | Placeholder text, disabled states |
| `--accent` | `#6EE7B7` | Primary accent — mint green, reads "technical, clean" without overdone cyan |
| `--accent-dim` | `rgba(110,231,183,0.12)` | Accent glow backgrounds, hover states |
| `--mono-highlight` | `#4ADE80` | Code-adjacent accents in monospace contexts |

**Rationale for mint/green over cyan:** Cyan (`#00E5FF`) reads "sci-fi" or "late 2010s hacker aesthetic" and is overused. Desaturated mint green lands in the same technical territory but feels less dated and more trustworthy. Think Vercel, Linear, Resend — the current crop of high-craft developer tools trends toward muted greens and whites on near-black, not electric cyan.

**Why `#0A0A0F` not `#000000`:** Pure black shows banding artifacts and feels harsh. Near-black with a blue cast (`#0A0A0F` or `#0D0D14`) is the current convention. Reference: GitHub's dark mode (`#0d1117`), Linear, Vercel.

**Confidence:** HIGH — based on direct inspection of the existing token system and established conventions in the developer tools design space.

---

### Typography

#### Primary Display Font — Inter

| Property | Value |
|----------|-------|
| Font | **Inter** |
| Source | Google Fonts CDN |
| Load | Variable font — `Inter:wght@300..800` |
| Use | All body copy, UI labels, headings |

**Why Inter:** Inter is the dominant choice for technical SaaS and developer-focused sites as of 2025. It was purpose-designed for screen legibility, has excellent numerical tabular figures, and reads "engineered" without requiring stylistic effort. It outperforms system font stacks in perceived quality at a CDN cost of ~40KB for the variable weight range.

**Not Roboto, not Outfit, not Plus Jakarta Sans** — these are common but lack Inter's optical refinement at small sizes. Not custom/paid fonts — unnecessary overhead for a personal brand site.

#### Monospace Accent Font — JetBrains Mono

| Property | Value |
|----------|-------|
| Font | **JetBrains Mono** |
| Source | Google Fonts CDN |
| Load | `JetBrains+Mono:wght@400;500` (two weights only) |
| Use | Code snippets, capability tags, section labels, `<pre>` elements, decorative CLI-style text fragments |

**Why JetBrains Mono:** It has ligatures, deliberate thick strokes for screen rendering, and an immediately recognizable programmer aesthetic. Alternatives — Fira Code, IBM Plex Mono — are also good. JetBrains Mono wins because it has slightly more visual weight, making it easier to use as a display element (not just inline code), which is exactly the "subtle code aesthetic" goal.

**Scope the monospace font carefully.** It is a seasoning, not a base. Apply it to:
- Section eyebrow labels (`// about`, `> capabilities`)
- Inline technical tags / capability chips
- Decorative fragments in the hero (short, not paragraphs)
- Timestamps and metadata
- Not for body copy or headings

**Google Fonts CDN load line:**
```html
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300..800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
```

**Confidence:** HIGH — Google Fonts is current and stable; both fonts are actively maintained as of 2025.

---

### CSS Architecture

#### Approach: Design Tokens + BEM Component Classes

The existing codebase already uses CSS custom properties for a token layer and BEM-adjacent class naming. Extend this pattern rather than replace it.

**Token Layer — `:root` (dark-first, always)**

Drop the `[data-theme='dark']` toggle system entirely. Dark is permanent. The existing toggle mechanism adds maintenance cost with no benefit for a dark-only site. Strip it.

```css
:root {
  /* Color */
  --bg-base:    #0A0A0F;
  --bg-surface: #111118;
  --bg-border:  rgba(255,255,255,0.07);

  /* Text */
  --text-primary:   #E8E8F0;
  --text-secondary: #7A7A90;
  --text-muted:     #3A3A50;

  /* Accent */
  --accent:          #6EE7B7;
  --accent-dim:      rgba(110,231,183,0.12);
  --accent-glow:     rgba(110,231,183,0.06);
  --mono-highlight:  #4ADE80;

  /* Typography */
  --font-sans:  'Inter', system-ui, sans-serif;
  --font-mono:  'JetBrains Mono', 'Fira Code', monospace;

  /* Scale */
  --text-xs:    0.75rem;   /* 12px — labels, tags */
  --text-sm:    0.875rem;  /* 14px — metadata, captions */
  --text-base:  1rem;      /* 16px — body */
  --text-lg:    1.125rem;  /* 18px — lead text */
  --text-xl:    1.25rem;   /* 20px */
  --text-2xl:   1.5rem;    /* 24px */
  --text-3xl:   1.875rem;  /* 30px */
  --text-4xl:   2.25rem;   /* 36px */
  --text-5xl:   3rem;      /* 48px — hero headline */

  /* Spacing (8px base) */
  --space-1:  0.25rem;
  --space-2:  0.5rem;
  --space-3:  0.75rem;
  --space-4:  1rem;
  --space-6:  1.5rem;
  --space-8:  2rem;
  --space-12: 3rem;
  --space-16: 4rem;
  --space-24: 6rem;

  /* Layout */
  --max-width:       1100px;
  --max-width-prose: 680px;

  /* Motion */
  --ease-out:   cubic-bezier(0.16, 1, 0.3, 1);
  --ease-in:    cubic-bezier(0.4, 0, 1, 1);
  --duration-fast:   150ms;
  --duration-normal: 300ms;
  --duration-slow:   500ms;

  /* Borders */
  --radius-sm:  4px;
  --radius-md:  8px;
  --radius-lg:  12px;
}
```

**Specific CSS Techniques to Use**

1. **CSS Grid for the story flow layout** — Each section is a full-width row. Use `display: grid` with named areas for the hero and capability sections. Avoids flexbox nesting complexity.

2. **Faint grid/dot background** — Achievable with pure CSS, no image:
   ```css
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
   This creates the subtle technical grid without any images or JS. The opacity must stay very low — 0.025 to 0.04. Higher values look like graph paper, not craft.

3. **Accent glow on hover** — Use `box-shadow` with the `--accent-glow` token:
   ```css
   .card:hover {
     border-color: var(--accent);
     box-shadow: 0 0 0 1px var(--accent-dim), 0 8px 32px var(--accent-glow);
   }
   ```

4. **Monospace section labels** — Eyebrow text above section headings:
   ```html
   <span class="eyebrow">// about</span>
   <h2>The person behind the work</h2>
   ```
   ```css
   .eyebrow {
     font-family: var(--font-mono);
     font-size: var(--text-xs);
     letter-spacing: 0.1em;
     color: var(--accent);
     text-transform: lowercase;
     display: block;
     margin-bottom: var(--space-2);
   }
   ```

5. **Scroll-driven fade-in** — Use `IntersectionObserver` in vanilla JS (see Animation section). No library needed.

6. **`text-wrap: balance`** — Apply to all headings. Native browser feature (Chrome 114+, Firefox 121+, Safari 17.4+). Makes multi-line headings break at natural reading units:
   ```css
   h1, h2, h3 { text-wrap: balance; }
   ```

7. **Logical properties** — Use `padding-inline`, `margin-block` etc. for cleaner responsive behavior on the text-heavy content sections.

**Confidence:** HIGH — all are stable, widely-supported CSS features.

---

### Animation Approach

**Recommendation: Vanilla JS IntersectionObserver + CSS transitions. Zero animation libraries.**

**Why no library:**

- Animate.css (~80KB, ~100 animations) — 97% of it unused for a personal site. Adds load for nothing.
- GSAP — Powerful but adds JS complexity and a license consideration for commercial projects. Overkill for scroll reveals and hover states.
- Motion One / Web Animations API — Worth knowing, but the motion requirements here don't justify the learning/maintenance overhead.
- AOS (Animate On Scroll) — Popular but uses JS to add/remove classes, which requires careful `prefers-reduced-motion` handling. Doing this manually in ~30 lines is less risky.

**The motion budget for a minimal personal brand site:**
1. Scroll-triggered fade + translate-up for sections (staggered)
2. Hover glow on cards and CTA buttons
3. Nav underline slide on active
4. Possibly: a blinking cursor in the hero

All of these are achievable with CSS transitions and a 30-line IntersectionObserver. No library is worth the dependency.

**Vanilla IntersectionObserver pattern:**
```javascript
// animations.js
const observer = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
      entry.target.classList.add('visible');
      observer.unobserve(entry.target); // fire once
    }
  });
}, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

document.querySelectorAll('[data-reveal]').forEach((el) => {
  observer.observe(el);
});
```

```css
[data-reveal] {
  opacity: 0;
  transform: translateY(24px);
  transition: opacity var(--duration-slow) var(--ease-out),
              transform var(--duration-slow) var(--ease-out);
}

[data-reveal].visible {
  opacity: 1;
  transform: translateY(0);
}

/* Stagger via CSS delay */
[data-reveal]:nth-child(2) { transition-delay: 100ms; }
[data-reveal]:nth-child(3) { transition-delay: 200ms; }

/* Always respect user preference */
@media (prefers-reduced-motion: reduce) {
  [data-reveal] {
    opacity: 1;
    transform: none;
    transition: none;
  }
}
```

**One legitimate CDN library to consider: particles.js or tsParticles**

If the hero calls for a dynamic background, `tsParticles` (~50KB min+gzip) is CDN-deliverable and produces the kind of subtle particle/dot-field that reads "developer" without being tacky. This is optional — a pure CSS grid background (described above) is the safer, more polished choice. Only add particles if the design explicitly calls for them. More likely to look overdone than to add value.

**Recommendation: Do not add tsParticles.** The CSS grid background is more refined.

**Confidence:** HIGH — all recommendations are native browser APIs or established vanilla patterns.

---

### Layout

**Single-page, scroll-based with anchor navigation.** The existing structure is correct. Refine, do not restructure.

**Section order (story flow):**
1. Hero — name, one-line position, single CTA
2. About — person, background, TUM, Munich, family business origin
3. What I build — capabilities section (not a services grid with icons; prefer a clean list or card layout)
4. Work — social proof, GitHub signal, maybe a project snapshot
5. CTA — contact form + book a call, side by side at wider viewports

**Max content width:** 1100px for sections, 680px for prose-heavy content (about section, personal narrative). The current `1200px` container is slightly wide for a minimal personal brand; pulling it to `1100px` creates more visual breathing room.

**Typography scale for dark minimal:**
- Hero h1: `--text-5xl` (3rem) mobile, `clamp(3rem, 6vw, 4.5rem)` desktop
- Section h2: `--text-3xl`
- Body: `--text-base` (1rem), line-height 1.7 (slightly more generous than the current 1.6)
- Lead text: `--text-lg`, color `--text-primary`
- Captions / metadata: `--text-sm`, color `--text-secondary`

---

### Booking Integration

**Recommendation: Calendly inline embed**

| Approach | Verdict | Reason |
|----------|---------|--------|
| Calendly inline embed | Recommended | Zero backend work, free tier sufficient, single `<link>` + `<div>` + `<script>` |
| Cal.com self-hosted | Overkill | Requires separate deployment |
| Cal.com cloud embed | Valid alternative | Open-source, similar embed model, slightly more control |
| Acuity / HubSpot booking | Avoid | Heavier brand presence, higher friction |

**Calendly** is the lowest-friction choice for a solo consultant. The free tier supports one event type, which is enough (single "intro call" booking). The inline embed (not popup) is preferred — popup modals break the visual flow of a minimal page.

**Calendly inline embed integration:**
```html
<!-- In <head> -->
<link href="https://assets.calendly.com/assets/external/widget.css" rel="stylesheet">

<!-- In the CTA section -->
<div class="calendly-inline-widget"
     data-url="https://calendly.com/YOUR_USERNAME/intro-call"
     style="min-width:320px;height:700px;">
</div>

<!-- Before </body> -->
<script src="https://assets.calendly.com/assets/external/widget.js" async></script>
```

**Styling the Calendly embed:** Calendly's iframe cannot be deeply styled from the outside. Neutralize the container border and set a transparent background class on the widget to reduce the visual disconnect:
```css
.calendly-inline-widget {
  border: none;
  border-radius: var(--radius-lg);
  overflow: hidden;
}
```

Calendly does offer dark background color configuration via the URL parameter `?background_color=0A0A0F&text_color=E8E8F0&primary_color=6EE7B7`, which significantly reduces the visual mismatch.

**Confidence:** HIGH — Calendly embed API is stable and documented; the URL parameter theming approach is widely used.

---

### What NOT to Use

| Library / Approach | Why Not |
|-------------------|---------|
| Bootstrap / Tailwind | Framework adoption in a no-build context means CDN-only, which loads the entire stylesheet. For a single-page site, this is wasteful and limits design control. The custom property system already does what Tailwind's utility classes would do. |
| Animate.css | Too heavy for what's needed; 95% unused. Does not compose with CSS custom properties. |
| jQuery | No reason to add it. The contact form handler uses fetch + vanilla DOM. jQuery would add 30KB for nothing. |
| GSAP | Appropriate for scroll-driven storytelling sites (portfolio agencies) but overkill for a single-page personal brand with subtle motion. |
| WebGL / Three.js | `webgl.js` exists but should remain empty. A subtle CSS grid background achieves the code-aesthetic goal without a 600KB dependency or GPU battery drain on mobile. |
| Light mode toggle | The existing `theme-manager.js` implements dark/light toggle. Strip it. Dark is permanent. The toggle adds UI complexity and the dark theme is an intentional identity choice, not a preference setting. |
| Icon libraries (Font Awesome, Material Icons) | Load an SVG icon set inline instead. Lucide icons (MIT, SVG sprite) or inline SVGs keep the icon set to exactly what's used — no 200KB icon font loaded for 5 icons. |
| Google Analytics via GA4 script tag | If analytics are needed, use Plausible (EU-hosted, GDPR-friendly, ~1KB script, no cookie banner required for basic usage) rather than GA4's bloated tag. This matters for a German/EU developer audience. |

---

### File Organization Recommendation

The current structure is clean. Extend it without adding complexity:

```
client/src/
├── assets/
│   ├── css/
│   │   └── app.css           -- All styles, one file is fine at this scale
│   ├── js/
│   │   ├── animations.js     -- IntersectionObserver reveal logic
│   │   ├── navigation.js     -- Mobile menu toggle, smooth scroll
│   │   └── form-handler.js   -- AJAX contact form (already designed for this)
│   └── icons/                -- SVG icon files (inline or sprite)
├── index.php                 -- Main page
├── contact.php               -- Form handler (keep as-is)
└── checkout.php / stripe     -- Keep as-is
```

Delete or leave empty: `webgl.js`, `theme-manager.js` — these are either removed (WebGL) or eliminated as a concept (theme toggle).

---

## Alternatives Considered

| Category | Recommended | Alternative | Why Not |
|----------|-------------|-------------|---------|
| Display font | Inter | Geist (Vercel) | Geist is not on Google Fonts; self-hosting adds complexity |
| Display font | Inter | Outfit | Less optically refined at small sizes |
| Monospace | JetBrains Mono | Fira Code | Both are good; JetBrains Mono has more display weight |
| Monospace | JetBrains Mono | IBM Plex Mono | IBM Plex Mono is excellent, slightly more corporate feel |
| Primary accent | Mint green `#6EE7B7` | Electric cyan `#00E5FF` | Cyan is overused in "hacker aesthetic" sites; mint is more current and distinctive |
| Background | `#0A0A0F` | `#0d1117` (GitHub) | Both are correct; slight preference for the warmer `#0A0A0F` which avoids looking like a GitHub clone |
| Booking | Calendly | Cal.com | Cal.com cloud is a legitimate alternative; same embed model; Calendly has wider recognition among non-technical clients |
| Animation | Vanilla IntersectionObserver | AOS library | Equivalent capability, zero dependency overhead |
| Background effect | CSS grid lines | tsParticles | CSS approach is faster, more elegant, lower maintenance |

---

## Sources and Confidence Notes

| Claim | Confidence | Basis |
|-------|------------|-------|
| Inter / JetBrains Mono on Google Fonts | HIGH | Stable Google Fonts entries; training data confirmed through Aug 2025 |
| CSS custom property approach | HIGH | Existing codebase already uses this; MDN-documented standard |
| IntersectionObserver browser support | HIGH | Baseline 2019 browser API; universally supported as of 2026 |
| `text-wrap: balance` support | HIGH | Chrome 114+, Firefox 121+, Safari 17.4+ — all current major browsers |
| Calendly embed URL color parameters | MEDIUM | Widely documented in community; official Calendly docs should be verified at implementation time |
| Mint green over cyan trend call | MEDIUM | Based on observation of current developer tools design (Vercel, Linear, Resend, Turso); WebSearch was unavailable to verify current trends |
| tsParticles bundle size (~50KB) | MEDIUM | Training data; verify at implementation time |

**Note:** WebSearch and WebFetch were unavailable during this research session. All recommendations are grounded in the existing codebase analysis plus training knowledge current to August 2025. Calendly pricing/tier details and any recently released font alternatives should be verified against live documentation at implementation time.
