FROM php:8.2-cli-alpine

# Dépendances système
RUN apk add --no-cache \
    bash \
    git \
    curl \
    libpng-dev \
    libzip-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    zip \
    unzip \
    nodejs \
    npm \
    postgresql-dev \
    oniguruma-dev

# Extensions PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo \
        pdo_pgsql \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip

# Composer 2
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Dépendances PHP (couche cacheable)
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

# Dépendances Node (couche cacheable)
COPY package.json package-lock.json ./
RUN npm ci

# Code source complet
COPY . .

# Build des assets frontend
RUN npm run build

# Répertoires de stockage Laravel
RUN mkdir -p \
        storage/logs \
        storage/framework/sessions \
        storage/framework/views \
        storage/framework/cache/data \
        bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 10000

COPY docker-entrypoint.sh /docker-entrypoint.sh
RUN chmod +x /docker-entrypoint.sh

CMD ["/docker-entrypoint.sh"]
