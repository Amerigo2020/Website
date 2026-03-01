---
phase: 01-css-foundation-reset
plan: 01
subsystem: ui
tags: [php, css, dark-mode, inline-styles, canvas, webgl]

# Dependency graph
requires: []
provides:
  - index.php with zero inline <style> blocks
  - index.php with zero PHP $colors array or color injection
  - index.php with zero themeToggle / dark-mode toggle system
  - index.php with zero hero-canvas / WebGL particle animation
  - app.css as sole CSS authority
affects:
  - 01-02 (typography/spacing tokens — can now safely override with app.css)
  - 01-03 (section-specific CSS — no competing inline rules)
  - All downstream phases that touch visual styling

# Tech tracking
tech-stack:
  added: []
  patterns:
    - "app.css is sole CSS authority — no inline <style> blocks allowed in index.php"
    - "Dark mode is unconditional — no data-theme attribute, no JS toggle, no FOUC script"
    - "LinkedIn badge always receives data-theme='dark'"

key-files:
  created: []
  modified:
    - client/src/index.php

key-decisions:
  - "Deleted $colors PHP array entirely — no consumers remain after style blocks removed"
  - "Deleted theme toggle system completely — dark mode is now permanent via app.css, no JS required"
  - "Deleted 950-line migrated-inline-styles block (media='not all') — it was pure bloat, never rendered"
  - "Fixed initLinkedIn to hardcode theme='dark' to avoid dependency on removed data-theme system"
  - "Removed hero-container-inner class from hero div — orphaned after canvas styles deleted"

patterns-established:
  - "No <style> blocks in index.php — all CSS lives in app.css"
  - "No PHP-injected CSS variables — tokens defined statically in app.css"

# Metrics
duration: 3min
completed: 2026-03-01
---

# Phase 1 Plan 01: CSS Foundation Reset — Inline Style Elimination Summary

**Removed 999 lines of competing CSS from index.php: PHP color injection, 950-line inline duplicate, FOUC script, theme toggle, WebGL canvas animation — app.css is now sole CSS authority**

## Performance

- **Duration:** 3 min
- **Started:** 2026-03-01T18:29:49Z
- **Completed:** 2026-03-01T18:33:16Z
- **Tasks:** 2
- **Files modified:** 1

## Accomplishments

- Eliminated the root cause of the light-mode override: the bare `<style>` block injecting `--color-background: #F7F7FF` on every page load
- Deleted 950-line `<style id="migrated-inline-styles" media="not all">` block — never rendered, pure payload bloat
- Removed entire dark-mode toggle system (FOUC prevention script, button, JS event listeners) — dark mode is now permanent via app.css
- Deleted `<canvas id="hero-canvas">` and 145-line WebGL Neural Constellation particle animation script
- Fixed `initLinkedIn()` to not depend on the removed `data-theme` system — badge always set to `'dark'`

## Task Commits

Each task was committed atomically:

1. **Task 1: Delete PHP $colors array and both inline style blocks** - `c5cd57c` (feat)
2. **Task 2: Delete theme toggle system, canvas, and WebGL animation** - `5fba5d2` (feat)

**Plan metadata:** (docs commit follows)

## Files Created/Modified

- `client/src/index.php` — Removed 999 lines (Task 1) + 177 lines (Task 2); file reduced from 2128 to ~954 lines

## Decisions Made

- Deleted `$colors` array entirely because it had zero consumers after the style blocks were removed
- Deleted the theme toggle system completely rather than preserving it — dark mode is now unconditional via `app.css` tokens, eliminating need for any runtime JS
- Hardcoded LinkedIn badge `data-theme` to `'dark'` in `initLinkedIn()` since the `document.documentElement.getAttribute('data-theme')` call would return `null` after removing the data-theme system
- Removed `hero-container-inner` class from the hero `<div>` because its CSS (position:relative, z-index:1) was defined inside the deleted `migrated-inline-styles` block and has no counterpart in `app.css`

## Deviations from Plan

### Auto-fixed Issues

**1. [Rule 2 - Missing Critical] Fixed initLinkedIn data-theme dependency on removed system**

- **Found during:** Task 2 (deleting theme toggle system)
- **Issue:** `initLinkedIn()` read `document.documentElement.getAttribute('data-theme')` which would return `null` after removing the data-theme attribute system, causing badge to always receive `'light'` (the `|| 'light'` fallback)
- **Fix:** Replaced `const theme = (document.documentElement.getAttribute('data-theme') || 'light')` with `const theme = 'dark'` — badge always dark to match site
- **Files modified:** `client/src/index.php`
- **Verification:** No `getAttribute('data-theme')` on documentElement remains; badge always receives `'dark'`
- **Committed in:** `5fba5d2` (Task 2 commit)

---

**Total deviations:** 1 auto-fixed (1 missing critical — data-theme null-safety)
**Impact on plan:** Fix necessary to prevent LinkedIn badge appearing in wrong theme. No scope creep.

## Issues Encountered

- The Neural Constellation `<script>` block was embedded inside the outer script block (line 1797-2126) rather than being a separate `<script>` element. An HTML comment and inner `<script>` tag appeared as text content within the JS context. Deletion required closing the outer script properly after line 1980 and deleting lines 1981-2126.

## User Setup Required

None - no external service configuration required.

## Next Phase Readiness

- `index.php` is now clean: zero `<style>` blocks, zero `$colors`, zero `themeToggle`, zero `hero-canvas`
- `app.css` is the single CSS authority — Phase 1 Plan 02 (typography/spacing tokens) and Plan 03 (section CSS cleanup) can proceed without risk of inline overrides
- PHP syntax valid (`php -l` confirms no errors)
- No blockers for 01-02 or 01-03

---
*Phase: 01-css-foundation-reset*
*Completed: 2026-03-01*
