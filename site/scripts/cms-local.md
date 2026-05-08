# Running Decap CMS locally (no GitHub auth needed)

For quick edits without setting up an OAuth proxy, run the bundled local backend:

```pwsh
# from /site
npm install --no-save decap-server
npx decap-server
```

Then in another terminal:

```pwsh
npm run dev
```

Open <http://localhost:4321/admin/>. The local backend reads/writes files in
`src/content/` directly — no auth, no commits.

To switch the admin into local mode, temporarily add to
`public/admin/config.yml`:

```yaml
local_backend: true
```

Remove (or set `false`) before deploying.

# Going to production — GitHub OAuth proxy

Decap CMS is a static SPA — to commit changes back to GitHub it needs a tiny
**OAuth proxy** that holds the GitHub OAuth App's client secret and exchanges
the code GitHub returns for an access token. Decap then talks to GitHub
directly from the browser using that token.

You only need to do this **once**. After that, anyone you add as a collaborator
on the GitHub repo can edit the site at `/admin/`.

## Step 1 — Create a GitHub OAuth App

1. Go to GitHub → your profile → **Settings → Developer settings → OAuth Apps → New OAuth App**
2. Fill in:
   - **Application name**: `MixTree CMS`
   - **Homepage URL**: `https://mixtreelang.nl`
   - **Authorization callback URL**: `https://oauth.mixtreelang.nl/callback`
     (or whatever subdomain you'll host the proxy on — see Step 2)
3. Click **Register application**
4. Copy the **Client ID**.
5. Click **Generate a new client secret**, copy that too. (You'll only see the secret once.)

## Step 2 — Deploy the OAuth proxy

Pick one of these. **Render is the easiest free option**; Cloud86 is the
"all in one place" option if you'd rather not add another provider.

### Option A — Render (free, ~5 min)

1. Fork <https://github.com/vencax/netlify-cms-github-oauth-provider> to your GitHub account.
2. Go to <https://render.com> → New → **Web Service** → connect the fork.
3. Settings:
   - Build command: `npm install`
   - Start command: `npm start`
   - Instance type: **Free**
4. Add **Environment Variables**:
   - `OAUTH_CLIENT_ID` = (from Step 1)
   - `OAUTH_CLIENT_SECRET` = (from Step 1)
   - `REDIRECT_URL` = `https://<your-render-subdomain>.onrender.com/callback`
   - `ORIGIN` = `https://mixtreelang.nl`
5. Deploy. Render gives you a URL like `https://mixtree-cms-oauth.onrender.com`.
6. Go back to your GitHub OAuth App and update the **Authorization callback URL** to match `https://<your-render-subdomain>.onrender.com/callback`.

> ⚠️ Render's free tier sleeps after 15 min of inactivity. The first login of the day will be slow (~30 s). Fine for an editor tool.

### Option B — Cloud86 Node service

If Cloud86's plan supports a Node app (not just static):

1. Clone <https://github.com/vencax/netlify-cms-github-oauth-provider> into a Cloud86 Node app.
2. Set environment variables (same names as Option A, with `REDIRECT_URL` pointing at your Cloud86 subdomain, e.g. `https://oauth.mixtreelang.nl/callback`).
3. Run `npm install && npm start` (or set as the start command).
4. Point a subdomain (e.g. `oauth.mixtreelang.nl`) at it via Cloud86 DNS.
5. Update the GitHub OAuth App callback URL to match.

### Option C — Fly.io / Railway / Vercel

Same proxy app, similar steps. Each platform has a free tier suitable for
a tiny OAuth proxy used by 1–3 editors.

## Step 3 — Wire Decap to the proxy

Edit [public/admin/config.yml](../public/admin/config.yml):

```yaml
backend:
  name: github
  repo: alexgoekjian-sudo/mixtreelang_website
  branch: main
  base_url: https://<your-proxy-domain>      # no trailing slash
  auth_endpoint: /auth                        # default; only set if your proxy differs
```

Commit + push. After Cloud86 redeploys, visit
<https://mixtreelang.nl/admin/> → "Login with GitHub" → authorise → you're in.

## Step 4 — Add editors

In GitHub repo → **Settings → Collaborators** → add their GitHub username.
They'll log in to `/admin/` with their own GitHub account.

> Drafts created in the CMS appear as **pull requests** in GitHub (because of
> `publish_mode: editorial_workflow`). Merging the PR triggers Cloud86 to
> redeploy. You can also reject/delete drafts there.
