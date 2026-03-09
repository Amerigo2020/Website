---
phase: 04-content-sections
plan: 02
subsystem: ui
tags: [html, css, capabilities, services, layout, monospace]

# Dependency graph
requires:
  - phase: 02-copy-and-voice-rewrite
    provides: finalized service card copy (AI & Automation, Web Applications & Hosting, DevOps & Deployment paragraphs)
  - phase: 01-css-foundation-reset
    provides: design token vocabulary (--space-*, --text-*, --accent, --font-mono, --max-width-prose)
provides:
  - .capabilities list layout replacing centered .services__grid card grid
  - .capability-label monospace labels for each service area
  - .services__intro class on intro paragraph
  - All old service card CSS rules removed (no orphans)
affects: [04-03, 05-social-profiles-and-cta]

# Tech tracking
tech-stack:
  added: []
  patterns:
    - "Capabilities list pattern: .capabilities > .capability > .capability-label + p — no cards, no icons, left-aligned prose"
    - "gap: 2.5rem used directly when no matching --space-* token exists"

key-files:
  created: []
  modified:
    - client/src/index.php
    - client/src/assets/css/app.css

key-decisions:
  - "gap: 2.5rem used directly for .capabilities — no --space-10 token in :root; raw value preferred over introducing a new token"
  - ".capability-label font-family handled by existing JetBrains Mono allowlist at line 107 — no duplicate font-family rule added"
  - "No tabindex on .capability divs — they are not interactive elements"

patterns-established:
  - "Capability list pattern: span.capability-label + p inside .capability div, all inside .capabilities container"
  - "Intro paragraph uses .services__intro class with max-width: var(--max-width-prose) for prose constraint"

# Metrics
duration: 1min
completed: 2026-03-08
---

# Phase 4 Plan 02: Capabilities List Upgrade Summary

**Services section rebuilt from centered emoji icon cards to left-aligned .capabilities list with monospace labels — all old .service-card CSS removed**

## Performance

- **Duration:** ~1 min
- **Started:** 2026-03-08T23:57:40Z
- **Completed:** 2026-03-08T23:59:01Z
- **Tasks:** 2
- **Files modified:** 2

## Accomplishments
- Replaced .services__grid card grid (with emoji icons and h3 headings) with .capabilities/.capability/.capability-label structure
- Removed all 8 orphaned service card CSS rules: .services__grid, .service-card, .service-card:hover, .service-icon, .service-card h3, .service-card p, @media .services__grid, .service-card:focus
- Added .services__intro, .capabilities, .capability, .capability p CSS rules after .services { background }
- Section id="services" and nav anchor preserved; .services background token unchanged

## Task Commits

Each task was committed atomically:

1. **Task 1: Replace #services section HTML with capabilities list** - `c8872e6` (feat)
2. **Task 2: Replace service card CSS with capabilities CSS in app.css** - `074db57` (feat)

**Plan metadata:** (docs commit follows)

## Files Created/Modified
- `client/src/index.php` - #services section rebuilt with .capabilities list; emoji icon divs and .service-card structure removed
- `client/src/assets/css/app.css` - .capabilities/.capability/.capability p CSS added; all old service card rules removed

## Decisions Made
- `gap: 2.5rem` used directly for `.capabilities` gap — no `--space-10` token exists in `:root`; the plan explicitly called this out as the correct approach
- `.capability-label` font-family already in JetBrains Mono allowlist at line 107 (`.eyebrow, .capability-label, .chip--date, .logo, pre, code`) — no duplicate font-family declaration added to new CSS

## Deviations from Plan

None - plan executed exactly as written.

## Issues Encountered

None.

## User Setup Required

None - no external service configuration required.

## Next Phase Readiness
- #services section is now .capabilities list — ready for Phase 4 Plan 3 (proof section / 04-03)
- No blockers introduced
- Calendly account question still does not block Phase 4 (only Phase 5)

---
*Phase: 04-content-sections*
*Completed: 2026-03-08*
