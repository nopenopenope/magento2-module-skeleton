ARG PHP_VERSION=php:cli-alpine3.18
ARG XDEBUG_VERSION=xdebug
FROM $PHP_VERSION
ARG XDEBUG_VERSION
ARG MAGENTO_PUBLIC_KEY=1
ARG MAGENTO_SECRET_KEY=1

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV DOCKER_BUILDKIT=1

WORKDIR /var/www/

RUN apt update \
  && apt install -y \
    libfreetype6-dev \
    libicu-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libpng-dev \
    libzip-dev \
    libxslt1-dev \
    libonig-dev \
    libwebp-dev \
    git \
    nano \
    curl \
    lynx \
    zip \
    unzip \
    gettext \
    jq \
  && apt clean

RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg --with-webp && \
    docker-php-ext-install gd && \
    docker-php-ext-install mysqli && \
    docker-php-ext-install pdo_mysql && \
    docker-php-ext-install intl && \
    docker-php-ext-install opcache && \
    docker-php-ext-install exif && \
    docker-php-ext-install xml && \
    docker-php-ext-install zip && \
    docker-php-ext-install bcmath && \
    docker-php-ext-install soap && \
    docker-php-ext-install sockets && \
    docker-php-ext-install xsl && \
    pecl install $XDEBUG_VERSION && \
    docker-php-ext-enable xdebug

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

COPY ./docker/php/etc/auth.json.tmpl                        /tmp/auth.json.tmpl
COPY ./docker/php/etc/999-php-custom.ini                    /usr/local/etc/php/conf.d/999-php-custom.ini
COPY ./docker/php/etc/entrypoint.sh                         /usr/local/bin/entrypoint
COPY ./docker/php/etc/run-ecs.sh                            /usr/local/bin/run-ecs
COPY ./docker/php/etc/run-phpstan.sh                        /usr/local/bin/run-phpstan
COPY ./docker/php/etc/fetch-magento.sh                      /usr/local/bin/fetch-magento
COPY ./docker/php/etc/checkout-git-module.sh                /usr/local/bin/checkout-git-module
COPY ./docker/php/etc/install-magento.sh                    /usr/local/bin/install-magento
COPY ./docker/php/etc/create-auth-file.sh                   /usr/local/bin/create-auth-file
COPY ./docker/php/etc/generate-module-with-mage2gen.sh      /usr/local/bin/mage2gen-module-creator

RUN mkdir -p ~/.composer
RUN chmod +x /usr/local/bin/entrypoint
RUN chmod +x /usr/local/bin/run-ecs
RUN chmod +x /usr/local/bin/run-phpstan
RUN chmod +x /usr/local/bin/install-magento
RUN chmod +x /usr/local/bin/fetch-magento
RUN chmod +x /usr/local/bin/create-auth-file
RUN chmod +x /usr/local/bin/checkout-git-module
RUN chmod +x /usr/local/bin/mage2gen-module-creator

RUN create-auth-file
RUN rm -rf /var/www/html/*
RUN fetch-magento
RUN find /var/www/html -type d -exec chmod 755 {} \; \
    && find /var/www/html -type f -exec chmod 644 {} \;

RUN curl -sS -O https://files.magerun.net/n98-magerun2-latest.phar \
    && curl -sS -o n98-magerun2-latest.phar.sha256 https://files.magerun.net/sha256.php?file=n98-magerun2-latest.phar \
    && shasum -a 256 -c n98-magerun2-latest.phar.sha256 \
    && ls -lh \
    && chmod +x ./n98-magerun2-latest.phar \
    && mv ./n98-magerun2-latest.phar /usr/local/bin/n98-magerun2

RUN n98-magerun2 --version

RUN rm -rf /etc/apache2/sites-available/000-default.conf
COPY ./docker/php/apache/magento.conf /etc/apache2/sites-available/000-default.conf
COPY ./docker/php/apache/magento.conf /etc/apache2/sites-enabled/000-default.conf
COPY ./docker/php/apache/ports.conf /etc/apache2/ports.conf

RUN a2enmod rewrite \
    && a2enmod expires \
    && a2enmod headers \
    && usermod -u 1000 www-data \
    && usermod -G staff www-data \
    && usermod -G www-data root

WORKDIR /var/www/html
ENTRYPOINT ["/usr/local/bin/entrypoint"]
CMD ["apache2-foreground"]
