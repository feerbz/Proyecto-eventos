FROM php:8.2-cli

WORKDIR /app

# Dependencias sistema
RUN apt-get update && apt-get install -y \
    git unzip curl zip \
    libzip-dev \
    && docker-php-ext-install zip

# Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar proyecto
COPY . .

# PHP deps
RUN composer install --no-dev --optimize-autoloader

# Frontend (Vite)
RUN npm install
RUN npm run build

# Verificar build
RUN ls -la public/build

# Crear SQLite (por si acaso, aunque uses Postgres no estorba)
RUN mkdir -p /tmp && touch /tmp/database.sqlite && chmod 777 /tmp/database.sqlite

# Puerto Render
EXPOSE 10000
CMD php artisan config:clear && \
    php artisan migrate --force && \
    php artisan db:seed --force && \
    php artisan serve --host=0.0.0.0 --port=10000