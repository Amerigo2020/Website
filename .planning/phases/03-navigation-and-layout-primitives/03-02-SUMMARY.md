---
phase: 03-navigation-and-layout-primitives
plan: 02
subsystem: ui
tags: [css-grid, hero, portrait, buttons, responsive, layout]

# Dependency graph
requires:
  - phase: 01-css-foundation-reset
    provides: Design tokens (--space-*, --accent, --bg-base, --text-*, --font-mono, --radius-*, --duration-*, --ease-out, --border-subtle) that all hero and button CSS references
  - phase: 02-copy-and-voice-rewrite
    provides: Final H1 copy and hero subtitle — do not alter copy established in phase 2
provides:
  - Two-column hero grid (portrait right, text left) visible above fold at 1280px
  - hero__eyebrow element with name and location in JetBrains Mono
  - Portrait image slot (assets/portrait.jpg, loading=eager, aspect-ratio 4/5)
  - btn--primary (mint fill) and btn--ghost (border-only) button system
  - Mobile single-column stack at 768px with text above portrait, full-width buttons
  - hero__actions flex row replacing broken inline style with non-existent --spacing-sm token
affects:
  - 03-navigation-and-layout-primitives (plan 03 if exists — shares responsive breakpoints)
  - Any future phase adding hero variants or CTA buttons (btn--primary/btn--ghost patterns established)

# Tech tracking
tech-stack:
  added: []
  patterns:
    - "Two-column hero grid via CSS grid-template-columns: 1fr 1fr on desktop, collapses to 1fr on mobile"
    - "btn--primary / btn--ghost button system for hero CTAs — .cta-button retained for modal/JS backward compat"
    - "Portrait above fold: loading=eager, explicit width/height dimensions to prevent layout shift, aspect-ratio: 4/5"
    - "Mobile stack ordering via CSS order property (hero__text order:1, hero__portrait-wrap order:2)"

key-files:
  created: []
  modified:
    - client/src/index.php
    - client/src/assets/css/app.css

key-decisions:
  - "btn--primary and btn--ghost are hero-only; .cta-button kept for LinkedIn modal (line 741) and GitHub JS fallback (line 895)"
  - "Portrait uses loading=eager — it is above the fold at 1280px, lazy loading would defer a visible asset"
  - "hero__grid replaces hero__content — hero__content rule left untouched in app.css for safety"
  - "Mobile portrait max-width 240px (desktop 380px) — smaller viewport needs smaller portrait to leave room for text"
  - "assets/portrait.jpg confirmed present (portrait.jpg and portrait.png both in assets/)"

patterns-established:
  - "btn--primary: mint fill, opacity 0.88 hover, scale(1.02), 2px accent outline focus"
  - "btn--ghost: transparent + var(--border-subtle) border, rgba(255,255,255,0.25) hover, accent outline focus"
  - "Hero eyebrow uses --font-mono, --text-sm, --text-tertiary, letter-spacing 0.06em"

# Metrics
duration: 2min
completed: 2026-03-02
---

# Phase 3 Plan 02: Hero Two-Column Grid and Button System Summary

**Two-column hero layout with portrait slot, name eyebrow, mint/ghost CTA buttons, and mobile single-column stack — replacing a broken inline-style CTA row and portrait-less single column**

## Performance

- **Duration:** ~2 min
- **Started:** 2026-03-02T12:20:18Z
- **Completed:** 2026-03-02T12:21:54Z
- **Tasks:** 2
- **Files modified:** 2

## Accomplishments

- Replaced single-column hero__content with hero__grid (CSS Grid two-column: text left, portrait right)
- Added portrait image slot (`assets/portrait.jpg`, loading=eager, 400x500, aspect-ratio 4/5, border-radius lg)
- Added hero__eyebrow element ("Amerigo Velletti · Munich") in JetBrains Mono above the H1
- Replaced broken inline style (`gap: var(--spacing-sm)` — non-existent token) with `.hero__actions` CSS class
- Introduced btn--primary (mint fill) and btn--ghost (border-only) replacing cta-button/cta-button--outline in hero
- Added complete mobile responsive stack at ≤768px: single column, text above portrait, buttons full-width

## Task Commits

Each task was committed atomically:

1. **Task 1: Rebuild hero HTML in index.php** - `cebc448` (feat)
2. **Task 2: Add hero grid CSS and button system to app.css** - `27b47a4` (feat)

**Plan metadata:** (committed after SUMMARY.md creation)

## Files Created/Modified

- `client/src/index.php` — Hero section (lines 298–325) rebuilt: hero__grid, hero__text, hero__eyebrow, hero__portrait-wrap, hero__portrait img, hero__actions with btn--primary/btn--ghost
- `client/src/assets/css/app.css` — Added 119 lines: .hero__grid, .hero__text, .hero__eyebrow, .hero__portrait-wrap, .hero__portrait, .hero__actions (desktop); .btn--primary, .btn--ghost with hover/focus states; mobile overrides inside @media (max-width: 768px)

## Decisions Made

- **btn--primary/btn--ghost are hero-only CTA classes.** `.cta-button` preserved in CSS and HTML — still used by LinkedIn modal (line 741) and GitHub JS fallback (line 895). Two parallel button systems intentional for backward compatibility.
- **portrait loading=eager.** The portrait is visible above fold at 1280px — lazy loading would defer a visible asset and hurt LCP.
- **hero__content left in CSS.** Not removed despite hero__grid replacing it in HTML — safe to leave, may be referenced by other elements or future phases.
- **Mobile portrait max-width 240px vs desktop 380px.** Smaller viewport needs a smaller portrait so text remains readable above it.

## Deviations from Plan

None — plan executed exactly as written.

## Issues Encountered

None. `assets/portrait.jpg` confirmed present before task execution. All token names (`--space-4`, `--space-8`, `--space-16`, `--radius-lg`, `--radius-md`, `--font-mono`, `--text-sm`, `--text-base`, `--text-tertiary`, `--border-subtle`, `--duration-fast`, `--ease-out`) verified to be part of the established token vocabulary from Phase 1.

## User Setup Required

None — no external service configuration required.

## Next Phase Readiness

- Hero layout complete: portrait, eyebrow, H1, subtitle, and CTAs all present and above-fold at 1280px
- btn--primary and btn--ghost pattern established — future phases can reuse for any new CTAs
- portrait.jpg confirmed present; no 404 expected
- Phase 3 Plan 03 (if it exists) can proceed immediately — no blockers

---
*Phase: 03-navigation-and-layout-primitives*
*Completed: 2026-03-02*
