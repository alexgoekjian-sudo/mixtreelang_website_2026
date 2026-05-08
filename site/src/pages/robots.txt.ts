import type { APIRoute } from 'astro';

/**
 * robots.txt endpoint.
 *
 * Production (default): allow crawling, point to sitemap.
 * Staging: set env var MTL_STAGING=1 (or NODE_ENV=staging) before `npm run build`
 *   and the output becomes a full Disallow so search engines won't index the
 *   staging subdomain (e.g. staging.mixtreelang.nl).
 */
export const GET: APIRoute = () => {
  const isStaging =
    process.env.MTL_STAGING === '1' ||
    process.env.NODE_ENV === 'staging';

  const body = isStaging
    ? `User-agent: *\nDisallow: /\n`
    : `User-agent: *\nDisallow: /.rate/\nDisallow: /mailer.php\n\nSitemap: https://mixtreelang.nl/sitemap-index.xml\n`;

  return new Response(body, {
    headers: { 'Content-Type': 'text/plain; charset=utf-8' },
  });
};
