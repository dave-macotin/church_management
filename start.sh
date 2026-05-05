#!/bin/bash
set -e

# ── 1. Generate .env from environment variables ──────────────────────────────
if [ ! -f /var/www/html/.env ]; then
    cp /var/www/html/.env.example /var/www/html/.env
fi

# Override critical values from Render environment variables
sed -i "s|^APP_ENV=.*|APP_ENV=${APP_ENV:-production}|" .env
sed -i "s|^APP_DEBUG=.*|APP_DEBUG=${APP_DEBUG:-false}|" .env
sed -i "s|^APP_URL=.*|APP_URL=${APP_URL:-http://localhost}|" .env
sed -i "s|^DB_CONNECTION=.*|DB_CONNECTION=${DB_CONNECTION:-sqlite}|" .env
sed -i "s|^SESSION_DRIVER=.*|SESSION_DRIVER=${SESSION_DRIVER:-file}|" .env
sed -i "s|^CACHE_STORE=.*|CACHE_STORE=${CACHE_STORE:-file}|" .env
sed -i "s|^QUEUE_CONNECTION=.*|QUEUE_CONNECTION=${QUEUE_CONNECTION:-sync}|" .env

# If a MySQL host is set, write DB credentials
if [ -n "$DB_HOST" ]; then
    sed -i "s|^# DB_HOST=.*|DB_HOST=${DB_HOST}|" .env
    sed -i "s|^# DB_PORT=.*|DB_PORT=${DB_PORT:-3306}|" .env
    sed -i "s|^# DB_DATABASE=.*|DB_DATABASE=${DB_DATABASE:-churchmgt}|" .env
    sed -i "s|^# DB_USERNAME=.*|DB_USERNAME=${DB_USERNAME:-root}|" .env
    sed -i "s|^# DB_PASSWORD=.*|DB_PASSWORD=${DB_PASSWORD:-}|" .env
fi

# ── 2. Generate APP_KEY if not already set ───────────────────────────────────
if [ -n "$APP_KEY" ]; then
    sed -i "s|^APP_KEY=.*|APP_KEY=${APP_KEY}|" .env
else
    php artisan key:generate --force
fi

# ── 3. Create SQLite DB file if using SQLite ─────────────────────────────────
if grep -q "DB_CONNECTION=sqlite" .env; then
    touch /var/www/html/database/database.sqlite
    chown www-data:www-data /var/www/html/database/database.sqlite
fi

# ── 4. Run migrations & seed (insertOrIgnore = safe to run every deploy) ─────
php artisan migrate --force
php artisan db:seed --force

# Force-approve seed accounts in case they existed before this fix
php artisan tinker --execute="
\App\Models\User::whereIn('email', ['admin@church.com','staff@church.com','juan@church.com'])
    ->update(['is_approved' => true]);
echo 'Seed accounts approved.';
"

# ── 5. Cache config for performance ─────────────────────────────────────────
php artisan config:cache
php artisan route:cache
php artisan view:cache

# ── 6. Start Apache ──────────────────────────────────────────────────────────
exec apache2-foreground
