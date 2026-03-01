---
phase: 02-copy-and-voice-rewrite
plan: "02"
subsystem: ui
tags: [php, copy, english, origin-story, contact-cta]

# Dependency graph
requires:
  - phase: 02-copy-and-voice-rewrite
    provides: English metadata/config from plan 02-01 (meta_description, meta_keywords, site_title)
provides:
  - Origin story paragraph (CP-03) inserted under experience section h2
  - English experience section h2 ("Background & Proof")
  - English experience sub-section h3s (Education, Industry Experience, Networks & Memberships)
  - Consistent degree label "Business Informatics" in both TUM chip and LinkedIn fallback
  - Contact section CTA rewritten to English with 24-hour response commitment (CP-05)
affects:
  - 03-layout-and-structure (experience section heading/paragraph layout)
  - 04-services-and-portfolio (consistent English voice in remaining sections)

# Tech tracking
tech-stack:
  added: []
  patterns:
    - "Response-time commitment embedded inline in contact intro paragraph — no separate element needed"
    - "Degree label consistent across two locations: experience chip and LinkedIn modal fallback"
    - "Semester number intentionally omitted from fallback — would go stale"

key-files:
  created: []
  modified:
    - client/src/index.php

key-decisions:
  - "Origin story is a single 4-sentence <p> immediately after h2, before first cards-grid — no structural wrapper"
  - "Response-time commitment is embedded in contact intro paragraph, not a separate badge/element"
  - "Semester number removed from LinkedIn fallback — stale data worse than no data"
  - "Business Informatics (not 'B.Sc. Information Systems') — consistent with TUM's English program name"

patterns-established:
  - "Copy-first approach: section headers and intro paragraphs rewritten before layout adjustments"
  - "Degree label sync: experience chip and LinkedIn fallback must always match"

# Metrics
duration: 1min
completed: 2026-03-01
---

# Phase 2 Plan 02: Copy Rewrite — Experience & Contact Summary

**English origin story paragraph, translated experience section headers, and 24-hour contact CTA replacing all German copy in experience and contact sections**

## Performance

- **Duration:** 1 min
- **Started:** 2026-03-01T20:57:01Z
- **Completed:** 2026-03-01T20:58:45Z
- **Tasks:** 2
- **Files modified:** 1

## Accomplishments

- Experience section h2 rewritten to "Background & Proof" with 4-sentence origin story (family IT company → TUM → EY + hackathons)
- All four German sub-elements translated: h2, "Akademischer Hintergrund", "Agentur- & Industrieerfahrung", "Netzwerk & Mitgliedschaften"
- TUM chip corrected from "B.Sc. Information Systems" to "Business Informatics" (matches TUM's official English program name)
- Contact section h2 and intro paragraph fully replaced — response-time commitment ("24 hours") now visible adjacent to the form
- LinkedIn fallback degree string updated to match, semester number removed (was stale)

## Task Commits

Each task was committed atomically:

1. **Task 1: Replace experience section headers and insert origin story paragraph** - `03676e7` (feat)
2. **Task 2: Rewrite contact section CTA and LinkedIn fallback degree string** - `2a64b10` (feat)

**Plan metadata:** committed in docs commit (follows)

## Files Created/Modified

- `client/src/index.php` - Experience section h2/h3s translated, origin story inserted, contact CTA rewritten, degree label synced across two locations

## Decisions Made

- **Origin story as single `<p>`:** The 4-sentence paragraph is a direct sibling of the h2, before the first cards-grid. No wrapper div or additional structural elements needed — keeps DOM flat and matches existing section patterns.
- **Response-time commitment inline:** Embedded in the single contact intro `<p>` rather than a separate badge element. Sufficient per research recommendation; avoids adding structural elements Phase 3 would need to position.
- **Semester number removed:** "Semester 6" would go stale within months. The LinkedIn fallback now reads "Business Informatics, Technische Universität München (TUM)" — accurate indefinitely.
- **"Business Informatics" vs "B.Sc. Information Systems":** TUM's official English name for the program (Wirtschaftsinformatik) is Business Informatics. Both the experience chip and the LinkedIn fallback now use this label.

## Deviations from Plan

None — plan executed exactly as written.

## Issues Encountered

The Edit tool rejected writes due to a file-modification timestamp mismatch (likely a formatter watching the file). Resolved by using Python's `str.replace()` via Bash to perform all string substitutions atomically, then verifying with `grep`. No data was lost and all replacements were confirmed correct before committing.

## User Setup Required

None — no external service configuration required.

## Next Phase Readiness

- Experience section and contact section copy is fully English and positioning-anchored
- "Background & Proof" h2 + origin story paragraph structure is stable for Phase 3 layout work
- Contact section copy is final; Phase 5 (Calendly) can insert a booking link after the intro paragraph without conflicting
- Remaining German text in index.php: Impressum and Datenschutz sections (legal — intentionally kept in German per German law requirements)

---
*Phase: 02-copy-and-voice-rewrite*
*Completed: 2026-03-01*
