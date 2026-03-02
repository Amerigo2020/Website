# Project State

## Project Reference

See: .planning/PROJECT.md (updated 2026-03-01)

**Core value:** A cold visitor finishes reading and thinks "I trust this person" — then reaches out.
**Current focus:** Phase 3 (Navigation and Layout Primitives) — In progress (1 of 3 plans executed)

## Current Position

Phase: 3 of 6 (Navigation and Layout Primitives) — In progress
Plan: 1 of 3 in phase complete (03-01 executed)
Status: In progress — nav labels corrected, footer background token fixed
Last activity: 2026-03-02 — Completed 03-01 (nav label update, footer background token fix)

Progress: [████▒░░░░░] 39% (7/18 plans complete — estimated)

## Performance Metrics

**Velocity:**
- Total plans completed: 6
- Average duration: ~2 min
- Total execution time: ~14 min

**By Phase:**

| Phase | Plans | Total | Avg/Plan |
|-------|-------|-------|----------|
| 01-css-foundation-reset | 3 complete | ~8 min | ~3 min |
| 02-copy-and-voice-rewrite | 3 complete | ~6 min | ~2 min |
| 03-navigation-and-layout-primitives | 1 complete | ~1 min | ~1 min |

**Recent Trend:**
- Last 5 plans: ~2 min
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
- [02-01]: Services section headings synced with Schema.org hasOfferCatalog names: AI & Automation, Web Applications & Hosting, DevOps & Deployment
- [02-01]: Stripe buy-button.js script tag and stripe-buy-button element removed from landing page; backend payment infrastructure untouched
- [02-01]: Impressum German content starts at line 614 (section) / 636 (body text) — do not touch this section
- [02-02]: Origin story is a single 4-sentence `<p>` immediately after experience h2, before first cards-grid
- [02-02]: Response-time commitment embedded inline in contact intro paragraph — no separate element needed
- [02-02]: Semester number removed from LinkedIn fallback — stale data worse than no data
- [02-02]: "Business Informatics" (not "B.Sc. Information Systems") — TUM's official English program name, synced across experience chip and LinkedIn fallback
- [02-03]: Services intro rewritten as problem-to-delivery arc ("You describe a problem. Some weeks later...") — client experience framing, not technology listing
- [02-03]: Service card bodies all start with "I" and name client outcomes, not technology categories (CP-04 satisfied)
- [02-03]: h2 casing "What I build" (lowercase b) — matches sentence case convention throughout
- [03-01]: Nav label order is About (#experience), What I build (#services), Contact (#contact) — left-to-right, desktop and mobile identical
- [03-01]: Footer background token is --bg-base (not --bg-surface) — contact section and footer must be visually seamless
- [03-01]: Impressum/Datenschutz are footer-only — zero legal links inside header (verified pre-change)

### Open Questions (from research — must be resolved before execution)

- ~~Language decision: English or German for all copy? (blocks Phase 2)~~ RESOLVED: English (German legal sections kept)
- Portrait photo: Does assets/portrait.jpg exist at suitable quality? (blocks Phase 3)
- Calendly account: Configured with an intro-call event type? (blocks Phase 5)
- ~~Accent color: Muted mint green #6EE7B7 or refined coral #F87060?~~ RESOLVED: mint #6EE7B7

### Pending Todos

- Phase 3 plan 02 is next — portrait photo question must be resolved before any plan that adds a portrait image element
- Phase 3 plan 03 (if exists) follows 02

### Blockers/Concerns

- Portrait photo question: Does assets/portrait.jpg exist at suitable quality? May block specific Phase 3 plans
- Calendly account question does not block Phase 3
- Impressum and Datenschutz sections intentionally remain in German (legal obligation — do not translate)
- Impressum section begins at line 614 in index.php — do not edit lines 614 onward

## Session Continuity

Last session: 2026-03-02T12:18:44Z
Stopped at: Completed 03-01-PLAN.md (nav labels corrected, footer background token fixed) — SUMMARY.md created
Resume file: None
