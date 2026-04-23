WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

ENV NODE_ENV=production

RUN npm ci
RUN npm run build
RUN ls -la public/build
