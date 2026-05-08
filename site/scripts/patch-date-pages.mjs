// Temporary patch script — fixes 2 pages with base64-trailing bodies that
// PowerShell regex couldn't safely target. Idempotent.
import { readFileSync, writeFileSync } from 'node:fs';

const fixes = [
  {
    file: 'src/pages/english-course/intensive-english-course-schedule/index.astro',
    filter: "{ type: 'INTENSIVE' }",
  },
  {
    file: 'src/pages/thank-you-level-check-mtl/index.astro',
    filter: "{ type: 'INTENSIVE' }",
  },
];

for (const { file, filter } of fixes) {
  let src = readFileSync(file, 'utf8');

  // 1) Strip any previously-misplaced injection at the very top.
  const badPrefix = /^---\r?\nconst bodyHtml = body\.replaceAll\(\r?\n  '<!-- TODO: dynamic date\/price was here -->',\r?\n  nextStartLabel\([^)]*\),\r?\n\);\r?\n\r?\n/;
  if (badPrefix.test(src)) {
    src = src.replace(badPrefix, '---\n');
    console.log(`removed misplaced injection: ${file}`);
  }

  // 2) Append the bodyHtml const just before the closing frontmatter.
  if (!src.includes('const bodyHtml')) {
    // Find the LAST `---` line that closes frontmatter (line preceding the template).
    // Strategy: split on the literal `\n---\n` and inject before the closer.
    const closerMatch = src.match(/(?:\r?\n)---(?:\r?\n)/g);
    if (!closerMatch) {
      console.log(`SKIP (no closer): ${file}`);
      continue;
    }
    // Find the LAST `---` line that closes frontmatter.
    const closerRe = /(?:\r?\n)---(?:\r?\n)/g;
    let closerIdx = -1;
    let m;
    while ((m = closerRe.exec(src)) !== null) closerIdx = m.index;
    if (closerIdx === -1) {
      console.log(`SKIP (no closer): ${file}`);
      continue;
    }
    const injection =
      `\n\nconst bodyHtml = body.replaceAll(\n  '<!-- TODO: dynamic date/price was here -->',\n  nextStartLabel(${filter}),\n);\n`;
    src = src.slice(0, closerIdx) + injection + src.slice(closerIdx);
  }

  // 3) Swap set:html={body} → set:html={bodyHtml} in the template region.
  src = src.replace(/set:html=\{body\}/g, 'set:html={bodyHtml}');

  writeFileSync(file, src);
  console.log(`OK: ${file}`);
}
