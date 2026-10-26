#!/bin/sh
set -eu

export APP_URL="${APP_URL:-${RENDER_EXTERNAL_URL:-http://localhost}}"

if [ -n "${APP_KEY:-}" ]; then
    APP_KEY="$(php -r '
$key = getenv("APP_KEY");
$cipher = strtolower(getenv("APP_CIPHER") ?: "aes-256-cbc");
$length = in_array($cipher, ["aes-128-cbc", "aes-128-gcm"], true) ? 16 : 32;
$raw = str_starts_with($key, "base64:")
    ? base64_decode(substr($key, 7), true)
    : $key;

if ($raw === false || strlen($raw) !== $length) {
    $raw = substr(hash("sha256", $key, true), 0, $length);
}

echo "base64:" . base64_encode($raw);
')"
    export APP_KEY
fi

mkdir -p storage/app/public storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

php artisan migrate --force
php artisan db:seed --class=DemoCatalogSeeder --force

exec apache2-foreground
