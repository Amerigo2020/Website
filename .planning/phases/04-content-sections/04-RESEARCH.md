# Phase 4: Content Sections - Research

**Researched:** 2026-03-09
**Domain:** HTML/CSS section layout — story prose, capabilities grid, proof list
**Confidence:** HIGH

---

## Summary

Phase 4 restructures the `#experience` section and upgrades the `#services` section within an existing PHP/CSS codebase. No new libraries are needed. All work is HTML edits to `client/src/index.php` and CSS additions to `client/src/assets/css/app.css`.

The current `#experience` section is a single massive section that contains the origin-story prose, a LinkedIn/GitHub profile-card row, 14 hackathon event chips, Education cards, Industry Experience cards, and Networks cards — all under the heading "Background & Proof". The requirements split this blob into three focused sections: the story/about section (SEC-02), the capabilities section (SEC-03), and the proof section (SEC-04). The `#services` section (the capabilities section) already has the correct copy from Phase 2 but needs its layout upgraded from three centered icon cards to capability rows with monospace labels.

The proof section completely removes the 14-chip hackathon grid. Only 4 items are kept: Enactus Bangkok, MSG Hackathon, EY, and the family business origin. Each item gets exactly one sentence of context. The LinkedIn/GitHub profile cards also currently live inside `#experience` — their final destination is the footer (Phase 5), so for Phase 4 they should simply be removed from `#experience` without being added to the footer yet (Phase 5 owns that).

**Primary recommendation:** Work section by section in the order the roadmap prescribes — 04-01 story, 04-02 capabilities, 04-03 proof — and make each plan surgical: targeted HTML replacement and targeted CSS additions.

---

## Standard Stack

No new libraries. This phase is pure HTML/CSS within the existing PHP stack.

### Core
| Tool | Version | Purpose | Why Standard |
|------|---------|---------|--------------|
| Plain HTML | — | Markup for story, capabilities, proof | Existing stack constraint; no framework |
| CSS custom properties | — | Tokens already in :root | All tokens already defined in Phase 1 |
| `client/src/index.php` | — | Single file for all HTML | Existing architecture |
| `client/src/assets/css/app.css` | — | Single CSS file | Existing architecture |

### Supporting
| Token | Value | Purpose | When to Use |
|-------|-------|---------|-------------|
| `--font-mono` | JetBrains Mono | Capability labels | Only on `.capability-label` class |
| `--bg-surface` | #111111 | Section background | Alternating section backgrounds |
| `--bg-base` | #0a0a0a | Section background | Alternating section backgrounds |
| `--bg-elevated` | #1a1a1a | Card backgrounds | Cards and chips |
| `--accent` | #6EE7B7 | Accent elements | Decorative rule, key labels |
| `--max-width-prose` | 680px | Prose constraint | Story paragraph max-width |
| `--border-subtle` | rgba(255,255,255,0.07) | Card borders | All bordered cards |
| `--space-*` | See :root | Spacing | Use only defined space tokens |

**Installation:** None required.

---

## Architecture Patterns

### Recommended HTML Structure After Phase 4

```
index.php (body flow after hero):

  #services   (capabilities — already exists, layout upgrade needed)
  #experience (story — rename to #about or keep #experience, see below)
  #proof      (new section id — replaces the 14-chip grid area)
  #contact    (unchanged in Phase 4)
```

**Note on section IDs:** The nav already uses `#experience` (anchor "About") and `#services` (anchor "What I build"). The roadmap plans are:
- 04-01 → story/about = `#experience` (keep the id, strip the chip grid content out)
- 04-02 → capabilities = `#services` (upgrade layout in place)
- 04-03 → proof = new section inserted between `#experience` and `#contact`

This means: in 04-01 the `#experience` section is gutted and rebuilt as a story section. In 04-03 a new `#proof` section is inserted after `#experience` and before `#contact`.

---

### Pattern 1: Story Section (04-01)

**What:** Replace the `#experience` section with a prose-only story section.
**When to use:** SEC-02 — one continuous first-person narrative.

**Current state (lines 358–579 in index.php):**
```html
<section id="experience" class="section experience">
    <div class="container">
        <h2>Background & Proof</h2>
        <p>I grew up helping run my family's IT services company...</p>
        <!-- LinkedIn card, GitHub card -->
        <!-- 14 event cards -->
        <!-- Education h3 + cards -->
        <!-- Industry Experience h3 + cards -->
        <!-- Networks h3 + cards -->
    </div>
</section>
```

**Target state after 04-01:**
```html
<section id="experience" class="section about">
    <div class="container">
        <h2>About</h2>
        <div class="about__prose">
            <p>I grew up helping run my family's IT services company,
               Jörg Velletti EDV Service — which meant debugging production
               systems long before I enrolled at university. [rest of origin story]</p>
        </div>
    </div>
</section>
```

The origin story paragraph already exists at line 361 — it is the correct copy from Phase 2. The plan just needs to strip everything else from the section and apply `max-width: var(--max-width-prose)` to the prose container.

**CSS needed:**
```css
/* Story / About Section */
.about {
  background: var(--bg-base);
}

.about__prose {
  max-width: var(--max-width-prose);
  margin-top: var(--space-8);
}

.about__prose p {
  color: var(--text-secondary);
  font-size: var(--text-lg);
  line-height: 1.8;
  margin-bottom: var(--space-6);
}
```

---

### Pattern 2: Capabilities Section (04-02)

**What:** Upgrade the `#services` section from centered icon cards to capability rows with monospace labels.
**When to use:** SEC-03 — output-oriented framing, no skill bars, no percentages.

**Current state:** Three service cards, centered layout, emoji icons, `text-align: center` on `.service-card`.

**The copy is already correct** (Phase 2, 02-03). The upgrade is structural: remove the centered icon cards and replace with a left-aligned list of capability rows.

**Target HTML pattern:**
```html
<section id="services" class="section services">
    <div class="container">
        <h2>What I build</h2>
        <p class="services__intro">You describe a problem. Some weeks later...</p>

        <div class="capabilities">
            <div class="capability">
                <span class="capability-label">AI & Automation</span>
                <p>I automate the workflows your team wastes hours on...</p>
            </div>
            <div class="capability">
                <span class="capability-label">Web Applications & Hosting</span>
                <p>A complete web presence: fast, accessible, and maintained...</p>
            </div>
            <div class="capability">
                <span class="capability-label">DevOps & Deployment</span>
                <p>I set up the pipelines that let you ship without fear...</p>
            </div>
        </div>
    </div>
</section>
```

**Why this pattern instead of the card grid:**
- `.capability-label` is already in the JetBrains Mono allowlist in app.css (line 107) — it was added in Phase 1 anticipating this phase
- No icons removes the "agency services brochure" feel
- Left-aligned label + prose reads as a knowledgeable person describing their work
- No need for hover transforms or box shadows on the capability itself

**CSS needed:**
```css
/* Capabilities list (replaces .services__grid / .service-card) */
.capabilities {
  margin-top: var(--space-12);
  display: flex;
  flex-direction: column;
  gap: var(--space-10);
  max-width: var(--max-width-prose);
}

.capability {
  display: flex;
  flex-direction: column;
  gap: var(--space-3);
}

.capability-label {
  font-family: var(--font-mono);
  font-size: var(--text-sm);
  color: var(--accent);
  letter-spacing: 0.04em;
}

.capability p {
  color: var(--text-secondary);
  line-height: 1.7;
  margin-bottom: 0;
}

.services__intro {
  color: var(--text-secondary);
  max-width: var(--max-width-prose);
  margin-top: var(--space-4);
}
```

Note: The existing `.services`, `.services__grid`, `.service-card`, `.service-card:hover`, `.service-icon`, `.service-card h3`, `.service-card p` rules and the `@media (min-width: 769px)` breakpoint for `.services__grid` should be removed or replaced in app.css since the old card system is gone.

---

### Pattern 3: Proof Section (04-03)

**What:** New section inserted between `#experience` and `#contact`. Contains exactly 4 curated proof items, each with one sentence of context. Replaces the 14-chip event grid that is removed from `#experience` in 04-01.
**When to use:** SEC-04.

**Items to include (from ROADMAP):**
1. Enactus Germany Worldcup — Bangkok 2025 (Winner)
2. MSG Hackathon — Code & Create (Top 3)
3. EY — Working Student, Transfer Pricing
4. Jörg Velletti EDV Service — family business origin

**Target HTML pattern:**
```html
<section id="proof" class="section proof">
    <div class="container">
        <h2>Selected proof</h2>

        <div class="proof__list">
            <div class="proof-item">
                <span class="proof-item__label">Enactus Worldcup — Bangkok 2025</span>
                <p class="proof-item__context">Won the international competition representing Germany...</p>
            </div>
            <div class="proof-item">
                <span class="proof-item__label">MSG Hackathon — Top 3</span>
                <p class="proof-item__context">Placed in the top three at the MSG Code & Create hackathon...</p>
            </div>
            <div class="proof-item">
                <span class="proof-item__label">EY — Working Student</span>
                <p class="proof-item__context">Currently working in Transfer Pricing at EY Munich...</p>
            </div>
            <div class="proof-item">
                <span class="proof-item__label">Jörg Velletti EDV Service</span>
                <p class="proof-item__context">Grew up maintaining production systems in the family IT business...</p>
            </div>
        </div>
    </div>
</section>
```

**CSS needed:**
```css
/* Proof Section */
.proof {
  background: var(--bg-surface);
}

.proof__list {
  margin-top: var(--space-12);
  display: flex;
  flex-direction: column;
  gap: 0;
  max-width: var(--max-width-prose);
}

.proof-item {
  padding: var(--space-6) 0;
  border-bottom: 1px solid var(--border-subtle);
  display: flex;
  flex-direction: column;
  gap: var(--space-2);
}

.proof-item:first-child {
  border-top: 1px solid var(--border-subtle);
}

.proof-item__label {
  font-family: var(--font-mono);
  font-size: var(--text-sm);
  color: var(--text-primary);
  letter-spacing: 0.03em;
}

.proof-item__context {
  color: var(--text-secondary);
  margin-bottom: 0;
  font-size: var(--text-base);
  line-height: 1.6;
}
```

The border-bottom list pattern (no cards, no chips, no hover) is appropriate because:
- No decorative chrome needed — the proof speaks for itself
- Matches the "person, not agency" tone
- Aligns with the capabilities section aesthetic (monospace label + prose)

---

### Section Background Alternation

Current and planned background pattern (important for visual rhythm):
```
#home (hero)       → --bg-base     (gradient to --bg-elevated)
#services          → --bg-surface  (already set)
#experience        → --bg-base     (currently has .experience class, no explicit bg rule)
#proof (new)       → --bg-surface  (alternates back)
#contact           → --bg-base     (already set)
```

This alternation creates visual separation without borders. The `.about` class replacing `.experience` should have `background: var(--bg-base)` explicitly.

---

### Anti-Patterns to Avoid

- **Keeping the 14-chip grid:** Remove it entirely in 04-01. Do not convert chips to a different format — the requirement says remove it, not redesign it.
- **Skill bars or percentages in capabilities:** The requirement explicitly excludes them. The existing copy already has none.
- **Adding icons back to capabilities:** The `.service-icon` emoji circles are part of the agency-feel being removed.
- **Making proof items cards:** The proof list must be a simple separated list, not a card grid. Cards suggest a portfolio or "all equal importance" — the bordered list prioritizes the items without visual noise.
- **Editing the Impressum section:** Lines 614 onward in index.php are off limits (confirmed in STATE.md).
- **Inline styles:** Do not use `style=""` attributes. The existing `#experience` section has `style="margin-bottom: var(--spacing-md);"` inline — this anti-pattern exists in the current code but should not be perpetuated.
- **Using --spacing-sm or --spacing-md:** These tokens do not exist. Only `--space-{N}` tokens are valid. The existing inline style with `var(--spacing-md)` is a pre-existing bug that disappears when the section is rebuilt.
- **Keeping LinkedIn/GitHub cards in #experience:** They do not belong in the story section. Their final home is the footer (Phase 5). In 04-01, they are removed from #experience. Do not add them anywhere else yet.

---

## Don't Hand-Roll

| Problem | Don't Build | Use Instead | Why |
|---------|-------------|-------------|-----|
| Prose max-width constraint | Custom wrapper divs with explicit px widths | `max-width: var(--max-width-prose)` (680px, already defined) | Token already exists in :root from Phase 1 |
| Monospace label styling | Custom font-family inline | `.capability-label` class (already in JetBrains Mono allowlist) | Class already in the font-family rule at line 107 |
| Section separators | Custom dividers or border elements | Background color alternation via CSS background property | Already how the other sections are separated |
| Section padding | Custom padding values | `var(--space-*)` tokens and `.section` class | `.section` class already provides `padding: var(--space-16) 0` |

**Key insight:** The token system from Phase 1 anticipated this phase. `.capability-label` is already scoped to JetBrains Mono. `--max-width-prose` is already defined. Every spacing value has a token. The phase is about wiring HTML structure to existing tokens, not inventing new patterns.

---

## Common Pitfalls

### Pitfall 1: Stale Section ID References

**What goes wrong:** Renaming or removing a section breaks the nav anchors.
**Why it happens:** Nav links (`#experience`, `#services`) are hardcoded in both desktop and mobile nav. They were verified as correct in Phase 3.
**How to avoid:** Do not change `id="experience"` or `id="services"`. Only change class names and interior content.
**Warning signs:** Nav links that scroll to wrong position or nowhere.

### Pitfall 2: Invalid Spacing Tokens

**What goes wrong:** Using `var(--spacing-md)` or `var(--spacing-sm)` — these do not exist. The broken inline style `style="margin-bottom: var(--spacing-md);"` on line 364 confirms the old token names.
**Why it happens:** Old code mixed two spacing systems.
**How to avoid:** Only use `--space-{N}` tokens (1, 2, 3, 4, 6, 8, 12, 16, 24). Verified at lines 42–50 of app.css.
**Warning signs:** Developer tools shows "invalid property value" for spacing custom properties.

### Pitfall 3: Leaving Old Service Card CSS Orphaned

**What goes wrong:** Removing the `.services__grid` and `.service-card` HTML but leaving their CSS creates dead rules and confusion for Phase 6 (animations).
**Why it happens:** Easy to forget to clean up CSS after removing HTML.
**How to avoid:** 04-02 plan should explicitly remove the old service-related CSS rules: `.services__grid`, `.service-card`, `.service-card:hover`, `.service-icon`, `.service-card h3`, `.service-card p`, and the `@media (min-width: 769px)` rule for `.services__grid`.
**Warning signs:** Unused CSS rules referencing classes that no longer exist in HTML.

### Pitfall 4: Overloading the Story Section

**What goes wrong:** Adding Education cards, Industry Experience cards, or Networks back into the story section because they seem related.
**Why it happens:** The old `#experience` was everything. The reflex is to keep everything together.
**How to avoid:** The story section (04-01) contains only the h2 and the origin story paragraph. Nothing else. The Education and Networks cards are permanently removed in Phase 4 — they are not needed anywhere.
**Warning signs:** Any `<div class="cards-grid">` remaining inside `#experience` after 04-01.

### Pitfall 5: Missing the Proof Section Insertion Point

**What goes wrong:** 04-03 inserts a new `<section id="proof">` in the HTML. If inserted after `#contact` instead of before it, the page flow breaks.
**Why it happens:** Index.php is large and the insertion point is easy to miss.
**How to avoid:** The proof section must be inserted between the closing `</section>` of `#experience` (line 579) and the opening `<section id="contact"` (line 582). Verify section order after insertion.
**Warning signs:** Proof section appears after the contact form on scroll.

---

## Code Examples

### Verified Token Usage Pattern (from existing app.css)

```css
/* Source: client/src/assets/css/app.css, lines 426-428 */
/* Section background — match this pattern for new sections */
.services {
  background: var(--bg-surface);
}

/* Section with alternate background */
.contact {
  background: var(--bg-base);
}
```

### Verified Prose Width Pattern (from app.css :root)

```css
/* Source: client/src/assets/css/app.css, line 54 */
/* --max-width-prose: 680px — use this for all reading-width constraints */
.about__prose {
  max-width: var(--max-width-prose);
}
```

### Verified Monospace Label Pattern (from app.css, line 106-113)

```css
/* Source: client/src/assets/css/app.css, lines 106-113 */
/* .capability-label is already in this allowlist — no new rule needed */
.eyebrow,
.capability-label,
.chip--date,
.logo,
pre,
code {
  font-family: var(--font-mono);
}
```

### Verified Border Separator Pattern (from existing .event-card)

```css
/* Source: client/src/assets/css/app.css, lines 893-899 */
/* Proof item border uses same --border-subtle token */
.profile-card,
.event-card {
  border: 1px solid var(--border-subtle);
  border-radius: 12px;
  padding: var(--space-6);
  background: var(--bg-surface);
}
```

### Existing Origin Story Paragraph (source of truth for 04-01)

```php
<!-- Source: client/src/index.php, line 361 -->
<p>I grew up helping run my family's IT services company, Jörg Velletti EDV Service —
which meant debugging production systems long before I enrolled at university. At TUM
studying Business Informatics, I developed the systems-thinking framing that connects
technical decisions to business outcomes. Today I work as a student at EY in Transfer
Pricing and compete in hackathons to keep shipping under pressure. I've won at the
Enactus Germany Worldcup (Bangkok 2025) and placed top 3 at the MSG Hackathon.</p>
```

This paragraph already satisfies SEC-02 and CP-03. The 04-01 plan does not need to rewrite it — only preserve it and strip everything else from the section.

---

## State of the Art

| Old Approach | Current Approach | When Changed | Impact |
|--------------|------------------|--------------|--------|
| `.cards-grid` with 14 event chips | 4-item proof list with context sentences | Phase 4 | SEC-04 satisfied; visual noise eliminated |
| `.service-card` centered icon cards | `.capabilities` left-aligned label+prose list | Phase 4 | SEC-03 satisfied; capability-label monospace class now used |
| `#experience` with all content mixed | `#experience` story-only + `#proof` new section | Phase 4 | SEC-02 satisfied; narrative focus preserved |

**Deprecated/outdated after Phase 4:**
- `.services__grid`: replaced by `.capabilities`
- `.service-card`, `.service-card:hover`: removed
- `.service-icon`: removed (emoji icons gone)
- `.cards-grid` inside `#experience`: removed (all chip grids gone)
- `.event-card` inside `#experience`: removed
- `.profile-card` inside `#experience`: removed (moving to footer in Phase 5)
- `h3` subheadings ("Education", "Industry Experience", "Networks") inside `#experience`: removed

---

## Open Questions

1. **Proof item copy — one sentence each**
   - What we know: The heading (e.g. "Enactus Germany Worldcup") is clear. The context sentence is not yet written.
   - What's unclear: The planner needs to draft the one-sentence context for each of the 4 proof items. This is copy work, not layout work.
   - Recommendation: The 04-03 plan should include the one-sentence context for each item in its action steps, derived from existing copy in the experience section.

2. **Section heading for proof**
   - What we know: The roadmap says "Selected proof" is not specified as the heading — SEC-04 says "proof section shows 3-4 items."
   - What's unclear: The exact h2 label is unspecified.
   - Recommendation: Use "Selected proof" or "Proof of work" — both are concrete, not generic. The planner should pick one. "Selected proof" is shorter and more direct.

3. **Education and Networks cards — final disposition**
   - What we know: They are removed from `#experience` in 04-01. They are not in the proof section (only 4 specific items are).
   - What's unclear: Are they permanently gone or deferred to another section?
   - Recommendation: Based on the roadmap and requirements, there is no phase that re-adds them. They should be considered permanently removed. The TUM education fact is covered in the origin story prose. EY is one of the 4 proof items.

---

## Sources

### Primary (HIGH confidence)
- `client/src/index.php` — read in full; sections at lines 329–579 analyzed directly
- `client/src/assets/css/app.css` — read in full; all 966 lines; token layer, section rules, responsive breakpoints
- `.planning/REQUIREMENTS.md` — SEC-02, SEC-03, SEC-04 requirements read directly
- `.planning/ROADMAP.md` — Phase 4 plan descriptions and success criteria read directly
- `.planning/STATE.md` — All accumulated decisions read directly

### Secondary (MEDIUM confidence)
- None required — this is a codebase-internal phase with no external library dependencies

### Tertiary (LOW confidence)
- None

---

## Metadata

**Confidence breakdown:**
- What HTML to change: HIGH — read the actual file, line numbers confirmed
- What CSS to write: HIGH — token vocabulary read from :root, patterns read from existing sections
- Copy for proof items: MEDIUM — the items are named in requirements, one-sentence context is not yet drafted
- Section ordering: HIGH — insertion points confirmed from reading index.php

**Research date:** 2026-03-09
**Valid until:** Stable — this is an internal codebase with no external dependencies. Valid until index.php or app.css are structurally changed.
