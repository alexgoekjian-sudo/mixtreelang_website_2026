/**
 * JSON-LD schema builders — modern @graph approach.
 *
 * Every page emits ONE <script type="application/ld+json"> containing a
 * @graph with these always-present nodes:
 *   - Organization (the school)        @id = SITE + '#organization'
 *   - WebSite                          @id = SITE + '#website'
 *   - WebPage (this page)              @id = canonical + '#webpage'
 *   - BreadcrumbList                   @id = canonical + '#breadcrumb'
 *
 * Pages add page-type-specific nodes via the BaseLayout `jsonLd` prop:
 *   - courseNode(spec)        for the 6 course pages
 *   - courseCatalogNode()     for /course-schedule/
 *   - articleNode(post, url)  for /english-language-tips/[slug]
 *   - meetupEventNode()       optional weekly conversation meetup (home)
 *
 * All page-type nodes reference the Organization via @id, so Google links
 * the entities cleanly across the site.
 */
import googleReviews from '../data/google-reviews.json';
import { findUpcoming, type CourseRow } from './schedule';

const SITE = 'https://mixtreelang.nl';
export const ORG_ID = `${SITE}/#organization`;
export const WEBSITE_ID = `${SITE}/#website`;

const ADDRESS = {
  '@type': 'PostalAddress',
  streetAddress: 'Eerste Weteringplantsoen 2c',
  addressLocality: 'Amsterdam',
  addressRegion: 'North Holland',
  postalCode: '1017 SJ',
  addressCountry: 'NL',
};

/** Actual address coordinates (verified via WP geo block). */
const GEO = {
  '@type': 'GeoCoordinates',
  latitude: '52.35981924525704',
  longitude: '4.889443538405737',
};

const PLACE = {
  '@type': 'Place',
  name: 'MixTree Languages',
  address: ADDRESS,
  geo: GEO,
};

/* ───────────────────────── sitewide nodes ───────────────────────── */

export function organizationNode(): Record<string, unknown> {
  return {
    '@type': ['LanguageSchool', 'EducationalOrganization', 'LocalBusiness'],
    '@id': ORG_ID,
    name: 'MixTree Languages',
    legalName: 'Mixtree Languages Stichting',
    description:
      'English language school in Amsterdam offering small group courses with CELTA-certified teachers since 2015',
    url: SITE,
    logo: { '@type': 'ImageObject', url: `${SITE}/logo.svg` },
    image: [
      `${SITE}/wp-content/uploads/amsterdam-english-classes.jpg`,
      `${SITE}/wp-content/uploads/celta-teachers.jpg`,
    ],
    address: ADDRESS,
    geo: GEO,
    email: 'info@mixtreelang.nl',
    telephone: '+31207861981',
    contactPoint: {
      '@type': 'ContactPoint',
      telephone: '+31207861981',
      email: 'info@mixtreelang.nl',
      contactType: 'customer service',
      availableLanguage: ['English', 'Dutch', 'Italian', 'Spanish', 'French'],
    },
    foundingDate: '2015',
    numberOfEmployees: { '@type': 'QuantitativeValue', minValue: 5, maxValue: 10 },
    priceRange: '€€',
    paymentAccepted: ['Cash', 'Credit Card', 'Bank Transfer'],
    currenciesAccepted: 'EUR',
    openingHoursSpecification: [
      {
        '@type': 'OpeningHoursSpecification',
        dayOfWeek: ['Monday', 'Tuesday', 'Thursday', 'Friday'],
        opens: '09:00',
        closes: '18:00',
      },
      {
        '@type': 'OpeningHoursSpecification',
        dayOfWeek: 'Wednesday',
        opens: '09:00',
        closes: '15:00',
      },
    ],
    serviceArea: { '@type': 'GeoCircle', geoMidpoint: GEO, geoRadius: '25000' },
    areaServed: ['Amsterdam', 'Netherlands'],
    knowsLanguage: ['en', 'nl', 'fr', 'it', 'es'],
    hasCredential: [
      {
        '@type': 'EducationalOccupationalCredential',
        credentialCategory: 'CELTA',
        recognizedBy: { '@type': 'Organization', name: 'Cambridge English' },
      },
      { '@type': 'EducationalOccupationalCredential', credentialCategory: 'TESOL' },
    ],
    sameAs: [
      'https://www.facebook.com/MixTreeLanguages',
      'https://www.instagram.com/mixtree.lang',
      'https://www.linkedin.com/company/mixtreelanguages',
    ],
  };
}

export function websiteNode(): Record<string, unknown> {
  return {
    '@type': 'WebSite',
    '@id': WEBSITE_ID,
    url: SITE,
    name: 'MixTree Languages',
    publisher: { '@id': ORG_ID },
    inLanguage: 'en',
  };
}

export function webPageNode(opts: {
  url: string;
  title: string;
  description: string;
  ogImage?: string;
}): Record<string, unknown> {
  return {
    '@type': 'WebPage',
    '@id': `${opts.url}#webpage`,
    url: opts.url,
    name: opts.title,
    description: opts.description,
    isPartOf: { '@id': WEBSITE_ID },
    about: { '@id': ORG_ID },
    inLanguage: 'en',
    breadcrumb: { '@id': `${opts.url}#breadcrumb` },
    ...(opts.ogImage ? { primaryImageOfPage: { '@type': 'ImageObject', url: opts.ogImage } } : {}),
  };
}

/** Build a BreadcrumbList from the URL pathname. Home is always first. */
export function breadcrumbNode(canonicalUrl: string): Record<string, unknown> {
  const u = new URL(canonicalUrl);
  const segments = u.pathname.split('/').filter(Boolean);
  const items: Array<Record<string, unknown>> = [
    { '@type': 'ListItem', position: 1, name: 'Home', item: SITE + '/' },
  ];
  let acc = '';
  segments.forEach((seg, i) => {
    acc += `/${seg}`;
    items.push({
      '@type': 'ListItem',
      position: i + 2,
      name: humanize(seg),
      item: `${SITE}${acc}/`,
    });
  });
  return {
    '@type': 'BreadcrumbList',
    '@id': `${canonicalUrl}#breadcrumb`,
    itemListElement: items,
  };
}

function humanize(slug: string): string {
  return slug.replace(/[-_]+/g, ' ').replace(/\b\w/g, (c) => c.toUpperCase());
}

/* ───────────────────────── per-page nodes ───────────────────────── */

export interface CourseSpec {
  name: string;
  description: string;
  courseCode: string;
  educationalLevel: string;
  /** Filter into schedule.json to derive real upcoming start dates. */
  scheduleFilter: { type?: string; level?: string };
  timeRequired: string;
  /** Workload as ISO 8601 duration, e.g. "PT40H". */
  courseWorkload: string;
  courseMode: 'in-person' | 'online' | 'blended';
  price: string; // EUR
  /** Page path, e.g. "/english-course/intensive-english-course/". */
  path: string;
}

export function courseNode(c: CourseSpec): Record<string, unknown> {
  const url = `${SITE}${c.path}`;
  const isOnline = c.courseMode === 'online';
  const upcoming = findUpcoming(c.scheduleFilter, 6);

  // Google Course rich result requires hasCourseInstance with real dates.
  const instances = upcoming.map((row: CourseRow) => ({
    '@type': 'CourseInstance',
    courseMode: courseModeUrl(c.courseMode),
    startDate: row.startDate,
    endDate: row.endDate,
    courseSchedule: {
      '@type': 'Schedule',
      duration: c.courseWorkload,
      repeatFrequency: 'Weekly',
      scheduleTimezone: 'Europe/Amsterdam',
    },
    location: isOnline
      ? { '@type': 'VirtualLocation', url: 'https://zoom.us/' }
      : PLACE,
    instructor: {
      '@type': 'Organization',
      name: 'CELTA and TESOL-certified teachers',
    },
    offers: {
      '@type': 'Offer',
      price: c.price,
      priceCurrency: 'EUR',
      availability: 'https://schema.org/InStock',
      validFrom: row.startDate,
      url,
      category: 'Paid',
    },
  }));

  // Aggregate rating sourced from cached Google reviews.
  const aggregateRating =
    googleReviews.rating && googleReviews.reviewCount
      ? {
          '@type': 'AggregateRating',
          ratingValue: String(googleReviews.rating),
          reviewCount: String(googleReviews.reviewCount),
          bestRating: '5',
        }
      : undefined;

  return {
    '@type': 'Course',
    '@id': `${url}#course`,
    url,
    name: c.name,
    description: c.description,
    provider: { '@id': ORG_ID },
    courseCode: c.courseCode,
    educationalLevel: c.educationalLevel,
    coursePrerequisites: 'Free level test',
    timeRequired: c.timeRequired,
    inLanguage: 'en',
    teaches: 'English language',
    isAccessibleForFree: false,
    ...(aggregateRating ? { aggregateRating } : {}),
    ...(instances.length ? { hasCourseInstance: instances } : {}),
  };
}

function courseModeUrl(mode: CourseSpec['courseMode']): string {
  switch (mode) {
    case 'online':
      return 'https://schema.org/OnlineEventAttendanceMode';
    case 'blended':
      return 'https://schema.org/MixedEventAttendanceMode';
    default:
      return 'https://schema.org/OfflineEventAttendanceMode';
  }
}

/** Catalog ItemList for /course-schedule/. */
export function courseCatalogNode(): Record<string, unknown> {
  const items = [
    { name: 'Intensive English Courses', url: '/english-course/intensive-english-course/' },
    { name: 'Morning English Courses', url: '/english-course/morning-english-courses/' },
    { name: 'English for Beginners', url: '/english-course/english-for-beginners/' },
    {
      name: 'Online Evening English Courses',
      url: '/english-course/online-evening-english-courses/',
    },
    { name: 'C1 Advanced English Courses', url: '/c1-advanced-english-course/' },
    { name: 'Business English Course', url: '/english-course/business-english/' },
  ];

  return {
    '@type': 'ItemList',
    '@id': `${SITE}/course-schedule/#itemlist`,
    name: 'English Courses in Amsterdam - MixTree Languages',
    description:
      'Complete list of English language courses offered by MixTree Languages in Amsterdam',
    numberOfItems: items.length,
    itemListElement: items.map((it, i) => ({
      '@type': 'ListItem',
      position: i + 1,
      url: `${SITE}${it.url}`,
      name: it.name,
    })),
  };
}

/** Article node for blog posts. */
export function articleNode(post: {
  title: string;
  excerpt?: string;
  publishedAt: string;
  updatedAt?: string;
  coverImage?: string;
  author?: string;
  url: string;
}): Record<string, unknown> {
  return {
    '@type': 'BlogPosting',
    '@id': `${post.url}#article`,
    headline: post.title,
    description: post.excerpt,
    datePublished: post.publishedAt,
    dateModified: post.updatedAt ?? post.publishedAt,
    image: post.coverImage,
    author: { '@type': 'Organization', name: post.author ?? 'MixTree Languages' },
    publisher: { '@id': ORG_ID },
    mainEntityOfPage: { '@id': `${post.url}#webpage` },
    inLanguage: 'en',
  };
}

/** Weekly conversation meetup — emit on home. Auto-rolls to next Wednesday. */
export function meetupEventNode(): Record<string, unknown> {
  const wed = nextWednesdayISO();
  return {
    '@type': 'Event',
    '@id': `${SITE}/#weekly-meetup`,
    name: 'English Conversation Meetups',
    description: 'Weekly social events for English practice and networking',
    startDate: `${wed}T13:00:00+01:00`,
    endDate: `${wed}T15:00:00+01:00`,
    eventSchedule: {
      '@type': 'Schedule',
      repeatFrequency: 'P1W',
      byDay: 'https://schema.org/Wednesday',
      scheduleTimezone: 'Europe/Amsterdam',
    },
    eventStatus: 'https://schema.org/EventScheduled',
    eventAttendanceMode: 'https://schema.org/OfflineEventAttendanceMode',
    location: PLACE,
    organizer: { '@id': ORG_ID },
    isAccessibleForFree: true,
    offers: {
      '@type': 'Offer',
      price: '0',
      priceCurrency: 'EUR',
      availability: 'https://schema.org/InStock',
      url: SITE + '/',
      validFrom: new Date().toISOString().slice(0, 10),
    },
  };
}

function nextWednesdayISO(): string {
  const d = new Date();
  const offset = (3 - d.getUTCDay() + 7) % 7 || 7;
  d.setUTCDate(d.getUTCDate() + offset);
  return d.toISOString().slice(0, 10);
}
