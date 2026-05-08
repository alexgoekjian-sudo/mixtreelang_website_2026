# GTM container setup — `GTM-M6N8T8S3`

This guide covers what you need to verify / change inside Google Tag Manager so the new Astro site fires conversions and respects consent **exactly the way your WordPress site did**, plus the bits that are *new* (Consent Mode v2 + Enhanced Conversions via dataLayer).

> TL;DR — your existing tags will keep firing, but two things probably need attention:
> 1. **Trigger names** — the new site fires a Custom Event called `contact_form_submit`. If your current Ads conversion fires on a CF7 listener (`wpcf7mailsent`) or a Form Submission trigger, it will **not** fire on the new site.
> 2. **Enhanced Conversions** — the new site already pushes user data to the dataLayer in the correct shape. You just have to point a few **Data Layer Variables** at it and tick a checkbox on the Ads tag.

---

## 0. Background: what changed vs. WordPress

| Concern | WordPress site | New Astro site |
|---|---|---|
| GTM container | `GTM-M6N8T8S3` injected by a plugin | Same container, injected inline in `<head>` |
| Form plugin | Contact Form 7 (fires `wpcf7mailsent` event) | Plain HTML form → `mailer.php` → redirect to `/thank-you/` |
| Form-submit signal for GTM | Auto-event from CF7 plugin | **Custom Event = `contact_form_submit`** pushed by site code |
| Consent | Cookiebot / Complianz plugin | vanilla-cookieconsent + Consent Mode v2 (built in) |
| Enhanced Conversions data | Read from CF7 fields by Ads tag | Pre-formatted in dataLayer under `eh.*` |

Everything below assumes you keep using the *same* container.

---

## 1. Verify the container is loading

1. Open https://mixtreelang.nl in Chrome.
2. Install / open the **Tag Assistant** Chrome extension → click "Add domain" → enter the URL.
3. You should see container `GTM-M6N8T8S3` connected, with these things in the dataLayer at page load:
   - `gtm.start`
   - A `consent` event (the default state set by Consent Mode v2)
   - `gtm.js`

If you see *two* GTM containers loading, something on Cloud86 is still injecting a duplicate — let me know.

---

## 2. Consent Mode v2 — what the site already does

The site sets these defaults **before GTM loads**:

```js
gtag('consent', 'default', {
  ad_storage:            'granted',
  ad_user_data:          'granted',
  ad_personalization:    'granted',
  analytics_storage:     'granted',
  functionality_storage: 'granted',
  personalization_storage:'granted',
  security_storage:      'granted',
  wait_for_update: 500
});
```

Then when a user clicks **Accept / Reject / Save preferences** in the cookie banner, the site fires:

```js
gtag('consent', 'update', { analytics_storage: 'granted'|'denied', ad_storage: ... });
window.dataLayer.push({ event: 'cookie_consent_update', categories: {...} });
```

### What you need to do in GTM

For each tag (GA4 + Google Ads + anything else that drops a cookie):

1. Open the tag → **Advanced Settings** → **Consent Settings**.
2. Choose **Require additional consent for tag to fire** and tick:
   - GA4 tags: `analytics_storage`
   - Google Ads / Floodlight tags: `ad_storage`, `ad_user_data`, `ad_personalization`

GTM already enforces this automatically when **Consent Overview** is enabled — turn it on at **Admin → Container Settings → Consent Overview**.

> ⚠️ Reminder: defaults are currently `granted`, which is **not GDPR-compliant in the Netherlands**. To fix later: in [`site/src/components/CookieBanner.astro`](../site/src/components/CookieBanner.astro), change every `'granted'` in the **default** block to `'denied'`. The banner will flip them to granted on Accept.

---

## 3. Form-submit trigger (replaces CF7 listener)

The contact form on the new site fires this dataLayer push on every submit:

```js
window.dataLayer.push({
  event: 'contact_form_submit',
  form_id: 'contact_form_submit',
  eh: {
    email: 'lowercased@example.com',
    phone_number: '+31612345678',
    address: { first_name: 'jane', last_name: 'doe', country: 'NL' }
  },
  form_destination: '/mailer.php'
});
```

### Create the trigger

1. GTM → **Triggers** → **New** → **Trigger Configuration** → **Custom Event**.
2. Event name: `contact_form_submit`
3. Fires on: **All Custom Events**.
4. Save as: **CE — Contact Form Submit**.

(Disable / pause the old CF7 trigger or it will sit idle forever.)

---

## 4. Data Layer Variables for Enhanced Conversions

GTM → **Variables** → **New** → **Data Layer Variable**. Create one for each:

| Variable name | Data Layer Variable Name | Version |
|---|---|---|
| DLV — eh.email | `eh.email` | 2 |
| DLV — eh.phone_number | `eh.phone_number` | 2 |
| DLV — eh.first_name | `eh.address.first_name` | 2 |
| DLV — eh.last_name | `eh.address.last_name` | 2 |
| DLV — eh.country | `eh.address.country` | 2 |

(Version 2 is required for nested keys with dots.)

---

## 5. Google Ads Conversion tag — Enhanced Conversions

1. GTM → **Tags** → either edit your existing **Google Ads Conversion Tracking** tag or create a new one.
2. Fill in your **Conversion ID** and **Conversion Label** from Google Ads.
3. Tick **Include user-provided data from your website**.
4. Choose **Select user-provided data variable** → **New Variable** → **User-Provided Data** → **Code: Manual configuration**, then map:
   - Email → `{{DLV — eh.email}}`
   - Phone Number → `{{DLV — eh.phone_number}}`
   - Address → expand → First Name → `{{DLV — eh.first_name}}`, Last Name → `{{DLV — eh.last_name}}`, Country → `{{DLV — eh.country}}`
5. Save the variable as **UPD — MixTree Form**.
6. Trigger: **CE — Contact Form Submit** (from §3).
7. **Consent Settings** → require `ad_storage`, `ad_user_data`, `ad_personalization`.
8. Save.

> The site sends the data **unhashed**. Google's tag hashes it client-side before sending. You don't need to hash anything yourself.

### Turn on Enhanced Conversions in Google Ads

1. Google Ads → **Tools** → **Conversions** → click the conversion → **Enhanced conversions**.
2. Turn on **Turn on enhanced conversions for leads**.
3. Choose **Google Tag Manager** as the setup method, accept the terms.
4. Within ~24h status should change from "Needs attention" → "Recording".

---

## 6. GA4 form_submit event (optional but recommended)

If you want the same form submit visible in GA4:

1. GTM → **Tags** → **New** → **Google Analytics: GA4 Event**.
2. Configuration tag: your existing GA4 Configuration tag.
3. Event name: `form_submit`
4. Event parameters:
   - `form_id` → `{{Event}}` (or hardcode `contact_form`)
5. Trigger: **CE — Contact Form Submit**.
6. Consent: `analytics_storage`.

---

## 7. Test in Preview mode

1. GTM → top-right **Preview**.
2. Enter `https://mixtreelang.nl` (or your staging URL) → **Connect**.
3. In the Tag Assistant tab:
   - Page load: confirm GA4 Config + Consent default fired.
   - Open the cookie banner via footer → **Manage cookies** → toggle Marketing → Save. Confirm a `cookie_consent_update` event with `consent — update`.
   - Submit the contact form. Confirm:
     - `contact_form_submit` event appears in the timeline.
     - **Tags Fired**: Google Ads Conversion + (optional) GA4 form_submit.
     - Click the Ads tag → **User-provided data** section shows email/phone/name populated (✅ green checkmarks).

If User-Provided Data shows empty / red, the Data Layer Variables are pointing at the wrong path — double-check the dots/case.

---

## 8. Publish

GTM → **Submit** → version name *"Astro migration + EC v2"* → **Publish**.

---

## 9. Future form pages

For any new form (level check, newsletter, etc.) just add to the `<form>` tag:

```html
<form
  action="/mailer.php"
  method="post"
  data-mtl-form
  data-mtl-conversion="level_check_submit">  <!-- pick a unique event name -->
  …
  <input name="first-name">  <!-- or first_name -->
  <input name="last-name">
  <input name="email" type="email">
  <input name="phone" type="tel">
</form>
```

The shared helper at [`site/src/components/EnhancedConversions.astro`](../site/src/components/EnhancedConversions.astro) will pick it up and fire `level_check_submit` (or whatever you name it). Then add a matching Custom Event trigger in GTM.

---

## 10. Quick sanity-check checklist

- [ ] Tag Assistant shows container `GTM-M6N8T8S3` loading once.
- [ ] Consent Overview enabled in container settings.
- [ ] All Ads/GA tags have **Consent Settings** filled in.
- [ ] Custom Event trigger `contact_form_submit` exists.
- [ ] 5 Data Layer Variables created (`eh.*`).
- [ ] Google Ads Conversion tag uses UPD variable + new trigger.
- [ ] Enhanced Conversions enabled in Google Ads UI.
- [ ] Old CF7 trigger paused / deleted.
- [ ] Container published.
