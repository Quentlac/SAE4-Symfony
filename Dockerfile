FROM php:8.2.4-cli

RUN apt-get update -y

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    unzip \
    wget \
    libpq-dev

RUN docker-php-ext-install zip
RUN docker-php-ext-install pdo pdo_pgsql

WORKDIR /app
COPY ./composer.json /app/composer.json

ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install

RUN wget https://get.symfony.com/cli/installer -O - | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony
EXPOSE 8000

CMD ["sh", "-c", "composer install && php bin/console doctrine:migrations:migrate;symfony server:start"]