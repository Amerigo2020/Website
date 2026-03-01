# Project State

## Project Reference

See: .planning/PROJECT.md (updated 2026-03-01)

**Core value:** A cold visitor finishes reading and thinks "I trust this person" — then reaches out.
**Current focus:** Phase 2 (Copy Rewrite) — plans 02-01 and 02-02 complete

## Current Position

Phase: 2 of 6 (Copy and Voice Rewrite) — In Progress
Plan: 2 of N in phase complete (02-01, 02-02 executed)
Status: In progress — 02-01 (metadata/config/lang) and 02-02 (experience + contact copy) done
Last activity: 2026-03-01 — Completed 02-02 (origin story, English headers, contact CTA, degree sync)

Progress: [████░░░░░░] 22% (5/18 plans complete — estimated, depends on total plan count for phase 2+)

## Performance Metrics

**Velocity:**
- Total plans completed: 5
- Average duration: ~2 min
- Total execution time: ~12 min

**By Phase:**

| Phase | Plans | Total | Avg/Plan |
|-------|-------|-------|----------|
| 01-css-foundation-reset | 3 complete | ~8 min | ~3 min |
| 02-copy-and-voice-rewrite | 2 complete | ~4 min | ~2 min |

**Recent Trend:**
- Last 5 plans: ~2–3 min
- Trend: Consistent, fast execution

*Updated after each plan completion*

## Accumulated Context

### Decisions

Decisions are logged in PROJECT.md Key Decisions table.
Recent decisions affecting current work:

- [Init]: 6-phase roadmap derived from 24 v1 requirements (count corrected from 22 in earlier draft)
- [Init]: Phase 1 (CSS) blocks all downstream work — competing PHP color injection and dark-overlay system must be eliminated before any section CSS is written
- [Init]: Copy (Phase 2) must precede layout (Phase 3) — nav labels and hero headline cannot be finalized around placeholder text
- [01-01]: $colors PHP array deleted entirely — no consumers remain after inline style blocks removed
- [01-01]: Theme toggle system deleted completely — dark mode is permanent via app.css, no runtime JS needed
- [01-01]: LinkedIn badge hardcoded to data-theme='dark' — avoids null return from removed data-theme system
- [01-01]: hero-container-inner class removed from hero div — was orphaned after canvas/WebGL CSS deleted
- [01-02]: Accent color resolved — mint #6EE7B7 (not coral #F87060, not cyan #00E5FF)
- [01-02]: Old --color-secondary (amber) mapped to --text-primary for headings — amber was garish and near-unreadable on dark backgrounds
- [01-02]: Token vocabulary established — all future CSS must use --bg-{level}, --text-{weight}, --accent, --space-{N}, --duration-{speed}
- [01-02]: No data-theme selectors in codebase — dark is permanent, not conditional; no JS required
- [01-03]: Google Fonts preconnect order is fixed — googleapis then gstatic (crossorigin) then stylesheet href
- [01-03]: Grid opacity pinned at 0.025 — higher values produce graph-paper look, not subtle texture
- [01-03]: body::before uses position:fixed so grid stays static on scroll (no parallax drift)
- [01-03]: body > * at z-index:1 establishes layering baseline — no per-component z-index overrides needed
- [01-03]: JetBrains Mono scoped to allowlist: .eyebrow, .capability-label, .chip--date, .logo, pre, code — body/h-tags/button/nav remain Inter
- [02-01]: Language is English throughout — German Impressum/Datenschutz sections remain German (legal requirement)
- [02-01]: PHP config uses English company_name/title; meta_description is positioning-anchored English copy
- [02-02]: Origin story is a single 4-sentence `<p>` immediately after experience h2, before first cards-grid
- [02-02]: Response-time commitment embedded inline in contact intro paragraph — no separate element needed
- [02-02]: Semester number removed from LinkedIn fallback — stale data worse than no data
- [02-02]: "Business Informatics" (not "B.Sc. Information Systems") — TUM's official English program name, synced across experience chip and LinkedIn fallback

### Open Questions (from research — must be resolved before execution)

- ~~Language decision: English or German for all copy? (blocks Phase 2)~~ RESOLVED: English (German legal sections kept)
- Portrait photo: Does assets/portrait.jpg exist at suitable quality? (blocks Phase 3)
- Calendly account: Configured with an intro-call event type? (blocks Phase 5)
- ~~Accent color: Muted mint green #6EE7B7 or refined coral #F87060?~~ RESOLVED: mint #6EE7B7

### Pending Todos

- Continue Phase 2 remaining plans (hero, services/capabilities copy)
- Portrait photo question must be resolved before Phase 3

### Blockers/Concerns

- Portrait photo question does not block Phase 2 but blocks Phase 3
- Calendly account question does not block Phase 2 or 3
- Impressum and Datenschutz sections intentionally remain in German (legal obligation — do not translate)

## Session Continuity

Last session: 2026-03-01T20:58:45Z
Stopped at: Completed 02-02-PLAN.md (experience section headers, origin story, contact CTA, degree sync)
Resume file: None
