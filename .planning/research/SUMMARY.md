# Project Research Summary

**Project:** Velletti — Personal Brand & Consulting Site Redesign
**Domain:** Solo developer personal brand / consulting site
**Researched:** 2026-03-01
**Confidence:** HIGH

## Executive Summary

The Velletti site requires a complete identity overhaul, not just a visual refresh. The existing site has a structurally broken trust architecture: it speaks as "we" when one person runs it, leads with technology categories rather than a person, buries credentials in an unreadable 14-card grid, and places a Stripe buy button before any trust is established. Non-technical startup founders — the target audience — will bounce at each of these points before they ever reach the contact form. The redesign must treat copy, story, and hierarchy as foundational concerns before touching CSS.

The recommended technical approach is a dark-first, no-build-toolchain implementation that extends the existing PHP/vanilla JS architecture. The color system must be completely rebuilt from scratch — the current site has two competing, conflicting color systems (PHP-injected coral/navy and CSS-defined electric cyan) that produce a light-mode-default site with a broken dark toggle. The target is a permanent dark-first design with a muted mint green accent (not electric cyan), Inter + JetBrains Mono typography, and CSS custom properties as the single source of truth. No frameworks, no animation libraries, no WebGL. The existing contact form and Stripe infrastructure are kept as-is; they are the only parts of the codebase that work correctly.

The dominant risk is accumulation: adding too many "developer aesthetic" signals (particle animations, gradient text, neon glows, monospace everywhere) that tip the design from "refined" to "template." The second risk is launching with the copy problem unsolved — visual polish on a site that still says "Wir entwickeln" and lists 14 undifferentiated hackathon cards will not improve conversion. Copy must be resolved in parallel with design, not after.

---

## Key Findings

### Recommended Stack

The existing PHP + vanilla JS + single-CSS-file architecture is correct for this scale and must not be replaced with a framework. The rebuild is a refactor of CSS architecture and HTML structure, not a technology migration.

See full detail: `.planning/research/STACK.md`

**Core technologies:**

- **Inter (variable font, Google Fonts CDN):** Display and body typography — purpose-built for screen legibility, signals "engineered" without effort, ~40KB
- **JetBrains Mono (Google Fonts CDN):** Monospace accent only — section eyebrows, capability labels, metadata; not body copy
- **CSS Custom Properties (dark-first, single file):** Design token layer in `app.css`; eliminates the PHP `$colors[]` injection system and all inline `<style>` blocks
- **Vanilla IntersectionObserver (30 lines):** Scroll-triggered fade/translate animations; no animation library needed
- **Calendly inline embed:** Booking integration via URL-parameterized embed (no backend work; free tier sufficient)
- **Plausible (if analytics needed):** EU-hosted, GDPR-compliant, ~1KB script; preferred over GA4 for a German/EU developer audience

**What NOT to use:** Tailwind, Bootstrap, jQuery, GSAP, Animate.css, WebGL/Three.js, tsParticles, Font Awesome, the light mode toggle (strip it entirely), the PHP color injection system.

---

### Expected Features

See full detail: `.planning/research/FEATURES.md`

**Must have (table stakes — without these the redesign fails its core goal):**

- First-person copy throughout — zero "we/our/us" anywhere
- Real photo of the person visible without scrolling or within first scroll
- Positioning statement — one sentence: what you do and for whom
- Origin story — 3-5 sentences connecting family IT business to present capability
- Curated proof — 3-4 credentials with one-sentence context each, not 14 chips
- Dark-committed design — permanent dark, no toggle, no light sections
- Dual CTA — contact form (exists) + book a call (Calendly embed or link)
- Stripe payment moved off main page entirely
- Language consistency — pick English or German, commit fully

**Should have (meaningful conversion lift, but site is coherent without them):**

- Capability framing replacing generic "AI & Automatisierung" service labels
- Response time commitment near contact form ("I reply within 24 hours")
- Social links demoted from header to footer
- GitHub activity surfaced on-page (not requiring modal discovery)

**Defer to post-v1:**

- Testimonials (only with real, named clients — not placeholders)
- Case studies (correctly scoped out of v1 in PROJECT.md)
- Blog or article section (stale content is worse than no content)
- Additional pages beyond single-page or near-single-page scope
- Calendly full inline embed (a direct Calendly link is sufficient for v1 if setup is complex)

---

### Architecture Approach

The architecture pattern is a layered CSS system (7 layers, one file) with a strict dark-first token foundation, three JS modules (scroll, nav, form), and HTML sections ordered for narrative flow rather than visual variety. The current site's architecture problems — dual CSS sources of truth, PHP color injection, `[data-theme='dark']` overlay on a light-first base — are all resolved by writing dark-first from the start and consolidating everything into `app.css`.

See full detail: `.planning/research/ARCHITECTURE.md`

**Major components:**

1. **CSS Token Layer (`app.css` Layer 1):** Design tokens as CSS custom properties — backgrounds (3 levels: base/surface/elevated), text hierarchy (4 levels), one accent color + its dim variant, type scale, spacing, motion, borders. Single source of truth. PHP `$colors[]` eliminated.
2. **Fixed Navigation (`<header>`):** Glass blur effect, transparent until 80px scroll, wordmark in monospace, 3-4 anchor links. No theme toggle.
3. **Hero Section (`#hero`):** Person-first — name/statement, portrait, positioning sub-text, dual CTA. Faint radial gradient background (CSS only, no WebGL). Hero H1 visible on first paint — no entrance animation blocking content.
4. **Story + Capabilities (`#about`, `#capabilities`):** Narrow prose container for about; capability rows in monospace-label + dot-separated items grid for skills. No skill bars, no percentages.
5. **Services Section (`#services`):** 3 dark surface cards — monospace category tag, H3, 2-sentence outcome-oriented description. No emoji icons. Stripe button removed from this section.
6. **Proof Section (`#proof`):** Only section on `--bg-surface` (creates the one visual rhythm break). Compact chronological list of 4-5 selected highlights with year, event, right-aligned result chip. LinkedIn/GitHub as slim horizontal profile rows, not center-stacked icons.
7. **Contact + CTA (`#contact`):** Existing PHP form preserved and restyled. Calendly embed or link alongside. Response time commitment line. No separate CTA section — the heading is the CTA.
8. **Footer:** 2 lines max — copyright and Impressum/Datenschutz links only.

**Animation:** `IntersectionObserver` in `scroll.js` triggers `animate-on-scroll` → `is-visible` class swap. Fire-once. `prefers-reduced-motion` disables all transitions. Hero H1 never animates. 3-4 animated elements per section maximum.

---

### Critical Pitfalls

See full detail: `.planning/research/PITFALLS.md`

1. **Corporate "we" copy (Pitfall 1)** — Every instance of wir/unsere/uns must be replaced with ich/mein/mir before any design work. This is the highest-impact single change. Use grep to detect and eliminate systematically.
2. **Two competing CSS systems (Pitfall 5)** — The PHP `$colors[]` injection and the CSS `[data-theme='dark']` overlay must both be eliminated in Phase 1. Building any new CSS on top of the current system will produce specificity conflicts that require rework.
3. **Stripe buy button before trust is established (Pitfall 6)** — Remove from the main page. The button creates immediate trust damage for cold visitors. Infrastructure stays; the placement changes.
4. **Overdone code aesthetic (Pitfall 8)** — Count visual effects in the hero: particle canvas + gradient text + gradient buttons = 3 competing effects. Target is 0-1. Restraint is the signal, not accumulation.
5. **No photo on the page (Pitfall 15)** — The portrait is in OG meta tags but never appears in actual page HTML. A personal brand site without a visible face loses the primary trust mechanism before the visitor reads a word. Confirm the asset exists and wire it into the hero.

---

## Implications for Roadmap

Research points to 8 phases with a strict dependency between the first two. Phases 1-2 are foundational and block everything else. Phases 3-6 are independent and can be parallelized. Phases 7-8 are finishing passes.

### Phase 1: CSS Foundation and Architecture Reset

**Rationale:** The existing CSS architecture (two competing systems, PHP color injection, light-first base) is the single largest technical risk. Every other phase's CSS will conflict with the current system if it is not resolved first. This is not cosmetic — it is structural.

**Delivers:** A clean, single-source-of-truth `app.css` with dark-first design tokens. All inline `<style>` blocks removed from `index.php`. PHP `$colors[]` injection eliminated. Dark background renders on first load without JS.

**Addresses:** Table stakes — dark-committed design; anti-feature — light mode toggle removal

**Avoids:** Pitfall 5 (competing color systems), Pitfall 14 (inline style duplication), Anti-Pattern 4 (dark overlay on light base)

**Research flag:** No additional research needed. Pattern is well-documented and the problems are directly observable in the existing code.

---

### Phase 2: Copy and Narrative Rewrite

**Rationale:** Copy must be resolved before layout, because layout choices (section order, column widths, card counts) are determined by the copy. Designing around placeholder or wrong copy means redesigning when real copy arrives. This is a content-first principle.

**Delivers:** All copy in first person, in one language (decision required — see Open Questions). Positioning statement written and approved. Origin story drafted. 3-4 proof items selected with context. Service descriptions rewritten as outcome statements. CTA language lowering commitment bar.

**Addresses:** Must-haves: first-person copy, positioning statement, origin story, curated proof, language consistency

**Avoids:** Pitfall 1 (we/us), Pitfall 2 (capability-first hero), Pitfall 3 (credential dump), Pitfall 9 (differentiation gap), Pitfall 10 (high-friction CTA language), Pitfall 11 (language mismatch)

**Research flag:** No research needed. Decisions required from the project owner (see Open Questions).

---

### Phase 3: Navigation and Layout Primitives

**Rationale:** After the token foundation (Phase 1) is in place, layout primitives — container, section padding, grid helpers — must exist before any section-level HTML can be built. The nav is built first because it is the constant visual anchor across all sections.

**Delivers:** Fixed glass nav with correct anchor labels. Container and section primitives. Typography scale applied globally. Mobile-responsive grid helpers.

**Addresses:** Table stakes: mobile-responsive layout; should-have: social links demoted to footer

**Avoids:** Pitfall 13 (nav labels mismatched to section content), Anti-Pattern 1 (alternating section backgrounds — prevented by establishing section system early)

**Research flag:** Standard patterns. Skip research-phase.

---

### Phase 4: Hero Section

**Rationale:** The hero is the highest-impact surface — it determines whether the visitor continues. It is built before other sections because it will receive the most iteration. Building it early allows feedback to be incorporated without blocking other phases.

**Delivers:** Full-height hero with portrait photo wired in, name/positioning statement/sub-text in first-person copy, dual CTA buttons (contact + book a call), faint CSS radial gradient background (no WebGL canvas).

**Addresses:** Must-haves: real photo, first-person copy, positioning statement, dark design

**Avoids:** Pitfall 2 (leading with capabilities), Pitfall 4 (electric cyan accent), Pitfall 8 (overdone code aesthetic), Pitfall 15 (missing portrait), Anti-Pattern 5 (scroll animations on every element — hero H1 is never animated)

**Research flag:** One decision point — whether to keep the WebGL canvas or replace with CSS radial gradient. Performance test on low-end mobile device recommended. Research says: default to CSS gradient unless WebGL passes the test.

---

### Phase 5: Content Sections (About, Capabilities, Services, Proof)

**Rationale:** These four sections share the same token and primitive foundations but are independent of each other. They can be built in any order, or in parallel if multiple contributors are involved.

**Delivers:** About section as prose narrative (origin story). Capabilities section as monospace-label + dot-separated rows. Services section as 3 dark surface cards with outcome copy and no Stripe button. Proof section as compact highlight list on `--bg-surface`.

**Addresses:** Must-haves: origin story, curated proof, capability framing; anti-features: Stripe removed from main page, achievement grid replaced

**Avoids:** Pitfall 3 (credential dump), Pitfall 6 (Stripe placement), Pitfall 7 (jargon-heavy service copy), Pitfall 12 (EY experience framing confusion), Anti-Pattern 2 (emoji icons)

**Research flag:** Standard patterns for section layouts. Skip research-phase.

---

### Phase 6: Contact Section and Form Restyling

**Rationale:** The existing PHP form (CSRF, honeypot, rate limiting, AJAX submit) is production-quality and must not be rewritten. This phase is only the dark restyling and the addition of the Calendly booking element alongside the form.

**Delivers:** Contact section with restyled dark form inputs, response time commitment line, Calendly embed or direct booking link, clear low-friction CTA heading.

**Addresses:** Must-have: dual CTA; should-have: response time commitment, Calendly integration

**Avoids:** Pitfall 10 (high-friction CTA language), breaking the existing form behavior

**Research flag:** Calendly URL color parameters (`?background_color=&text_color=&primary_color=`) should be verified against live Calendly documentation at implementation time. STACK.md rates this MEDIUM confidence.

---

### Phase 7: Animation Layer

**Rationale:** Animations are the last layer added because they require stable, final HTML structure and CSS. Adding animations to content that may still change wastes effort and risks CLS (Cumulative Layout Shift) if animation starting states interact with layout shifts.

**Delivers:** `scroll.js` IntersectionObserver wiring `animate-on-scroll` → `is-visible` on section-level containers and direct children. Nav glass effect on scroll. Hover micro-interactions on cards and CTA button. `prefers-reduced-motion` override.

**Addresses:** Should-have: subtle code aesthetic in motion behavior

**Avoids:** Pitfall 8 (overdone visual effects), Anti-Pattern 5 (scroll animations on every element — strict limit of 3-4 animated elements per section)

**Research flag:** Standard patterns. Skip research-phase. All APIs are native browser (IntersectionObserver baseline 2019).

---

### Phase 8: Polish, Legal, and Accessibility Audit

**Rationale:** Final pass to catch contrast ratio failures, focus state gaps, nav label mismatches, and footer correctness. This phase has no deliverables that change the architecture — it only validates what was built.

**Delivers:** Impressum/Datenschutz styled consistently with dark design. Footer trimmed to 2 lines. Focus states on all interactive elements. Contrast ratios verified (WCAG AA minimum). Print styles preserved.

**Addresses:** Table stakes: Impressum/Datenschutz, mobile-responsive layout (final verification)

**Avoids:** Pitfall 13 (nav label audit), legal compliance gap

**Research flag:** No research needed. WCAG 2.1 AA is the standard. Contrast ratios are verifiable with browser devtools.

---

### Phase Ordering Rationale

- Phase 1 blocks everything: all CSS references the token layer. Building any section without it means the work must be redone.
- Phase 2 blocks layout and section design: copy determines section structure. Design around placeholder copy is design around the wrong requirements.
- Phase 3 sets the layout primitives that Phases 4-6 depend on, but it does not block those phases from being drafted.
- Phases 4-6 are independent once Phase 3 is complete — they can run concurrently.
- Phase 7 (animations) is explicitly last by architecture rule: "Do not skip to animations early. Animations on poorly structured content expose layout problems rather than hiding them." (ARCHITECTURE.md)
- Phase 8 is a validation pass — nothing about it is buildable until Phase 7 is complete.

---

### Research Flags

**Needs verification at implementation time:**
- **Phase 6:** Calendly URL color parameters — verify against live Calendly docs before implementing. The specific parameter names are widely documented in community sources but not confirmed against official docs.

**Standard patterns (skip research-phase):**
- **Phase 1:** CSS custom property cascade — established spec, directly verified in existing codebase
- **Phase 3:** Navigation primitives — no novel patterns
- **Phase 4:** Hero layout — two-column flex/grid, well-documented
- **Phase 5:** BEM component sections — established pattern
- **Phase 7:** IntersectionObserver scroll animations — Baseline 2019 API, universally supported
- **Phase 8:** WCAG AA audit — browser devtools + established spec

---

## Open Questions

These decisions must be made by the project owner before execution begins. They are not resolvable by research.

1. **Language choice:** Is the primary audience English-speaking startup founders or German-speaking SMEs? This determines whether all copy is rewritten in English or German. The research recommends English for the Munich startup / international audience, but if the active client pipeline is German SMEs, German is correct. **This decision blocks Phase 2.**

2. **Portrait photo:** Does a suitable portrait photo exist as an asset? The OG meta tag references `assets/portrait.jpg`. Is this a quality photo appropriate for a professional personal brand (not a passport crop)? If not, a photo session is a dependency for Phase 4.

3. **Calendly account:** Does a Calendly account exist with an intro-call event type configured? If not, this is a setup task that must precede Phase 6. A fallback (direct `mailto:` or calendar link) can serve for v1 if Calendly setup is deferred.

4. **Accent color decision:** Research recommends replacing the existing electric cyan (`#00E5FF`) with muted mint green (`#6EE7B7`) or staying with a refined version of the original coral (`#F87060`). The ARCHITECTURE.md recommends the coral for the primary CTA button specifically. A color direction decision is needed before Phase 1 tokens are written.

5. **First-person copy draft:** The positioning statement and origin story cannot be written by an outside party — they require the project owner's voice and facts. These should be drafted before Phase 4 (hero) is built. Suggested prompt: "In one sentence, who do you build for and what do you give them that they couldn't get from a dev agency?" and "Tell me about the family IT business and when you started doing real production work."

---

## Confidence Assessment

| Area | Confidence | Notes |
|------|------------|-------|
| Stack | HIGH | Based on direct codebase analysis + established browser standards. All recommended technologies are native or Google Fonts CDN. No framework adoption risk. |
| Features | HIGH for table stakes; MEDIUM for differentiators | Must-haves are conversion fundamentals with solid basis. Differentiator copy patterns are drawn from training knowledge, not 2025-verified external sources. |
| Architecture | HIGH | Based on direct `index.php` and `app.css` analysis. CSS cascade behavior, IntersectionObserver support, and WCAG ratios are spec-verified. |
| Pitfalls | HIGH | Critical pitfalls are directly observed in the existing codebase, not inferred. Evidence cited with line numbers in PITFALLS.md. |

**Overall confidence:** HIGH

### Gaps to Address

- **Calendly pricing/tier details:** Free tier is described as sufficient for one event type, but this should be verified against current Calendly pricing at account setup. (STACK.md rates MEDIUM due to unavailable WebSearch during research.)
- **Current design trends (2025-2026):** The mint green over cyan recommendation and the "current developer tool aesthetic" observations are based on training data through August 2025. The trend direction is sound; specific color choices could benefit from a quick review of Dribbble/Behance in the dark minimal / developer tools category before finalizing the accent token.
- **Copy effectiveness:** The specific copy directions (positioning statement examples, CTA language) are pattern-matched from established conversion principles but are not validated against A/B testing data for this specific audience. Treat as informed starting points, not proven formulas.

---

## Sources

### Primary (HIGH confidence — direct codebase analysis)

- `/client/src/index.php` — current site structure, copy, component layout, color conflicts
- `/client/src/assets/css/app.css` — existing token system, dark theme implementation, competing color variables
- `/client/src/contact.php` — form handler (CSRF, honeypot, rate limiting — keep as-is)
- `.planning/PROJECT.md` — project goals, scope, constraints

### Secondary (HIGH confidence — established specifications)

- CSS Custom Properties specification (MDN) — cascade behavior, `:root` token layer
- IntersectionObserver API (Baseline 2019) — scroll animation implementation
- WCAG 2.1 AA — contrast ratios (verified: `#f0f0f0` on `#0a0a0a` = ~17:1)
- `text-wrap: balance` — Chrome 114+, Firefox 121+, Safari 17.4+ (all current browsers)

### Secondary (MEDIUM confidence — training knowledge, cutoff August 2025)

- Google Fonts — Inter variable font, JetBrains Mono availability
- Calendly embed URL color parameters — widely documented in community; official docs not directly accessed
- Developer tools design aesthetic trends (Vercel, Linear, Resend) — mint/muted green over cyan
- Conversion principles for solo developer personal brand sites — established copywriting/CRO knowledge

---

*Research completed: 2026-03-01*
*Ready for roadmap: yes*
