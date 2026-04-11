# UTM Tracking Links

Plausible tracks UTM parameters automatically. Use these links consistently
when sharing your website across different channels.

## Homepage Links

| Channel          | Link |
|------------------|------|
| LinkedIn Post    | `https://ame.velletti.de/?utm_source=linkedin&utm_medium=social&utm_campaign=brand` |
| GitHub Profile   | `https://ame.velletti.de/?utm_source=github&utm_medium=profile` |
| Email Signature  | `https://ame.velletti.de/?utm_source=email&utm_medium=signature` |
| LinkedIn DM      | `https://ame.velletti.de/?utm_source=linkedin&utm_medium=dm&utm_campaign=outreach` |
| Business Card    | `https://ame.velletti.de/?utm_source=offline&utm_medium=card` |

## Blog Post Links (for sharing)

Template: `https://ame.velletti.de/blog/post.php?slug=SLUG&utm_source=SOURCE&utm_medium=MEDIUM&utm_campaign=CAMPAIGN`

### AI Automation Post

| Channel          | Link |
|------------------|------|
| LinkedIn         | `https://ame.velletti.de/blog/post.php?slug=ai-automation-for-startups&utm_source=linkedin&utm_medium=social&utm_campaign=blog` |
| Twitter/X        | `https://ame.velletti.de/blog/post.php?slug=ai-automation-for-startups&utm_source=twitter&utm_medium=social&utm_campaign=blog` |

### CI/CD Post

| Channel          | Link |
|------------------|------|
| LinkedIn         | `https://ame.velletti.de/blog/post.php?slug=cicd-for-small-teams&utm_source=linkedin&utm_medium=social&utm_campaign=blog` |
| Dev.to / HN      | `https://ame.velletti.de/blog/post.php?slug=cicd-for-small-teams&utm_source=devto&utm_medium=crosspost&utm_campaign=blog` |

### Solo Founder Post

| Channel          | Link |
|------------------|------|
| LinkedIn         | `https://ame.velletti.de/blog/post.php?slug=tech-stack-decisions-solo-founder&utm_source=linkedin&utm_medium=social&utm_campaign=blog` |
| Indie Hackers    | `https://ame.velletti.de/blog/post.php?slug=tech-stack-decisions-solo-founder&utm_source=indiehackers&utm_medium=forum&utm_campaign=blog` |

## Plausible Goals to Configure

In the Plausible dashboard (plausible.io), set up these Goals:

1. **Pageview goal**: `/blog/post.php` — tracks all blog post views
2. **Custom event**: `contact_form_submit` — tracks form submissions
3. **Custom event**: `cta_click` — tracks CTA button clicks (props: label)
4. **Custom event**: `checkout_click` — tracks checkout initiations
5. **Custom event**: `payment_success` — tracks completed payments
