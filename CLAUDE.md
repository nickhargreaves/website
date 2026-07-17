# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Overview

Personal website for Nick Hargreaves (tech executive, entrepreneur, hiker), served as a static site with a small PHP proxy. No build tooling, no package manager, no JS framework — plain HTML/CSS/vanilla JS.

## Files

| File | Purpose |
|------|---------|
| `index.html` | Entire single-page site: markup, all sections, and inline `<script>` for the Medium carousel |
| `styles.css` | All styling — dark "synthwave" theme, CSS custom properties defined in `:root` |
| `feed.php` | Server-side proxy that fetches Nick's Medium RSS feed and caches it to `feed-cache.xml` for 1 hour |
| `images/` | Background portrait, favicon, and project header images |

There is no JS/CSS build step — edit `index.html` and `styles.css` directly and refresh the browser.

## Local development

```bash
php -S localhost:8000
```

Open `index.html` directly in a browser for pure layout/CSS work. The PHP dev server is only needed to exercise the `/feed.php` proxy (the "Latest Writing" Medium carousel fetches from it via `fetch("/feed.php")`).

There are no automated tests, linters, or build/CI commands in this repo.

## Architecture notes

- **Single-page structure**: `index.html` is organized as stacked `<section class="panel">` blocks (links, writing carousel, about, experience, projects, beyond work) inside `<main class="container">`. Add new content by adding another `.panel` section.
- **Medium carousel**: The inline script in `index.html` fetches XML from `feed.php`, parses `<item>` elements client-side (title, link, pubDate, first `<img>` in the encoded content, stripped-HTML excerpt), renders up to 5 `.carousel-card` elements, and drives prev/next + dot navigation by translating `#carouselTrack` on the X axis. Any changes to feed item rendering happen in this one script block — there's no separate JS file.
- **feed.php caching**: Writes `feed-cache.xml` next to itself on first request and serves from that cache for 1 hour (`$ttl = 3600`) before re-fetching from `https://medium.com/feed/@nickhargreaves`. Falls back to a stale cache file if the live fetch fails. The web directory must be writable in production for this cache file.
- **Theming**: Color palette is defined once as CSS custom properties at the top of `styles.css` (`--bg`, `--panel`, `--line`, `--text`, `--muted`, `--accent`, `--accent-soft`). Reuse these variables rather than hardcoding colors.
- **External dependencies**: Font Awesome is loaded via CDN link in `<head>` — no local icon assets or npm packages.

## Deployment

Hosted on shared hosting (DreamHost-style). Deploy by uploading files via FTP/SFTP — no CI/CD pipeline. The web directory must be writable so `feed.php` can write `feed-cache.xml`.

## Git workflow

Work directly on the `main` branch. Do not create feature branches or PRs for changes to this repo — it's a simple personal site and that overhead isn't wanted. Only suggest branches/PRs if the project grows to be larger, multi-contributor, or production-sensitive.
