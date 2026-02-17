# 🎨 Portfolio CMS - Laravel

> Professional Portfolio & Content Management System built with Laravel 11, PostgreSQL, and Bootstrap 5.

[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=flat&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat&logo=php)](https://php.net)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-16+-336791?style=flat&logo=postgresql)](https://postgresql.org)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=flat&logo=bootstrap)](https://getbootstrap.com)

---

## 📋 Table of Contents

- [Features](#-features)
- [Tech Stack](#-tech-stack)
- [Requirements](#-requirements)
- [Installation](#-installation)
- [Database Schema](#-database-schema)
- [File Structure](#-file-structure)
- [Usage Guide](#-usage-guide)
- [Image Management](#-image-management)
- [Deployment](#-deployment)
- [Troubleshooting](#-troubleshooting)
- [Credits](#-credits)

---

## ✨ Features

### Frontend (Portfolio Website)
- ✅ **Single-page portfolio** with smooth scrolling
- ✅ **Hero section** with typing animation
- ✅ **About section** with timeline
- ✅ **Skills section** with progress bars (grouped by category)
- ✅ **Portfolio section** with isotope filtering & lightbox
- ✅ **Resume section** (work experience & education)
- ✅ **Testimonials** (critic reviews & personal testimonials)
- ✅ **Contact form** with FormSubmit.co integration
- ✅ **Lazy loading** images for performance
- ✅ **AOS animations** (Animate On Scroll)
- ✅ **Responsive design** (mobile-first)

### Backend (Admin CMS)
- ✅ **Dashboard** with statistics & tabs
- ✅ **Skills management** (name, category, percentage, icon, image)
- ✅ **Portfolio management** (title, category, description, image, tags, featured)
- ✅ **Experience management** (position, company, dates, achievements array)
- ✅ **Education management** (degree, institution, years)
- ✅ **Testimonials management** (personal & critic reviews, avatar, rating)
- ✅ **Social links management** (platform, URL, icon)
- ✅ **Soft delete** with restore functionality
- ✅ **Image upload** with automatic compression
- ✅ **Image preview** before upload
- ✅ **Authentication** (login/logout)

### Technical Features
- ✅ **Soft delete** on all tables (deleted_at, deleted_by)
- ✅ **Image compression** with Intervention Image
- ✅ **Lazy loading** for better performance
- ✅ **JSON storage** for tags & achievements
- ✅ **Display order** for custom sorting
- ✅ **Active/Inactive** status toggle
- ✅ **CSRF protection**
- ✅ **Form validation**

---

## 🛠 Tech Stack

### Backend
- **Laravel 11.x** - PHP Framework
- **PostgreSQL 16+** - Database
- **Intervention Image** - Image processing

### Frontend
- **Bootstrap 5.3** - CSS Framework
- **Bootstrap Icons** - Icon library
- **AOS** - Animate On Scroll
- **GLightbox** - Lightbox gallery
- **Isotope** - Portfolio filtering
- **Swiper** - Testimonials slider
- **Typed.js** - Typing animation
- **PureCounter** - Number counter

---

## 📦 Requirements

- PHP >= 8.2
- Composer
- Node.js & NPM
- PostgreSQL >= 16
- GD Library (for image processing)

---

## 🚀 Installation

### 1. Clone Repository

```bash
git clone <repository-url>
cd portfolio-cms
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 3. Environment Setup

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Configuration

Edit `.env` file:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=portfolio_db
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

Create PostgreSQL database:

```bash
# Login to PostgreSQL
psql -U postgres

# Create database
CREATE DATABASE portfolio_db;

# Exit
\q
```

### 5. Run Migrations

```bash
php artisan migrate
```

### 6. Create Admin User

```bash
php artisan tinker
```

In tinker:

```php
\App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@portfolio.com',
    'password' => bcrypt('password123')
]);
```

Exit tinker: `exit`

### 7. Create Required Directories

```bash
mkdir -p public/assets/img/skills/original
mkdir -p public/assets/img/portfolio/original
mkdir -p public/assets/img/person/original
```

### 8. Install Intervention Image

```bash
composer require intervention/image
```

### 9. Create ImageHelper

Create file `app/Helpers/ImageHelper.php` (copy from provided files)

Edit `composer.json`:

```json
"autoload": {
    "psr-4": {
        "App\\": "app/"
    },
    "files": [
        "app/Helpers/ImageHelper.php"
    ]
}
```

Run:

```bash
composer dump-autoload
```

### 10. Compile Assets

```bash
npm run build
```

### 11. Start Development Server

```bash
php artisan serve
```

Visit:
- **Frontend**: http://localhost:8000
- **Admin**: http://localhost:8000/login

**Default credentials:**
- Email: `admin@portfolio.com`
- Password: `password123`

---

## 🗄 Database Schema

### Tables Overview

| Table | Description | Features |
|-------|-------------|----------|
| `users` | Admin users | Authentication |
| `skills` | Technical skills | Category, percentage, icon, image |
| `portfolios` | Portfolio projects | Tags (JSON), featured flag, image |
| `experiences` | Work experience | Achievements (JSON), current job flag |
| `educations` | Educational background | Year range |
| `testimonials` | Client reviews | Personal/Critic, rating, avatar |
| `social_links` | Social media | Platform, URL, icon |

### Soft Delete Columns

All tables have:
- `deleted_at` (timestamp, nullable)
- `deleted_by` (bigint, nullable) - references users.id

---

## 📁 File Structure

```
portfolio-cms/
├── app/
│   ├── Helpers/
│   │   └── ImageHelper.php          # Image upload & compression
│   ├── Http/
│   │   └── Controllers/
│   │       ├── FrontendController.php
│   │       ├── Auth/
│   │       │   └── LoginController.php
│   │       └── Admin/
│   │           ├── DashboardController.php
│   │           ├── SkillController.php
│   │           ├── PortfolioController.php
│   │           ├── ExperienceController.php
│   │           ├── EducationController.php
│   │           ├── TestimonialController.php
│   │           └── SocialLinkController.php
│   └── Models/
│       ├── User.php
│       ├── Skill.php
│       ├── Portofolio.php
│       ├── Experience.php
│       ├── Education.php
│       ├── Testimonial.php
│       └── SocialLink.php
│
├── database/
│   └── migrations/
│       ├── xxxx_create_skills_table.php
│       ├── xxxx_create_portfolios_table.php
│       ├── xxxx_create_experiences_table.php
│       ├── xxxx_create_educations_table.php
│       ├── xxxx_create_testimonials_table.php
│       └── xxxx_create_social_links_table.php
│
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── partials/
│       │   └── frontend/
│       │       ├── header.blade.php
│       │       └── footer.blade.php
│       ├── frontend/
│       │   ├── home.blade.php
│       │   └── sections/
│       │       ├── hero.blade.php
│       │       ├── about.blade.php
│       │       ├── skills.blade.php
│       │       ├── resume.blade.php
│       │       ├── portofolio.blade.php
│       │       ├── testimonials.blade.php
│       │       ├── faq.blade.php
│       │       └── contact.blade.php
│       └── admin/
│           ├── dashboard.blade.php
│           └── sections/
│               ├── skills.blade.php
│               ├── portofolios.blade.php
│               ├── experiences.blade.php
│               ├── educations.blade.php
│               ├── testimonials.blade.php
│               └── social_links.blade.php
│
├── public/
│   └── assets/
│       ├── css/
│       │   └── main.css
│       ├── js/
│       │   └── main.js
│       ├── img/
│       │   ├── skills/
│       │   │   ├── original/        # Original images
│       │   │   └── [compressed]     # Auto-compressed
│       │   ├── portfolio/
│       │   │   ├── original/
│       │   │   └── [compressed]
│       │   └── person/
│       │       ├── original/
│       │       └── [compressed]
│       └── vendor/                  # Libraries (AOS, GLightbox, etc)
│
└── routes/
    └── web.php                      # All routes
```

---

## 📖 Usage Guide

### Admin Panel

#### 1. Login
Visit `/login` and enter credentials

#### 2. Dashboard
- View statistics for all content types
- Use tabs to switch between sections

#### 3. Adding Content

**Skills:**
1. Click "Add Skill"
2. Fill form (name, category, percentage, icon)
3. Upload image (optional, max 5MB)
4. Preview before submit
5. Click "Save Skill"

**Portfolio:**
1. Click "Add Portfolio"
2. Fill form (title, category, description, URL)
3. Add tags (comma-separated)
4. Upload image (required, max 5MB)
5. Set featured flag (optional)
6. Click "Save Portfolio"

**Experience:**
1. Click "Add Experience"
2. Fill form (position, company, dates)
3. Add achievements (multiple entries)
4. Check "Currently working" if applicable
5. Click "Save Experience"

**Testimonials:**
1. Click "Add Testimonial"
2. Fill form (name, position, company, rating)
3. Upload avatar (optional)
4. Toggle "Critic review" if from media
5. Click "Save Testimonial"

#### 4. Editing Content
1. Click edit button on table row
2. Modify fields
3. Change image (optional - leave empty to keep current)
4. Click "Update"

#### 5. Deleting Content
1. Click delete button
2. Confirm deletion
3. Data is **soft deleted** (can be restored)

---

## 🖼 Image Management

### Upload Process

1. **Select image** (JPG, PNG, GIF, WEBP)
2. **Preview** appears instantly
3. **Upload** on form submit
4. **Auto-compression** happens
5. **Two versions saved**:
   - Original: `public/assets/img/{folder}/original/{filename}`
   - Compressed: `public/assets/img/{folder}/{filename}`

### Image Compression Settings

| Type | Max Width | Quality | Folder |
|------|-----------|---------|--------|
| Skills | 800px | 85% | `skills/` |
| Portfolio | 1200px | 80% | `portfolio/` |
| Avatars | 400px | 85% | `person/` |

### Lazy Loading

All images use `loading="lazy"` except:
- Hero images (above the fold)
- Logo
- Critical first-view images

### Image Fallback

If image fails to load, defaults are:
- Skills: `assets/img/skills/default.jpg`
- Portfolio: `assets/img/portfolio/default.jpg`
- Avatars: `assets/img/person/default-avatar.jpg`

---

## 🌐 Deployment

### Production Checklist

- [ ] Set `APP_ENV=production` in `.env`
- [ ] Set `APP_DEBUG=false`
- [ ] Generate production key: `php artisan key:generate`
- [ ] Configure production database
- [ ] Run migrations: `php artisan migrate --force`
- [ ] Optimize: `php artisan optimize`
- [ ] Set proper file permissions:
  ```bash
  chmod -R 755 storage bootstrap/cache
  chmod -R 775 public/assets/img
  ```
- [ ] Setup SSL certificate
- [ ] Configure web server (Nginx/Apache)
- [ ] Setup cron for scheduled tasks
- [ ] Configure email (SMTP)
- [ ] Setup backups (database + uploads)

### Nginx Configuration

```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /var/www/portfolio-cms/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

---

## 🔧 Troubleshooting

### Common Issues

**1. Image upload fails**
- Check folder permissions: `chmod -R 775 public/assets/img`
- Check GD library: `php -m | grep -i gd`
- Install if missing: `sudo apt-get install php-gd`

**2. Database connection error**
- Verify PostgreSQL is running: `sudo systemctl status postgresql`
- Check `.env` credentials
- Test connection: `psql -U postgres -d portfolio_db`

**3. Page shows blank/white screen**
- Check logs: `tail -f storage/logs/laravel.log`
- Enable debug: `APP_DEBUG=true` in `.env`
- Clear cache: `php artisan cache:clear`

**4. Images not loading**
- Check file exists in `public/assets/img/`
- Check file permissions
- Verify asset URL: `php artisan route:list`

**5. AOS animations not working**
- Check browser console for JS errors
- Verify AOS is loaded: `View Source → search for "aos.js"`
- Clear browser cache

**6. Contact form not working**
- Verify FormSubmit email
- Add `_captcha=false` hidden input
- Check network tab in browser DevTools

---

## 📝 Development Notes

### Models Best Practices

All models use:
- **Soft Delete** trait
- **Active** scope for filtering non-deleted
- **Ordered** scope for sorting by display_order
- **Fillable** properties for mass assignment
- **Casts** for JSON fields and booleans

### Controllers Best Practices

- Use **ImageHelper** for uploads
- Validate all inputs
- Set `deleted_by` on soft delete
- Clear `deleted_by` on restore
- Redirect with success messages

### Blade Best Practices

- Use `@forelse` for loops with empty state
- Always set `alt` on images
- Use `loading="lazy"` on images below fold
- Add `onerror` fallback for images
- Escape output with `{{ }}` not `{!! !!}`

---

## 👤 Credits

**Developed by:** Najwa Fauziah Rahmania

**Built with:**
- Laravel Framework
- Bootstrap 5
- PostgreSQL
- Intervention Image
- AOS, GLightbox, Isotope, Swiper

---

## 📄 License

This project is proprietary software. All rights reserved.

---

## 🤝 Support

For issues or questions:
- Email: najwafauziah123@gmail.com
- GitHub Issues: [Create Issue]

---

**Last Updated:** February 2026
