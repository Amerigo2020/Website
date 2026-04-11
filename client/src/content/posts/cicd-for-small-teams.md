---
title: "CI/CD for Small Teams: Ship Without Fear in Under a Day"
description: "You don't need a dedicated DevOps engineer to deploy reliably. Here's a practical CI/CD setup for small teams using GitHub Actions, Docker, and zero-downtime deploys."
date: "2026-04-10"
author: "Amerigo Velletti"
tags: "DevOps, CI/CD, GitHub Actions, Docker, Deployment"
---

Most small teams deploy one of two ways: they either push directly to production and pray, or they have a process so painful that shipping becomes a weekly event instead of a daily one.

Neither works. Here's how to set up a deployment pipeline that a two-person team can maintain, in under a day.

## Why Small Teams Avoid CI/CD

The usual reasons: "We're too small for that." "It's overengineered for our stage." "We'll set it up later."

But the math doesn't support waiting. If you deploy manually and something breaks:

- You spend 30 minutes figuring out what changed
- You spend another 30 minutes rolling back
- You lose the confidence to ship quickly

A basic CI/CD pipeline prevents all three. And with GitHub Actions, the setup cost is measured in hours, not weeks.

## The Minimal Viable Pipeline

Here's what a practical pipeline looks like for a small PHP or Node.js project:

### Step 1: Automated Testing on Every Push

Create `.github/workflows/ci.yml`:

```yaml
name: CI
on: [push, pull_request]
jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - name: Run tests
        run: |
          composer install --no-dev
          ./vendor/bin/phpunit
```

Even if you only have 5 tests, this catches the obvious mistakes before they reach production.

### Step 2: Build a Container

Docker eliminates "works on my machine." Your Dockerfile doesn't need to be fancy:

```dockerfile
FROM php:8.3-apache
COPY client/src/ /var/www/html/
COPY vendor/ /var/www/vendor/
RUN a2enmod rewrite
```

Build and push it in your CI pipeline. Use GitHub Container Registry. It's free for public repos and cheap for private ones.

### Step 3: Deploy with Zero Downtime

For a small project, you don't need Kubernetes. A simple approach:

1. SSH into your server from GitHub Actions
2. Pull the new container image
3. Stop the old container, start the new one

For zero-downtime deploys, use Docker Compose with a reverse proxy:

```yaml
services:
  app:
    image: ghcr.io/yourname/app:latest
    restart: unless-stopped
  caddy:
    image: caddy:latest
    ports:
      - "80:80"
      - "443:443"
    volumes:
      - ./Caddyfile:/etc/caddy/Caddyfile
```

Caddy handles SSL automatically. No certbot scripts. No renewal cron jobs.

## What to Monitor

A pipeline without monitoring is a pipeline you'll stop trusting. At minimum, track:

- **Deployment frequency**: Are you shipping more often? That's the goal.
- **Failure rate**: What percentage of deploys fail? This should trend toward zero.
- **Recovery time**: When something breaks, how fast can you roll back?
- **Build time**: If CI takes 20 minutes, people will skip it. Keep it under 5.

Use the free tier of a tool like Uptime Robot or Betterstack for basic uptime monitoring. Add a Slack webhook for deployment notifications.

## Common Mistakes

**Over-engineering the pipeline.** Your first pipeline should be 20 lines, not 200. Add complexity when you need it, not before.

**No staging environment.** Even a $5/month VPS running the same Docker setup gives you a place to test before production.

**Ignoring secrets management.** Never commit API keys. Use GitHub Actions secrets and reference them as environment variables.

**Skipping the rollback plan.** Tag every release. If the latest deploy breaks, rolling back is one command: `docker compose pull && docker compose up -d` with the previous tag.

## The Payoff

After setup, your workflow becomes:

1. Write code, push to a branch
2. CI runs tests automatically
3. Merge to main
4. GitHub Actions builds, pushes, and deploys
5. You get a Slack message: "Deployed v1.2.3"

The entire process takes minutes. No manual SSH. No FTP uploads. No hoping you remembered to pull the latest changes.

For a two-person team, this is the difference between shipping three times a day and shipping once a week. The confidence to deploy often is what lets small teams move fast without breaking things.

---

**Weitere Artikel:** [Tech Stack Decisions as a Solo Founder: What Actually Matters](/blog/post.php?slug=tech-stack-decisions-solo-founder) | [CSRF Protection: The Attack Every Web Developer Should Understand](/blog/post.php?slug=csrf-protection-explained)
