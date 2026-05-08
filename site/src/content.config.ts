import { defineCollection, z } from 'astro:content';
import { glob } from 'astro/loaders';

const seo = z.object({
  title: z.string(),
  description: z.string(),
  canonical: z.string().url().optional(),
  ogImage: z.string().optional(),
  noindex: z.boolean().default(false),
});

const courses = defineCollection({
  loader: glob({ pattern: '**/*.md', base: './src/content/courses' }),
  schema: z.object({
    title: z.string(),
    // Slug under /english-course/ or /private-courses/, matching current URLs.
    urlPath: z.string(),
    category: z.enum(['group', 'private']),
    levels: z.array(z.string()),
    format: z.enum(['in-person', 'online', 'in-company', 'hybrid']),
    hours: z.number().optional(),
    weeks: z.number().optional(),
    priceEur: z.number().optional(),
    nextStartDate: z.string().optional(), // ISO yyyy-mm-dd
    heroImage: z.string().optional(),
    heroImageAlt: z.string().optional(),
    seo,
    order: z.number().default(0),
  }),
});

const posts = defineCollection({
  loader: glob({ pattern: '**/*.{md,mdx}', base: './src/content/posts' }),
  schema: z.object({
    title: z.string(),
    // Path under /english-language-tips/
    urlSlug: z.string(),
    publishedAt: z.coerce.date(),
    updatedAt: z.coerce.date().optional(),
    excerpt: z.string(),
    coverImage: z.string().optional(),
    coverImageAlt: z.string().optional(),
    author: z.string().default('MixTree Languages'),
    tags: z.array(z.string()).default([]),
    /**
     * Optional original source. When set, the article page renders a
     * standardised "Source" footer linking out with rel="noopener external".
     * Use for cross-posts / press mentions hosted on iamexpat.nl, expatica, etc.
     */
    source: z
      .object({
        name: z.string(),
        url: z.string().url(),
      })
      .optional(),
    seo,
  }),
});

export const collections = { courses, posts };
