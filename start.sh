#!/bin/bash

# ── 1. Generate .env from .env.example ───────────────────────────────────────
if [ ! -f /var/www/html/.env ]; then
    cp /var/www/html/.env.example /var/www/html/.env
fi

cd /var/www/html

# Override critical values from Render environment variables
sed -i "s|^APP_ENV=.*|APP_ENV=${APP_ENV:-production}|" .env
sed -i "s|^APP_DEBUG=.*|APP_DEBUG=${APP_DEBUG:-false}|" .env
sed -i "s|^APP_URL=.*|APP_URL=${APP_URL:-http://localhost}|" .env
sed -i "s|^DB_CONNECTION=.*|DB_CONNECTION=${DB_CONNECTION:-sqlite}|" .env
sed -i "s|^SESSION_DRIVER=.*|SESSION_DRIVER=${SESSION_DRIVER:-file}|" .env
sed -i "s|^CACHE_STORE=.*|CACHE_STORE=${CACHE_STORE:-file}|" .env
sed -i "s|^QUEUE_CONNECTION=.*|QUEUE_CONNECTION=${QUEUE_CONNECTION:-sync}|" .env

# ── 2. Set APP_KEY ────────────────────────────────────────────────────────────
if [ -n "$APP_KEY" ]; then
    sed -i "s|^APP_KEY=.*|APP_KEY=${APP_KEY}|" .env
else
    php artisan key:generate --force
fi

# ── 3. Create SQLite DB file if needed ───────────────────────────────────────
if grep -q "DB_CONNECTION=sqlite" .env; then
    mkdir -p /var/www/html/database
    touch /var/www/html/database/database.sqlite
    chown www-data:www-data /var/www/html/database/database.sqlite
    chmod 664 /var/www/html/database/database.sqlite
fi

# ── 4. Run migrations ─────────────────────────────────────────────────────────
php artisan migrate --force || echo "Migration warning (non-fatal)"

# ── 5. Seed database ──────────────────────────────────────────────────────────
php artisan db:seed --force || echo "Seed warning (non-fatal)"

# ── 6. Force-approve seed accounts via PHP (no tinker) ───────────────────────
php -r "
define('LARAVEL_START', microtime(true));
require '/var/www/html/vendor/autoload.php';
\$app = require_once '/var/www/html/bootstrap/app.php';
\$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
\Illuminate\Support\Facades\DB::table('users')
    ->whereIn('email', ['admin@church.com','staff@church.com','juan@church.com'])
    ->update(['is_approved' => 1]);
echo 'Seed accounts approved.' . PHP_EOL;
" || echo "Approval update warning (non-fatal)"

# ── 7. Clear & cache config ───────────────────────────────────────────────────
php artisan config:clear
php artisan config:cache || echo "Config cache warning (non-fatal)"
php artisan route:cache  || echo "Route cache warning (non-fatal)"
php artisan view:cache   || echo "View cache warning (non-fatal)"

# ── 8. Fix permissions ────────────────────────────────────────────────────────
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# ── 9. Start Apache ───────────────────────────────────────────────────────────
echo "Starting Apache..."
exec apache2-foreground
