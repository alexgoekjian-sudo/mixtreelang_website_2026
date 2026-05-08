# MixTree Languages — Project Status & Task Tracker

_Last updated: 8 May 2026 (after first GitHub push)_

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
| Decap CMS scaffolding | ✅ Done — [site/public/admin/](site/public/admin/) wired to `alexgoekjian-sudo/mixtreelang_website` |
| Root `.gitignore`, `README.md`, `.env.example` | ✅ Done |
| GitHub repo created + first push | ✅ Done — https://github.com/alexgoekjian-sudo/mixtreelang_website |
| Lighthouse pass (written guidance) | ⏳ Pending |
| Cloud86 git deploy hook configured | ⏳ Pending — Alex to do in Cloud86 panel |
| `/mailer.php` updated to handle `form=private-lessons` | ⏳ Pending — server-side, Alex to coordinate |
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

### ✅ Done in this session

- ✅ Decap CMS config wired to `alexgoekjian-sudo/mixtreelang_website`
- ✅ `git init -b main`, 371 files committed as "Initial Astro site (migrated from WordPress)"
- ✅ Pushed to `https://github.com/alexgoekjian-sudo/mixtreelang_website` `main` (one README merge conflict resolved — kept our richer version)

### 🔴 P1 — Server side & Cloud86 wiring (blocking launch)

- [ ] **Get Cloud86 `/mailer.php` updated** to handle `form=private-lessons` → email to info@mixtreelang.nl. New fields the script must read: `package_hours`, `lesson_format`, `english_level`, `goals`. Also respect the hidden `redirect_to` field (currently posts back to `…/inquiry/?sent=1`).
- [ ] **Cloud86 control panel** — set up git deploy:
  - Repo: `https://github.com/alexgoekjian-sudo/mixtreelang_website.git`
  - Branch: `main`
  - Build command: `cd site && npm ci && npm run build`
  - Publish directory: `site/dist`
  - Node version: 22 LTS (package.json requires `>=22.12.0`)
  - Env var (optional): `GOOGLE_PLACES_API_KEY` — only if running `npm run reviews:fetch` on the runner. Otherwise the cached `src/data/google-reviews.json` is used.
  - If the repo is private, add Cloud86's deploy key to GitHub → Settings → Deploy keys (read-only).
- [ ] Add Cloud86's webhook URL to GitHub → Settings → Webhooks (push-to-main triggers redeploy).
- [ ] Smoke-test on staging URL: home, one course page, one magazine post, the new `/private-courses/private-english-course/inquiry/`, the contact form, and at least one Yoast-redirect URL (e.g. `/buy-10-hours-online-english-course/` should land on the inquiry page with `?package=10&format=online`).
- [ ] **Rotate `GOOGLE_PLACES_API_KEY`** if it has ever been pasted in chat or shared. Re-issue in Google Cloud Console with HTTP-referrer restrictions for `localhost` + `mixtreelang.nl` + `*.mixtreelang.nl`. (Not blocking launch — only matters when running the reviews:fetch script.)

### 🟢 P3 — Post-launch polish

- [ ] **Lighthouse pass** — see §8 below for the full checklist & how to run it.
- [ ] **Decap CMS OAuth proxy** — full step-by-step now in [site/scripts/cms-local.md](site/scripts/cms-local.md) (Render free-tier route is the easiest, ~5 min). Until then, editors can use `npx decap-server` locally.
- ✅ Package CTAs on `/private-courses/private-english-course/` re-pointed at the new inquiry form with matching `?package=X&format=Y` query strings (this session).
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

---

## 8. Lighthouse pass — checklist

### How to run

**Locally (cheapest, fast feedback):**

```pwsh
cd site
npm run build
npm run preview         # serves dist/ on http://localhost:4321
```

Then in Chrome → DevTools → **Lighthouse tab**:
- Mode: **Navigation**
- Device: **Mobile** (Google ranks on mobile scores)
- Categories: all four (Performance, Accessibility, Best Practices, SEO)
- Click **Analyze**

Or from the command line (one-shot, all key pages):

```pwsh
npm install -g lighthouse
lighthouse http://localhost:4321/ --preset=desktop --view
lighthouse http://localhost:4321/ --view   # mobile (default)
```

**On staging** (after first Cloud86 deploy): same, but point Lighthouse at the staging URL. Always test the **production** URL too once live, because CDN/cache headers from Cloud86 affect TTFB.

### Pages to test (the canonical 5)

| Page | Why |
|---|---|
| `/` | Home — most traffic, hero video, has the LCP image |
| `/english-course/intensive-english-course/` | Course page template — used by ~10 pages |
| `/english-language-tips/` | Magazine front — image-heavy grid |
| `/free-online-english-level-check/` | High-converting funnel page |
| `/private-courses/private-english-course/inquiry/` | New form — make sure no JS regressions |

### Targets

| Category | Target |
|---|---|
| Performance | ≥ 90 (mobile), ≥ 95 (desktop) |
| Accessibility | ≥ 95 |
| Best Practices | 100 |
| SEO | 100 |

### Common things Lighthouse flags & how to fix

| Lighthouse warning | Fix |
|---|---|
| **LCP > 2.5s** on home | Hero image already in `<picture>` with `loading="eager"` and `fetchpriority="high"` — verify on the actual hero element. If still slow, add `<link rel="preload" as="image" href="..." />` in `BaseLayout.astro` head, conditionally per page. |
| **CLS > 0.1** | Every `<img>` and `<iframe>` must have `width` & `height` attrs (or aspect-ratio CSS). Audit hero video iframe + magazine post images. |
| **Render-blocking resources** | Cookie banner JS — load with `defer` or after page idle. Check `BaseLayout.astro` for any synchronous third-party `<script>`. |
| **Unused CSS** | Tailwind v4 already tree-shakes. If flagged, it's usually the cookie banner or GTM CSS — out of scope. |
| **Image elements do not have explicit width/height** | Add `width` and `height` attrs (the source image's intrinsic dimensions). |
| **Serve images in next-gen formats** | Astro `<Image />` (from `astro:assets`) auto-converts to AVIF/WebP. Verify magazine post images use it; raw `<img>` tags inside markdown go through `prose` and won't auto-convert — `astro-rehype-relative-markdown-links` or `<Picture>` wrapping needed if it's a problem. |
| **Buttons do not have an accessible name** | Check icon-only buttons (mobile menu toggle, social icons). Add `aria-label`. |
| **Heading order** | Make sure no page jumps from `<h1>` to `<h3>` skipping `<h2>`. |
| **Document does not have a meta description** | All pages use `seo.description` via `BaseLayout`. If flagged, the page is missing the `seo` prop. |
| **Tap targets too small** | Minimum 48×48 px for touch targets. Phone/email links and pagination arrows are common offenders. |
| **Cumulative cookie banner blocking** | If GTM consent mode v2 is correctly configured, this should already be fine. Worth a recheck. |

### Quick wins specific to this site

1. **Hero video on home** — already on `youtube-nocookie.com` ✅. If LCP is slow, swap autoplay video for poster image until user clicks (most likely the cheapest perf win).
2. **Magazine post images** — they're served from `/wp-content/uploads/` (raw, not via `astro:assets`). For top-traffic posts, consider running them through `<Image />`.
3. **Google Reviews JSON** — already cached, no runtime fetch ✅.
4. **`schedule.json`** — small, fine.
5. **Fonts** — using system fonts via Tailwind defaults ✅, no custom font load.

### After fixing: regression check

```pwsh
cd site
npm run build
npm run links:check
```

Both must pass before deploy.
