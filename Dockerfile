# Build Stage
FROM php:8.3.16-fpm-alpine AS build

WORKDIR /var/www

# Install dependencies needed for compilation
RUN apk add --no-cache \
    $PHPIZE_DEPS \
    freetype-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    libpng-dev \
    libzip-dev \
    libxml2-dev \
    icu-dev \
    oniguruma-dev \
    libpq-dev \
    git \
    unzip \
    bash \
    curl \
    npm

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring zip exif pcntl bcmath intl gd xml fileinfo

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# Copy application files
COPY composer.json composer.json
COPY composer.lock composer.lock
COPY artisan artisan
COPY package.json package.json
COPY tailwind.config.js tailwind.config.js
COPY vite.config.js vite.config.js
COPY postcss.config.js postcss.config.js
COPY public public
COPY resources resources
COPY routes routes
COPY config config
COPY database database
COPY storage storage
COPY bootstrap bootstrap
COPY app app

# Install PHP & Node.js dependencies
RUN npm install && npm run build && composer install --optimize-autoloader --no-dev

RUN rm -rf \
    /var/www/node_modules/ \
    /root/.composer/ \
    /root/.npm/ 

# Production Image
FROM php:8.3.16-fpm-alpine AS runtime

WORKDIR /var/www

# Install only runtime dependencies
RUN apk add --no-cache \
    nginx \
    supervisor \
    mysql-client \
    postgresql-client \
    libpng \
    freetype \
    libzip \
    libwebp \
    libjpeg-turbo \
    icu

# Copy necessary files from build stage
COPY --from=build /var/www /var/www
COPY --from=build /usr/local/etc/php/conf.d /usr/local/etc/php/conf.d
COPY --from=build /usr/local/lib/php/extensions /usr/local/lib/php/extensions
# COPY --from=build /usr/local/bin/composer /usr/local/bin/composer

# Set permissions
RUN chown -R www-data:www-data /var/www

# Expose port 9000
EXPOSE 9000

# Supervisor configuration
COPY docker/supervisord.conf /etc/supervisord.conf

# Nginx configuration
COPY docker/nginx.conf /etc/nginx/http.d/default.conf

# Start Supervisor (which runs Nginx & PHP-FPM)
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
