/**
 * Internal link checker for the built site.
 *
 * Crawls every HTML file in `dist/`, extracts internal `<a href>`s,
 * resolves them against the directory tree (respecting `trailingSlash:'always'`),
 * and reports any link that doesn't point to an existing page or asset.
 *
 * External links (http(s)://, mailto:, tel:, javascript:, data:) are skipped.
 *
 * Usage:
 *   pnpm --filter site build      # or `npm run build` from /site
 *   node scripts/check-links.mjs  # from /site
 */
import { readFile } from 'node:fs/promises';
import { existsSync, statSync } from 'node:fs';
import path from 'node:path';
import { fileURLToPath } from 'node:url';
import { glob } from 'tinyglobby';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const ROOT = path.resolve(__dirname, '..');
const DIST = path.join(ROOT, 'dist');

if (!existsSync(DIST)) {
  console.error(`✗ ${DIST} not found. Run \`npm run build\` first.`);
  process.exit(2);
}

const HREF_RE = /<a\b[^>]*\bhref=(["'])([^"']+)\1/gi;
const SCRIPT_RE = /<script\b[^>]*>[\s\S]*?<\/script>/gi;
const SKIP = /^(https?:|mailto:|tel:|javascript:|data:|#)/i;
const TEMPLATE_VAR = /\$\{|<%/;  // unresolved JS template literals or template tags

function resolveTarget(rawHref, fromFile) {
  const cleaned = rawHref.split('#')[0].split('?')[0];
  if (!cleaned) return null;

  let p;
  if (cleaned.startsWith('/')) {
    p = path.join(DIST, cleaned);
  } else {
    const dir = path.dirname(fromFile);
    p = path.resolve(dir, cleaned);
  }

  // Directory URL → look for index.html.
  if (cleaned.endsWith('/') || (existsSync(p) && statSync(p).isDirectory())) {
    p = path.join(p, 'index.html');
  }

  // No extension → assume directory-style page.
  if (!path.extname(p)) {
    const idx = path.join(p, 'index.html');
    if (existsSync(idx)) return idx;
  }

  return p;
}

const htmlFiles = await glob(['**/*.html'], { cwd: DIST });
let totalLinks = 0;
const broken = [];

for (const rel of htmlFiles) {
  const file = path.join(DIST, rel);
  let html = await readFile(file, 'utf8');
  // Strip <script>…</script> contents — JS template literals inside scripts
  // can look like <a href="${var}"> and trip the parser.
  html = html.replace(SCRIPT_RE, '');
  let m;
  HREF_RE.lastIndex = 0;
  while ((m = HREF_RE.exec(html))) {
    const href = m[2];
    if (SKIP.test(href) || TEMPLATE_VAR.test(href)) continue;
    totalLinks += 1;
    const target = resolveTarget(href, file);
    if (!target || !existsSync(target)) {
      broken.push({ from: rel, href, resolved: target ? path.relative(DIST, target) : null });
    }
  }
}

console.log(`Checked ${totalLinks} internal link(s) across ${htmlFiles.length} page(s).`);

if (broken.length === 0) {
  console.log('✓ No broken internal links.');
  process.exit(0);
}

console.error(`✗ ${broken.length} broken link(s):\n`);
for (const b of broken) {
  console.error(`  ${b.from}`);
  console.error(`    → ${b.href}${b.resolved ? `  (resolved: ${b.resolved})` : ''}`);
}
process.exit(1);
