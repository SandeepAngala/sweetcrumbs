# Vercel Deployment — Sweet Crumbs

## Critical: do not use `outputDirectory: "public"`

That setting deploys `public/` as a **static site**, so browsers **download** `index.php` instead of running PHP. Laravel must run through `api/index.php` + `vercel-php@0.7.4`.

## Build separation (required)

| Phase | Environment | Command |
|-------|-------------|---------|
| Frontend assets | Node | `npx vite build` (via `vercel.json` `buildCommand`) |
| PHP / Composer | `vercel-php@0.7.4` (Node 22) | `composer run vercel` (npm + vite only, no artisan) |

**Do not** add `php artisan` to `package.json` `build` or `vercel-build` scripts.

## If deploy still fails with `php: command not found`

Vercel is running a **dashboard override** or cached `package.json` that chains `php artisan` after Vite.

1. **Vercel Dashboard** → Settings → Build & Development  
   - **Framework Preset:** Other  
   - **Build Command:** `node scripts/vercel-vite.mjs` (or leave **empty** to use `vercel.json`)  
   - **Install Command:** `npm ci` (or empty)  
   - **Delete** any command containing `php artisan`

2. **Redeploy without cache** (required)  
   Deployments → ⋮ → Redeploy → **uncheck** “Use existing Build Cache”

3. Repo build scripts (must match):
   ```json
   "build": "node scripts/vercel-vite.mjs",
   "vercel-build": "node scripts/vercel-vite.mjs"
   ```

4. `public/build` is committed so assets exist even if the Node build step is skipped.
