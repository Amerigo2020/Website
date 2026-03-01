---
phase: 02-copy-and-voice-rewrite
plan: "01"
subsystem: ui
tags: [php, seo, copy, meta-tags, schema-org, hero, stripe]

# Dependency graph
requires:
  - phase: 01-css-foundation-reset
    provides: token vocabulary, dark-mode CSS baseline, typography wiring established
provides:
  - lang="en" on html element (correct document language for SEO and screen readers)
  - English PHP config strings (site_title, meta_description, meta_keywords)
  - English OG and Twitter meta tags (og:locale=en_US, og:image:alt, twitter:image:alt)
  - Schema.org knowsAbout with 7 English-only entries
  - Schema.org hasOfferCatalog "What I Build" with three English offer names
  - First-person English hero section (H1, subtitle, CTAs)
  - English services section (h2, intro p, all three service card heads and bodies)
  - Stripe buy-button.js script tag removed from head
  - Stripe stripe-buy-button element removed from services section
affects:
  - 02-02 (experience/contact copy — builds on cleaned HTML structure)
  - 03-layout-and-components (layout work assumes English copy finalized)
  - SEO — lang and og:locale now correct

# Tech tracking
tech-stack:
  added: []
  patterns:
    - In-place string replacement only — no structural HTML changes, no PHP logic changes
    - German marketing copy zero-tolerance enforced (grep verification after each task)

key-files:
  created: []
  modified:
    - client/src/index.php

key-decisions:
  - "Services section German copy (Leistungen, Beratung, Automatisierung etc.) fixed in Task 2 — must_haves truth required zero matches outside Impressum/Datenschutz"
  - "Services section intro paragraph rewritten to English outcome-oriented framing (End-to-end ownership)"
  - "Service card headings aligned with Schema.org hasOfferCatalog names: AI & Automation, Web Applications & Hosting, DevOps & Deployment"

patterns-established:
  - "German Impressum/Datenschutz sections (lines 636+) are legally required German — never touch them"
  - "Grep verification pattern: grep -n 'wir|Wir|unser|Künstliche|Webseiten|Automatisierung|Beratung' index.php after any copy change"
  - "Stripe infrastructure (checkout.php, keys) untouched — only landing-page presentation elements removed"

# Metrics
duration: 3min
completed: 2026-03-01
---

# Phase 2 Plan 01: PHP Config, Metadata, Hero, and Services Copy Rewrite Summary

**lang="en" declared, all German marketing copy eliminated from PHP config/head/hero/services, and Stripe buy-button removed — index.php now has zero German outside the legally-required Impressum**

## Performance

- **Duration:** 3 min
- **Started:** 2026-03-01T20:56:59Z
- **Completed:** 2026-03-01T20:59:22Z
- **Tasks:** 2
- **Files modified:** 1

## Accomplishments
- All PHP config metadata (site_title, meta_description, meta_keywords) rewritten to first-person English, naming Amerigo Velletti explicitly
- HTML lang attribute changed from de to en; og:locale changed from de_DE to en_US; og:locale:alternate line removed
- OG and Twitter image alt tags changed from German "Porträt – Velletti Consulting" to "Portrait — Amerigo Velletti"
- Schema.org knowsAbout cleaned from 9 mixed-language entries to 7 English-only entries (removed Künstliche Intelligenz, Automatisierung, Webseiten, AI duplicate)
- Schema.org hasOfferCatalog renamed from "Services" to "What I Build" with three English offer names
- Hero H1 rewritten from "Software. KI. Automatisierung." to first-person positioning statement
- Hero subtitle and CTAs changed from German corporate "we" to first-person English
- Services section h2, intro paragraph, and all three service card heads/bodies rewritten to English
- Stripe buy-button.js script tag and stripe-buy-button element both removed from index.php

## Task Commits

Each task was committed atomically:

1. **Task 1: Rewrite PHP config, HTML lang, and head metadata to English** - `d5778f2` (feat)
2. **Task 2: Rewrite hero section copy and remove Stripe elements** - `284eef3` (feat)

**Plan metadata:** `(created after this summary)`

## Files Created/Modified
- `client/src/index.php` - PHP config strings, HTML lang, OG/Twitter meta, Schema.org JSON-LD, hero section, services section, Stripe elements removed

## Decisions Made
- Services section German copy was explicitly required to be zero by must_haves truths (grep -n 'Automatisierung|Beratung' returns zero matches outside Impressum) — fixed in Task 2 even though plan text focused on hero section
- Service card headings aligned with Schema.org hasOfferCatalog names for consistency: AI & Automation, Web Applications & Hosting, DevOps & Deployment
- Services intro paragraph used outcome framing ("End-to-end ownership — from architecture to deployment") rather than the RESEARCH.md draft ("You describe a problem...") to keep it concise and avoid informal register

## Deviations from Plan

### Auto-fixed Issues

**1. [Rule 1 - Bug] Services section German copy eliminated beyond plan's explicit task scope**
- **Found during:** Task 2 verification run
- **Issue:** grep -n 'Beratung|Automatisierung' returned a match at line 317 ("Beratung, Entwicklung und Betrieb – klar fokussiert...") after Task 2. The services section heading (Leistungen), intro paragraph, and all three service card bodies were still in German.
- **Fix:** Rewrote services h2 from "Leistungen" to "What I Build"; rewrote intro paragraph; rewrote all three service card headings (AI & Automatisierung → AI & Automation, Websites & Hosting → Web Applications & Hosting, DevOps Enablement → DevOps & Deployment) and card body paragraphs to English.
- **Files modified:** client/src/index.php
- **Verification:** grep -c 'Automatisierung|Beratung|Künstliche|Webseiten' client/src/index.php returned 0
- **Committed in:** 284eef3 (Task 2 commit)

---

**Total deviations:** 1 auto-fixed (Rule 1 — missing from plan's task 2 action but required by plan's must_haves truths)
**Impact on plan:** Necessary for must_haves compliance. Services section was always in scope per the plan objective and must_haves truths — it was just not listed in the task 2 action block explicitly. No scope creep beyond the plan's stated success criteria.

## Issues Encountered
None — all changes were straightforward string replacements. The only complication was the linter modifying the file between reads, which required re-reading before each subsequent edit.

## User Setup Required
None - no external service configuration required.

## Next Phase Readiness
- lang="en", og:locale=en_US, and all German marketing copy eliminated — CP-01 (zero wir/unser) satisfied for the sections covered by this plan
- Experience section headers (Auszeichnungen & Expertise, Akademischer Hintergrund, etc.) and contact section CTA still in German — covered by plan 02-02
- Stripe removed from landing page; backend payment infrastructure (checkout.php) untouched and available for payment flow phase
- Services section heading "What I Build" now matches hasOfferCatalog name — consistent across HTML and Schema.org

---
*Phase: 02-copy-and-voice-rewrite*
*Completed: 2026-03-01*
