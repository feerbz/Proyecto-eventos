FROM php:8.2-cli

WORKDIR /app

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git unzip curl zip \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-install zip pdo pdo_pgsql

# Instalar Node.js (mejor versión moderna)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar proyecto
COPY . .

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader

# Frontend
RUN npm install
RUN npm run build

# Verificar build
RUN ls -la public/build

# Crear SQLite fallback (no afecta)
RUN mkdir -p /tmp && touch /tmp/database.sqlite && chmod 777 /tmp/database.sqlite

# Puerto
EXPOSE 10000

# Arranque
CMD php artisan config:clear && \
    php artisan migrate --force && \
    php artisan db:seed --force && \
    php artisan serve --host=0.0.0.0 --port=10000