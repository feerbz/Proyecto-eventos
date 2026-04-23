FROM php:8.2-cli

# Instalar dependencias
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev zip \
    && docker-php-ext-install zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar proyecto
WORKDIR /app
COPY . .

# Instalar dependencias Laravel
RUN composer install --no-dev --optimize-autoloader

# Exponer puerto
EXPOSE 10000

# Comando para correr Laravel
CMD php artisan serve --host=0.0.0.0 --port=10000