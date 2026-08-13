---
feature: portfolio-audit
status: delivered
updated: 2026-08-13
branch: fix/p0-audit-fixes
commits: 4c2f960..HEAD
---

# Portfolio All-Round Audit

## Report

**What was built** — A comprehensive audit of the "Luminescent Architect" Laravel portfolio site across four domains: Performance, SEO, Accessibility, and Best Practices. The audit examined all 4 public pages, the master layout, 9 JavaScript modules, CSS assets, build output, robots.txt, and the admin-to-public SEO pipeline. Findings were validated by a reviewer subagent against actual source code (14/16 original findings confirmed, 2 denied as factually incorrect, 6 additional issues identified). Subsequently, all 4 P0 critical findings were fixed: Three.js/HLS.js now dynamically import (saving ~1 MB on non-home pages), the existing SeoSetting model is now wired into the public `<head>` with full OG/Twitter Card/canonical support, and a sitemap.xml route was added.

**Verification** — All findings verified by reading actual source files. Reviewer confirmed 87.5% accuracy of original findings. F-10 (Google Fonts `display=swap`) was denied — the URL already includes `&display=swap`. F-12 (Vite scripts blocking) was denied — `<script type="module">` is inherently deferred. F-06 was corrected from ~4 to 3 concurrent rAF loops. Six new findings added from reviewer analysis. P0 fixes: Vite build confirmed `isDynamicEntry: true` for hero-3d and video-background; all SEO tags verified in blade template; sitemap route registered and returns valid XML.

**Journey log**:
1. Initial exploration subagent mapped the full audit surface: 4 public routes, 9 JS modules, 2 CSS files, ~1.21 MB total payload
2. The SeoSetting model disconnect was the most surprising finding — a complete admin SEO UI exists but zero data reaches the public `<head>`
3. F-10 and F-12 were false positives caught by reviewer — always verify "missing" claims against actual file content before reporting
4. The `comet-animation.js` file (273 lines) is dead code — initialized but container immediately removed on DOMContentLoaded
5. Color contrast failures are worse than initially measured — `text-white/20` on black yields ~1.2:1 ratio, practically invisible

## [S1] Problem

The Laravel portfolio site ("Luminescent Architect") has never been audited for performance, SEO, accessibility, or best practices. The admin panel includes a full SEO Settings UI, but the data is never rendered in public views. Heavy JS bundles (Three.js + HLS.js = ~1 MB) load on every page despite only being used on the homepage. Systematic accessibility gaps (missing ARIA, poor contrast, unlabeled forms) and absent security headers degrade quality and discoverability.

## [S2] Design

### Audit Scope

Four domains, each scored P0–P3:

| Domain | Focus |
|--------|-------|
| **Performance** | Bundle size, lazy loading, CLS, font loading, animation loops |
| **SEO** | Meta tags, OG, Twitter Cards, sitemap, structured data, SeoSetting integration |
| **Accessibility** | ARIA, alt text, form labels, contrast, semantic HTML, focus management, reduced-motion |
| **Best Practices** | Security headers, external link safety, console noise, HTTPS, PWA |

### Findings Summary

#### P0 — Critical (4)

| ID | Category | Finding | Evidence |
|----|----------|---------|----------|
| F-01 | Performance | Three.js (506 KB) + HLS.js (497 KB) loaded on ALL pages, only used on home | `resources/js/app.js` lines 2, 6: static imports of `./video-background` and `./hero-3d`; `hero-3d.js` line 6: `import * as THREE from 'three'`; `vite.config.ts` lines 21–27: manual chunks |
| F-02 | SEO | SeoSetting model exists with `meta_title`, `meta_description`, `og_image`, `canonical_url`, `no_index` — but never queried or rendered in `<head>` | `app/Models/SeoSetting.php` has `getMetaTagsAttribute()` (line 42), `getByPage()` (line 28); `ProjectController` has no `use App\Models\SeoSetting` import; zero SEO data passed to any public view |
| F-03 | SEO | No OG tags, Twitter Cards, canonical URLs, or structured data (JSON-LD) on any page | `resources/views/app.blade.php` lines 4–29 — `<head>` contains only charset, viewport, description, theme-color, title, CSS vars, fonts, favicons, `@vite()`; no `@stack('meta')` for per-page injection |
| F-04 | SEO | No `sitemap.xml` | `public/` has no sitemap file; `public/robots.txt` has no `Sitemap:` directive |

#### P1 — High (7)

| ID | Category | Finding | Evidence |
|----|----------|---------|----------|
| F-05 | SEO | Meta descriptions are generic (same for all pages), not page-specific | `app.blade.php` line 7: `<meta name="description" content="{{ $siteSettings['site_tagline'] ?? '...' }}">`; no page view overrides this; no `@yield('meta-description')` exists |
| F-06 | Performance | 3 concurrent `requestAnimationFrame` loops on projects page (ambient + projects-bg + cursor) | `ambient-background.js` line 280 (rAF loop, active on projects via line 309); `projects-background.js` line 347 (rAF loop); `immersive-interactions.js` CustomCursor line 116 (rAF loop, all pages). Note: ScrollReveal uses IntersectionObserver, not rAF |
| F-07 | Accessibility | Contact form labels not programmatically associated with inputs — no `for`/`id` linkage | `contact.blade.php` lines 120, 130, 141, 151: `<label>` has no `for`; lines 121–157: `<input>`/`<textarea>` have no `id` (only `name`) |
| F-08 | Accessibility | Systematic color contrast failures — 26 instances of `text-white/20`, `text-white/25`, `text-white/30` on `bg-black` | Ratios: white/20 ≈ 1.2:1, white/25 ≈ 1.5:1, white/30 ≈ 1.8:1 (WCAG AA requires 4.5:1). Found in `app.blade.php` (lines 199, 202), `home.blade.php` (92), `about.blade.php` (45, 49, 118, 136, 154, 178, 357, 508, 548), `projects.blade.php` (17), `contact.blade.php` (31, 49, 67, 115, 120, 126, 130, 136, 141, 147, 151, 157), `maintenance.blade.php` (78) |
| F-09 | Performance | No `width`/`height` on `<img>` tags → CLS | All `<img>` in `home.blade.php` (lines 212–217, 281), `about.blade.php` (63–68, 330, 387–390), `projects.blade.php` (43–48) — no HTML width/height. Container aspect ratios partially mitigate but don't eliminate CLS |
| F-17 | Accessibility | No `prefers-reduced-motion` support — all animations run at full intensity regardless of user preference | `grep` for `prefers-reduced-motion` across all resources: zero matches. Affects Three.js scene, ambient background, cursor, scroll reveals, parallax, tilt effects. WCAG 2.1 SC 2.3.3 violation |
| F-18 | Accessibility | Mobile menu toggle has no `aria-label`, `aria-expanded`, or `aria-controls` | `app.blade.php` line 86: `<button id="mobile-toggle" ...>` — screen readers announce as just "button" with no description or state |

#### P2 — Medium (5)

| ID | Category | Finding | Evidence |
|----|----------|---------|----------|
| F-11 | Best Practices | No security headers (CSP, X-Frame-Options, X-Content-Type-Options, Referrer-Policy, Permissions-Policy) | grep for these headers in `app/Http/`: no matches; no middleware or `.htaccess` config |
| F-13 | Best Practices | External `target="_blank"` links missing `rel="noopener noreferrer"` | `app.blade.php` lines 145, 150, 155: GitHub, Twitter, LinkedIn links — no `rel` attribute. Note: modern browsers implicitly set `noopener`, but `noreferrer` still relevant |
| F-19 | Accessibility | Decorative background video not hidden from screen readers | `app.blade.php` lines 45–54: `<video>` has no `aria-hidden="true"` or `role="presentation"` |
| F-20 | SEO | Maintenance page lacks `<meta name="robots" content="noindex">` | `resources/views/errors/maintenance.blade.php` — no robots meta tag; search engines could index maintenance page |
| F-21 | Best Practices | Missing `<meta name="csrf-token">` in `<head>` | `app.blade.php` has no CSRF meta tag; contact form handles CSRF inline via `{{ csrf_token() }}` in JS (non-standard) |

#### P3 — Low (4)

| ID | Category | Finding | Evidence |
|----|----------|---------|----------|
| F-14 | Best Practices | Maintenance page loads full Tailwind (~300 KB) from CDN client-side | `resources/views/errors/maintenance.blade.php` line 7: `<script src="https://unpkg.com/@tailwindcss/browser@4">` |
| F-15 | Best Practices | No web manifest (PWA) | No `manifest.json` in `public/`; no `<link rel="manifest">` |
| F-16 | Performance | No `srcset`/`<picture>` for responsive images | grep for `srcset` or `<picture` in blade templates: zero matches |
| F-22 | Performance | Three.js imports entire library via `import * as THREE` instead of selective imports | `hero-3d.js` line 6: `import * as THREE from 'three'` — could use `import { Scene, PerspectiveCamera, WebGLRenderer, ... } from 'three'` |

### Additional Observations

- **Console noise in production**: `app.js` line 10: `console.log('%c Luminescent Architect — System Online', ...)`; `video-background.js` has 8+ `console.log`/`console.warn` calls
- **SVG icons lack `aria-hidden="true"`**: All decorative SVGs in `app.blade.php` (lines 65–67, 87–91, 133–135, 146, 151, 156, 186–188) lack `aria-hidden`
- **Active nav links lack `aria-current="page"`**: `app.blade.php` line 77 — active state uses CSS class `active` only
- **`cursor: none` on body**: `resources/css/app.css` line 180 — impairs keyboard-only navigation visibility
- **`comet-animation.js` dead code**: 273 lines, class never instantiated — `container.remove()` runs on DOMContentLoaded (lines 266–271)

### Recommendation Priority Order

1. **F-01** — Dynamic import Three.js/HLS.js (biggest perf win, ~1 MB saved on non-home pages)
2. **F-02 + F-03** — Wire SeoSetting into `<head>` via `@stack('meta')` in layout + `@push('meta')` in pages (existing model, just needs rendering)
3. **F-04** — Generate sitemap.xml (artisan command or route)
4. **F-07** — Add `for`/`id` to contact form labels (small, high-impact a11y fix)
5. **F-17** — Add `prefers-reduced-motion` media query to disable/reduce animations
6. **F-08** — Bump low-opacity text to at least `white/50` for WCAG AA
7. **F-09** — Add `width`/`height` to images for CLS
8. **F-18** — Add `aria-label`, `aria-expanded`, `aria-controls` to mobile menu toggle
9. **F-11** — Add security headers via middleware
10. **F-13** — Add `rel="noopener noreferrer"` to external links
11. **F-19, F-20, F-21, F-05, F-06, F-14, F-15, F-16, F-22** — Secondary improvements

## [S3] Out of Scope

- Visual redesign or layout changes
- Backend logic changes (controllers, models, migrations)
- New features or pages
- Admin panel improvements
- Database schema changes
- Third-party service integrations

## Tasks — Audit

- [x] T1: Audit report compilation — acceptance: complete spec document with all findings, evidence, and recommendations (covers: S2)
- [x] T2: Review and validate findings — acceptance: reviewer confirms findings are accurate and evidence-backed; 14/16 confirmed, 2 denied, 6 added (covers: S2; depends: T1)
- [x] T3: Finalize spec document — acceptance: spec delivered with status=delivered, report section filled (covers: S2; depends: T2)

## Tasks — P0 Fixes

- [x] T4: Dynamic import Three.js/HLS.js — acceptance: `three` and `hls.js` chunks only load on pages that use them; `npm run build` succeeds (covers: F-01)
- [x] T5: Wire SeoSetting into public `<head>` — acceptance: OG tags, Twitter Cards, canonical URL, per-page meta description render in HTML source; existing SeoSetting admin values appear on corresponding pages (covers: F-02, F-03)
- [x] T6: Generate sitemap.xml — acceptance: `/sitemap.xml` returns valid XML with all 4 public pages; `robots.txt` includes `Sitemap:` directive (covers: F-04)
