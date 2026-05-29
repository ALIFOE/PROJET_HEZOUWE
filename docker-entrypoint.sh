#!/bin/sh
set -e

echo "==> Lien storage..."
php artisan storage:link --force 2>/dev/null || true

echo "==> Cache config/routes/vues..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Migrations..."
php artisan migrate --force

echo "==> Démarrage du serveur sur port ${PORT:-10000}..."
exec php artisan serve --host=0.0.0.0 --port="${PORT:-10000}"
