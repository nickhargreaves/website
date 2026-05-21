# nickhargreaves.com

Personal website for Nick Hargreaves — tech executive, entrepreneur, hiker.

## Stack

- Plain HTML + CSS, no build tooling
- Font Awesome via CDN for icons
- PHP proxy (`feed.php`) to fetch and cache the Medium RSS feed server-side

## Files

| File | Purpose |
|------|---------|
| `index.html` | Single-page site |
| `styles.css` | All styles — dark synthwave theme |
| `feed.php` | Server-side Medium RSS proxy with 1-hour file cache |
| `images/synth_nick.jpg` | Background portrait |

## Features

- Social links panel (LinkedIn, GitHub, Strava, Medium, WhatsApp, Goodreads)
- Latest Writing carousel — pulls up to 5 posts from Medium with featured image, title, excerpt, and dot navigation
- About, Experience, Latest Projects, and Beyond Work sections

## Deployment

Hosted on shared hosting (DreamHost-style). Deploy by uploading files via FTP/SFTP. The `feed.php` script writes a `feed-cache.xml` file alongside itself on first load — the web directory must be writable.

## Local development

Open `index.html` directly in a browser for layout work. For the Medium carousel, the `/feed.php` proxy requires a PHP server:

```bash
php -S localhost:8000
```
