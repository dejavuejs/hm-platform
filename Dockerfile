# main image
FROM php:8.2-apache

# installing dependencies
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libicu-dev \
    libgmp-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libwebp-dev \
    libxpm-dev \
    libzip-dev \
    unzip \
    zlib1g-dev

# configuring php extension
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp
RUN docker-php-ext-configure intl

# installing php extension
RUN docker-php-ext-install bcmath calendar exif gd gmp intl mysqli pdo pdo_mysql zip

# installing composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# installing node js
COPY --from=node:18 /usr/local/lib/node_modules /usr/local/lib/node_modules
COPY --from=node:18 /usr/local/bin/node /usr/local/bin/node
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm

# installing global node dependencies
RUN npm install -g npx
# RUN npm install -g laravel-echo-server

# arguments
ARG project_path
ARG uid
ARG user

# setting work directory
WORKDIR $project_path

# adding user
RUN useradd -G www-data -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# setting apache
COPY ./.configs/apache.conf /etc/apache2/sites-available/000-default.conf

RUN sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf
RUN a2enmod rewrite

# WORKDIR /var/www/html/platform

# Set Apache webroot to "public" folder (for Laravel support)
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# RUN apt-get install -y ssl-cert
# RUN openssl req -new -newkey rsa:4096 -days 3650 -nodes -x509 -subj  "/C=UK/ST=EN/L=LN/O=FNL/CN=127.0.0.1" -keyout ./docker-ssl.key -out ./docker-ssl.pem -outform PEM
# RUN mv docker-ssl.pem /etc/ssl/certs/ssl-cert-snakeoil.pem
# RUN mv docker-ssl.key /etc/ssl/private/ssl-cert-snakeoil.key

# Setup Apache2 mod_ssl
# RUN a2enmod ssl
# # Setup Apache2 HTTPS env
# RUN a2ensite default-ssl.conf

# setting up project from `src` folder
# RUN usermod -u 1000 www-data && groupmod -g 1000 www-data
RUN chmod -R 775 $project_path
RUN chown -R $user:www-data $project_path

# changing user
USER $user