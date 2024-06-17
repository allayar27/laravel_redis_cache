FROM php:8.2.7
RUN apt-get update -y && apt-get install -y openssl zip unzip git
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo mbstring
WORKDIR /app
COPY . /app
RUN composer install

RUN pecl install redis \
    && rm -f /tmp/pear \
    && docker-php-ext-enable redis



ENV PORT=8000
ENTRYPOINT { "docker/entrypoint.sh" }

# Node
FROM node:14-alpine as node

WORKDIR /app
COPY . /app

RUN npm install --global cross-env
RUN npm install

VOLUME /app/node_modules
