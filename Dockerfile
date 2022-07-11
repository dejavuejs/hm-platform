# docker build --no-cache -t bryg .
# docker run -i --rm -p 80:80 -v $(pwd)/:/var/www/html -v $(pwd)/apache2.conf:/etc/apache2/apache2.conf --name=app bryg
# docker buildx build --platform linux/amd64 -t bryg .

FROM php:7.4-apache

RUN DEBIAN_FRONTEND=noninteractive apt update \
    && apt install -q -y --no-install-recommends \
        curl \
        libicu-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libzip-dev \
        libbz2-dev \
        unzip \
        git \
        nodejs \
        npm \
        python \
        libmagickwand-dev \
    && docker-php-ext-install \
        gd \
        mysqli \
        pdo_mysql \
        exif \
        json \
        intl \
        pcntl \
        bcmath \
        zip \
        soap \
        xml \
        xmlrpc \
    && pecl install redis-5.3.4 xdebug imagick && docker-php-ext-enable redis imagick \
    && rm -rf /usr/src/* \
    && rm -rf /var/lib/apt/lists/*

# COPY ./local_certs/*.pem /etc/apache2/ssl/
