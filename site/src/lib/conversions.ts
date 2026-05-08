/**
 * Google Ads conversion targets used by /thank-you-* pages.
 *
 * These were imported from the Yoast/WP page export — the payload is the
 * same conversion id across all post-form thank-you pages. Update if the
 * conversion is split per funnel in Google Ads.
 *
 * Format: "AW-<conversion-id>/<conversion-label>".
 */
const FORM_CONVERSION = 'AW-9513016967/JxjUCIOQg5ADEMDszsUD';

export const GADS_CONVERSION = {
  /** Generic contact / inquiry forms. */
  contact: FORM_CONVERSION,
  /** Free level-check booking. */
  levelCheck: FORM_CONVERSION,
  /** Course enrolment confirmation. */
  enrolment: FORM_CONVERSION,
  /** Mollie payment success. */
  payment: FORM_CONVERSION,
  /** Newsletter subscription. */
  newsletter: FORM_CONVERSION,
} as const;
