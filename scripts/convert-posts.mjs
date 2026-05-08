// One-off WP XML -> Astro content collection markdown extractor.
// Keeps body as raw HTML inside the .md (Astro renders it fine).
// Run from repo root: node scripts/convert-posts.mjs
import { readFileSync, writeFileSync, mkdirSync } from 'node:fs';
import { fileURLToPath } from 'node:url';
import { dirname, resolve, join } from 'node:path';

const here = dirname(fileURLToPath(import.meta.url));
const inFile = resolve(here, '..', 'mixtreelanguages-englishlanguageschool.WordPress.2026-05-05.xml');
const outDir = resolve(here, '..', 'site', 'src', 'content', 'posts');
mkdirSync(outDir, { recursive: true });

const xml = readFileSync(inFile, 'utf8');

// Split by <item> blocks
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

function yamlEscape(s) {
  if (s === '' || s == null) return "''";
  // Use single-quoted YAML; escape internal quotes by doubling
  return "'" + String(s).replace(/'/g, "''") + "'";
}

function extractCategories(block) {
  // <category domain="post_tag" nicename="travel"><![CDATA[Travel]]></category>
  const out = { tags: [], categories: [] };
  const re = /<category[^>]*domain="(post_tag|category)"[^>]*nicename="([^"]+)"[^>]*><!\[CDATA\[([^\]]+)\]\]><\/category>/g;
  let m;
  while ((m = re.exec(block)) !== null) {
    const list = m[1] === 'post_tag' ? out.tags : out.categories;
    if (!list.includes(m[3])) list.push(m[3]);
  }
  return out;
}

let written = 0;
const skipped = [];

for (const block of items) {
  const postType = getCdata(block, 'wp:post_type');
  if (postType !== 'post') continue;
  const status = getCdata(block, 'wp:status');
  if (status !== 'publish') { skipped.push({ status, title: getCdata(block, 'title') }); continue; }

  const title = getCdata(block, 'title') || getPlain(block, 'title');
  const slug = getCdata(block, 'wp:post_name');
  const excerpt = getCdata(block, 'excerpt:encoded').replace(/\s+/g, ' ').trim();
  const content = getCdata(block, 'content:encoded');
  const dateStr = getCdata(block, 'wp:post_date_gmt') || getCdata(block, 'wp:post_date');
  // dateStr like "2024-03-15 09:30:00"
  const isoDate = dateStr ? dateStr.split(' ')[0] : '2024-01-01';

  const { tags, categories } = extractCategories(block);

  if (!slug) { skipped.push({ reason: 'no slug', title }); continue; }

  // Excerpt fallback: first ~160 chars of stripped content
  const excerptFinal = excerpt || content
    .replace(/<[^>]+>/g, ' ')
    .replace(/\s+/g, ' ')
    .trim()
    .slice(0, 160);

  const fm = [
    '---',
    `title: ${yamlEscape(title)}`,
    `urlSlug: ${yamlEscape(slug)}`,
    `publishedAt: ${yamlEscape(isoDate)}`,
    `excerpt: ${yamlEscape(excerptFinal)}`,
    'tags:',
    ...(tags.length ? tags.map(t => `  - ${yamlEscape(t)}`) : ['  []']),
    'seo:',
    `  title: ${yamlEscape(`${title} | MixTree Magazine`)}`,
    `  description: ${yamlEscape(excerptFinal)}`,
    '---',
    '',
  ].join('\n');

  // Body: keep WP HTML as-is. Strip WP block comments to keep it clean.
  const body = content
    .replace(/<!--\s*\/?wp:[^>]*-->/g, '')
    .trim();

  const outPath = join(outDir, `${slug}.md`);
  writeFileSync(outPath, fm + body + '\n', 'utf8');
  written++;
}

console.log(`Wrote ${written} posts to ${outDir}`);
if (skipped.length) console.log(`Skipped ${skipped.length}:`, skipped);
