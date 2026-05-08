# MixTree Languages — Project Status & Task Tracker

_Last updated: 8 May 2026_

This document is the single source of truth for where we are in the WordPress → Astro migration of **mixtreelang.nl**, what's done, what's next, and what's needed from Alex (the site owner).

---

## 1. Where the project lives

- **Repo root**: `c:\Users\alex\mixtreelang_website\`
- **Astro project**: [site/](site/) (Astro 6.2.2, Tailwind v4, SSG, `trailingSlash: 'always'`)
- **Build output**: `site/dist/`
- **Local dev**: `cd site && npm run dev` → http://localhost:4321
- **Build**: `cd site && npm run build` (currently builds 74 pages cleanly)
- **Link checker**: `cd site && npm run links:check` (currently 0 broken across 4953 internal links)
- **Target host**: Cloud86 (git-based static deploy)

---

## 2. Status snapshot

| Area | Status |
|---|---|
| Page migration from WP | ✅ Done |
| Course pages on `CourseDetailLayout` | ✅ Done (incl. Business English) |
| Magazine (`english-language-tips`) | ✅ Done — markdown content collection, source-link aside, brand styling |
| Schema / SEO (`@graph` per page) | ✅ Done |
| Yoast 301 redirects ported | ✅ Done — 27 entries in [astro.config.mjs](site/astro.config.mjs) |
| YouTube embeds → nocookie | ✅ Done in `HeroVideo.astro` |
| Custom 404 page | ✅ Done — [site/src/pages/404.astro](site/src/pages/404.astro) |
| Internal link checker script | ✅ Done — [site/scripts/check-links.mjs](site/scripts/check-links.mjs) |
| Thank-you pages unified on `ThankYouLayout` | ✅ Done (10 pages) + Enhanced Conversions GTM event |
| Free level-check enrolment redesign | ✅ Done — Alpine tabs, cal.com iframes, Service JSON-LD |
| WooCommerce buy-X-hour pages → unified inquiry form | ✅ Done (this session) |
| Decap CMS scaffolding | ✅ Done — [site/public/admin/](site/public/admin/) (needs repo URL filled in) |
| Root `.gitignore`, `README.md`, `.env.example` | ✅ Done |
| Lighthouse pass (written guidance) | ⏳ Pending |
| GitHub repo created + first push | ⏳ Pending — needs repo URL from Alex |
| Cloud86 git deploy hook configured | ⏳ Pending — Alex to do in Cloud86 panel after first push |
| Decap CMS OAuth proxy (production) | ⏳ Pending — needed before non-local editors can log in |

---

## 3. Recent work — this session

### New unified inquiry form (replaces 6 deleted WooCommerce stubs)

**Page**: [site/src/pages/private-courses/private-english-course/inquiry/index.astro](site/src/pages/private-courses/private-english-course/inquiry/index.astro)

- Posts to `/mailer.php` with `form=private-lessons`
- Hidden `redirect_to=/private-courses/private-english-course/inquiry/?sent=1`
- Package picker (10/20/30 hours) as styled radio cards
- Format picker (online / in-person / either) as pill buttons
- Pre-fills `package` & `format` from URL query string
- Standard fields: first/last name, email, phone, English level (A1–C2), goals & schedule textarea, consent checkbox
- Honeypot `website` + UTM hidden inputs (auto-filled by `UtmCapture`)
- `data-mtl-form data-mtl-conversion="private_lessons_request"` triggers Enhanced Conversions GTM event
- JSON-LD `Service` node
- Sidebar with "What's included" and link to free level check

**Redirects updated** in [site/astro.config.mjs](site/astro.config.mjs) — all 6 old buy URLs now 301 to the new page with the right query string:

| Old URL | Redirects to |
|---|---|
| `/buy-10-hours-online-english-course/` | `…/inquiry/?package=10&format=online` |
| `/buy-20-hours-online-english-course/` | `…/inquiry/?package=20&format=online` |
| `/buy-30-hours-online-english-course/` | `…/inquiry/?package=30&format=online` |
| `/buy-10-hours-private-english-course/` | `…/inquiry/?package=10&format=in-person` |
| `/buy-20-hours-private-english-course/` | `…/inquiry/?package=20&format=in-person` |
| `/buy-30-hours-private-english-course/` | `…/inquiry/?package=30&format=in-person` |

**Server-side (Cloud86) requirement**: existing `/mailer.php` needs to handle the `form=private-lessons` value and route the email to **info@mixtreelang.nl**. New field names to expect: `package_hours`, `lesson_format`, `english_level`, `goals` (plus the standard `first-name`, `last-name`, `email`, `phone`, `consent`, UTM set, and `redirect_to`).

---

## 4. Outstanding tasks (in priority order)

### 🔴 P1 — Before first GitHub push

- [ ] **Get Cloud86 `/mailer.php` updated** to handle `form=private-lessons` → email to info@mixtreelang.nl. (Alex to coordinate — or share current mailer.php so we can patch it.)
- [ ] **Provide GitHub repo URL** (`github.com/<owner>/<repo>`) so we can:
  - Set `backend.repo` in [site/public/admin/config.yml](site/public/admin/config.yml)
  - Add the git remote
- [ ] **Confirm default branch** name (`main` recommended)
- [ ] **Rotate `GOOGLE_PLACES_API_KEY`** if it has ever been pasted in chat or shared. Re-issue in Google Cloud Console with HTTP-referrer restrictions for `localhost` + `mixtreelang.nl` + `*.mixtreelang.nl`.
- [ ] Final pre-push sanity check: `git status` to confirm nothing private staged (`.env`, `dist/`, exports).

### 🟡 P2 — First push & Cloud86 wiring

- [ ] `git init -b main && git add . && git commit -m "Initial Astro site (migrated from WordPress)"`
- [ ] `git remote add origin <repo URL> && git push -u origin main`
- [ ] In Cloud86 control panel:
  - Build command: `cd site && npm ci && npm run build`
  - Publish directory: `site/dist`
  - Node version: 22 LTS (package.json requires `>=22.12.0`)
  - Env var: `GOOGLE_PLACES_API_KEY` (only if running `npm run reviews:fetch` on the runner; otherwise the cached `src/data/google-reviews.json` is used)
- [ ] Add Cloud86's webhook URL to GitHub → Settings → Webhooks (push-to-main triggers redeploy)
- [ ] Smoke-test on staging URL: home, one course page, one magazine post, the new `/private-courses/private-english-course/inquiry/`, the contact form, and at least one Yoast-redirect URL

### 🟢 P3 — Post-launch polish

- [ ] **Lighthouse pass** — run on home, one course page, magazine front, free level-check enrolment, new inquiry page. Target ≥ 90 on all four categories. Common fixes:
  - Preload LCP image on hero pages
  - Ensure cookie banner doesn't block render
  - `loading="lazy"` on below-the-fold images (already mostly done)
  - Confirm fonts subset / preload OK
- [ ] **Decap CMS OAuth proxy** — deploy `vencax/netlify-cms-github-oauth-provider` (or equivalent) on a Cloud86 Node service or free Render/Fly.io. Then update [site/public/admin/config.yml](site/public/admin/config.yml) with `base_url: https://oauth.mixtreelang.nl`. See [site/scripts/cms-local.md](site/scripts/cms-local.md) for steps. Until then, editors can use `npx decap-server` locally.
- [ ] Add a "Request a quote" CTA button from the main private-english-course page → new inquiry page (currently only reachable via redirects).
- [ ] (Optional) Create a dedicated `/thank-you-private-lessons-request/` page. Right now it lands back on the inquiry page with `?sent=1` banner — fine, but a dedicated page would let GA/GTM track conversions cleanly.

---

## 5. Key files & where things live

### Form / conversion pattern

- [site/src/pages/contact/index.astro](site/src/pages/contact/index.astro) — reference contact form
- [site/src/pages/private-courses/private-english-course/inquiry/index.astro](site/src/pages/private-courses/private-english-course/inquiry/index.astro) — new inquiry form
- [site/src/components/UtmCapture.astro](site/src/components/UtmCapture.astro) — auto-fills UTM hidden inputs
- [site/src/components/EnhancedConversions.astro](site/src/components/EnhancedConversions.astro) — GTM dataLayer push on submit
- [site/src/components/ConversionEvent.astro](site/src/components/ConversionEvent.astro) — fires on thank-you pages
- [site/src/lib/conversions.ts](site/src/lib/conversions.ts) — conversion ID/label map

### SEO / schema

- [site/src/lib/schema.ts](site/src/lib/schema.ts) — `@graph` builder
- [site/src/layouts/BaseLayout.astro](site/src/layouts/BaseLayout.astro) — auto-emits schema, accepts `jsonLd` prop
- [site/src/layouts/CourseDetailLayout.astro](site/src/layouts/CourseDetailLayout.astro) — course pages
- [site/src/layouts/ThankYouLayout.astro](site/src/layouts/ThankYouLayout.astro) — all thank-you pages

### Redirects & 404

- [site/astro.config.mjs](site/astro.config.mjs) — all 27 Yoast 301s + 6 buy-* redirects
- [site/src/pages/404.astro](site/src/pages/404.astro) — branded 404

### Decap CMS

- [site/public/admin/index.html](site/public/admin/index.html) — Decap CDN bootstrap
- [site/public/admin/config.yml](site/public/admin/config.yml) — collections (posts + courses), needs repo URL filled in
- [site/scripts/cms-local.md](site/scripts/cms-local.md) — local + production OAuth setup notes

### Tooling

- [site/scripts/check-links.mjs](site/scripts/check-links.mjs) — internal link crawler
- [.gitignore](.gitignore) — root-level
- [site/.env.example](site/.env.example) — env template
- [README.md](README.md) — project overview & commands

---

## 6. Known gotchas / decisions

- **No e-commerce / no direct buy.** All purchase intent funnels through `/private-courses/private-english-course/inquiry/` (or the contact form / level-check booking). Decision made this session.
- **Trailing slashes always** — Astro is configured with `trailingSlash: 'always'` and `build.format: 'directory'`. Internal links must include the trailing slash. The link checker enforces this.
- **`/mailer.php` is server-side** on Cloud86 — not part of the Astro build. It's the single point that handles all form submissions and email routing. Keep its handling consistent across `form` values.
- **Google reviews are cached** in `site/src/data/google-reviews.json` and only re-fetched when `npm run reviews:fetch` is run with a valid API key. Build does NOT need the key.
- **Alpine.js `x-model` + `<select>` with `<template x-for>`** — known to fail to preselect. Use `@change` + `:selected` instead. (See user memory notes.)

---

## 7. Validation status

Last verified: 8 May 2026, after adding the new inquiry form.

```
74 page(s) built in 3.36s
Checked 4953 internal link(s) across 103 page(s).
✓ No broken internal links.
```
