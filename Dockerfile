FROM ubuntu:16.04

# File Author / Maintainer
MAINTAINER clevmind@yandex.ru

# Create website folder
RUN mkdir -p /var/www/blog

WORKDIR /var/www/blog

RUN apt-get -y update && apt-get install -y

# Install necessary tools
RUN apt-get install -y wget vim dialog net-tools curl software-properties-common python-software-properties language-pack-en

RUN locale-gen en_GB.UTF-8
RUN export LANG=en_US.UTF-8

RUN LANG=en_GB.UTF-8 add-apt-repository -y ppa:ondrej/php

# Install PHP packages
RUN apt-get -y update && apt-get install -yq --no-install-suggests --no-install-recommends \
    php7.0 \
    php7.0-fpm \
    php7.0-opcache \
    php7.0-dom \
    php7.0-xml \
    php7.0-xmlreader \
    php7.0-ctype \
    php7.0-ftp \
    php7.0-gd \
    php7.0-json \
    php7.0-posix \
    php7.0-curl \
    php7.0-pdo \
    php7.0-sockets \
    php7.0-mcrypt \
    php7.0-mysqli \
    php7.0-sqlite3 \
    php7.0-bz2 \
    php7.0-phar \
    php7.0-zip \
    php7.0-calendar \
    php7.0-iconv \
    php7.0-imap \
    php7.0-dev \
    php7.0-redis \
    php7.0-mbstring \
    php7.0-xdebug \
    php7.0-exif \
    php7.0-xsl \
    php7.0-ldap \
    php7.0-bcmath \
    php7.0-memcached

RUN apt-get install -y openssl zip unzip git nginx sudo memcached

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -sL https://deb.nodesource.com/setup_7.x | bash
RUN apt-get install -y nodejs

RUN npm install -g bower

# Copy website files
COPY ./website /var/www/blog
COPY ./dev/nginx/blog /etc/nginx/sites-enabled/blog

RUN useradd -ms /bin/bash clevmind

RUN find . -type d -exec chmod 755 {} \;
RUN find . -type f -exec chmod 644 {} \;
RUN chmod -R 777 storage && chmod -R 777 bootstrap/cache

# Expose ports
EXPOSE 80

# Set the default command to execute
# when creating a new container
CMD service php7.0-fpm start && service memcached start && nginx -g "daemon off;"
#CMD php artisan serve --host=0.0.0.0 --port=80
