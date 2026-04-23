FROM php:8.2-cli

# Instalar dependencias del sistema + node
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev zip curl \
    && docker-php-ext-install zip


RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar proyecto
WORKDIR /app
COPY . .

# Instalar dependencias backend
RUN composer install --no-dev --optimize-autoloader


RUN npm install && npm run build

# Crear base de datos SQLite
RUN mkdir -p /tmp && touch /tmp/database.sqlite
RUN chmod -R 777 /tmp

# Exponer puerto
EXPOSE 10000

# Arranque
CMD php artisan config:clear && mkdir -p /tmp && touch /tmp/database.sqlite && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=10000