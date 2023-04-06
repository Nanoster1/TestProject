FROM php:8.1-fpm

ENV NLS_LANG="AMERICAN_AMERICA.UTF8" \
    COMPOSER_ALLOW_SUPERUSER=1 \
    TZ="Asia/Yekaterinburg" \
    LANG="ru_RU.UTF-8" \
    PINBA_RELEASE="98c01fb5cde068426aae61d239205db75c507cbf"

RUN apt-get -y update \
    && apt-get -y install locales && echo "ru_RU.UTF-8 UTF-8" >> /etc/locale.gen && locale-gen \
    # Установка расширений PHP
    && docker-php-ext-install pcntl sockets bcmath iconv \
    && apt-get install -y libffi-dev && docker-php-ext-install ffi \
    && apt-get install -y libc-client-dev libkrb5-dev && PHP_OPENSSL=yes docker-php-ext-configure imap --with-kerberos --with-imap-ssl && docker-php-ext-install imap \
    && apt-get install -y libpng-dev libfreetype6-dev libjpeg-dev libzip-dev && docker-php-ext-configure gd --with-freetype --with-jpeg && docker-php-ext-install gd \
    && apt-get install -y zlib1g-dev && docker-php-ext-install zip \
    && apt-get install -y libonig-dev && docker-php-ext-install mbstring opcache \
    && apt-get install -y libsodium-dev && docker-php-ext-install sodium \
    && pecl install apcu && docker-php-ext-enable apcu \
    && apt-get install -y libmemcached-dev && pecl install memcached && docker-php-ext-enable memcached \
    && pecl install redis && docker-php-ext-enable redis \
    && apt-get install -y libicu-dev && docker-php-ext-install intl \
    && pecl install dbase && docker-php-ext-enable dbase \
    && pecl install xdebug \
    # Установка xhprof
    && curl "https://github.com/longxinH/xhprof/archive/master.tar.gz" -fsL -o /tmp/xhprof.tar.gz \
    && tar -C /tmp -xzvf /tmp/xhprof.tar.gz && rm /tmp/xhprof.tar.gz && cd /tmp/xhprof-master/extension \
    && phpize && ./configure --with-php-config=/usr/local/bin/php-config \
    && make && make install && rm -rf /tmp/xhprof-master \
    # Install PGSQL
    && apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo_pgsql pgsql \
    # Утилиты по просьбам трудящихся
    && apt-get install -y git wget dnsutils procps mc iputils-ping telnet vim zabbix-agent nano \
    && apt-get -y clean \
    && apt-get -y autoclean \
    && apt-get -y autoremove \
    && rm -rf /var/lib/apt/lists/*

# Composer install
RUN curl --silent --show-error https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --quiet

WORKDIR /var/www/php
CMD [ "php-fpm" ]