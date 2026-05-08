/**
 * Image rehost — downloads every https://mixtreelang.nl/wp-content/uploads/...
 * URL referenced anywhere in the source tree to the local public/ folder, then
 * rewrites the references to root-relative paths so the new site doesn't need
 * the WordPress origin to keep serving images.
 *
 * Usage:
 *   node scripts/rehost-images.mjs            # download + rewrite
 *   node scripts/rehost-images.mjs --dry      # report only, no writes
 */
import {
  readFileSync,
  writeFileSync,
  existsSync,
  mkdirSync,
  createWriteStream,
} from 'node:fs';
import { dirname, join, relative } from 'node:path';
import { fileURLToPath } from 'node:url';
import { glob } from 'tinyglobby';

const __dirname = dirname(fileURLToPath(import.meta.url));
const ROOT = join(__dirname, '..');
const PUBLIC_DIR = join(ROOT, 'public');
const DRY = process.argv.includes('--dry');

const ORIGIN = 'https://mixtreelang.nl';
// matches absolute URLs in href/src/srcset and even bare strings
const URL_RE = /https?:\/\/(?:www\.)?mixtreelang\.nl\/wp-content\/uploads\/[^\s"'<>)]+/g;

const SOURCE_GLOBS = [
  'src/**/*.{astro,md,mdx,ts,tsx,js,jsx,json,html}',
];

async function main() {
  const files = await glob(SOURCE_GLOBS, { cwd: ROOT, absolute: true });
  const urlSet = new Set();

  for (const f of files) {
    const text = readFileSync(f, 'utf8');
    const matches = text.match(URL_RE);
    if (matches) for (const u of matches) urlSet.add(u);
  }

  console.log(`Found ${urlSet.size} unique wp-content URLs across ${files.length} files`);

  if (urlSet.size === 0) return;

  const downloaded = new Map(); // originalUrl -> local relative path (e.g. "/wp-content/uploads/2022/02/foo.jpg")
  let okCount = 0;
  let failCount = 0;
  let skipCount = 0;

  for (const url of urlSet) {
    try {
      const u = new URL(url);
      const relPath = u.pathname; // /wp-content/uploads/...
      const localAbs = join(PUBLIC_DIR, relPath);
      downloaded.set(url, relPath);

      if (existsSync(localAbs)) {
        skipCount++;
        continue;
      }
      if (DRY) {
        console.log(`DRY: would download ${url}`);
        continue;
      }
      mkdirSync(dirname(localAbs), { recursive: true });
      const res = await fetch(url, { redirect: 'follow' });
      if (!res.ok || !res.body) {
        console.warn(`FAIL ${res.status} ${url}`);
        failCount++;
        downloaded.delete(url);
        continue;
      }
      const buf = Buffer.from(await res.arrayBuffer());
      writeFileSync(localAbs, buf);
      okCount++;
      if (okCount % 10 === 0) console.log(`  …${okCount} downloaded`);
    } catch (err) {
      console.warn(`ERR ${url}: ${err.message}`);
      failCount++;
      downloaded.delete(url);
    }
  }

  console.log(
    `Downloads: ${okCount} new, ${skipCount} cached, ${failCount} failed`,
  );

  if (DRY) {
    console.log('Dry run — no files modified.');
    return;
  }

  // Rewrite references in source files for URLs we successfully have locally.
  let rewroteFiles = 0;
  let rewroteRefs = 0;
  for (const f of files) {
    let text = readFileSync(f, 'utf8');
    const original = text;
    for (const [url, relPath] of downloaded) {
      if (text.includes(url)) {
        const before = text.length;
        text = text.split(url).join(relPath);
        rewroteRefs += (original.length - before === 0 ? 1 : 1);
      }
    }
    if (text !== original) {
      writeFileSync(f, text);
      rewroteFiles++;
      console.log(`rewrote: ${relative(ROOT, f)}`);
    }
  }

  console.log(`\nRewrote ${rewroteRefs} references in ${rewroteFiles} files.`);
}

main().catch((e) => {
  console.error(e);
  process.exit(1);
});
