# MixTree Languages — website (Astro)

Static site built with [Astro](https://astro.build) (`/site/`), deployed to Cloud86.

## Local development

```pwsh
cd site
npm install
cp .env.example .env   # fill in GOOGLE_PLACES_API_KEY
npm run dev            # http://localhost:4321
```

## Build & verify

```pwsh
cd site
npm run build          # outputs /site/dist
npm run preview        # serve dist locally
npm run links:check    # check all internal links resolve
```

## Project layout

- `site/` — Astro app
  - `src/pages/` — routes (`.astro` files become URLs)
  - `src/content/posts/` — magazine articles (Markdown, edited via Decap CMS)
  - `src/content/courses/` — course definitions (Markdown frontmatter)
  - `src/layouts/` — `BaseLayout`, `CourseDetailLayout`, `ThankYouLayout`
  - `src/components/` — shared UI components
  - `src/lib/` — schedule data, JSON-LD schema builders, Google Ads conversions
  - `public/` — static assets, served as-is at the site root
  - `public/admin/` — Decap CMS admin UI
- `scripts/` — one-off WP migration scripts
- `wordpress-seo-redirects.csv` — historical redirects (mirrored in `astro.config.mjs`)
- `*.WordPress.*.xml` — original WP export, kept locally for reference (gitignored)

## Content editing

Markdown content under `src/content/` is edited either:

- Directly in VS Code or the GitHub web editor.
- Through the Decap CMS UI at `/admin/` once the GitHub OAuth proxy is set up
  (see [site/scripts/cms-local.md](site/scripts/cms-local.md)).

## Deployment (Cloud86 + GitHub)

Cloud86 supports git-based deploys. The expected flow:

1. Push to `main` on GitHub.
2. Cloud86 webhook triggers a fresh build (`npm install && npm run build`).
3. `site/dist/` is published.

Required environment variables on the build runner:

- `GOOGLE_PLACES_API_KEY` (only needed when running `npm run reviews:fetch`).

The site itself has no runtime secrets — it's a static SSG build.
