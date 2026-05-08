// One-off converter: wp_courses_export.txt (PHP array dump) -> site/src/data/schedule.json
// Run from repo root: node scripts/convert-courses.mjs
import { readFileSync, writeFileSync } from 'node:fs';
import { fileURLToPath } from 'node:url';
import { dirname, resolve } from 'node:path';

const here = dirname(fileURLToPath(import.meta.url));
const inFile = resolve(here, '..', 'wp_courses_export.txt');
const outFile = resolve(here, '..', 'site', 'src', 'data', 'schedule.json');

const src = readFileSync(inFile, 'utf8');

// Split into per-course blocks: each starts with "[" and ends with "],"
const blocks = src.split(/\n\s*\[\s*\n/).slice(1); // drop everything before first block

const MONTHS = {
  Jan: 1, Feb: 2, Mar: 3, Apr: 4, May: 5, Jun: 6,
  Jul: 7, Aug: 8, Sep: 9, Sept: 9, Oct: 10, Nov: 11, Dec: 12,
};

function field(block, key) {
  const re = new RegExp(`'${key}'\\s*=>\\s*'([^']*)'`);
  const m = block.match(re);
  return m ? m[1] : '';
}

function toISO(monthDay, year) {
  // "May 11" + "2026" -> "2026-05-11"
  const m = monthDay.match(/^(\w+)\s+(\d{1,2})$/);
  if (!m) return null;
  const month = MONTHS[m[1]];
  if (!month) return null;
  return `${year}-${String(month).padStart(2, '0')}-${String(parseInt(m[2], 10)).padStart(2, '0')}`;
}

function normaliseDays(d) {
  return d
    .replace(/\bThurs\b/g, 'Thu')
    .replace(/\bThur\b/g, 'Thu')
    .replace(/\bTues\b/g, 'Tue');
}

const rows = [];
const skipped = [];

for (const raw of blocks) {
  const name = field(raw, 'name');
  if (!name) continue;
  const type = field(raw, 'type');
  const level = field(raw, 'level');
  const programme = field(raw, 'programme');
  const hoursStr = field(raw, 'hours'); // "40 hours/4 weeks"
  const priceStr = field(raw, 'price'); // "€640"
  const startMD = field(raw, 'startDate');
  const endMD = field(raw, 'endDate');
  const yearStr = field(raw, 'year');
  const days = field(raw, 'days');
  const times = field(raw, 'times');

  const hwMatch = hoursStr.match(/(\d+)\s*hours?\s*\/\s*(\d+)\s*weeks?/i);
  const hours = hwMatch ? parseInt(hwMatch[1], 10) : null;
  const weeks = hwMatch ? parseInt(hwMatch[2], 10) : null;
  const priceEur = parseInt((priceStr.match(/\d+/) || ['0'])[0], 10);
  const year = parseInt(yearStr, 10);
  const startDate = toISO(startMD, year);
  // End year may roll over (Dec -> Jan); naive: same year, fix below if end < start
  let endDate = toISO(endMD, year);
  if (startDate && endDate && endDate < startDate) {
    endDate = toISO(endMD, year + 1);
  }

  if (!hours || !weeks || !startDate || !endDate || !year) {
    skipped.push({ name, reason: 'parse failed', hoursStr, priceStr, startMD, endMD, yearStr });
    continue;
  }

  rows.push({
    code: name,
    type,
    level,
    programme,
    hours,
    weeks,
    priceEur,
    startDate,
    endDate,
    year,
    days: normaliseDays(days),
    times,
    registerUrl: '/free-english-level-check-enrolment/',
  });
}

rows.sort((a, b) => a.startDate.localeCompare(b.startDate) || a.code.localeCompare(b.code));

writeFileSync(outFile, JSON.stringify(rows, null, 2) + '\n', 'utf8');
console.log(`Wrote ${rows.length} rows to ${outFile}`);
if (skipped.length) {
  console.log(`Skipped ${skipped.length}:`);
  for (const s of skipped) console.log(' -', s);
}
