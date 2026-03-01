---
phase: 01-css-foundation-reset
plan: 02
subsystem: ui
tags: [css, design-tokens, dark-mode, css-custom-properties]

# Dependency graph
requires: []
provides:
  - Single dark-first CSS token layer in app.css :root block
  - New token vocabulary: --bg-base, --bg-surface, --bg-elevated, --accent (#6EE7B7), --font-sans, --font-mono
  - Body base rule preventing FOUC without JS
  - Zero data-theme selectors in codebase
  - Zero theme-toggle CSS in codebase
  - All component var(--color-*) references migrated to new tokens
affects:
  - 01-03 (next plan in phase)
  - All downstream phases touching CSS

# Tech tracking
tech-stack:
  added: []
  patterns:
    - "Dark-first token layer: single :root block, no data-theme overrides, no JS required"
    - "Token naming: semantic (--bg-base, --text-primary, --accent) not role-mixed (--color-primary)"
    - "Body baseline in CSS layer 2 immediately after :root to prevent FOUC"

key-files:
  created: []
  modified:
    - client/src/assets/css/app.css

key-decisions:
  - "Accent color is mint #6EE7B7 — not coral #F87060 or cyan #00E5FF"
  - "Old --color-secondary (amber #FFAB00) mapped to --text-primary for headings — original was near-invisible on dark backgrounds"
  - "Collapsed both tasks into a single atomic file rewrite — cleaner than incremental sed-style patches on a 897-line file"
  - ".theme-toggle CSS fully removed; .social-btn styles preserved and updated to use new tokens"

patterns-established:
  - "Token naming: --bg-{level}, --text-{weight}, --accent, --space-{N}, --duration-{speed} — all future CSS must use this vocabulary"
  - "No data-theme selectors: dark is permanent, not conditional"
  - "No JS required for dark rendering: body background set in CSS"

# Metrics
duration: 2min
completed: 2026-03-01
---

# Phase 1 Plan 2: CSS Token Rewrite Summary

**Single dark-first :root token layer replacing 3 competing variable systems; all component var(--color-*) references migrated; zero data-theme selectors remain**

## Performance

- **Duration:** 2 min
- **Started:** 2026-03-01T18:29:57Z
- **Completed:** 2026-03-01T18:32:09Z
- **Tasks:** 2 (executed as one atomic rewrite)
- **Files modified:** 1

## Accomplishments

- Replaced old `:root` block (--color-bg-dark, --color-primary, --color-secondary, etc.) with complete new token vocabulary covering backgrounds, text, accent, borders, typography, spacing, layout, motion, and radius
- Removed all `:root[data-theme='dark']` blocks (5 distinct override blocks spanning ~250 lines) — the dark theme no longer needs JS to activate
- Replaced all `var(--color-*)` component references with new token names throughout the file; only the 3 intentionally-kept functional tokens (--color-success, --color-error, --color-white) remain
- Removed `.theme-toggle` CSS entirely while preserving `.social-btn` styles (updated to use new tokens)
- Added LAYER 2 body rule (`background-color: var(--bg-base)`) immediately after `:root` to prevent FOUC

## Task Commits

Each task was committed atomically:

1. **Tasks 1 & 2: Rewrite :root block, remove data-theme, migrate all var(--color-*)** - `0bbaae4` (feat)

**Plan metadata:** (docs commit follows this summary)

## Files Created/Modified

- `client/src/assets/css/app.css` - Complete CSS rewrite: new token layer, LAYER 2 body base, all old var(--color-*) references replaced, all data-theme overrides removed, theme-toggle CSS removed

## Decisions Made

- **Accent color is mint #6EE7B7** — resolves the open question from STATE.md. Not coral, not cyan.
- **Old --color-secondary (amber #FFAB00) mapped to --text-primary** — the original secondary was used for headings and form labels; on a dark background, amber headings were garish and near-unreadable. --text-primary (#f0f0f0) is the correct semantic mapping.
- **Old --color-background / --color-bg-dark both map to --bg-base** — these were duplicate dark background tokens; the new system has a single source of truth.
- **Single atomic file rewrite chosen over incremental patches** — with ~897 lines and 20+ substitution rules, a single Write operation is safer and more reviewable than sequential sed-style edits that can leave partial states.

## Deviations from Plan

None — plan executed exactly as written. Both tasks completed in a single write operation (an efficiency choice, not a deviation from scope).

## Issues Encountered

None.

## User Setup Required

None — no external service configuration required.

## Next Phase Readiness

- `app.css` is now the single CSS source of truth for all dark rendering
- All new component CSS written in plan 01-03 must use the new token vocabulary (--bg-base, --accent, etc.)
- The open question "Accent color: Muted mint green #6EE7B7 or refined coral #F87060?" is now resolved: mint #6EE7B7
- No blockers for plan 01-03

---
*Phase: 01-css-foundation-reset*
*Completed: 2026-03-01*
