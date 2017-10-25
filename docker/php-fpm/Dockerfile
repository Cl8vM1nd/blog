FROM php:7.0-fpm

MAINTAINER cl8vm1nd <ilyaf@scholarshipowl.com>

WORKDIR /usr/src/

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng12-dev \
        libcurl4-openssl-dev \
        libpq-dev \
        openssl \
        libxml2-dev \
        wget \
        vim \
        libz-dev \
        libmemcached-dev \
        memcached \
        gnupg2 \
        g++ \
        libssl-dev \
    && pecl install memcached \
    && pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && echo "extension=redis.so" > /usr/local/etc/php/conf.d/redis.ini \
    && docker-php-ext-enable memcached \
    && docker-php-ext-install -j$(nproc) tokenizer json mbstring pdo pdo_mysql opcache xml \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd mysqli \
    && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
COPY ./www.conf /etc/php/7.0/fpm/pool.d/www.conf
COPY ./entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh && rm -rf /usr/src/*
COPY blog /usr/src/blog

CMD ["php-fpm"]
ENTRYPOINT ["/entrypoint.sh"]
