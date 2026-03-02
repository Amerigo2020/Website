# Requirements: Velletti — Personal Brand Redesign

**Defined:** 2026-03-01
**Core Value:** A cold visitor finishes reading and thinks "I trust this person" — then reaches out.

---

## v1 Requirements

### Design System

- [ ] **DS-01**: Rebuild CSS token layer dark-first — eliminate the 3 competing color systems (app.css, inline `<style>`, PHP-injected block) into a single source of truth
- [ ] **DS-02**: Implement dark color system: `--bg-base: #0a0a0a`, `--bg-surface: #111111`, `--bg-elevated: #1a1a1a`, `--accent: #6EE7B7`
- [ ] **DS-03**: Load Inter (variable, Google Fonts CDN) as the sole body/display typeface
- [ ] **DS-04**: Load JetBrains Mono (2 weights, Google Fonts CDN) scoped strictly to labels, dates, and technical identifiers
- [ ] **DS-05**: Remove theme toggle mechanism entirely — dark is permanent
- [ ] **DS-06**: Replace WebGL canvas hero background with CSS-only subtle grid (body::before, ~2.5% opacity linear-gradient)

### Copy & Voice

- [ ] **CP-01**: Rewrite all copy to first-person English — zero instances of "we", "our", "wir", "unser"
- [ ] **CP-02**: Write a single-sentence positioning statement: what you build and for whom (e.g. "I build complete systems — from database to UI — for startups that need one person to own the technical side")
- [ ] **CP-03**: Write origin story section (3–5 sentences): family business production experience → TUM Business Informatics → systems-thinking approach
- [ ] **CP-04**: Rewrite capability/services section as output-oriented copy — describe what a finished project looks like for the client, not which tech stack is used
- [ ] **CP-05**: Add response time commitment near the contact CTA ("I reply to every inquiry within 24 hours")

### Page Structure & Sections

- [ ] **SEC-01**: Hero section — photo visible without scrolling, name, positioning statement (CP-02), primary CTA
- [ ] **SEC-02**: Story/About section — origin story (CP-03), connects family business to present capability
- [ ] **SEC-03**: Capabilities section — output-oriented framing (CP-04), no generic category labels
- [ ] **SEC-04**: Proof section — curate 3–4 items (Enactus Worldcup Bangkok, MSG Hackathon Top 3, EY working student, family business origin), each with one sentence of context; remove the 14-chip grid
- [ ] **SEC-05**: Contact section — dual CTA: contact form (restyled existing PHP form) + "Book a call" Calendly link/embed side-by-side

### CTA & Conversion

- [ ] **CTA-01**: Remove Stripe buy button from the main page — payment lives only on checkout.php, accessible post-conversation
- [ ] **CTA-02**: Add Calendly booking option (link or embed) alongside the existing contact form in the contact section
- [ ] **CTA-03**: Demote social links (LinkedIn, GitHub) from header to footer — reduce premature exit paths

### Navigation & Layout

- [ ] **NAV-01**: Navigation labels reflect the redesigned section structure (not generic "Services", "About")
- [ ] **NAV-02**: Move Impressum/Datenschutz to footer only — out of main navigation
- [ ] **NAV-03**: Verify mobile-responsive layout holds for all redesigned sections

### Animation & Interaction

- [ ] **ANI-01**: Implement subtle entrance animations via IntersectionObserver + CSS transitions (no animation libraries)
- [ ] **ANI-02**: All animations are entrance-only, no looping — content is readable without animation

---

## v2 Requirements

### Social Proof

- **PROOF-01**: Named testimonials with full name, company, and context — only if real clients can provide them
- **PROOF-02**: Case studies / project deep-dives (currently out of scope per PROJECT.md)

### Content

- **CONT-01**: "How I approach a project" narrative piece — a single authored section, no date, never goes stale

### Analytics

- **ANA-01**: GDPR-compliant analytics (Plausible recommended over GA4 for German audience)

---

## Out of Scope

| Feature | Reason |
|---------|--------|
| Blog / articles | Requires consistent publishing; 2-post graveyard actively hurts trust |
| Light mode | Dark is a deliberate, permanent design decision |
| Agency/team framing | Solo personal brand — "we" is explicitly removed |
| Multi-page architecture | Single-page or near-single-page is the right scope for a personal brand site |
| Fake terminal / typing animations | Hacker-movie aesthetic kills trust with both technical and non-technical buyers |
| Testimonials without real sources | Placeholder praise is immediately recognizable and trust-damaging |

---

## Traceability

| Requirement | Phase | Status |
|-------------|-------|--------|
| DS-01 | Phase 1 — CSS Foundation Reset | Complete |
| DS-02 | Phase 1 — CSS Foundation Reset | Complete |
| DS-03 | Phase 1 — CSS Foundation Reset | Complete |
| DS-04 | Phase 1 — CSS Foundation Reset | Complete |
| DS-05 | Phase 1 — CSS Foundation Reset | Complete |
| DS-06 | Phase 1 — CSS Foundation Reset | Complete |
| CP-01 | Phase 2 — Copy & Voice Rewrite | Complete |
| CP-02 | Phase 2 — Copy & Voice Rewrite | Complete |
| CP-03 | Phase 2 — Copy & Voice Rewrite | Complete |
| CP-04 | Phase 2 — Copy & Voice Rewrite | Complete |
| CP-05 | Phase 2 — Copy & Voice Rewrite | Complete |
| NAV-01 | Phase 3 — Navigation & Layout Primitives | Complete |
| NAV-02 | Phase 3 — Navigation & Layout Primitives | Complete |
| NAV-03 | Phase 3 — Navigation & Layout Primitives | Complete |
| SEC-01 | Phase 3 — Navigation & Layout Primitives | Complete |
| SEC-02 | Phase 4 — Content Sections | Pending |
| SEC-03 | Phase 4 — Content Sections | Pending |
| SEC-04 | Phase 4 — Content Sections | Pending |
| SEC-05 | Phase 5 — Contact & CTA | Pending |
| CTA-01 | Phase 5 — Contact & CTA | Pending |
| CTA-02 | Phase 5 — Contact & CTA | Pending |
| CTA-03 | Phase 5 — Contact & CTA | Pending |
| ANI-01 | Phase 6 — Animation & Polish | Pending |
| ANI-02 | Phase 6 — Animation & Polish | Pending |

**Coverage:**
- v1 requirements: 24 total (corrected from earlier draft count of 22 — DS×6, CP×5, SEC×5, CTA×3, NAV×3, ANI×2)
- Mapped to phases: 24
- Unmapped: 0

---
*Requirements defined: 2026-03-01*
*Last updated: 2026-03-01 — traceability expanded to individual requirement rows; count corrected to 24*
