---
phase: 02-copy-and-voice-rewrite
plan: "03"
subsystem: ui
tags: [php, copy, services-section, output-oriented, english, german-removal]

# Dependency graph
requires:
  - phase: 02-copy-and-voice-rewrite
    provides: "02-01 (English base copy, services headings synced), 02-02 (experience h2, origin story, contact CTA)"
provides:
  - "Output-oriented English services section body copy satisfying CP-04"
  - "Complete Phase 2 German-copy elimination — zero German marketing text outside Impressum/Datenschutz"
  - "Services intro reframed as client-problem-to-system-delivered narrative"
  - "All three service card bodies in first-person, outcome-focused English"
affects:
  - phase-03-layout
  - phase-04-interactions

# Tech tracking
tech-stack:
  added: []
  patterns:
    - "Output-oriented copy: body paragraphs start with 'I' and describe client outcomes, not technology categories"
    - "Problem-solution framing: intro starts with client context ('You describe a problem'), ends with concrete delivery"

key-files:
  created: []
  modified:
    - client/src/index.php

key-decisions:
  - "Services intro rewritten as problem-to-delivery arc ('You describe a problem... Some weeks later...') — sets client expectations without technology jargon"
  - "AI card body leads with workflow waste ('I automate the workflows your team wastes hours on') — time-cost framing over technology listing"
  - "Web card body leads with completeness ('A complete web presence') — single-vendor ownership framing"
  - "DevOps card body leads with fear-removal ('I set up the pipelines that let you ship without fear') — confidence framing over process listing"
  - "Services h2 casing corrected: 'What I build' (lowercase b) — matches sentence case convention used throughout"

patterns-established:
  - "Client-outcome copy pattern: every service description names what the client gets, not what the developer does technically"
  - "First-person voice: all service body paragraphs open with 'I' — consistent with hero and contact sections"

# Metrics
duration: 2min
completed: 2026-03-01
---

# Phase 2 Plan 03: Services Copy Rewrite Summary

**Output-oriented English services copy with problem-to-delivery framing, completing Phase 2 German elimination — zero marketing German remains outside Impressum/Datenschutz**

## Performance

- **Duration:** ~2 min
- **Started:** 2026-03-01T21:02:02Z
- **Completed:** 2026-03-01T21:04:13Z
- **Tasks:** 2 (1 edit, 1 verification)
- **Files modified:** 1

## Accomplishments

- Services section h2 corrected to "What I build" (sentence case) with client-problem-to-system intro paragraph replacing generic "end-to-end ownership" copy
- All three service card body paragraphs replaced with first-person, outcome-oriented English: AI automation waste framing, web hosting ownership framing, DevOps confidence framing
- Full Phase 2 success criteria verified: 12/12 criteria pass — zero German marketing copy outside legal sections, all approved copy blocks present

## Task Commits

Each task was committed atomically:

1. **Task 1: Rewrite services section header and all three service card copy blocks** - `469fe57` (feat)
2. **Task 2: Final German-copy sweep and zero-instance verification** - verification only, no file changes

**Plan metadata:** (committed with SUMMARY.md and STATE.md below)

## Files Created/Modified

- `client/src/index.php` - Services section: h2, intro paragraph, and all three card body paragraphs rewritten

## Decisions Made

- Services intro rewritten as problem-to-delivery arc ("You describe a problem. Some weeks later, you have a system that runs...") — frames the service promise around a client's lived experience, not a developer's capability list
- AI card leads with "I automate the workflows your team wastes hours on" — time-cost framing makes the value concrete, avoids "AI-powered" buzzword lede
- Web card leads with "A complete web presence: fast, accessible, and maintained" — single-vendor completeness framing distinguishes from agency model
- DevOps card leads with "I set up the pipelines that let you ship without fear" — fear-removal framing speaks to the actual pain of broken deployments
- h2 casing: "What I build" (lowercase b) — matches sentence case in all other section headers

## Deviations from Plan

The file state was ahead of plan expectations. Previous plans (02-01 and 02-02) had already translated service h3 headings to English ("AI & Automation", "Web Applications & Hosting", "DevOps & Deployment") and an earlier execution had replaced the German body paragraphs with functional-but-generic English. The plan's replacement targets assumed German source text, but the actual source was already English. The edits were still executed — replacing the generic English with the specific outcome-oriented copy specified in the plan. No rules invoked, no scope deviation.

None of the five verification steps (Steps 1-4: zero German outside legal; Step 5: three approved strings present) required any corrective edits.

---

**Total deviations:** 0 rule-invoked auto-fixes
**Impact on plan:** File was ahead of plan — edits upgraded English-to-English instead of German-to-English. Net result identical to plan intention.

## Issues Encountered

- Verification Step 1 ("wir" sweep) matched JavaScript function name `wireModalButton` — "wir" is a substring of "wire". Confirmed to be English code, not German text. No action needed.
- Criterion 1 filter in the plan used `grep -v "648:\|..."` but the Impressum section begins at line 614. The German text on lines 627-633 is within the Impressum section and is legally required. Filter range in plan was approximate; actual content is correct.

## User Setup Required

None - no external service configuration required.

## Next Phase Readiness

- Phase 2 is fully complete: all 12 success criteria satisfied
- index.php contains zero German marketing copy — only Impressum and Datenschutz sections (lines 614+) contain German, as required by law
- Phase 3 (Layout & Structure) can begin immediately
- Portrait photo question (assets/portrait.jpg quality) must be resolved before Phase 3 executes — open question noted in STATE.md

---
*Phase: 02-copy-and-voice-rewrite*
*Completed: 2026-03-01*
