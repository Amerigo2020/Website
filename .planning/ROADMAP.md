# Roadmap: Velletti — Personal Brand & Consulting Site Redesign

## Overview

The existing site has three structural problems that block conversion: it speaks as "we" when one person runs it, leads with technology categories instead of a person, and carries two competing CSS systems that make any styling work immediately conflict with itself. The roadmap resolves these problems in strict dependency order — token foundation first, copy second, structure third — so that every phase builds on stable ground rather than fighting the previous layer.

## Phases

**Phase Numbering:**
- Integer phases (1, 2, 3): Planned milestone work
- Decimal phases (2.1, 2.2): Urgent insertions (marked with INSERTED)

Decimal phases appear between their surrounding integers in numeric order.

- [x] **Phase 1: CSS Foundation Reset** — Eliminate competing color systems; establish single dark-first token source of truth
- [x] **Phase 2: Copy & Voice Rewrite** — Replace all corporate/plural copy with first-person English; write positioning statement and origin story
- [ ] **Phase 3: Navigation & Layout Primitives** — Build fixed nav, container/section primitives, and hero section
- [ ] **Phase 4: Content Sections** — Story, capabilities, and proof sections with final copy wired in
- [ ] **Phase 5: Contact & CTA** — Dual CTA contact section; Stripe removed from main page
- [ ] **Phase 6: Animation & Polish** — Entrance animations via IntersectionObserver; accessibility and motion preferences

## Phase Details

### Phase 1: CSS Foundation Reset
**Goal**: The site renders correctly in dark mode on first load — no JS required, no flash, no competing styles.
**Depends on**: Nothing (first phase)
**Requirements**: DS-01, DS-02, DS-03, DS-04, DS-05, DS-06
**Success Criteria** (what must be TRUE):
  1. Opening the site in a browser with no JS shows a dark background (#0a0a0a) with readable text on first paint — no flash of light content.
  2. A developer inspecting `app.css` finds exactly one color system — CSS custom properties at `:root` — with no competing values from PHP injection or inline `<style>` blocks.
  3. Inter loads as the body typeface and JetBrains Mono appears only on technical labels — no system fallback fonts visible in the rendered page.
  4. The theme toggle button and all related JS are gone from the DOM; dark is the only state.
**Plans**: 3 plans

Plans:
- [ ] 01-01-PLAN.md — Delete PHP $colors array, both inline style blocks (~950-line migrated block + active PHP color injection), theme-init script, theme toggle button, theme toggle JS, canvas element, and WebGL animation script from index.php
- [ ] 01-02-PLAN.md — Rewrite app.css :root block with dark-first token vocabulary; remove all data-theme override blocks; update all var(--color-*) references to new token names throughout component CSS
- [ ] 01-03-PLAN.md — Add Google Fonts preconnect + Inter/JetBrains Mono stylesheet to index.php; add body::before CSS grid background to app.css; delete theme-manager.js and webgl.js stubs

### Phase 2: Copy & Voice Rewrite
**Goal**: Every word on the site is first-person English — zero instances of "we", "our", "wir", or "unser" — and the positioning statement and origin story are written and approved.
**Depends on**: Phase 1
**Requirements**: CP-01, CP-02, CP-03, CP-04, CP-05
**Success Criteria** (what must be TRUE):
  1. Grepping the rendered HTML for "wir", "unser", "we ", "our " returns zero results.
  2. A one-sentence positioning statement exists that names what gets built and for whom — readable in under 5 seconds.
  3. A 3–5 sentence origin story exists connecting the family business, TUM, and the systems-thinking approach — written in first person with specific facts.
  4. Service/capability descriptions describe client outcomes, not technology categories — no section heading reads "AI & Automatisierung" or equivalent generic label.
**Plans**: 3 plans

Plans:
- [ ] 02-01-PLAN.md — Replace PHP config metadata, html lang, OG/Twitter meta, Schema.org JSON-LD, hero section copy, and remove Stripe elements (CP-01, CP-02)
- [ ] 02-02-PLAN.md — Replace experience section headers, insert origin story paragraph, replace contact CTA and response-time commitment, fix degree label in both locations (CP-03, CP-05)
- [ ] 02-03-PLAN.md — Rewrite services section header and all three service card copy blocks as output-oriented English; run full zero-German verification sweep (CP-04, CP-01 final)

### Phase 3: Navigation & Layout Primitives
**Goal**: The fixed navigation reflects the real section structure, legal links are in the footer only, and the hero section is visible and iterable on all screen sizes.
**Depends on**: Phase 2 (copy determines nav labels and hero headline)
**Requirements**: NAV-01, NAV-02, NAV-03, SEC-01
**Success Criteria** (what must be TRUE):
  1. The nav bar shows anchor labels that match actual section content — no "Services" label pointing to a generic capability section, no Impressum link in the main nav.
  2. The hero section is visible without scrolling: photo, name, positioning statement, and a primary CTA button are all above the fold on a 1280px viewport.
  3. On a 375px mobile viewport, the hero stacks cleanly — no horizontal overflow, no overlapping text, touch targets at least 44px.
  4. Impressum and Datenschutz links appear in the footer and nowhere else in the navigation.
**Plans**: 2 plans

Plans:
- [ ] 03-01-PLAN.md — Update nav labels to "About"/"What I build"/"Contact" in desktop and mobile nav (NAV-01); verify Impressum/Datenschutz footer-only (NAV-02); fix footer background token to --bg-base
- [ ] 03-02-PLAN.md — Rebuild hero with two-column grid (portrait right, text left), name eyebrow, fix broken --spacing-sm token reference, add .btn--primary/.btn--ghost CSS classes (SEC-01, NAV-03)

### Phase 4: Content Sections
**Goal**: A visitor scrolling past the hero encounters — in order — a personal origin story, a description of what gets built, and a curated list of 3–4 proof items with context.
**Depends on**: Phase 3
**Requirements**: SEC-02, SEC-03, SEC-04
**Success Criteria** (what must be TRUE):
  1. The story/about section reads as a continuous first-person narrative — it names the family business, TUM, and the connection between them in concrete terms.
  2. The capabilities section uses monospace labels and describes output, not technology — no skill bars, no percentages, no generic category headings.
  3. The proof section shows exactly 3–4 items (Enactus Bangkok, MSG Hackathon, EY, family business origin) each with one sentence of context — the 14-chip grid is gone.
**Plans**: 3 plans

Plans:
- [ ] 04-01-PLAN.md — Gut #experience section; preserve origin story paragraph; add .about class and prose CSS; remove all chip grids, profile cards, education/industry/networks cards (SEC-02)
- [ ] 04-02-PLAN.md — Replace #services centered icon cards with .capabilities list; remove old service card CSS from app.css (SEC-03)
- [ ] 04-03-PLAN.md — Insert new #proof section between #experience and #contact; 4 curated items with monospace labels and one-sentence context; extend monospace allowlist (SEC-04)

### Phase 5: Contact & CTA
**Goal**: A visitor who is ready to reach out finds two low-friction options side by side — the existing contact form and a Calendly booking link — with no Stripe button anywhere on the main page.
**Depends on**: Phase 4
**Requirements**: SEC-05, CTA-01, CTA-02, CTA-03
**Success Criteria** (what must be TRUE):
  1. The contact section presents the restyled PHP form and a Calendly booking option (link or embed) side by side — a visitor can choose their preferred engagement method without hunting.
  2. A response time commitment ("I reply to every inquiry within 24 hours" or equivalent) is visible near the form.
  3. The Stripe buy button does not appear anywhere on index.php — payment is only accessible on checkout.php.
  4. LinkedIn and GitHub links appear in the footer and not in the site header.
**Plans**: TBD

Plans:
- [ ] 05-01: Remove Stripe button from index.php; demote social links from header to footer (CTA-01, CTA-03)
- [ ] 05-02: Restyle PHP contact form for dark design; add Calendly booking link/embed; add response time commitment (SEC-05, CTA-02)

### Phase 6: Animation & Polish
**Goal**: Sections animate into view on scroll using only native browser APIs — no animation library, no looping effects — and the site is accessible to users with reduced motion preferences.
**Depends on**: Phase 5 (animations require stable, final HTML structure)
**Requirements**: ANI-01, ANI-02
**Success Criteria** (what must be TRUE):
  1. Scrolling down the page reveals each section with a subtle fade/translate entrance — content is not visible until it enters the viewport (except the hero H1, which is never animated).
  2. Setting `prefers-reduced-motion: reduce` in the OS disables all transitions — content remains fully readable and accessible without any animation.
  3. No animation runs on a loop — every animation fires once on entrance and stops.
**Plans**: TBD

Plans:
- [ ] 06-01: Implement IntersectionObserver in scroll.js; wire animate-on-scroll / is-visible class swap on section containers; add prefers-reduced-motion override

## Progress

**Execution Order:**
Phases execute in strict dependency order: 1 → 2 → 3 → 4 → 5 → 6

| Phase | Plans Complete | Status | Completed |
|-------|----------------|--------|-----------|
| 1. CSS Foundation Reset | 3/3 | Complete | 2026-03-01 |
| 2. Copy & Voice Rewrite | 3/3 | Complete | 2026-03-01 |
| 3. Navigation & Layout Primitives | 2/2 | Complete | 2026-03-02 |
| 4. Content Sections | 3/3 | Complete | 2026-03-09 |
| 5. Contact & CTA | 0/2 | Not started | - |
| 6. Animation & Polish | 0/1 | Not started | - |
