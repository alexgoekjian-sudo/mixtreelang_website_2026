/**
 * Fetch Google Places reviews and cache as JSON.
 *
 * Usage:
 *   GOOGLE_PLACES_API_KEY=AIza... node scripts/fetch-google-reviews.mjs
 *
 * Output: site/src/data/google-reviews.json
 *
 * Notes:
 *   - Places API "Place Details" returns up to 5 reviews. For more, you would
 *     need the New Places API (v1) — see https://developers.google.com/maps/documentation/places/web-service/place-details
 *   - This script uses the v1 endpoint which returns up to 5 most-relevant
 *     reviews and is the recommended modern API.
 *   - We persist the JSON in source control so the site renders reviews even
 *     when the build pipeline has no network / no API key.
 *   - Re-run weekly (cron / GitHub Action) to keep them fresh.
 */
import { writeFileSync, mkdirSync } from 'node:fs';
import { dirname } from 'node:path';

const PLACE_ID = 'ChIJu4xnzAnixUcRuPo_hGKp8QU'; // Mixtree Languages
const OUT = 'src/data/google-reviews.json';
const KEY = process.env.GOOGLE_PLACES_API_KEY;

if (!KEY) {
  console.error('GOOGLE_PLACES_API_KEY env var is required.');
  console.error('Get one at https://console.cloud.google.com/apis/credentials');
  console.error('Then run: $env:GOOGLE_PLACES_API_KEY="AIza..."; node scripts/fetch-google-reviews.mjs');
  process.exit(1);
}

const url = `https://places.googleapis.com/v1/places/${PLACE_ID}`;
const res = await fetch(url, {
  headers: {
    'X-Goog-Api-Key': KEY,
    'X-Goog-FieldMask': 'displayName,rating,userRatingCount,reviews,googleMapsUri',
    'Accept-Language': 'en',
  },
});

if (!res.ok) {
  console.error(`Places API ${res.status}: ${await res.text()}`);
  process.exit(1);
}

const data = await res.json();

const reviews = (data.reviews || []).map((r) => ({
  author: r.authorAttribution?.displayName || 'Anonymous',
  authorUri: r.authorAttribution?.uri || null,
  authorPhoto: r.authorAttribution?.photoUri || null,
  rating: r.rating,
  text: r.text?.text || r.originalText?.text || '',
  relativeTime: r.relativePublishTimeDescription || '',
  publishedAt: r.publishTime || null,
}));

const out = {
  fetchedAt: new Date().toISOString(),
  placeName: data.displayName?.text || 'Mixtree Languages',
  rating: data.rating,
  reviewCount: data.userRatingCount,
  mapsUri: data.googleMapsUri,
  reviews,
};

mkdirSync(dirname(OUT), { recursive: true });
writeFileSync(OUT, JSON.stringify(out, null, 2));
console.log(
  `Wrote ${reviews.length} reviews (rating ${data.rating} / ${data.userRatingCount} total) → ${OUT}`,
);
