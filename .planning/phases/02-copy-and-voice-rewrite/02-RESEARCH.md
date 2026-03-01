# Phase 2: Copy & Voice Rewrite — Research

**Researched:** 2026-03-01
**Domain:** Copy audit, first-person English voice, conversion-oriented positioning copy
**Confidence:** HIGH — grounded entirely in direct file inspection of index.php and FEATURES.md

---

## Summary

The existing index.php is written in German corporate "we" voice throughout, with a mix of German marketing copy and English form labels. Every major content section — hero, services, experience header, contact CTA, and meta tags — contains either German copy, "we/our/wir/unser" language, or both.

The standard approach for this phase is surgical replacement: locate each offending string in the file, replace it with approved English first-person copy. No structural HTML changes are needed — this phase is strictly a copy pass. The executor needs exact replacement text for each location to avoid vague rewrites.

The drafted copy below applies the following principles verified in FEATURES.md: output-oriented framing over input-listing, the specificity test (generic dev cannot say this), acknowledgment of buyer fear ("someone who owns the problem"), and response-time commitment as a trust signal.

**Primary recommendation:** Replace every string listed in "Copy Audit" below with the exact draft copy provided in "Approved Replacement Copy." Execute replacements in file-location order (top of file to bottom) to avoid confusion.

---

## Copy Audit: Every String That Must Change

Each entry shows: the current text (quoted), its file location by line number, and whether it is German, corporate "we", or both.

### 1. PHP Config Block — Site Metadata (Lines 21–27)

**Current:**
```
'site_title' => 'Velletti Consulting | AI, Automatisierung, Websites & Hosting'
'meta_description' => 'Velletti Consulting in München – AI (Künstliche Intelligenz), Automatisierung, Aufbau und Hosting moderner Websites. Beratung, Entwicklung und Betrieb.'
'meta_keywords' => 'Velletti Consulting, AI, Künstliche Intelligenz, Automatisierung, Webentwicklung, Webseiten, Website Hosting, DevOps, München, Beratung'
```
**Problems:** German throughout. Keywords include "Künstliche Intelligenz", "Webseiten", "Beratung."

### 2. HTML Lang Attribute (Line 143)

**Current:** `<html lang="de">`
**Problem:** Declares German document. Must be English.

### 3. Open Graph / Twitter Meta — Locale and Image Alt (Lines 159, 164, 167)

**Current:**
```
<meta property="og:locale" content="de_DE">
<meta property="og:image:alt" content="Porträt – Velletti Consulting">
<meta name="twitter:image:alt" content="Porträt – Velletti Consulting">
```
**Problem:** German locale declaration; "Porträt" is German.

### 4. Schema.org JSON-LD — knowsAbout and hasOfferCatalog (Lines 205–233)

**Current knowsAbout entries:**
- `"Künstliche Intelligenz"` (line 208)
- `"Automatisierung"` (line 210)
- `"Webseiten"` (line 212)

**Current offer names:**
- `"AI & Automatisierung"` (line 222)
- `"Websites & Hosting"` (line 226)
- `"DevOps Enablement"` (line 230)

**Problem:** German entries mixed in knowsAbout; offer names are generic category labels.

### 5. Hero Section (Lines 314–322)

**Current:**
```html
<h1 class="hero__title">Software. KI. Automatisierung.</h1>
<p class="hero__subtitle">
    Wir entwickeln zukunftssichere digitale Lösungen für Ihr Unternehmen.
    <br>Von der ersten Idee bis zum Betrieb maßgeschneiderter Systeme.
</p>
<a href="#contact" class="cta-button">Projektanfrage starten</a>
<a href="#services" class="cta-button cta-button--outline">Unsere Leistungen</a>
```
**Problems:**
- H1 is a German market category label ("Software. KI. Automatisierung.")
- Subtitle contains "Wir" (we) and "Ihr" (your — formal German)
- CTA "Projektanfrage starten" is German
- "Unsere Leistungen" = "Our Services" — corporate "our"

### 6. Services Section Header (Lines 330–332)

**Current:**
```html
<h2>Leistungen</h2>
<p>Beratung, Entwicklung und Betrieb – klar fokussiert auf AI, Automatisierung sowie moderne Websites & Hosting.</p>
```
**Problems:** "Leistungen" is German for "services." Intro paragraph is German.

### 7. Service Card — AI (Lines 337–342)

**Current:**
```html
<h3>AI & Automatisierung</h3>
<p>
    Von Proof-of-Concept bis Produktion: KI-gestützte Workflows, Automatisierung von Prozessen,
    Integrationen und agentische Systeme zur Effizienzsteigerung.
</p>
```
**Problems:** Card title and body are German. "KI-gestützte", "Effizienzsteigerung" — generic agency language.

### 8. Service Card — Websites (Lines 344–350)

**Current:**
```html
<h3>Websites & Hosting</h3>
<p>
    Moderne Unternehmens-Websites: Performance, SEO, Barrierefreiheit – inkl. Hosting, Domain,
    Deployment und Monitoring für einen stabilen Betrieb.
</p>
```
**Problems:** Body paragraph is German. Generic category framing.

### 9. Service Card — DevOps (Lines 352–359)

**Current:**
```html
<h3>DevOps Enablement</h3>
<p>
    Build-/Release-Pipelines, Infrastruktur als Code, Observability und Automatisierung –
    damit Teams schneller und sicherer liefern.
</p>
```
**Problems:** Body is German. "damit Teams" = "so that teams" — generic agency framing.

### 10. Experience Section Header (Lines 375–376)

**Current:**
```html
<h2>Auszeichnungen & Expertise</h2>
<p>Unsere Erfahrung aus branchenübergreifenden Projekten, Hackathons und Auszeichnungen.</p>
```
**Problems:** "Auszeichnungen & Expertise" is German. "Unsere Erfahrung" = "Our experience" — corporate "our."

### 11. Experience Sub-section Headers (Lines 512, 531, 558)

**Current:**
```html
<h3>Akademischer Hintergrund</h3>
<h3>Agentur- & Industrieerfahrung</h3>
<h3>Netzwerk & Mitgliedschaften</h3>
```
**Problems:** All three subheadings are German.

### 12. Contact Section CTA (Lines 603–604)

**Current:**
```html
<h2>Projektanfrage starten</h2>
<p>Bereit für das nächste Projekt? Schreiben Sie uns und wir melden uns zeitnah bei Ihnen.</p>
```
**Problems:**
- "Projektanfrage starten" is German for "Start project inquiry"
- Body contains "uns" (us), "wir melden uns" (we'll get back to you) — corporate "we"
- "zeitnah" is German for "promptly" — this is where the response time commitment (CP-05) belongs

### 13. LinkedIn Fallback Text (Line 757)

**Current:**
```
B.Sc. Information Systems (Semester 6), Technische Universität München
```
**Problem:** Describes Semester 6, but the TUM card at line 520 says "Semester 7." Needs to match. Also the degree is "Business Informatics" per context (resolved decisions), but the file says "Information Systems." This needs confirming — the file says "B.Sc. Information Systems" in both the experience card (line 518) and the LinkedIn fallback. The context brief says "Business Informatics student at TUM." These must agree. Research finding: the degree label needs a single decision. The experience card at line 518 reads `B.Sc. Information Systems` — this is an English label so it does not require German-to-English conversion, but it may need correction to match the actual degree name. Flag as needing executor confirmation.

---

## What Stays (Do Not Touch)

### Impressum Section (Lines 648–674)

The Impressum is a German legal requirement. German content here is mandatory. The boilerplate ("Dienstanbieter gemäß § 5 TMG", "Haftung für Inhalte", etc.) must remain in German. The contact details (phone, email, address) are already output by PHP config and are language-neutral.

**Do not touch:**
- Lines 650–674: All Impressum content
- Lines 680–708: All Datenschutzerklärung content
- Footer links: `<a href="#impressum">Impressum</a>` and `<a href="#privacy">Datenschutz</a>` — these legal navigation labels may stay German as they are established German legal terms

### Contact Form Labels (Lines 610–642)

The form fields (Name, Email, Phone, Message, Send Message) are already in English. Leave them.

### Navigation Labels (Lines 268–270)

"Services", "Events", "Contact" are already English. Leave them. (Note: the nav link says "Events" but the section heading says "Auszeichnungen & Expertise" — the heading needs to change but the nav label can stay.)

---

## Approved Replacement Copy

This section contains the exact copy the executor should use. Each block is ready to paste.

---

### PHP Config Block (replaces lines 21–23)

```php
'site_title' => 'Amerigo Velletti | Systems Builder for Startups — Munich',
'meta_description' => 'I build complete systems — from backend to UI — for startups and small teams that need one person to own the technical side. Based in Munich, studying Business Informatics at TUM.',
'meta_keywords' => 'Amerigo Velletti, systems developer, full-stack developer, startup developer, Munich, TUM, Business Informatics, automation, web development, DevOps',
```

---

### HTML Lang Attribute

```html
<html lang="en">
```

---

### Open Graph / Twitter Meta

```html
<meta property="og:locale" content="en_US">
<meta property="og:image:alt" content="Portrait — Amerigo Velletti">
<meta name="twitter:image:alt" content="Portrait — Amerigo Velletti">
```

---

### Schema.org knowsAbout — Remove German Duplicates

Replace the `knowsAbout` array with English-only entries:
```json
"knowsAbout": [
    "Artificial Intelligence",
    "Automation",
    "Web Development",
    "Web Hosting",
    "DevOps",
    "Full-Stack Development",
    "Systems Architecture"
]
```

Replace the `hasOfferCatalog` offer names:
```json
"hasOfferCatalog": {
    "@type": "OfferCatalog",
    "name": "What I Build",
    "itemListElement": [
        { "@type": "Offer", "name": "AI & Automation" },
        { "@type": "Offer", "name": "Web Applications & Hosting" },
        { "@type": "Offer", "name": "DevOps & Deployment" }
    ]
}
```

---

### Hero Section

**H1 (positioning statement — satisfies CP-02):**
```
I build complete systems — from backend to UI — for startups that need one person to own the technical side.
```

**Subtitle (supports positioning, first-person English):**
```
From the first conversation to production. I own the architecture, the code, and the deployment — so you don't have to manage a developer.
```

**Primary CTA button:**
```
Start a project
```

**Secondary CTA button:**
```
What I build
```

**Design note:** The hero section currently has two CTA buttons. Both should change. No structural changes needed — just text replacement.

---

### Services Section Header (satisfies CP-04 framing)

**H2:**
```
What I build
```

**Intro paragraph (output-oriented, first-person):**
```
You describe a problem. Some weeks later, you have a system that runs: a backend that handles your business logic, a front end your team can actually use, and deployments that don't require you to call me at 2am.
```

---

### Service Card — AI & Automation (replaces current German card)

**H3:**
```
AI & Automation
```

**Body (output-oriented — describes what the client ends up with, not what I do):**
```
I automate the workflows your team wastes hours on. The result: AI-assisted processes that run without manual intervention, integrated into the systems you already use.
```

---

### Service Card — Web Applications & Hosting (replaces current German card)

**H3:**
```
Web Applications & Hosting
```

**Body:**
```
A complete web presence: fast, accessible, and maintained. I handle the domain, the hosting, the deployment pipeline, and the monitoring — so the site stays up and you stay focused on your business.
```

---

### Service Card — DevOps & Deployment (replaces current German card)

**H3:**
```
DevOps & Deployment
```

**Body:**
```
I set up the pipelines that let you ship without fear. CI/CD, infrastructure as code, observability — so every release is predictable and every incident is visible.
```

---

### Experience Section Header (satisfies CP-03 context setup)

**H2:**
```
Background & Proof
```

**Intro paragraph (origin story — satisfies CP-03):**
```
I grew up helping run my family's IT services company, Jörg Velletti EDV Service — which meant debugging production systems long before I enrolled at university. At TUM studying Business Informatics, I developed the systems-thinking framing that connects technical decisions to business outcomes. Today I work as a student at EY in Transfer Pricing and compete in hackathons to keep shipping under pressure. I've won at the Enactus Germany Worldcup (Bangkok 2025) and placed top 3 at the MSG Hackathon.
```

**Specificity test:** A generic developer cannot say any of this. Each sentence contains a proper noun or verifiable fact specific to Amerigo.

---

### Experience Sub-section Headers

**"Akademischer Hintergrund" replacement:**
```
Education
```

**"Agentur- & Industrieerfahrung" replacement:**
```
Industry Experience
```

**"Netzwerk & Mitgliedschaften" replacement:**
```
Networks & Memberships
```

---

### Contact Section (satisfies CP-01 and CP-05)

**H2:**
```
Start a conversation
```

**Intro paragraph (first-person English + response time commitment from CP-05):**
```
Tell me about your project. I reply to every inquiry within 24 hours.
```

**Design note:** The response time commitment ("I reply to every inquiry within 24 hours") is embedded directly in the intro paragraph per CP-05. It should be visually distinct — the planner can decide whether to render it as a separate `<p>` tag with emphasis, or inline. Either is valid as long as it is visible near the contact form CTA.

---

### LinkedIn Fallback Text

**Current (line 757):**
```
B.Sc. Information Systems (Semester 6), Technische Universität München
```

**Replacement:**
```
Business Informatics, Technische Universität München (TUM)
```

**Note on degree label discrepancy:** The file uses "B.Sc. Information Systems" in two places (LinkedIn fallback, line 757; experience card, line 518). The context brief states "Business Informatics student at TUM." These need to agree. Research recommendation: use "Business Informatics" (the more common English name for TUM's "Wirtschaftsinformatik" program). The executor should apply this change to both the experience card chip (line 518) and the LinkedIn fallback (line 757).

---

## Architecture Patterns

### Pattern: In-Place String Replacement, No Structural Changes

This phase touches only visible text content and meta-tag strings. It does not:
- Add or remove HTML elements
- Change CSS class names
- Modify the PHP logic above line 141
- Touch any JavaScript

All replacements are either:
1. PHP config string values (lines 21–27) — replace the quoted string values
2. HTML text content — replace the text between tags
3. HTML attribute values — replace the attribute value strings

**Exception:** If the planner decides to add the response time commitment as a separate `<p>` tag below the existing contact intro paragraph, that is the only structural addition permitted in this phase. Keep it minimal: one `<p>` tag.

### Anti-Patterns to Avoid

- **Translating the Impressum:** Leave the Impressum and Datenschutz sections in German. They are legal documents written in the language the law requires.
- **Changing the PHP variable names:** `$config['company_name']`, `$config['meta_description']` etc. — only the string values change, not the variable names.
- **Rewriting the contact form field labels:** They are already English (Name, Email, Phone, Message). Do not alter them.
- **Partial rewrites that leave isolated German words:** The zero-instances requirement is strict. Run a grep check after changes: `grep -n "wir\|unser\|Wir\|Unser\|unsere\|Unsere" index.php` to verify.

---

## Don't Hand-Roll

| Problem | Don't Build | Use Instead | Why |
|---------|-------------|-------------|-----|
| Checking for remaining German/corporate copy | Manual scan | `grep -in "wir\|unser\|leistungen\|anfrage\|berat" index.php` | Fast, complete, repeatable |
| Writing positioning copy from scratch | Original composition | The approved copy above | Already specificity-tested and on-brand |

---

## Common Pitfalls

### Pitfall 1: "Datenschutz" and "Impressum" in Footer Links

**What goes wrong:** Executor changes footer nav links to English ("Privacy Policy", "Legal Notice"), removing the German legal terminology.
**Why it happens:** The "zero German" rule reads as absolute.
**How to avoid:** The rule applies to marketing copy. "Impressum" and "Datenschutz" are legal terms that German visitors expect to see in German. The footer link text can stay as-is, or the planner can specify English equivalents with the German in parentheses — but do not remove the German terms from the legal sections themselves.

### Pitfall 2: Inconsistent Degree Name

**What goes wrong:** "B.Sc. Information Systems" in experience card and "Business Informatics" in LinkedIn fallback — two different strings for the same degree.
**Why it happens:** The two strings are in different sections and easy to miss.
**How to avoid:** The executor must update both instances (line 518 and line 757) in the same pass. Recommend a global search: `grep -n "Information Systems\|Business Informatics" index.php`.

### Pitfall 3: Stripe Buy Button Left In Services Section

**What goes wrong:** The Stripe buy button (lines 364–368) remains in the services section after copy rewrite.
**Why it happens:** It's JavaScript/HTML, not copy — easy to skip in a copy-focused phase.
**How to handle:** Removing the Stripe buy button from the services section is in scope for this phase because it is part of the services section's content. The executor should remove lines 363–368 (the containing `<div>` and the `<stripe-buy-button>` element). The Stripe script tag on line 256 (`<script async src="https://js.stripe.com/v3/buy-button.js">`) should also be removed since it serves no purpose without the button. The backend infrastructure (checkout.php, actual Stripe keys) is untouched.

### Pitfall 4: Hero Subtitle Running Too Long

**What goes wrong:** The approved hero subtitle is 2 sentences — longer than typical hero copy — and may push the CTA below the fold on small viewports.
**Why it happens:** The current subtitle is also 2 lines, so the designer assumed 2-line hero copy.
**How to avoid:** The planner should note that if the subtitle runs long visually, it can be split: the first sentence ("From the first conversation to production.") as the main subtitle, and the second sentence ("I own the architecture...") as a smaller supporting line. This is a layout decision, not a copy decision — flag it in the plan so the executor knows the intent.

### Pitfall 5: Experience Section Intro Paragraph Length

**What goes wrong:** The origin story paragraph (CP-03) is 4 sentences. The existing section has only 1 intro line. The executor may truncate or omit the paragraph.
**Why it happens:** The existing section has no paragraph block for an origin story — just the heading and then the event cards grid.
**How to avoid:** The executor must add a `<p>` element between the `<h2>Background & Proof</h2>` heading and the `cards-grid` div. This is the only structural addition needed for the origin story. One new `<p>` tag.

---

## Code Examples

### Grep Verification Pattern (Run After Each Change)

```bash
# Check for remaining German corporate copy
grep -n "wir\|Wir\|unser\|Unser\|unsere\|Unsere" /path/to/index.php

# Check for remaining German keywords in visible content
grep -n "Leistungen\|Anfrage\|Beratung\|Entwicklung\|Betrieb\|Projekt" /path/to/index.php

# Check for remaining German in meta tags
grep -n "de_DE\|Künstliche\|Automatisierung\|Webseiten\|Beratung" /path/to/index.php
```

**Expected result:** Zero matches in content sections after Phase 2. German matches in Impressum/Datenschutz sections are expected and acceptable.

### Inserting Origin Story Paragraph — Structural Pattern

The origin story paragraph needs to be inserted after the experience section `<h2>` and before the first `.cards-grid`. The pattern:

```html
<!-- Before (current) -->
<h2>Auszeichnungen & Expertise</h2>
<p>Unsere Erfahrung aus branchenübergreifenden Projekten, Hackathons und Auszeichnungen.</p>

<!-- After (replacement) -->
<h2>Background & Proof</h2>
<p>I grew up helping run my family's IT services company, Jörg Velletti EDV Service — which meant debugging production systems long before I enrolled at university. At TUM studying Business Informatics, I developed the systems-thinking framing that connects technical decisions to business outcomes. Today I work as a student at EY in Transfer Pricing and compete in hackathons to keep shipping under pressure. I've won at the Enactus Germany Worldcup (Bangkok 2025) and placed top 3 at the MSG Hackathon.</p>
```

### Inserting Response Time Commitment — Contact Section Pattern

```html
<!-- Before (current) -->
<h2>Projektanfrage starten</h2>
<p>Bereit für das nächste Projekt? Schreiben Sie uns und wir melden uns zeitnah bei Ihnen.</p>

<!-- After (replacement) -->
<h2>Start a conversation</h2>
<p>Tell me about your project. I reply to every inquiry within 24 hours.</p>
```

---

## State of the Art

| Old Approach | Current Approach | Impact for This Phase |
|--------------|------------------|----------------------|
| German-language developer portfolio | English-first personal brand for international/startup clients | All marketing copy must be English |
| Corporate "we" for solo operators | First-person "I" voice | Zero exceptions — every heading and paragraph |
| Service category labels (AI, DevOps) | Output-oriented capability statements | Service card bodies describe client outcomes |
| Stripe buy button on landing page | Payment after conversation | Remove from services section in this phase |

---

## Open Questions

1. **Degree name: "Information Systems" vs "Business Informatics"**
   - What we know: The file uses "Information Systems" in two places. The context brief says "Business Informatics."
   - What's unclear: TUM's Wirtschaftsinformatik program is officially called "Information Systems" in English on TUM's own website, but "Business Informatics" is the more common translation used on German university sites internationally. The context brief decision takes precedence.
   - Recommendation: Use "Business Informatics" throughout, as specified in the context brief. Executor confirms with a global replace.

2. **Semester number in LinkedIn fallback**
   - What we know: Experience card says "Semester 7" (line 520); LinkedIn fallback says "Semester 6" (line 757).
   - What's unclear: Which is current as of execution time.
   - Recommendation: Remove the semester number from the LinkedIn fallback entirely. "Business Informatics, Technische Universität München (TUM)" without a semester number does not go stale.

3. **"Evolve — Early-stage Startup" experience card (line 583)**
   - What we know: Listed as "Business Dev, Tech & Robotics" with chip. The company name is "Evolve."
   - What's unclear: Whether this should be highlighted vs. kept as a grid card.
   - Recommendation: Leave as a grid card. The origin story already names the 3-4 most important proof points. This card can stay as contextual evidence without needing elevated treatment in this phase.

---

## Sources

### Primary (HIGH confidence)
- Direct inspection: `C:/Users/ameri/Documents/Programming/Website/client/src/index.php` — full file read, all copy catalogued
- Feature research: `C:/Users/ameri/Documents/Programming/Website/.planning/research/FEATURES.md` — copy patterns, anti-patterns, positioning direction

### Secondary (MEDIUM confidence)
- Context brief decisions: locked choices from the phase description (language, person, positioning direction, origin story elements)
- Copy theory applied: output-oriented framing, specificity test, response-time commitment — sourced from FEATURES.md which documents these as established conversion principles

### Tertiary (LOW confidence)
- None. All findings are grounded in direct file inspection and the project's own documented decisions.

---

## Metadata

**Confidence breakdown:**
- Copy audit (what to change): HIGH — direct file inspection, line numbers verified
- Replacement copy drafts: HIGH — follows locked decisions from context brief and FEATURES.md patterns
- Structural recommendations (origin story paragraph insertion, Stripe removal): HIGH — grounded in FEATURES.md anti-patterns
- Degree name discrepancy: MEDIUM — identified in file, resolution follows context brief but should be confirmed by executor

**Research date:** 2026-03-01
**Valid until:** This research is tied to the current state of index.php. Any structural changes to that file before Phase 2 executes would invalidate the line numbers. Re-run the grep checks at execution time.
