// One-off converter: WP pages XML -> Astro page files (with WPBakery cleanup).
// Run from repo root: node scripts/convert-pages.mjs
import { readFileSync, writeFileSync, mkdirSync, existsSync } from 'node:fs';
import { fileURLToPath } from 'node:url';
import { dirname, resolve, join } from 'node:path';

const here = dirname(fileURLToPath(import.meta.url));
const inFile = resolve(here, '..', 'mixtreelanguages-englishlanguageschool.WordPress.2026-05-05-pages.xml');
const pagesDir = resolve(here, '..', 'site', 'src', 'pages');

const HAND_BUILT = new Set([
  '/',
  '/contact/',
  '/course-schedule/',
  '/free-online-english-level-check/',
  '/english-language-tips/',
  '/thank-you/',
]);

const xml = readFileSync(inFile, 'utf8');
const items = xml.split(/<item>/).slice(1).map(s => s.split('</item>')[0]);

function getCdata(block, tag) {
  const re = new RegExp(`<${tag}[^>]*>\\s*<!\\[CDATA\\[([\\s\\S]*?)\\]\\]>\\s*</${tag.split(' ')[0]}>`);
  const m = block.match(re);
  return m ? m[1] : '';
}
function getPlain(block, tag) {
  const re = new RegExp(`<${tag}[^>]*>([\\s\\S]*?)</${tag.split(' ')[0]}>`);
  const m = block.match(re);
  return m ? m[1].trim() : '';
}
function getMeta(block, key) {
  const re = new RegExp(
    `<wp:meta_key>\\s*<!\\[CDATA\\[${key.replace(/[.*+?^${}()|[\\]\\\\]/g, '\\\\$&')}\\]\\]>\\s*</wp:meta_key>\\s*<wp:meta_value>\\s*<!\\[CDATA\\[([\\s\\S]*?)\\]\\]>\\s*</wp:meta_value>`
  );
  const m = block.match(re);
  return m ? m[1].trim() : '';
}

// ---------- Build attachment-ID -> URL map ----------
const attachmentMap = {};
for (const block of items) {
  if (getCdata(block, 'wp:post_type') !== 'attachment') continue;
  const id = getPlain(block, 'wp:post_id');
  const url = getCdata(block, 'wp:attachment_url');
  if (id && url) attachmentMap[id] = url;
}

// ---------- WPBakery shortcode cleanup ----------
function decodeRawHtml(payload) {
  try {
    const b64 = payload.trim();
    const urlEncoded = Buffer.from(b64, 'base64').toString('utf8');
    return decodeURIComponent(urlEncoded);
  } catch {
    return '';
  }
}

function cleanWpBakery(html) {
  if (!html) return html;
  let s = html;

  // [vc_raw_html ...]BASE64[/vc_raw_html] -> embed decoded HTML
  s = s.replace(/\[vc_raw_html[^\]]*\]([\s\S]*?)\[\/vc_raw_html\]/g, (_, payload) => {
    return '\n' + decodeRawHtml(payload) + '\n';
  });

  // [vc_custom_heading text="X" font_container="tag:hN|..."] -> <hN>X</hN>
  s = s.replace(/\[vc_custom_heading\b([^\]]*)\]/g, (full) => {
    const text = (full.match(/text="([^"]*)"/) || [, ''])[1];
    const fc   = (full.match(/font_container="([^"]*)"/) || [, ''])[1];
    const tag  = (fc.match(/tag:(h[1-6])/) || [, 'h2'])[1];
    return `<${tag}>${text}</${tag}>`;
  });

  // [vc_btn title="X" link="url:ENCODED|title:..."] -> <a class="btn">X</a>
  s = s.replace(/\[vc_btn\b([^\]]*)\]/g, (full) => {
    const title = (full.match(/title="([^"]*)"/) || [, 'Learn more'])[1];
    const link  = (full.match(/link="([^"]*)"/) || [, ''])[1];
    let href = '#';
    const urlMatch = link.match(/url:([^|]+)/);
    if (urlMatch) {
      try { href = decodeURIComponent(urlMatch[1]); } catch { href = urlMatch[1]; }
    }
    const color = (full.match(/color="([^"]*)"/) || [, ''])[1];
    const cls = color === 'warning'
      ? 'inline-block rounded-full bg-accent-500 px-6 py-3 text-sm font-semibold text-white hover:bg-accent-600 no-underline'
      : 'inline-block rounded-full bg-brand-600 px-6 py-3 text-sm font-semibold text-white hover:bg-brand-700 no-underline';
    return `<a href="${href}" class="${cls}">${title}</a>`;
  });

  // [vc_single_image image="ID" ...] -> <img src="..."> (resolved via attachment map)
  s = s.replace(/\[vc_single_image\b([^\]]*)\]/g, (full) => {
    const id = (full.match(/image="([^"]*)"/) || [, ''])[1];
    const url = attachmentMap[id];
    if (!url) return '';
    const align = (full.match(/alignment="([^"]*)"/) || [, ''])[1];
    const wrapClass = align === 'center' ? 'text-center' : '';
    return `<p class="${wrapClass}"><img src="${url}" alt="" loading="lazy" /></p>`;
  });

  // Drop reviews widgets and other plugin shortcodes
  s = s.replace(/\[google-reviews-pro[\s\S]*?\]/g, '');
  s = s.replace(/\[\/?(?:saswp_initiate_schema|saswp[^\]]*|trx_[^\]]*|wpb_[^\]]*)\]/g, '');

  // Server-side date/price shortcodes — leave a TODO marker
  s = s.replace(/\[(?:[a-z0-9_-]+_date_shortcode|[a-z0-9_-]+_price_shortcode)\]/g, '<!-- TODO: dynamic date/price was here -->');

  // Strip remaining vc_* opening + closing tags
  s = s.replace(/\[vc_[a-z_]+(?:\s[^\]]*)?\]/g, '');
  s = s.replace(/\[\/vc_[a-z_]+\]/g, '');

  // Tidy
  s = s.replace(/<p>\s*<\/p>/g, '');
  s = s.replace(/\n{3,}/g, '\n\n');
  return s.trim();
}

function urlToPath(link) {
  try {
    const u = new URL(link);
    let p = u.pathname;
    if (!p.endsWith('/')) p += '/';
    return p;
  } catch {
    return '';
  }
}
function escAttr(s) { return String(s).replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/</g, '&lt;'); }
function escTpl(s)  { return String(s).replace(/\\/g, '\\\\').replace(/`/g, '\\`').replace(/\$\{/g, '\\${'); }

let written = 0;
const skipped = [];
const overwritten = [];

for (const block of items) {
  if (getCdata(block, 'wp:post_type') !== 'page') continue;
  if (getCdata(block, 'wp:status') !== 'publish') {
    skipped.push({ status: getCdata(block, 'wp:status'), title: getCdata(block, 'title') });
    continue;
  }

  const link = getPlain(block, 'link');
  const urlPath = urlToPath(link);
  if (!urlPath) { skipped.push({ reason: 'no link', title: getCdata(block, 'title') }); continue; }
  if (HAND_BUILT.has(urlPath)) { skipped.push({ reason: 'hand-built', urlPath }); continue; }

  const title = getCdata(block, 'title');
  const rawContent = getCdata(block, 'content:encoded');
  const excerpt = getCdata(block, 'excerpt:encoded').replace(/\s+/g, ' ').trim();
  const yoastTitle = getMeta(block, '_yoast_wpseo_title');
  const yoastDesc  = getMeta(block, '_yoast_wpseo_metadesc');

  const seoTitle = (yoastTitle && yoastTitle.replace(/%%[a-z_]+%%/g, '').trim()) ||
                   `${title} | MixTree Languages`;
  const seoDesc  = yoastDesc || excerpt || `${title} at MixTree Languages, English language school in Amsterdam.`;

  const stripped = rawContent.replace(/<!--\s*\/?wp:[^>]*-->/g, '');
  const body = cleanWpBakery(stripped);

  const depth = urlPath.split('/').filter(Boolean).length + 1;
  const astroSource = `---
/**
 * AUTO-GENERATED from WordPress page export (WPBakery shortcodes cleaned).
 * Source: ${link}
 * Re-running scripts/convert-pages.mjs will overwrite this file.
 */
import BaseLayout from '${'../'.repeat(depth)}layouts/BaseLayout.astro';

const seo = {
  title: ${JSON.stringify(seoTitle)},
  description: ${JSON.stringify(seoDesc)},
};

const body = \`${escTpl(body)}\`;
---
<BaseLayout seo={seo}>
  <h1 class="text-3xl font-bold text-brand-700 sm:text-4xl">${escAttr(title)}</h1>
  <article class="prose prose-slate mt-6 max-w-none" set:html={body} />
</BaseLayout>
`;

  const outDir = join(pagesDir, urlPath.replace(/^\//, '').replace(/\/$/, ''));
  const outFile = join(outDir, 'index.astro');
  const stubExisted = existsSync(outFile);
  mkdirSync(outDir, { recursive: true });
  writeFileSync(outFile, astroSource, 'utf8');
  if (stubExisted) overwritten.push(urlPath); else written++;
}

console.log(`Wrote ${written} new pages, replaced ${overwritten.length} existing`);
console.log(`Attachment URLs resolved: ${Object.keys(attachmentMap).length}`);
if (skipped.length) console.log(`Skipped ${skipped.length}:`, skipped.map(s => s.urlPath || s.title || s));
