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

# Going to production on Cloud86

Decap needs an OAuth proxy in front of GitHub. The easiest open-source option is
`vencax/netlify-cms-github-oauth-provider`, which is a tiny Node app you can run
under cloud86 (or any small VPS).

1. Create a GitHub OAuth App
   - Settings → Developer settings → OAuth apps → New
   - Homepage URL: <https://mixtreelang.nl>
   - Authorization callback URL: `https://oauth.mixtreelang.nl/callback`
2. Deploy the OAuth proxy with the client ID + secret as env vars.
3. Edit `public/admin/config.yml`:
   ```yaml
   backend:
     name: github
     repo: <owner>/<repo>
     branch: main
     base_url: https://oauth.mixtreelang.nl
   ```
4. Visit `https://mixtreelang.nl/admin/` → click "Login with GitHub" → done.
