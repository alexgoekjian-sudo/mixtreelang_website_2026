#!/usr/bin/env node
/**
 * Scrape /wp-content/uploads/ images from one or more live WP pages
 * and mirror them under site/public/wp-content/uploads/ preserving
 * their original paths.
 *
 * Usage:
 *   node scripts/scrape-images.mjs                   # scrapes homepage
 *   node scripts/scrape-images.mjs /about/ /contact/ # scrapes given paths
 *   node scripts/scrape-images.mjs --all             # crawls site map
 *
 * Skips files that already exist locally. Idempotent.
 */
import { mkdir, writeFile, access } from 'node:fs/promises';
import { dirname, join } from 'node:path';
import { fileURLToPath } from 'node:url';

const ORIGIN = 'https://mixtreelang.nl';
const ROOT = join(dirname(fileURLToPath(import.meta.url)), '..');
const OUT_DIR = join(ROOT, 'site', 'public');

const IMG_RE = /https:\/\/mixtreelang\.nl\/wp-content\/uploads\/[^"'\s)<>]+?\.(?:jpe?g|png|webp|gif|svg)/gi;

async function fileExists(p) {
  try { await access(p); return true; } catch { return false; }
}

async function fetchHtml(path) {
  const url = path.startsWith('http') ? path : `${ORIGIN}${path}`;
  const res = await fetch(url, { headers: { 'User-Agent': 'mtl-image-scraper/1.0' } });
  if (!res.ok) throw new Error(`${url} → ${res.status}`);
  return res.text();
}

function extractImages(html) {
  return Array.from(new Set(html.match(IMG_RE) || []));
}

async function downloadOne(url) {
  const relPath = url.replace(`${ORIGIN}/`, '');
  const localPath = join(OUT_DIR, relPath);
  if (await fileExists(localPath)) {
    return { url, status: 'skip' };
  }
  const res = await fetch(url);
  if (!res.ok) return { url, status: `error ${res.status}` };
  const buf = Buffer.from(await res.arrayBuffer());
  await mkdir(dirname(localPath), { recursive: true });
  await writeFile(localPath, buf);
  return { url, status: `ok ${(buf.length / 1024).toFixed(1)}KB` };
}

async function scrapePage(path) {
  console.log(`\n=== ${path} ===`);
  const html = await fetchHtml(path);
  const urls = extractImages(html);
  console.log(`  found ${urls.length} image URLs`);
  let ok = 0, skip = 0, err = 0;
  for (const u of urls) {
    const r = await downloadOne(u);
    if (r.status === 'skip') skip++;
    else if (r.status.startsWith('ok')) { ok++; console.log(`    + ${u.replace(ORIGIN, '')} (${r.status})`); }
    else { err++; console.log(`    ! ${u} → ${r.status}`); }
  }
  console.log(`  -> downloaded ${ok}, skipped ${skip}, errors ${err}`);
  return { ok, skip, err };
}

const args = process.argv.slice(2);
const paths = args.length === 0 ? ['/'] : args;

let totals = { ok: 0, skip: 0, err: 0 };
for (const p of paths) {
  const r = await scrapePage(p);
  totals.ok += r.ok; totals.skip += r.skip; totals.err += r.err;
}
console.log(`\nDone. Total: ${totals.ok} new, ${totals.skip} already present, ${totals.err} failed.`);
