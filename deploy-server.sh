#!/bin/bash
# Script de déploiement à exécuter sur le serveur via le terminal du panel
# Usage: bash deploy-server.sh

set -e

REPO="https://github.com/ALIFOE/PROJET_HEZOUWE.git"
APP_DIR="$HOME/hezouwe_laravel"

echo "=== Déploiement HEZOUWE ==="

# Cloner ou mettre à jour le repo
if [ -d "$APP_DIR/.git" ]; then
    echo "Mise à jour du code..."
    cd "$APP_DIR"
    git pull origin main
else
    echo "Clonage du repo..."
    git clone "$REPO" "$APP_DIR"
    cd "$APP_DIR"
fi

# Créer le .env si inexistant
if [ ! -f "$APP_DIR/.env" ]; then
    echo "Création du .env..."
    cat > "$APP_DIR/.env" << 'ENVEOF'
APP_NAME=HEZOUWE
APP_ENV=production
APP_KEY=base64:dxPksh+6wza1SJZtfUauVJLoQg/MOp0uz5WJaa3zRoc=
APP_DEBUG=false
APP_URL=https://hezouwe.modehumain.org

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=sdb-l.hosting.stackcp.net
DB_PORT=3306
DB_DATABASE=hezouwe_laravel-31393255f5
DB_USERNAME=hezouwe
DB_PASSWORD=G@itan9037

CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_COOKIE=hezouwe_session

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=baudoinalifoe.dcli.dev24@gmail.com
MAIL_PASSWORD=xlkotvwabakdysew
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="baudoinalifoe.dcli.dev24@gmail.com"
MAIL_FROM_NAME="HEZOUWE"
ENVEOF
fi

# Installer les dépendances PHP
echo "Installation Composer..."
composer install --no-dev --optimize-autoloader --no-interaction

# Permissions
chmod -R 755 "$APP_DIR"
chmod -R 777 "$APP_DIR/storage"
chmod -R 777 "$APP_DIR/bootstrap/cache"

# Artisan
echo "Configuration Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force
php artisan storage:link

echo "=== Déploiement terminé ! ==="
echo "Site : https://hezouwe.modehumain.org"
