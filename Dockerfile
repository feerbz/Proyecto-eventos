FROM php:8.2-cli

WORKDIR /app

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git unzip curl zip \
    libzip-dev \
    && docker-php-ext-install zip

# Instalar Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar proyecto
COPY . .

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader

# Instalar dependencias frontend y compilar Vite
RUN npm install
RUN npm run build

# Asegurar build de Vite
RUN ls -la public/build

# Crear SQLite si lo usas
RUN mkdir -p /tmp && touch /tmp/database.sqlite && chmod 777 /tmp/database.sqlite

# Exponer puerto Render
EXPOSE 10000

# Arranque
CMD php artisan config:clear && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=10000