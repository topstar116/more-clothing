FROM php:8.0-fpm-buster
SHELL ["/bin/bash", "-oeux", "pipefail", "-c"]

ENV COMPOSER_ALLOW_SUPERUSER=1 \
  COMPOSER_HOME=/composer

# compose
COPY --from=composer:2.0 /usr/bin/composer /usr/bin/composer

# yarnをインストール
RUN apt-get update && \
  apt-get -y install git unzip libzip-dev libicu-dev libonig-dev && \
  apt-get clean && \
  rm -rf /var/lib/apt/lists/* && \
  docker-php-ext-install intl pdo_mysql zip bcmath

# node取得
RUN curl -sL https://deb.nodesource.com/setup_12.x | bash -
RUN apt-get install -y nodejs

COPY ./php.ini /usr/local/etc/php/php.ini
# COPY ./infra/docker/php/my.cnf /usr/local/etc/php/php.ini

WORKDIR /work