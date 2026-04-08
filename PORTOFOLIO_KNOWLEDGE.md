# 📚 Portofolio-Main — Project Knowledge Base

> **Last Updated:** 2026-04-04  
> **Framework:** Laravel 13 + Blade + Tailwind CSS v4  
> **Database:** MySQL (`portofolio_main`)  
> **App URL:** http://portofolio-main.test (Laragon)

---

## 🏗️ Architecture Overview

Portfolio website yang diubah menjadi dynamic CMS dengan Admin Dashboard.

### File Structure

```
app/Http/Controllers/
├── ProjectController.php          # Public routes (home, projects, about, contact)
└── Admin/
    ├── DashboardController.php    # Admin overview
    ├── ProjectAdminController.php # CRUD + toggleFeatured
    └── ProfileAdminController.php # Profile/bio/photo settings

app/Http/Middleware/
└── RedirectGuestToHome.php        # Redirect guests to homepage (not login)

app/Models/
├── Project.php          # Has: slug (auto), image_url, tech_stack (JSON), is_featured
└── ProfileSetting.php   # Key-value store: get(key), set(key, val), allAsArray()

resources/views/
├── app.blade.php            # Public layout
├── home.blade.php           # Uses: $projects (featured), $profile
├── projects.blade.php       # Uses: $projects (all)
├── about.blade.php          # Uses: $profile
├── contact.blade.php        # Uses: $profile
└── admin/
    ├── layout.blade.php     # Dark sidebar admin layout
    ├── dashboard.blade.php
    ├── auth/login.blade.php # Custom login page (glassmorphism)
    ├── projects/index.blade.php
    ├── projects/create.blade.php
    ├── projects/edit.blade.php
    └── profile/edit.blade.php
```

---

## 🔑 Authentication

- **Login URL:** `/akses-rahasia-admin` (hidden, route name: `login`)
- **Register:** DISABLED (`/register` returns 403)
- **After login:** Redirects to `/admin`
- **Unauthenticated admin access:** Redirects to `/` (homepage)

### Default Admin (seeded)
```
Email:    admin@portofolio.dev
Password: admin123456
```
Change with: `php artisan tinker` → `User::first()->update(['password' => bcrypt('newpass')])`

---

## 🗄️ Database Schema

### `projects` table
| Column | Type | Notes |
|--------|------|-------|
| title | string | |
| slug | string unique | auto from title |
| category | string | |
| description | text | |
| image_url | string null | storage or external |
| tech_stack | json null | array |
| tags | json null | array |
| year | string | "2024" |
| link_repo | string null | |
| link_demo | string null | |
| is_featured | boolean | homepage display |

### `profile_settings` table (key-value)
Keys: `name`, `tagline`, `bio`, `location`, `email`, `photo_url`,
`years_exp`, `projects_count`, `github_url`, `linkedin_url`, `twitter_url`,
`hero_badge`, `hero_line1`, `hero_line2`, `hero_desc`

---

## 🎨 Design System

- **Aesthetic:** "Luminescent Architect" — dark glassmorphism
- **Primary:** `#00f2ff` (cyan), **Secondary:** `#7c3aed` (purple), **Accent:** `#ff6b6b`
- **Font:** Instrument Sans (Bunny Fonts), CSS via Tailwind v4
- **Custom classes:** `.glass`, `.text-gradient-blue`, `.animate-fade-in`, `.animate-slide-up`

---

## 🛣️ Route Summary

| Route | Name | Auth |
|-------|------|------|
| GET `/` | home | No |
| GET `/projects` | projects | No |
| GET `/about` | about | No |
| GET `/contact` | contact | No |
| GET/POST `/akses-rahasia-admin` | login / admin.login.post | guest |
| GET `/admin` | admin.dashboard | ✅ |
| CRUD `/admin/projects` | admin.projects.* | ✅ |
| GET/POST `/admin/profile` | admin.profile.* | ✅ |

---

## 📦 Storage

- Disk: `public`, Symlink: `public/storage` → `storage/app/public`
- Project images: `storage/app/public/projects/`
- Profile photo: `storage/app/public/profile/`

---

## 🛠️ Commands

```bash
php artisan migrate:fresh --seed    # Reset DB + seed
php artisan storage:link            # Create symlink
php artisan config:clear            # Clear caches
php artisan route:list              # See all routes
php artisan tinker                  # REPL
```

---

## ⚙️ Config Changes

`config/fortify.php`:
- `home` → `/admin` (redirect after login)
- All features disabled (registration, 2FA, reset password)

`.env`:
- `DB_CONNECTION=mysql`, `DB_DATABASE=portofolio_main`
- `FILESYSTEM_DISK=public`
- `APP_URL=http://portofolio-main.test`

---

## 🐛 Known Issues

1. `image` vs `image_url`: DB column is `image_url`. Accessor `getImageAttribute()` handles bridge.
2. Fortify still registers `/login` route — workaround redirect in `web.php`.
3. `inertiajs/inertia-laravel` still in `composer.json` (unused, safe to ignore).
4. ProjectSeeder uses Unsplash URLs (not lh3.googleusercontent.com).

---

## 📋 TODO

- [ ] Individual project detail page `/projects/{slug}`
- [ ] Contact form with DB storage or email
- [ ] Skills / expertise CRUD section
- [ ] OG meta tags from profile settings
- [ ] Admin password change form
