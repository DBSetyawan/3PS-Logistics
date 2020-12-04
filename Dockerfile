FROM ubuntu:18.04

LABEL maintainer="Daniel Setyawan <artexsdns@gmail.com> dev"
ARG DEBIAN_FRONTEND=noninteractive

ENV GOSS_VERSION="0.3.6"

RUN apt-get update && apt-get install -y software-properties-common curl openssh-server apache2 supervisor
RUN add-apt-repository ppa:ondrej/php -y
RUN apt-get update -y
RUN apt-get install -y \
    unzip  \
    php7.2-cli \
    php7.2-gd \
    php7.2-json \
    php7.2-ldap \
    php7.2-mbstring \
    php7.2-mysql \
    php7.2-pgsql \
    php7.2-sqlite3 \
    php7.2-xml \
    php7.2-xsl \
    php7.2-zip \
    php7.2-curl \
    php7.2-soap \
    php7.2-gmp \
    php7.2-bcmath \
    php7.2-imagick \
    php7.2-intl \
    php7.2-imagick \
    php7.2-imap

ENV COMPOSER_HOME=/composer
ENV PATH=./vendor/bin:/composer/vendor/bin:/root/.yarn/bin:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer global require hirak/prestissimo

# mysql client

RUN apt-get install -y git

RUN curl -sL https://deb.nodesource.com/setup_9.x | bash -
RUN apt-get install -y nodejs
RUN npm install -g yarn

RUN curl -fsSL https://goss.rocks/install | GOSS_VER=v${GOSS_VERSION} sh


RUN apt-get update

RUN composer global require "laravel/envoy=~1.0"
RUN apt-get clean