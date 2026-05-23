# Vercel Deployment — Sweet Crumbs

## Build separation (required)

| Phase | Environment | Command |
|-------|-------------|---------|
| Frontend assets | Node | `npx vite build` (via `vercel.json` `buildCommand`) |
| PHP / Composer | vercel-php runtime | `composer run vercel` (npm + vite only, no artisan) |

**Do not** add `php artisan` to `package.json` `build` or `vercel-build` scripts.

## If deploy still fails with `php: command not found`

1. **Vercel Dashboard** → Project → Settings → Build & Development  
   - **Framework Preset:** Other (`null`)  
   - **Build Command:** leave empty (use `vercel.json`) or set exactly: `npx vite build`  
   - **Install Command:** leave empty or `npm ci`  
   - **Do not** use: `vite build && php artisan ...`

2. **Redeploy without cache**  
   Deployments → ⋮ → Redeploy → uncheck “Use existing Build Cache”

3. Confirm `package.json` on GitHub `main` has only:
   ```json
   "build": "vite build"
   ```
