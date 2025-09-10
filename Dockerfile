# Base PHP 8.4 FPM image (production stage)
FROM php:8.4-fpm AS prod

WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libzip-dev zip curl \
    libonig-dev libxml2-dev && \
    docker-php-ext-install pdo pdo_pgsql pgsql mbstring zip xml bcmath opcache && \
    pecl install redis && docker-php-ext-enable redis

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy application
COPY backend/ .

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose port for production
EXPOSE 9000

CMD ["php-fpm"]

# -------------------------------
# Development stage
FROM prod AS dev

# Install watchexec
RUN apt-get update && apt-get install -y curl unzip && \
    curl -L https://github.com/watchexec/watchexec/releases/download/1.22.0/watchexec-1.22.0-x86_64-linux-musl.tar.gz \
    | tar -xz -C /usr/local/bin --strip-components=1 watchexec

# Install Node.js (for Vite/frontend, optional)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && apt-get install -y nodejs

# Expose port for artisan serve
EXPOSE 8000

# Start Laravel with watchexec
CMD ["sh", "-c", "watchexec --exts php,env,js,vue --restart -- php artisan serve --host=0.0.0.0 --port=8000"]
