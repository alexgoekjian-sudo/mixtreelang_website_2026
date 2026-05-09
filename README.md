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

## Deployment

Cloud86 shared hosting blocks SFTP and non-interactive CI deploys (chrootsh +
CageFS), so deploys run from a developer machine via [`deploy.ps1`](deploy.ps1).
The script builds locally, runs the link checker, tars `site/dist/`, uploads via
`scp -O`, and atomically syncs with `rsync` over the SSH exec channel.

### Workflow for any change

1. **Edit & preview locally**

   ```pwsh
   cd site
   npm run dev          # http://localhost:4321
   ```

2. **Commit & push to git**

   ```pwsh
   cd ..
   git add -A
   git commit -m "describe the change"
   git push
   ```

3. **Deploy to staging first** (https://dev.mixtreelang.nl/)

   ```pwsh
   ./deploy.ps1 staging
   ```

   - Builds with `MTL_STAGING=1` so `robots.txt` blocks indexing.
   - You'll be prompted for the SSH password twice (once for `scp`, once for `ssh`).
   - Verify the change on the dev URL.

4. **Deploy to production** (https://mixtreelang.nl/)

   ```pwsh
   ./deploy.ps1 prod
   ```

   - Same flow, but writes to `httpdocs/`.

### Useful flags

- `-SkipBuild` — re-upload current `site/dist/` without rebuilding.
- `-SkipLinkCheck` — skip the link checker (faster; not recommended before prod).

### Content editing via Decap CMS

Content editors can use https://dev.mixtreelang.nl/admin/ once the GitHub OAuth
proxy is deployed. Decap commits edits to git; a developer still runs
`./deploy.ps1 prod` afterwards to publish. (Auto-deploy on push isn't possible
because Cloud86 blocks CI deploys.)

### Required environment variables

- `GOOGLE_PLACES_API_KEY` (only needed when running `npm run reviews:fetch`).

The site itself has no runtime secrets — it's a static SSG build.
