# Laravel Production Deployment Report
## Project: Twinvexa Technology BD
### Generated: 2026-07-21

---

## 1. Overview

A production-ready deployment package has been prepared from:
- **Original Source:** `D:\National Drug Central Labratory\NewEcom`
- **Deploy Copy:** `D:\National Drug Central Labratory\NewEcom_live_deploy`
- **Deploy Package:** `D:\National Drug Central Labratory\NewEcom_live_deploy.zip`

The original project directory was **NOT modified** during this process.

---

## 2. Excluded Files / Directories

The following were excluded from the deployment package:

### Directories Excluded
| Path | Reason |
|------|--------|
| `.git/` | Git repository history (not needed on production server) |
| `node_modules/` | Frontend build dependencies (huge, not deployable; rebuild on server or deploy built assets only) |
| `vendor/` | PHP dependencies (excluded to reduce package size; install via `composer install` on server) |
| `tests/` | Test suite (not needed in production) |

### Files Excluded
| Path | Reason |
|------|--------|
| `phpunit.xml` | PHPUnit test configuration |
| `.phpunit.result.cache` | PHPUnit execution cache |
| `create_tables.php` | Development database setup script |
| `nul` | Windows empty file artifact |
| `.env.example.backup` | Backup of environment file (did not exist in this project) |
| `.vscode/` directory | VS Code IDE configuration (not present) |
| `.idea/` directory | JetBrains IDE configuration (not present) |
| `public/storage` symlink | Stale symbolic link pointing to original project storage; must be recreated on server |

---

## 3. .env Changes

The entire `.env` file was rewritten for production. Below is a complete diff-style summary.

| Variable | Original Value | Deploy Value | Notes |
|----------|---------------|--------------|-------|
| `APP_NAME` | `Laravel` | `"Twinvexa Technology BD"` | Quoted due to spaces |
| `APP_ENV` | `local` | `production` | |
| `APP_DEBUG` | `true` | `false` | |
| `APP_URL` | `http://localhost` | `https://twinvexatechnologybd.com` | |
| `APP_KEY` | Same | Same | Preserved from original |
| `LOG_LEVEL` | `debug` | `warning` | |
| `SESSION_SECURE_COOKIE` | `null` | `true` | Required for HTTPS |
| `FILESYSTEM_DISK` | `local` | `public` | Serves uploaded files via public/storage |
| `CACHE_DRIVER` | *not set* | `database` | Added for clarity |
| `DB_DATABASE` | `twinvexa_technology_bd` | `your_database_name` | Placeholder |
| `DB_USERNAME` | `admin` | `your_db_user` | Placeholder |
| `DB_PASSWORD` | `Admin@12345` | `your_db_password` | Placeholder |

All other original `.env` variables were preserved with their values unless otherwise noted.

---

## 4. Configuration Changes

### A. Route Configuration (`routes/web.php`)
**Problem:** Route caching failed because both the custom 404 route and the fallback route were assigned the same name `errors.404`.

**Fix Applied:**
- Removed `->name('errors.404')` from the `Route::fallback()` definition at line 268.
- The explicit `Route::get('404', ...)` named route remains intact for backwards compatibility.

### B. Cache Configuration (`config/cache.php`)
- No file changes required.
- Default cache store is `database`, which aligns with production.
- `.env` variable `CACHE_STORE=database` and `CACHE_DRIVER=database` were set.

### C. Session Configuration (`config/session.php`)
- No file changes required.
- Default session driver is `database`, which aligns with production.
- `.env` variable `SESSION_DRIVER=database` was set.
- `.env` variable `SESSION_SECURE_COOKIE=true` was set for HTTPS.

### D. Filesystem Configuration (`config/filesystems.php`)
- No file changes required.
- Default disk changed to `public` via `.env` (`FILESYSTEM_DISK=public`).
- Public disk serves files from `storage/app/public` through the `public/storage` symlink.

---

## 5. Laravel Caches Generated

The following caches were generated successfully in the deploy copy:

- `bootstrap/cache/config.php` - Compiled configuration
- `bootstrap/cache/routes-v7.php` - Compiled routes (Laravel 12 uses v7 route format)
- `bootstrap/cache/events.php` - Compiled event listeners
- `storage/framework/views/*.php` - Compiled Blade templates

> **Note:** These caches were generated on the local machine. They will function correctly on the production server **after** `composer install` installs the matching package versions from `composer.lock`.

---

## 6. Commands Needed on the Live Server

Upload the extracted package (or the zip) to your live server, then execute the following commands **in the application root directory**:

```bash
# 1. Install PHP dependencies (production only, no dev packages)
composer install --no-dev --optimize-autoloader --no-interaction

# 2. Create the public/storage symbolic link
php artisan storage:link

# 3. Run database migrations
php artisan migrate --force

# 4. (Optional) Seed the database if you have seeders
php artisan db:seed --force

# 5. Ensure storage and cache directories have correct permissions
# See Section 8 for exact commands
```

---

## 7. Database Setup Instructions

Your application uses database-backed sessions, cache, and queues. Ensure the following tables exist:

### Required Tables (Auto-created by Laravel Migrations)
- `sessions` - For database session storage
- `cache` - For database cache storage
- `cache_locks` - For cache locking
- `jobs` - For queued jobs
- `job_batches` - For job batching
- `failed_jobs` - For failed queue jobs

### Recommended Database Schema / User Setup

```sql
-- Create database (adjust name as needed)
CREATE DATABASE twinvexa_technology_bd CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Create user and grant privileges
CREATE USER 'your_db_user'@'localhost' IDENTIFIED BY 'your_db_password';
GRANT ALL PRIVILEGES ON twinvexa_technology_bd.* TO 'your_db_user'@'localhost';
FLUSH PRIVILEGES;
```

> **Important:** Replace the placeholders in `.env` (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`) with your actual production credentials before running migrations.

---

## 8. File Permission Requirements

If deploying to a Linux server, set the following permissions:

```bash
# Set ownership to the web server user (e.g., www-data, nginx, or apache)
sudo chown -R www-data:www-data /path/to/deployment

# Ensure writable directories for Laravel
sudo chmod -R 775 storage bootstrap/cache

# Ensure read/execute for all other directories
find /path/to/deployment -type d -exec chmod 755 {} +
find /path/to/deployment -type f -exec chmod 644 {} +
```

If deploying to a Windows server with IIS, ensure the IIS_IUSRS group has Modify permissions on `storage` and `bootstrap/cache`.

---

## 9. Post-Deployment Manual Steps

1. **Update Database Credentials**
   - Edit `.env` and replace `your_database_name`, `your_db_user`, and `your_db_password` with actual production values.

2. **Update Mail Configuration**
   - Edit `.env` and replace `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD` with your SMTP provider details.
   - Update `MAIL_FROM_ADDRESS` to a valid domain email.

3. **Verify APP_KEY**
   - The `APP_KEY` is already set in the deployed `.env`. Do NOT regenerate it unless you want to invalidate all existing encrypted data.

4. **Run Composer Install**
   - Ensure `composer install` completes successfully on the server.

5. **Run Migrations**
   - Execute `php artisan migrate --force` to create all required tables.

6. **Create Storage Symlink**
   - Execute `php artisan storage:link` to link `public/storage` to `storage/app/public`.

7. **Configure Web Server**
   - Set the document root to the `public/` directory.
   - Ensure `.htaccess` is enabled (Apache) or equivalent Nginx config is applied.
   - Ensure `mod_rewrite` is enabled on Apache.

8. **Set HTTPS / SSL**
   - Configure SSL certificate (Let's Encrypt, etc.) for `https://twinvexatechnologybd.com`.
   - Ensure the server redirects HTTP to HTTPS.

9. **Configure Queue Worker (if using queues)**
   - If the application uses queues, set up a Supervisor process or systemd service to run `php artisan queue:work --daemon`.

10. **Smoke Test**
    - Visit `https://twinvexatechnologybd.com` and verify the homepage loads.
    - Test user registration, login, and any critical user flows.
    - Verify admin panel is reachable.

---

## 10. Additional Notes

- **Composer.lock is included** in the package to guarantee identical dependency versions on the production server.
- **Frontend assets** in `public/build/` are included (pre-built Vite assets). No `npm install` or npm build is required on the server unless you plan to modify frontend assets.
- **APP_KEY** was preserved from the original environment. If you suspect it was compromised, or if you are deploying to a completely separate environment, you may generate a new one:
  ```bash
  php artisan key:generate --force
  ```
- **Cache Warmup:** The first request after deployment may be slightly slower while views compile. Subsequent requests will use the pre-cached views generated during package preparation.

---

## 11. File Listing Verification

Key files present in the deployment package:
- `artisan` - Laravel CLI
- `composer.json` + `composer.lock` - PHP dependency definitions
- `bootstrap/cache/config.php` - Cached configuration
- `bootstrap/cache/routes-v7.php` - Cached routes
- `bootstrap/cache/events.php` - Cached events
- `public/build/` - Pre-compiled frontend assets
- `storage/` - Application storage (empty except for framework subdirectories and cached views)
- All application code under `app/`, `config/`, `database/`, `resources/`, `routes/`
