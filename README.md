# 🌟 Luminescent Architect — Laravel Portfolio CMS

> **Sebuah sistem manajemen portofolio berbasis Laravel yang elegan, berfitur lengkap, dan didesain untuk developer profesional.**

[![Laravel](https://img.shields.io/badge/Laravel-v13.3-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3+-777BB4?logo=php&logoColor=white)](https://www.php.net)
[![Vite](https://img.shields.io/badge/Vite-Frontend-646CFF?logo=vite&logoColor=white)](https://vitejs.dev)
[![Three.js](https://img.shields.io/badge/Three.js-3D_Effects-000000?logo=threedotjs&logoColor=white)](https://threejs.org)
[![TailwindCSS](https://img.shields.io/badge/TailwindCSS-v4-06B6D4?logo=tailwindcss&logoColor=white)](https://tailwindcss.com)

---

## 📋 Daftar Isi

- [Fitur Utama](#-fitur-utama)
- [Tech Stack](#-tech-stack)
- [Persyaratan Sistem](#-persyaratan-sistem)
- [Instalasi & Setup](#-instalasi--setup)
- [CLIENT SIDE — Panduan Pengguna](#-client-side--panduan-pengguna)
- [ADMIN SIDE — Panduan Admin](#-admin-side--panduan-admin)
- [Arsitektur Caching](#-arsitektur-caching)
- [Struktur Database](#-struktur-database)
- [Struktur Proyek](#-struktur-proyek)
- [Perintah Artisan Penting](#-perintah-artisan-penting)
- [Troubleshooting](#-troubleshooting)

---

## ✨ Fitur Utama

### 🖥️ Sisi Client (Publik)
| Fitur | Deskripsi |
|-------|-----------|
| **3D Background** | Efek partikel interaktif berbasis Three.js |
| **Halaman Home** | Hero section, featured projects, dan testimonial |
| **Halaman Projects** | Daftar proyek dengan paginasi |
| **Halaman About** | Profil, skill tree (progress bar), career timeline |
| **Halaman Contact** | Form kontak yang langsung tersimpan ke inbox admin |
| **Desain Responsif** | Mobile-first, kompatibel semua ukuran layar |
| **SEO Friendly** | Meta tags, Open Graph, canonical URL terkelola |

### 🛠️ Sisi Admin (Panel)
| Fitur | Deskripsi |
|-------|-----------|
| **Dashboard Komprehensif** | Statistik lengkap, aktivitas terbaru, quick actions |
| **Manajemen Proyek** | CRUD proyek dengan toggle featured, upload gambar |
| **Manajemen Pesan** | Inbox kontak, tandai baca/belum, simpan balasan |
| **Manajemen Testimonial** | CRUD, sistem persetujuan, bintang rating 1-5 |
| **Manajemen Skill** | Kategori skill, proficiency 0-100, toggle aktif |
| **Manajemen Pengalaman** | Timeline karier, pendidikan, sertifikasi |
| **SEO Manager** | Konfigurasi meta tag per halaman |
| **Pengaturan Situs** | Mode maintenance, branding, integrasi Analytics |
| **Profil Identitas** | Data diri, kontak, media sosial |

---

## 🔧 Tech Stack

### Backend
- **PHP** `^8.3` — Bahasa utama
- **Laravel** `^13.0` — Framework MVC
- **Laravel Fortify** `^1.34` — Autentikasi (tanpa UI bawaan)
- **Eloquent ORM** — Database abstraction layer
- **File Cache Driver** — Caching berbasis JSON

### Frontend
- **Vite** `^8.0` — Bundler modern & dev server
- **TailwindCSS** `^4.0` — Utility-first styling
- **Three.js** `^0.183` — Grafis 3D interaktif
- **Blade Templates** — Templating engine Laravel

### Database
- **SQLite / MySQL** — Dual support

---

## 💻 Persyaratan Sistem

| Komponen | Minimum |
|----------|---------|
| PHP | `8.3` atau lebih tinggi |
| Composer | `2.x` |
| Node.js | `18.x` atau lebih tinggi |
| npm | `9.x` atau lebih tinggi |
| Database | MySQL `8.0+` atau SQLite `3.x` |
| Web Server | Laragon / XAMPP / Apache / Nginx |

> **Catatan:** Proyek ini diuji dan dikembangkan di lingkungan **Laragon** (Windows). Sangat disarankan menggunakannya untuk pengembangan lokal.

---

## 🚀 Instalasi & Setup

### Langkah 1 — Clone Repositori

```bash
git clone https://github.com/cruzhgggggg-coder/PORTOFOLIO_LARAVEL.git
cd PORTOFOLIO_LARAVEL
```

### Langkah 2 — Install Dependensi PHP

```bash
composer install
```

### Langkah 3 — Konfigurasi Environment

```bash
# Salin file .env
copy .env.example .env

# Generate application key
php artisan key:generate
```

Kemudian buka `.env` dan sesuaikan konfigurasi database:

```dotenv
# Untuk MySQL (Laragon default):
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=portofolio_main
DB_USERNAME=root
DB_PASSWORD=

# Untuk SQLite (lebih simpel untuk dev):
DB_CONNECTION=sqlite
# DB_DATABASE=database/database.sqlite

# Cache driver (WAJIB: gunakan 'file')
CACHE_STORE=file
```

> ⚠️ **PENTING:** Selalu gunakan `CACHE_STORE=file`. Jangan gunakan `database` sebagai cache driver karena dapat menyebabkan error serialisasi.

### Langkah 4 — Siapkan Database

```bash
# Jalankan migrasi dan seeding data awal
php artisan migrate --seed
```

Perintah ini akan membuat:
- Semua tabel database yang diperlukan
- **15 skill** bawaan dengan progress level realistis
- **6 pengalaman** (pekerjaan, pendidikan, sertifikasi)
- **4 testimonial** dari klien contoh
- Pengaturan SEO untuk semua halaman
- Pengaturan situs dengan nilai default

### Langkah 5 — Install Dependensi Frontend

```bash
npm install
```

### Langkah 6 — Jalankan Aplikasi

**Mode Development (buka 2 terminal terpisah):**

```bash
# Terminal 1 — Backend Laravel
php artisan serve

# Terminal 2 — Frontend Vite (hot reload)
npm run dev
```

Atau gunakan perintah all-in-one dari Composer (memerlukan `concurrently`):

```bash
composer dev
```

Aplikasi siap diakses di: **`http://localhost:8000`**

### Langkah 7 — Buat Akun Admin

```bash
# Buat admin via seeder (sudah termasuk dalam migrate --seed)
# Email: admin@portofolio.dev
# Password: admin123456

# Atau buat manual via Tinker
php artisan tinker
```

```php
// Di dalam tinker:
App\Models\User::create([
    'name' => 'Nama Admin',
    'email' => 'admin@email.com',
    'password' => bcrypt('password_aman'),
]);
```

---

## 🌐 CLIENT SIDE — Panduan Pengguna

Ini adalah halaman-halaman yang dapat diakses oleh pengunjung publik (tanpa login).

---

### 🏠 Halaman Home — `/`

**URL:** `http://localhost:8000/`

#### Apa yang Ditampilkan:
- **Hero Section** — Animasi 3D partikel interaktif berbasis Three.js di background, teks sambutan, dan tombol CTA
- **Featured Projects** — Daftar proyek yang ditandai sebagai "Featured" oleh admin
- **Testimonial Carousel** — Ulasan dari klien yang telah disetujui dan di-"featured"
- **Tombol CTA** — Mengarahkan pengunjung ke halaman `/projects` dan `/contact`

#### Cara Berinteraksi:
1. Arahkan kursor ke background → partikel 3D akan merespons gerakan mouse
2. Klik kartu proyek → akan diarahkan ke detail / link demo/repo proyek
3. Klik tombol "View All Projects" → diarahkan ke halaman `/projects`

> ℹ️ **Cache:** Halaman ini di-cache selama 24 jam. Cache otomatis terhapus ketika admin mengubah data proyek, testimonial, atau profil.

---

### 📁 Halaman Projects — `/projects`

**URL:** `http://localhost:8000/projects`

#### Apa yang Ditampilkan:
- **Grid Proyek** — Semua proyek yang ada di database, diurutkan dari yang terbaru
- **Paginasi** — Jumlah proyek per halaman dikonfigurasi oleh admin (default: 9)
- Setiap kartu proyek menampilkan:
  - Gambar thumbnail
  - Nama proyek & kategori
  - Deskripsi singkat
  - Tech stack (tags)
  - Tahun pengerjaan
  - Link demo & repository (jika ada)

#### Cara Navigasi:
- Klik tombol halaman di bawah untuk berpindah antar halaman paginasi
- Klik link "Demo" atau "GitHub" pada kartu proyek untuk membuka link eksternal

> ℹ️ **Cache:** Setiap halaman paginasi di-cache secara terpisah dengan key `portfolio.projects_page_v3_{nomor_halaman}`.

---

### 👤 Halaman About — `/about`

**URL:** `http://localhost:8000/about`

#### Apa yang Ditampilkan:

**1. Profil Identitas**
- Foto profil, nama, jabatan/role
- Bio/deskripsi singkat
- Informasi kontak (email, lokasi)

**2. Skills & Keahlian**
- Skill dikelompokkan per kategori:
  - 🖥️ **Frontend** — React, HTML, CSS, dsb.
  - ⚙️ **Backend** — Laravel, Node.js, dsb.
  - 🛠️ **Tools** — Git, Docker, dsb.
  - 🤝 **Soft Skills** — Komunikasi, teamwork, dsb.
- Setiap skill menampilkan **progress bar visual** berdasarkan nilai proficiency (0-100)

**3. Career Timeline**
- Riwayat pekerjaan, pendidikan, dan sertifikasi secara kronologis
- Setiap entri menampilkan: judul, perusahaan/institusi, periode, dan highlights

**4. Testimonial**
- Kutipan dari klien nyata dengan foto, nama, perusahaan, dan rating bintang

---

### 📬 Halaman Contact — `/contact`

**URL:** `http://localhost:8000/contact`

#### Apa yang Ditampilkan:
- Informasi kontak admin (email, telepon, lokasi) yang diambil dari profil
- **Form Kontak** dengan field:
  - Nama Lengkap
  - Alamat Email
  - Subjek
  - Pesan

#### Cara Mengirim Pesan:
1. Isi semua field form yang tersedia
2. Klik tombol **"Kirim Pesan"** / **"Send Transmission"**
3. Pesan akan tersimpan langsung ke **Inbox Admin**

#### Validasi Form:
| Field | Aturan |
|-------|--------|
| Nama | Wajib, maks. 255 karakter |
| Email | Wajib, format email valid, maks. 255 karakter |
| Subjek | Wajib, maks. 255 karakter |
| Pesan | Wajib, maks. 5000 karakter |

> ✅ Setelah berhasil dikirim, akan muncul notifikasi sukses. Pesan langsung bisa dilihat di admin panel.

---

## 🔐 ADMIN SIDE — Panduan Admin

Panel admin hanya bisa diakses oleh pengguna yang sudah login.

---

### 🔑 Login Admin

**URL Login:** `http://localhost:8000/akses-rahasia-admin`

> 🔒 URL login sengaja disembunyikan (bukan `/login` standar) untuk keamanan tambahan.

**Kredensial Default:**
```
Email    : admin@portofolio.dev
Password : admin123456
```

> ⚠️ **SEGERA GANTI** password default setelah pertama kali login melalui menu **Settings** atau via Tinker.

**Setelah Login:**
- Kamu akan otomatis diarahkan ke halaman `/admin` (Dashboard)
- URL `/register` sepenuhnya diblokir (tidak ada registrasi publik)
- Sesi admin aman dan dilindungi middleware autentikasi

---

### 📊 Dashboard — `/admin`

**URL:** `http://localhost:8000/admin`

Dashboard adalah pusat komando untuk semua aktivitas situs.

#### Kartu Statistik:
| Kartu | Informasi |
|-------|-----------|
| **Total Proyek** | Jumlah proyek + berapa yang di-featured |
| **Total Views** | Akumulasi views semua proyek + rata-rata per proyek |
| **Pesan Masuk** | Jumlah pesan belum dibaca (tampil merah jika ada) |
| **Total Konten** | Rekapan testimonial, skill, dan pengalaman |

#### Bagian Lainnya:
- **Recent Projects** — 5 proyek terakhir beserta jumlah views
- **Quick Actions** — Tombol cepat: Tambah Proyek, Lihat Pesan, Tambah Testimonial, Lihat Situs
- **Recent Messages** — 3 pesan terbaru dengan status baca/belum
- **Most Viewed Projects** — Ranking proyek berdasarkan jumlah views

---

### 📁 Manajemen Proyek — `/admin/projects`

**URL:** `http://localhost:8000/admin/projects`

#### Menambah Proyek Baru:
1. Klik tombol **"Tambah Proyek"** / **"New Project"**
2. Isi form:
   - **Judul Proyek** (wajib) — Slug otomatis dibuat dari judul
   - **Kategori** — Contoh: `Web App`, `Mobile`, `API`
   - **Deskripsi** — Penjelasan lengkap proyek
   - **Gambar** — URL gambar atau upload file
   - **Tech Stack** — Daftar teknologi yang digunakan (JSON array)
   - **Tags** — Label proyek (JSON array)
   - **Tahun** — Tahun pengerjaan
   - **Link Repository** — URL GitHub/GitLab (opsional)
   - **Link Demo** — URL live demo (opsional)
3. Centang **"Featured"** agar proyek ditampilkan di halaman Home
4. Klik **"Simpan"**

#### Mengedit Proyek:
1. Klik ikon ✏️ (Edit) pada baris proyek yang ingin diubah
2. Ubah field yang diperlukan
3. Klik **"Update"**

#### Menghapus Proyek:
1. Klik ikon 🗑️ (Hapus) pada proyek
2. Konfirmasi penghapusan di dialog yang muncul

#### Toggle Featured:
1. Klik tombol **"Featured"** / **"Toggle"** pada proyek
2. Status featured langsung berubah tanpa reload halaman
3. Proyek yang di-featured akan muncul di **halaman Home**

---

### 💬 Manajemen Pesan — `/admin/messages`

**URL:** `http://localhost:8000/admin/messages`

Semua pesan yang dikirim melalui form kontak akan masuk ke sini.

#### Tampilan Inbox:
- Pesan yang **belum dibaca** ditandai dengan latar yang lebih terang / bold
- Setiap baris menampilkan: nama pengirim, subjek, tanggal, status baca

#### Melihat Pesan:
1. Klik baris pesan untuk membuka detailnya
2. Pesan akan otomatis ditandai sebagai **"Sudah Dibaca"**
3. Di halaman detail kamu bisa melihat isi pesan lengkap

#### Menyimpan Balasan:
1. Buka detail pesan
2. Tulis balasan di textarea yang tersedia
3. Klik **"Simpan Balasan"** — balasan tersimpan di database sebagai catatan internal

#### Mengubah Status:
- Klik **"Tandai Belum Dibaca"** untuk mengembalikan status pesan
- Klik **"Tandai Sudah Dibaca"** untuk menandai pesan

#### Menghapus Pesan:
1. Klik tombol hapus di halaman detail pesan
2. Konfirmasi di dialog yang muncul

#### Bulk Actions:
1. Centang checkbox di beberapa pesan
2. Pilih aksi dari dropdown (Hapus / Tandai Dibaca / dsb.)
3. Klik **"Terapkan"**

---

### ⭐ Manajemen Testimonial — `/admin/testimonials`

**URL:** `http://localhost:8000/admin/testimonials`

#### Menambah Testimonial:
1. Klik **"Tambah Testimonial"**
2. Isi form:
   - **Nama Klien** (wajib)
   - **Jabatan / Posisi** — Contoh: `CEO di Startup X`
   - **Perusahaan** — Nama perusahaan klien
   - **Email** — Email klien (tidak ditampilkan publik)
   - **URL Avatar** — Foto profil klien
   - **Rating** — Pilih 1–5 bintang ⭐
   - **Isi Testimonial** — Komentar/ulasan dari klien
   - **Proyek Terkait** — Opsional
3. Klik **"Simpan"**

#### Workflow Persetujuan:
- Testimonial baru berstatus **"Pending"** (belum tampil di publik)
- Klik **"Approve"** untuk menampilkan testimonial di halaman publik
- Hanya testimonial yang `approved = true` yang tampil di situs

#### Toggle Featured:
- Klik **"Toggle Featured"** untuk menampilkan testimonial di **Halaman Home**
- Hanya testimonial yang `featured = true` AND `approved = true` yang tampil di Home

| Status | Tampil di About | Tampil di Home |
|--------|-----------------|----------------|
| Approved ✅ | Ya | Tidak |
| Approved ✅ + Featured ⭐ | Ya | Ya |
| Pending | Tidak | Tidak |

---

### 🎯 Manajemen Skill — `/admin/skills`

**URL:** `http://localhost:8000/admin/skills`

#### Menambah Skill:
1. Klik **"Tambah Skill"**
2. Isi form:
   - **Nama Skill** — Contoh: `Laravel`, `React`, `Docker`
   - **Kategori** — Pilih salah satu:
     - `frontend` — Teknologi sisi klien
     - `backend` — Teknologi sisi server
     - `tools` — Alat bantu pengembangan
     - `soft` — Kemampuan non-teknis
   - **Proficiency (0-100)** — Tingkat kemahiran
   - **Ikon/Emoji** — Contoh: `⚡`, `🔥`, `🐳` (opsional)
   - **Deskripsi** — Penjelasan singkat (opsional)
3. Klik **"Simpan"**

#### Toggle Aktif:
- Klik **"Toggle Active"** untuk menyembunyikan/menampilkan skill di halaman publik
- Skill dengan `is_active = false` tidak akan tampil di halaman About

#### Urutan Tampilan:
- Skill diurutkan berdasarkan kolom `sort_order`
- Skill dengan sort_order lebih kecil tampil lebih dulu

#### Bulk Actions:
- Centang beberapa skill
- Pilih "Aktifkan Semua" atau "Nonaktifkan Semua"
- Klik **"Terapkan"**

**Contoh Pengisian Proficiency:**
| Level | Nilai (0-100) | Keterangan |
|-------|--------------|------------|
| Pemula | 0–30 | Baru belajar |
| Menengah | 31–60 | Bisa menggunakan |
| Mahir | 61–85 | Paham mendalam |
| Expert | 86–100 | Level profesional |

---

### 💼 Manajemen Pengalaman — `/admin/experiences`

**URL:** `http://localhost:8000/admin/experiences`

#### Menambah Pengalaman:
1. Klik **"Tambah Pengalaman"**
2. Isi form:
   - **Tipe** — Pilih:
     - `work` — Pengalaman kerja/magang
     - `education` — Riwayat pendidikan
     - `certification` — Sertifikat resmi
   - **Judul/Posisi** — Contoh: `Backend Developer`, `S1 Informatika`
   - **Perusahaan/Institusi** — Nama tempat bekerja/belajar
   - **Lokasi** — Kota, Negara
   - **Tanggal Mulai** — Format: `YYYY-MM-DD`
   - **Tanggal Selesai** — Kosongkan jika masih berjalan ("Saat ini")
   - **Posisi Saat Ini** — Centang jika ini pekerjaan/studi yang sedang berlangsung
   - **Highlights** — Daftar pencapaian/poin penting (bisa multiple)
   - **URL Logo** — Logo perusahaan/institusi (opsional)
3. Klik **"Simpan"**

#### Toggle Aktif:
- Pengalaman yang `is_active = false` tidak tampil di halaman About
- Berguna untuk menyembunyikan pengalaman lama tanpa menghapusnya

---

### 🔍 SEO Manager — `/admin/seo`

**URL:** `http://localhost:8000/admin/seo`

Kelola meta tag SEO untuk setiap halaman secara individual.

#### Halaman yang Bisa Dikonfigurasi:
| Page Key | Halaman |
|----------|---------|
| `home` | Halaman Utama (`/`) |
| `projects` | Halaman Proyek (`/projects`) |
| `about` | Halaman About (`/about`) |
| `contact` | Halaman Kontak (`/contact`) |

#### Field Konfigurasi per Halaman:
1. Buka `/admin/seo`
2. Klik **"Edit"** pada halaman yang ingin dikonfigurasi
3. Isi field:
   - **Meta Title** — Judul di tab browser & hasil pencarian Google
   - **Meta Description** — Deskripsi singkat (maks. 160 karakter) untuk Google
   - **Meta Keywords** — Kata kunci relevan (dipisah koma)
   - **OG Image URL** — Gambar yang muncul saat link dibagikan di media sosial
   - **Canonical URL** — URL kanonik untuk menghindari duplicate content
   - **No Index** — Centang untuk mencegah halaman diindeks Google
4. Klik **"Simpan"**

**Tips SEO:**
> - Meta Title ideal: **50–60 karakter**
> - Meta Description ideal: **120–160 karakter**
> - OG Image ideal: **1200×630 piksel**

---

### ⚙️ Pengaturan Situs — `/admin/settings`

**URL:** `http://localhost:8000/admin/settings`

Kontrol pusat untuk semua konfigurasi global situs.

#### Grup Pengaturan:

**1. General — Pengaturan Umum**
| Setting | Deskripsi |
|---------|-----------|
| `site_name` | Nama situs (muncul di semua halaman) |
| `site_tagline` | Tagline singkat |
| `maintenance_mode` | Aktifkan mode maintenance (situs tidak bisa diakses publik) |

**2. Contact — Informasi Kontak**
| Setting | Deskripsi |
|---------|-----------|
| `contact_email` | Email yang tampil di halaman Contact |
| `contact_phone` | Nomor telepon |
| `contact_address` | Alamat / Kota |

**3. Analytics — Pelacak Trafik**
| Setting | Deskripsi |
|---------|-----------|
| `google_analytics_id` | Kode Google Analytics (format: `G-XXXXXXXXXX`) |
| `facebook_pixel_id` | ID Facebook Pixel |

**4. Display — Tampilan**
| Setting | Deskripsi |
|---------|-----------|
| `projects_per_page` | Jumlah proyek per halaman di `/projects` (default: 9) |

**5. Features — Fitur On/Off**
| Setting | Deskripsi |
|---------|-----------|
| `show_testimonials` | Tampilkan/sembunyikan section testimonial |
| `show_tech_marquee` | Tampilkan/sembunyikan marquee teknologi di Home |

#### Mode Maintenance:
1. Klik **"Aktifkan Maintenance Mode"**
2. Semua pengunjung publik akan melihat halaman **"Under Maintenance"**
3. Admin yang login tetap bisa mengakses dashboard
4. Klik **"Nonaktifkan"** untuk kembali normal

> ⚠️ Pastikan kamu masih dalam keadaan login sebelum mengaktifkan maintenance mode!

---

### 👤 Profil & Identitas — `/admin/profile`

**URL:** `http://localhost:8000/admin/profile`

Data profil kamu yang ditampilkan di seluruh situs (Header, About, Contact).

#### Field yang Bisa Diubah:
| Field | Deskripsi | Tampil di |
|-------|-----------|-----------|
| `name` | Nama lengkap | Semua halaman, hero section |
| `title` | Jabatan profesional (`Full Stack Developer`) | Home, About |
| `bio` | Tentang kamu (paragraf pendek) | Home, About |
| `email` | Email kontak | Contact, Footer |
| `phone` | Nomor telepon | Contact |
| `location` | Kota, Negara | About, Contact |
| `avatar_url` | URL foto profil | About |
| `github_url` | Link GitHub | Footer, About |
| `linkedin_url` | Link LinkedIn | Footer, About |
| `twitter_url` | Link Twitter/X | Footer, About |
| `instagram_url` | Link Instagram | Footer (opsional) |
| `resume_url` | Link CV/Resume (PDF) | About — tombol "Download CV" |

#### Cara Update:
1. Buka `/admin/profile`
2. Ubah field yang ingin diperbarui
3. Klik **"Simpan Perubahan"**
4. Semua halaman publik akan otomatis menampilkan data baru (cache ikut terhapus)

---

## 💾 Arsitektur Caching

Proyek ini menggunakan **JSON-Based Caching** yang stabil dan bebas dari masalah serialisasi PHP native.

### Cara Kerja:
```
Request → Controller → Cek Cache (file)
    ├── Cache HIT  → JSON::decode → Object → View
    └── Cache MISS → Query DB → JSON::encode → Simpan Cache → Object → View
```

### Cache Keys yang Digunakan:
| Cache Key | TTL | Konten |
|-----------|-----|--------|
| `portfolio.home_data_v3` | 24 jam | Projects featured + testimonial |
| `portfolio.about_data_v3` | 24 jam | Skills + experiences + testimonials |
| `portfolio.contact_profile_v3` | 24 jam | Data profil kontak |
| `portfolio.projects_page_v3_{n}` | 24 jam | Data paginasi per halaman ke-n |
| `portfolio.settings_v3` | 24 jam | Site settings global |
| `portfolio.settings_profile_v3` | 24 jam | Profile settings global |

### Invalidasi Cache Otomatis:
Cache **otomatis terhapus** setiap kali admin melakukan perubahan data melalui `PortfolioObserver`. Tidak perlu clear manual setelah update data.

### Clear Cache Manual (jika diperlukan):
```bash
php artisan cache:clear
```

---

## 🗄️ Struktur Database

### Tabel Utama:

```
users                     -- Akun admin
projects                  -- Data proyek portofolio
messages                  -- Pesan dari form kontak
testimonials              -- Ulasan/review klien
skills                    -- Daftar keahlian
experiences               -- Riwayat karier & pendidikan
seo_settings              -- Konfigurasi SEO per halaman
site_settings             -- Pengaturan global situs (key-value)
profile_settings          -- Data profil admin (key-value)
```

### Relasi Key:
- Setiap model memiliki scope query seperti `:active()`, `:ordered()`, `:approved()`, `:featured()`
- Model `SiteSetting` dan `ProfileSetting` menggunakan pola key-value store

---

## 📂 Struktur Proyek

```
portofolio-main/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── ProjectController.php         ← Controller halaman publik
│   │   │   └── Admin/
│   │   │       ├── DashboardController.php
│   │   │       ├── ProjectAdminController.php
│   │   │       ├── MessageAdminController.php
│   │   │       ├── TestimonialAdminController.php
│   │   │       ├── SkillAdminController.php
│   │   │       ├── ExperienceAdminController.php
│   │   │       ├── SeoSettingController.php
│   │   │       ├── SiteSettingController.php
│   │   │       └── ProfileAdminController.php
│   │   └── Middleware/
│   │       └── RedirectGuestToHome.php        ← Proteksi admin routes
│   ├── Models/                                ← Eloquent Models
│   │   ├── Project.php
│   │   ├── Message.php
│   │   ├── Testimonial.php
│   │   ├── Skill.php
│   │   ├── Experience.php
│   │   ├── SeoSetting.php
│   │   ├── SiteSetting.php
│   │   └── ProfileSetting.php
│   ├── Observers/
│   │   └── PortfolioObserver.php             ← Auto-invalidate cache
│   └── Providers/
│       └── AppServiceProvider.php            ← Global view sharing + cache
├── resources/
│   └── views/
│       ├── home.blade.php                    ← Halaman publik
│       ├── projects.blade.php
│       ├── about.blade.php
│       ├── contact.blade.php
│       └── admin/                            ← Template admin panel
│           ├── layout.blade.php
│           ├── dashboard.blade.php
│           └── ...
├── routes/
│   └── web.php                              ← Definisi semua route
├── database/
│   ├── migrations/                          ← Skema database
│   └── seeders/                             ← Data awal
├── public/                                  ← Aset statis & entry point
├── .env                                     ← Konfigurasi environment
├── vite.config.ts                           ← Konfigurasi frontend bundler
└── composer.json                            ← Dependensi PHP
```

---

## 🎯 Perintah Artisan Penting

```bash
# Menjalankan server development
php artisan serve

# Migrasi database (bersih dari awal + seeding)
php artisan migrate:fresh --seed

# Hanya jalankan migrasi baru
php artisan migrate

# Hanya jalankan seeder
php artisan db:seed

# Membersihkan cache aplikasi
php artisan cache:clear

# Membersihkan cache view Blade
php artisan view:clear

# Membersihkan cache route
php artisan route:clear

# Membersihkan semua cache sekaligus
php artisan optimize:clear

# Membuat akun user baru via tinker
php artisan tinker

# Melihat semua route yang terdaftar
php artisan route:list

# Build frontend untuk production
npm run build

# Dev server frontend dengan hot reload
npm run dev
```

---

## 🐛 Troubleshooting

### Error: "Attempt to read property on string"
**Penyebab:** Cache lama masih menyimpan data format lama (non-JSON)
**Solusi:**
```bash
php artisan cache:clear
php artisan view:clear
```

### Error: "Class not found / incomplete object"
**Penyebab:** Cache driver `database` menyimpan serialized PHP objects yang rusak
**Solusi:** Pastikan `.env` menggunakan `CACHE_STORE=file`, lalu:
```bash
php artisan cache:clear
```

### Error: CSRF Token Mismatch
**Penyebab:** Sesi expired atau form tidak menyertakan `@csrf`
**Solusi:** Refresh halaman dan coba lagi. Pastikan semua form Blade menyertakan `@csrf`.

### Halaman Tidak Update Setelah Edit Data
**Penyebab:** Cache masih menyimpan data lama
**Solusi:** Cache seharusnya otomatis terhapus via Observer. Jika tidak, jalankan:
```bash
php artisan cache:clear
```

### Error: "npm run dev" gagal
**Penyebab:** Node modules belum terinstall atau versi Node tidak kompatibel
**Solusi:**
```bash
# Hapus node_modules dan install ulang
Remove-Item -Recurse -Force node_modules
npm install
npm run dev
```

### Error: "php artisan serve" port sudah digunakan
**Solusi:**
```bash
# Gunakan port lain
php artisan serve --port=8001
```

### Database Error: Table not found
**Penyebab:** Migrasi belum dijalankan
**Solusi:**
```bash
php artisan migrate --seed
```

---

## 🔐 Keamanan

- ✅ **Admin URL tersembunyi** — Login hanya via `/akses-rahasia-admin`
- ✅ **Registrasi diblokir** — `/register` diarahkan ke home, `POST /register` mengembalikan 403
- ✅ **Middleware autentikasi** — Semua route `/admin/*` dilindungi
- ✅ **CSRF Protection** — Semua form dilindungi CSRF token Laravel
- ✅ **SQL Injection Prevention** — Semua query menggunakan Eloquent ORM
- ✅ **Input Validation** — Semua input divalidasi sebelum diproses
- ✅ **Rate Limiting** — Login throttle untuk mencegah brute force

---

## 📄 Lisensi

Proyek ini dibuat untuk keperluan portofolio pribadi. Bebas digunakan dan dimodifikasi.

---

<div align="center">

**Dibuat dengan ❤️ menggunakan Laravel + Three.js**

[🌐 Live Demo](#) • [📁 Repository](https://github.com/cruzhgggggg-coder/PORTOFOLIO_LARAVEL) • [🐛 Report Bug](https://github.com/cruzhgggggg-coder/PORTOFOLIO_LARAVEL/issues)

</div>
