# Feature Landscape

**Domain:** Solo developer personal brand & consulting site
**Project:** Velletti — personal brand redesign
**Researched:** 2026-03-01
**Confidence note:** WebSearch was unavailable. Findings draw on training data (cutoff August 2025) grounded against the existing codebase, PROJECT.md, and established conversion-rate and UX research principles. Confidence levels are assigned per section.

---

## Context: What the Current Site Gets Wrong

Before listing what to build, it's worth naming what the existing site does that hurts trust — because these are the live anti-patterns to reverse.

| Current Problem | Why It Hurts |
|----------------|--------------|
| "Wir entwickeln..." — corporate "we" for a solo developer | Signals inauthenticity; visitors sense mismatch between agency voice and solo reality |
| Hero headline is a category label ("Software. KI. Automatisierung.") | Describes a market, not a person; zero differentiation from any other dev shop |
| 14 achievement cards dumped in a grid with no narrative | Impressive raw material, completely unreadable; signals quantity over quality |
| Stripe buy button in the services section | Asks for payment before any trust is established; violates funnel logic |
| No person visible above the fold | Technical buyers hire people, not logos; the human must appear early |
| Services described in generic agency language | "Von Proof-of-Concept bis Produktion" sounds like a brochure, not a person |
| Language mismatch (German site, English form fields) | Creates cognitive friction; pick one language and commit |
| Zero narrative thread connecting sections | Visitor has no journey; it reads like a CV dump |

These are the reference points for every recommendation below.

---

## Table Stakes

Features a technical buyer expects from any credible solo developer site. Missing any of these and credibility suffers before the person has read a word.

| Feature | Why Expected | Complexity | Notes |
|---------|--------------|------------|-------|
| Real photo of the person | Technical buyers hire humans; anonymity signals risk | Low | Must appear in hero or immediately after — not buried. Good photo, not a passport crop. |
| First-person copy throughout | "I" voice is expected from solo practitioners; "we" reads as deceptive at solo scale | Low | Zero exceptions — every heading, paragraph, CTA uses "I" |
| Clear name and location visible | Visitors verify identity; Germany/Munich context matters for B2B trust | Low | Name in logo/header, city in intro or footer |
| Contact mechanism that works | The entire goal of the page | Low | Form already exists; needs visible placement and friction-free UX |
| Mobile-responsive layout | Over 50% of initial site visits are mobile, even B2B | Medium | Current site has responsive CSS; verify it holds for redesigned layout |
| Page load under 3 seconds | Trust signal; slow sites signal low craft for a developer's own site | Low | No heavy frameworks; PHP + vanilla JS is fast by default |
| GitHub link visible and active | The portfolio for technical buyers who evaluate before contacting | Low | Already exists; needs to be discoverable, not buried in a card grid |
| Services described clearly | Visitor must understand what you actually do in 10 seconds | Low | Currently over-generic; needs specificity |
| Response expectation set | "I'll reply within 24 hours" removes anxiety about contacting | Low | One line near or in the CTA section |
| Impressum / Datenschutz (Germany) | Legal requirement; absence is a red flag for German B2B | Low | Already exists; keep it, move it to footer not main navigation |

**Confidence: HIGH** — These are well-established conversion basics. No external verification needed; they apply to any trust-driven contact page.

---

## Differentiators

Features that make this site memorable rather than generic. Not universally expected, but high-value given this specific person's profile and target client.

### D1: The "Systems Thinker" Positioning Statement

**What it is:** A single-sentence positioning hook that names the unique value — not a category ("full-stack dev") but a capability ("I connect the business problem to the system that solves it").

**Why it differentiates:** Most developer sites list technologies. Startup founders and small business owners don't care about Rust vs PHP — they care about whether someone can own the problem end-to-end. This positioning directly addresses their real fear: "will I have to manage a developer who only understands code, or someone who understands my business?"

**Placement:** First thing visible after the name. Before any tech list.

**Example copy direction:**
> "I build complete systems — from the database schema to the checkout page — for startups that need one person to own the technical side."

**Confidence: HIGH** — Positioning theory is well-established; this specific application is pattern-matched from observed high-converting solo dev sites.

---

### D2: The Origin Story (Family Business Thread)

**What it is:** A short (3-5 sentence) personal narrative that explains *why* this person builds what they build. The family EDV business (Jörg Velletti EDV Service) is the key thread — it's why there's real production experience before graduation.

**Why it differentiates:** "TUM student" is common. "TUM student who has been debugging production systems since age 15 because his family ran an IT services company" is not. This story answers the buyer's implicit question: "Is this person actually experienced, or just book-smart?"

**What to surface:**
- The family business origin (real production work, not toy projects)
- The EY working student role (enterprise credibility)
- The hackathon pattern (proof of shipping under pressure, not just coursework)

**What NOT to do:** Don't list all 14 hackathons as a grid. Select 2-3 that demonstrate different things (technical depth, business thinking, teamwork) and narrate them in one sentence each.

**Confidence: HIGH** — Story-driven personal brand conversion is well-documented. The specific assets here are drawn from the existing site data.

---

### D3: Selective Proof (Not a CV Dump)

**What it is:** Instead of displaying all credentials equally, curate 3-4 that together tell a story of capability. Each one earns its place.

**Curation criteria for this profile:**
1. **Enactus Germany Worldcup Winner (Bangkok 2025)** — international scale, business impact, not just code
2. **MSG Hackathon Top 3** — competitive technical performance
3. **EY Working Student** — enterprise credibility, current
4. **Jörg Velletti EDV Service** — origin story anchor, production reality

**Why this differentiates:** A wall of 14 achievement chips reads as anxiety (compensating for lack of real work) to an experienced buyer. Four well-framed proofs read as confidence. Less is more when each item is explained.

**Confidence: MEDIUM** — This is drawn from established copywriting/conversion principles (social proof specificity). Not externally verified for this specific domain in 2025.

---

### D4: Capability Demonstration Over Service Listing

**What it is:** Instead of "AI & Automatisierung / Websites & Hosting / DevOps Enablement" — describe what a finished project looks like from the client's perspective.

**Example copy direction:**
> "You described a problem. Six weeks later, you have a system that runs: a backend that handles your business logic, a front end your team can actually use, and deployments that don't require you to call me at 2am."

**Why it differentiates:** Service cards describe inputs (what the developer does). Capability statements describe outputs (what the client gets). Buyers evaluate outputs, not inputs.

**Confidence: HIGH** — Output-oriented copy is established conversion best practice for services.

---

### D5: Dual CTA With Explicit Friction Levels

**What it is:** Two contact paths, positioned as options for different buyer readiness:
- "Send me a message" (low friction — async, no commitment)
- "Book a 30-minute call" (medium friction — synchronous, shows serious interest)

**Why it differentiates:** Forcing all visitors through one CTA loses the visitors who are ready to talk now (they want a call) and the visitors who aren't ready to commit to a call (they want to write first). The dual CTA self-selects commitment level without losing either segment.

**Implementation note:** The call-booking CTA needs a real booking tool (Calendly or equivalent). The form already exists and works. The visual framing matters: "Book a call" should not appear more prominent than "Send a message" — both are valid paths.

**Confidence: HIGH** — Dual CTA patterns for service businesses are well-documented.

---

### D6: Subtle Code Aesthetic in Design (Not Decorative)

**What it is:** Typography and layout choices that signal developer identity without being a parody of it. Specifically: monospace type used for code-adjacent labels or metadata (tech stack mentions, dates, section markers) while body copy stays readable.

**Why it differentiates:** Most "developer aesthetic" sites over-apply it (fake terminal windows, matrix rain, blinking cursors). The goal is a developer visiting the site who thinks "this person has taste" — not "this person watched too many hacker movies." The restraint itself is the signal.

**What works:**
- Monospace font for small labels, dates, technical identifiers only
- Dark background with careful contrast ratios
- One accent color used consistently (current `#F87060` is strong — keep it)
- No decorative animations unless they serve comprehension

**What to avoid:** See anti-features below.

**Confidence: MEDIUM** — Aesthetic judgment applied from observed patterns; no 2025-specific source.

---

### D7: Language Consistency and Audience Choice

**What it is:** A deliberate, committed choice to write the entire site in one language. Given the target clients (startups and small businesses in Munich and Germany broadly), and the fact that the current site is German but has English form labels and mixed copy, this needs resolution.

**Recommendation:** English. Reasons:
- Startups in Munich increasingly operate in English
- International startups looking for Munich-based developers will search in English
- The personal brand positioning (systems thinking, TUM, hackathons at EU/global level) reads more naturally in English
- German is still served by the Impressum/Datenschutz sections, which are legally required in German anyway

**If the primary client base is explicitly German SMEs (not startups):** flip to German throughout. But pick one.

**Confidence: MEDIUM** — Based on project context. Language strategy depends on actual client pipeline, which I cannot verify.

---

## Anti-Features

Things to deliberately NOT build. These are the over-engineering traps and trust-killers specific to this domain.

### A1: The Stripe Buy Button in the Services Section

**What it is:** The current site has a Stripe buy button embedded directly in the services section, before any trust has been established.

**Why it kills trust:** Presenting a payment mechanism to a cold visitor who just read a generic service description signals one of two things: either this person expects clients to self-serve a purchase without a conversation (which doesn't work for custom development), or this person doesn't understand the sales motion for consulting work. Either way, the buyer reads it as a red flag.

**What to do instead:** Payment comes *after* a discovery conversation. The Stripe integration can live on a separate, linked page (already exists as checkout.php) accessible only after the contact/call flow. Keep the infrastructure; remove it from the main page.

---

### A2: The Achievement Grid as a Wall

**What it is:** 14+ event cards displayed as a uniform grid with no hierarchy, no narrative, no context.

**Why it kills trust:** Quantity signaling ("look how many things I've done") reads as insecurity to experienced buyers. It also fails the 10-second scan test — a visitor can't tell which of these 14 things matters. The impression is noise, not competence.

**What to do instead:** Curate 3-4. Tell each one in a sentence. Let the GitHub profile and LinkedIn do the exhaustive listing — link to them.

---

### A3: Generic Service Category Labels

**What it is:** "AI & Automatisierung," "Websites & Hosting," "DevOps Enablement" — these are market categories, not services.

**Why it kills trust:** Every developer consultancy in Germany has these exact three categories. If a visitor can replace your name with any competitor's name and the page still makes sense, the copy is not doing its job.

**What to do instead:** Name what you actually build and for whom. "I automate the workflows your team wastes hours on" beats "AI & Automatisierung." Specificity signals experience.

---

### A4: A Blog

**What it is:** Articles, tutorials, or thought leadership content requiring regular publishing.

**Why it's an anti-feature here:** Content marketing requires consistent publishing to have SEO or trust-building effect. A blog with 2 posts from 6 months ago signals abandonment — actively worse than no blog. It also takes focus away from conversion. PROJECT.md correctly calls this out-of-scope. This is correct.

**What to do instead:** If there's a desire to demonstrate thinking, one well-written "how I approach a project" narrative section on the main page does more than a blog. Single authored piece, no publication date, never goes stale.

---

### A5: Testimonials (Without Having Them)

**What it is:** A testimonial or social proof section with placeholder text, fake-sounding praise, or thinly-veiled self-promotion.

**Why it kills trust:** Empty testimonial sections are immediately recognizable. They signal the developer either doesn't have clients yet, or couldn't get anyone to say something specific. Technical buyers are experienced at reading between the lines.

**What to do instead:** If real testimonials from real named clients exist — include them with full name, company, and context. If they don't exist yet — skip the section entirely. The hackathon wins and the EY working student role do more work as social proof than a vague testimonial.

---

### A6: Fake Terminal / Matrix Aesthetic

**What it is:** Animated fake terminals, typing effects that simulate code execution, particle backgrounds, matrix rain, or other "hacker movie" visual tropes.

**Why it's an anti-feature:** Developers with taste can immediately tell these are decorative. They signal the developer is trying to perform technical identity rather than demonstrate it. Non-technical founders find them confusing or juvenile. The current canvas-based hero background is already borderline — it needs to either serve a clear purpose or be replaced with clean typography.

**What to do instead:** Let the work speak. A clear headline, good spacing, one accent color, a real photo — these signal confidence better than any animation.

---

### A7: A "Services" Navigation Link That Jumps to a Product Grid

**What it is:** Navigation that leads visitors to a section framed like an e-commerce catalog.

**Why it's an anti-feature:** Custom development is not a product. A buyer who clicks "Services" and sees three icon-plus-paragraph cards with prices is being asked to self-select a SKU for a relationship that requires a conversation. It creates a cognitive mismatch.

**What to do instead:** Frame that section as "What I build" or "How I work" — language that signals collaboration rather than purchase. The section can describe capability areas, but the CTA from that section should be "let's talk about your project," not "buy."

---

### A8: Social Proof Icons That Link Off-Site Immediately

**What it is:** The current design has LinkedIn and GitHub profile links as primary navigation elements in the header, which immediately take visitors off the page.

**Why it's an anti-feature:** These links compete with the primary CTA (contact). A visitor who clicks LinkedIn leaves the site and may not return. External links should be available but de-prioritized — footer placement, or at the end of the about section after the CTA has been seen.

**What to do instead:** Move social links to the footer. If GitHub activity is shown (repo list in modal), keep it on-page. Let the visitor get to the contact section before offering them an exit.

---

## Feature Dependencies

```
Real photo + first-person copy
    → establishes identity
    → enables the origin story narrative
    → makes capability claims credible

Origin story
    → justifies selective proof (why these 3-4 items, not 14)
    → gives context for the "systems thinking" positioning

Positioning statement (systems thinker)
    → frames what the services section is actually about
    → gives the CTA its urgency ("if this is what you need...")

Dual CTA
    → requires Calendly or booking tool (external dependency)
    → contact form already exists (no dependency)

Dark minimal design
    → must be committed to completely — half-dark (current state) is worse than either
    → affects all section backgrounds, not just the hero
```

---

## Copy / Narrative Patterns That Work for Technical Buyers

These are patterns observed in high-trust solo developer personal brand sites. Confidence: MEDIUM (training knowledge, not verified against 2025 sources).

### Pattern 1: Lead With the Outcome, Not the Input

**Avoid:** "I use Rust, Python, React, and Next.js to build..."
**Use:** "Six weeks from our first call, you'll have a system running in production."

Technical buyers know that tools are means, not ends. Leading with the stack signals that you think like a developer. Leading with outcomes signals that you think like a business partner.

### Pattern 2: The Specificity Test

Any claim should fail if a generic developer could say the same thing.
- "I build high-quality software" — fails (any developer says this)
- "I built the payment flow for my family's IT services business in PHP while I was still in school" — passes (no one else has this exact story)

Apply the specificity test to every paragraph.

### Pattern 3: Acknowledge the Buyer's Real Fear

Startup founders hiring a solo dev have a specific fear: "What if this person disappears, or can't handle the complexity, or I have to manage them like a junior?" Good copy names and addresses this directly, without defensiveness:

> "You don't want to manage a developer. You want someone who can own the problem. That's what I do."

### Pattern 4: The Volume-to-Quality Transition

The current site lists 14 hackathons. The redesign should create the impression that the developer is selective — that they've done a lot and *chosen* what to highlight, rather than listed everything to prove they're busy.

One technique: use past tense with confidence. "I've competed in over a dozen hackathons. The ones worth mentioning: [3 items]." This signals editorial judgment, which is itself a trust signal.

### Pattern 5: Response Time Specificity

"Contact me" is vague. "I reply to every inquiry within 24 hours" is a commitment. Commitments build trust because they're falsifiable — the buyer knows what to expect and can hold you to it. Add this near the contact form.

---

## MVP Recommendation

For the initial redesign, prioritize in this order:

**Must have (without these, the redesign hasn't solved the core problem):**
1. First-person copy throughout — person, not corporation
2. Real photo visible without scrolling (or within first scroll)
3. Positioning statement — the one-sentence "what I do and for whom"
4. Origin story — 3-5 sentences connecting family business to present capability
5. Curated proof (3-4 items with context, not 14 chips)
6. Dual CTA (form already exists; booking tool needed)
7. Dark-committed design (not half-light/half-dark)
8. Stripe payment moved off main page
9. Language consistency (pick English or German, commit)

**Should have (these improve conversion, but the site is coherent without them):**
10. Capability framing replacing generic service categories
11. Response time commitment near contact form
12. Social links demoted to footer
13. GitHub activity shown on-page (current modal pattern is acceptable, just de-prioritize from header)

**Defer to post-v1:**
- Testimonials (only if real ones can be obtained)
- Case studies (PROJECT.md calls this out-of-scope for v1 — correct)
- Blog or articles
- Additional pages (single-page or near-single-page is the right scope)
- Calendly integration (if booking tool is complex to set up, a "book a call" link to a Calendly URL is sufficient for v1)

---

## Sources

- Existing site analysis: `/c/Users/ameri/Documents/Programming/Website/client/src/index.php` (direct inspection)
- Project requirements: `/c/Users/ameri/Documents/Programming/Website/.planning/PROJECT.md`
- Conversion principles: Training knowledge (cutoff August 2025) — MEDIUM confidence unless noted HIGH
- Solo dev / freelance consulting conversion patterns: Training knowledge — MEDIUM confidence
- Anti-pattern identification: Grounded against current site deficiencies (HIGH confidence — directly observed)
- WebSearch: Unavailable for this research session. Findings should be validated against current (2025-2026) resources before final implementation decisions.
