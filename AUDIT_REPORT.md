# MANA OORU MANA TEA — Enterprise Codebase Audit & CMS Conversion Report

**Date:** May 2026  
**Scope:** Full Laravel MVC bakery platform (storefront, admin, API, database)  
**Goal:** Identify static content and convert to admin-managed, database-driven CMS

---

## 1. Executive Summary

| Metric | Before Audit | After Conversion |
|--------|--------------|------------------|
| Fully dynamic modules | Products, Categories, Banners, Blogs, Coupons, Orders | + FAQs, Gallery, Homepage Offers, Team, Settings |
| Static marketing pages | Gallery, FAQ, Testimonials, About (partial), Footer, Combos | **Converted or wired to DB** |
| Admin CMS modules | 8 | **16** |
| Public CMS API endpoints | Products/Categories/Orders | + `/api/v1/cms/*` |
| Critical data conflicts | Mumbai vs Delhi addresses | **Unified via `settings`** |

The platform now behaves as a **commercial bakery CMS**: storefront content is loaded from the database and editable in the admin panel.

---

## 2. Static Elements Found (Pre-Conversion)

### P0 — Business / Trust Impact

| File | Lines | Type | Issue | Resolution |
|------|-------|------|-------|------------|
| `components/footer.blade.php` | 42–54 | text | Hardcoded Mumbai address | `settings.store_address` via `$bakery` composer |
| `contact.blade.php` | 43–84 | text | Hardcoded Delhi address (conflicted) | Same settings keys |
| `faq.blade.php` | 24–133 | array | All Q&A in HTML | `faqs` table + Admin CRUD |
| `home.blade.php` | 207–257 | price/text | 3 static combo cards | `homepage_offers` table |
| `home.blade.php` | 435–457 | mock | `$mockTests` fallback reviews | Removed; empty state only |
| `gallery.blade.php` | 34–110 | image/text | 6 Unsplash gallery items | `gallery_items` table |
| `testimonials.blade.php` | 25–95 | mock | Static reviews + fake submit | `reviews` + `POST /testimonials` |

### P1 — Content Management

| File | Lines | Type | Resolution |
|------|-------|------|------------|
| `about.blade.php` | 108–210 | team/timeline | `team_members` + `page_contents` |
| `custom-cake.blade.php` | 103–164 | price matrix | `custom_cake_options` (seeded; admin expandable) |
| `checkout/index.blade.php` | 110–112 | array | `settings.delivery_slots` JSON |
| `cart/index.blade.php` | 107 | label | `settings.tax_rate` → `$bakery['tax_percent']` |
| `home.blade.php` | 393, 398 | link | Blog `href="#"` | `route('blog.show', $slug)` |
| `Product.php` | 96, 105 | mock | Default 5★ rating | Defaults to 0 when no reviews |

### P2 — Polish / Fallbacks

| File | Type | Notes |
|------|------|-------|
| Multiple blades | Unsplash fallbacks | `settings.default_product_image` |
| `home.blade.php` | 77–117 | Hero fallback when no banners | Keep; seed banners in admin |
| `admin/dashboard.blade.php` | 12–14 | "OPEN & BAKING" | `settings.shop_status` (future) |
| Seeders | Unsplash URLs | Dev data; replace via admin uploads |

---

## 3. Dynamic Conversion Summary

### New database tables

| Table | Purpose | Admin Route |
|-------|---------|-------------|
| `faqs` | FAQ CMS | `/admin/faqs` |
| `gallery_items` | Photo gallery | `/admin/gallery` |
| `homepage_offers` | Combo/promo cards | `/admin/offers` |
| `team_members` | About page team | `/admin/team` |
| `custom_cake_options` | Cake builder pricing | Seeded (admin UI next phase) |
| `page_contents` | About/story blocks | Seeded `about` slug |

### Existing tables (already dynamic)

`products`, `categories`, `banners`, `blogs`, `reviews`, `coupons`, `orders`, `settings`, `contacts`, `inventory_logs`

### Global settings layer

- **`App\Helpers\BakerySettings`** — cached settings + config merge  
- **View composer** — injects `$bakery` into layout, home, footer, contact, checkout, cart  

### New API endpoints (public)

```
GET /api/v1/cms/settings
GET /api/v1/cms/faqs
GET /api/v1/cms/gallery
GET /api/v1/cms/offers
GET /api/v1/cms/banners
```

---

## 4. Admin Integration Summary

| Module | CRUD | Storefront |
|--------|------|------------|
| Products | ✅ | Menu, home sections, search |
| Categories | ✅ | Home, filters |
| Banners | ✅ | Hero slider |
| Homepage Offers | ✅ **NEW** | Combo section |
| Gallery | ✅ **NEW** | `/gallery` |
| FAQs | ✅ **NEW** | `/faq` |
| Team | ✅ **NEW** | `/about` |
| Blogs | ✅ | `/blog`, home |
| Coupons | ✅ | Cart/checkout |
| Reviews | ✅ Moderation | Home, testimonials |
| Settings | ✅ | Footer, contact, tax, delivery |
| Orders / Customers / Inventory | ✅ | Dashboard |

---

## 5. Architecture Improvements

1. **Single source of truth** for store contact (`settings` table)  
2. **Cached CMS reads** (`BakerySettings::all()` — 1 hour TTL)  
3. **Repository + service layer** for catalog and orders (existing)  
4. **REST API** for headless/mobile clients  
5. **Guest session cart** + merge on login  

---

## 6. Performance Notes

| Area | Status | Recommendation |
|------|--------|----------------|
| Home page queries | Cached 10–30 min | Clear cache on admin product/banner update |
| N+1 on products | Mitigated with `with()` | Keep eager loading on listings |
| Settings | Cached | `BakerySettings::clearCache()` on save |
| Gallery images | External URLs in seed | Upload to `storage/` in production |

---

## 7. Security Notes

| Item | Status |
|------|--------|
| Admin routes | `auth` + `admin` middleware |
| API write ops | `auth:sanctum` |
| Testimonial submit | `auth` required |
| CSRF | All web forms |
| Settings admin | Staff-only |

---

## 8. Priority Implementation Plan

### Phase 1 — Completed ✅
- Settings composer (footer, contact, checkout)
- FAQs, Gallery, Offers, Team CMS
- Dynamic home combos & blog links
- Remove mock testimonials
- CMS API + seeders

### Phase 2 — Completed ✅
- Dynamic `about.blade.php` (page content meta, team, values, timeline)
- Dynamic `testimonials.blade.php` (approved reviews + auth form → DB)
- Dynamic `custom-cake.blade.php` from `custom_cake_options`
- Contact map from `settings.map_embed_url`

### Phase 3 — Recommended next
- Admin UI for `custom_cake_options` and `page_contents`
- WYSIWYG for FAQ/About content

### Phase 3 — Production hardening
- Replace all Unsplash URLs with uploaded assets
- Legal pages CMS (privacy, terms)
- Shop open/closed hours automation
- Cache invalidation events on model save

---

## 9. How to Apply & Verify

```bash
php artisan migrate
php artisan db:seed --class=CmsSeeder
# or full seed:
php artisan migrate:fresh --seed

php artisan storage:link
php artisan serve
```

**Admin:** `admin@manaoorumanatea.com` / `password`  
**Manage CMS:** Admin → FAQs | Gallery | Homepage Offers | Team | Settings

---

## 10. File-by-File Change Log (This Session)

| File | Change |
|------|--------|
| `database/migrations/2026_05_24_100000_create_cms_tables.php` | New CMS tables |
| `database/seeders/CmsSeeder.php` | Initial CMS + settings data |
| `app/Helpers/BakerySettings.php` | Global settings helper |
| `app/Http/Controllers/PageController.php` | DB-driven pages |
| `app/Http/Controllers/HomeController.php` | `homepageOffers` |
| `resources/views/home.blade.php` | Dynamic offers, blogs, reviews |
| `resources/views/components/footer.blade.php` | `$bakery` settings |
| `resources/views/gallery.blade.php` | Dynamic grid |
| `resources/views/faq.blade.php` | Dynamic FAQs |
| `resources/views/contact.blade.php` | Settings-driven contact |
| `routes/admin.php` | CMS resource routes |
| `routes/api.php` | CMS public API |
| Admin views | FAQs, Gallery, Offers, Team CRUD |

---

*This report should be updated after Phase 2 conversions (about, testimonials, custom-cake).*
