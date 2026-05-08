// @ts-check
import { defineConfig } from 'astro/config';
import sitemap from '@astrojs/sitemap';
import mdx from '@astrojs/mdx';
import tailwindcss from '@tailwindcss/vite';

/**
 * 301s migrated from Yoast (wordpress-seo-redirects.csv).
 *
 * Trailing slashes are added because the build is `format: 'directory'` +
 * `trailingSlash: 'always'`. Targets pointing at `/` keep no trailing
 * extra (root). The two existing redirects (online-english-private-lessons,
 * private-courses) are preserved below the merged set.
 */
const yoastRedirects = {
  '/engels-leren-amsterdam/': '/',
  '/about-mixtree/testimonials/': '/about-mixtree-languages/student-testimonials-mixtree-languages/',
  '/about-mixtree/testimonials-mixtree-languages-english-courses-in-the-heart-of-amsterdam/':
    '/about-mixtree-languages/student-testimonials-mixtree-languages/',
  '/homepage/cursus-engels-amsterdam/': '/',
  '/buy-10-hours-online-english-course/':
    '/private-courses/private-english-course/inquiry/?package=10&format=online',
  '/buy-20-hours-online-english-course/':
    '/private-courses/private-english-course/inquiry/?package=20&format=online',
  '/buy-30-hours-online-english-course/':
    '/private-courses/private-english-course/inquiry/?package=30&format=online',
  '/buy-10-hours-private-english-course/':
    '/private-courses/private-english-course/inquiry/?package=10&format=in-person',
  '/buy-20-hours-private-english-course/':
    '/private-courses/private-english-course/inquiry/?package=20&format=in-person',
  '/buy-30-hours-private-english-course/':
    '/private-courses/private-english-course/inquiry/?package=30&format=in-person',
  '/english-course/c1-advanced-english-course/': '/c1-advanced-english-course/',
  '/english-language-tips/mixtree-languages-a-non-profit-english-institute-in-amsterdams-city-centre/':
    '/english-language-tips/mixtree-languages-a-non-profit-english-school-in-amsterdams-city-centre/',
  '/english-language-tips/amsterdam-language-experience-partners-with-mixtree-languages-english-institute/':
    '/',
  '/homepage/about-mixtree/': '/about-mixtree-languages/',
  '/english-course/business-english-course/': '/english-course/business-english/',
  '/about-mixtree/': '/about-mixtree-languages/',
  '/about-mixtree-languages/student-testimonials-mixtree-languages-english-courses-in-the-heart-of-amsterdam/':
    '/about-mixtree-languages/student-testimonials-mixtree-languages/',
  '/english-course/intensive-test-db-connection/':
    '/english-course/intensive-english-course-schedule/',
  '/thank-you-free-level-check-new/': '/thank-you-free-level-check/',
  '/english-language-tips/a-non-profit-english-language-school-in-the-heart-of-amsterdam/':
    '/english-language-tips/learn-english-in-amsterdam-10-years-of-mixtree-languages-2/',
  '/english-language-tips/learn-english-in-amsterdam-10-years-of-mixtree-languages-2/':
    '/english-language-tips/learn-english-in-amsterdam-10-years-of-mixtree-languages/',
  '/course-schedule-2025/': '/course-schedule/',
  '/about-mixtree-languages/faq/': '/about-mixtree-languages/faq-mixtree-languages/',
  '/thank-you-free-intake/': '/thank-you-level-check-mtl/',
  '/thank-you-contact/': '/thank-you-contact-mtl/',
  '/cursus-engels-amsterdam/': '/engels-leren-mixtree/',
};

// https://astro.build/config
export default defineConfig({
  site: 'https://mixtreelang.nl',
  trailingSlash: 'always',
  redirects: {
    ...yoastRedirects,
    '/online-english-private-lessons/': '/private-courses/private-english-course/',
    '/private-courses/': '/private-courses/private-english-course/',
  },
  build: {
    format: 'directory',
  },
  integrations: [
    mdx(),
    sitemap({
      changefreq: 'weekly',
      priority: 0.7,
      filter: (page) =>
        !page.includes('/preview/') && !page.includes('/draft/'),
    }),
  ],
  vite: {
    plugins: [tailwindcss()],
  },
});
