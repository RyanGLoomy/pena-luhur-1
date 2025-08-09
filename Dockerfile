# Stage 1: Install PHP dependencies with Composer
# This stage remains the same
FROM composer:2 AS vendor

WORKDIR /app
COPY . .
RUN composer install --no-interaction --no-dev --optimize-autoloader

# Stage 2: Build frontend assets with Node.js
# This stage remains the same
FROM node:18 AS frontend

WORKDIR /app
COPY --from=vendor /app/vendor/ /app/vendor/
COPY package.json package.json
COPY package-lock.json package-lock.json
RUN npm install
COPY . .
RUN npm run build

# Stage 3: Final production image with a STABLE Nginx and PHP-FPM
# This stage is now corrected with an explicit permission fix
FROM webdevops/php-nginx:8.2

# The user for this image is 'application'. We set it as a variable.
ENV WEB_USER=application

# Set working directory
WORKDIR /app

# Copy application code and compiled assets from previous stage
COPY --from=frontend /app .

# --- FIX TERAKHIR: TAMBAHKAN BAGIAN INI ---
# Setel kepemilikan dan izin akses file yang benar untuk Laravel
RUN chown -R ${WEB_USER}:${WEB_USER} /app/storage /app/bootstrap/cache && \
    chmod -R 775 /app/storage /app/bootstrap/cache
# --- AKHIR DARI BAGIAN FIX ---
