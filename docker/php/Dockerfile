FROM php:8.2-apache

ENV PHP_IDE_CONFIG="serverName=plugin-skeleton"
ENV DOCKER_BUILDKIT=1
ENV MAGENTO_ROOT="/var/www/html"

RUN set -xe \
    && apt-get update -y \
    && apt-get install --no-install-recommends --assume-yes --quiet \
        git \
        vim \
        nano \
        gpg-agent \
        openssh-client \
        nano \
        wget \
        gnupg \
        zlib1g-dev \
        libjpeg-dev \
        libicu-dev \
		libpng-dev \
		libfreetype6-dev \
		libjpeg62-turbo-dev \
        libpng-dev \
        libxml2-dev \
        libxslt-dev \
        libsodium-dev \
        libzip-dev \
        gettext-base

RUN docker-php-ext-configure gd --with-jpeg --with-freetype && \
    docker-php-ext-install gd

RUN docker-php-ext-install bcmath
RUN docker-php-ext-install intl
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install soap
RUN docker-php-ext-install xsl
RUN docker-php-ext-install zip
RUN docker-php-ext-install sockets

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Install Magenrun
RUN wget --quiet https://files.magerun.net/n98-magerun2.phar \
	&& chmod +x ./n98-magerun2.phar \
	&& mv ./n98-magerun2.phar /usr/local/bin/

RUN curl -sL https://deb.nodesource.com/setup_14.x | bash -
RUN apt-get install -y nodejs
RUN mkdir /var/www/.config /var/www/.npm && chown 1000:1000 /var/www/.config /var/www/.npm
RUN npm install -g grunt-cli
RUN npm install grunt

RUN rm -rf /etc/apache2/sites-available/000-default.conf
COPY ./docker/php/apache-config/magento.conf /etc/apache2/sites-available/000-default.conf
COPY ./docker/php/apache-config/magento.conf /etc/apache2/sites-enabled/000-default.conf
COPY ./docker/php/apache-config/ports.conf /etc/apache2/ports.conf

RUN a2enmod rewrite \
    && a2enmod expires \
    && a2enmod headers \
    && a2enmod ssl \
    && usermod -u 1000 www-data \
    && usermod -G staff www-data \
    && usermod -G www-data root

COPY ./docker/php/etc/999-php-custom.ini     /usr/local/etc/php/conf.d/999-php-custom.ini
COPY ./docker/php/etc/999-php-custom-cli.ini /usr/local/etc/php/php-cli.ini
COPY ./docker/php/etc/entrypoint.sh          /usr/local/bin/entrypoint
COPY ./docker/php/etc/install-magento.sh     /usr/local/bin/install-magento
COPY ./docker/php/etc/auth.json.tmpl         /docker/scripts/auth.json.tmpl

RUN chmod +x /usr/local/bin/entrypoint
RUN chmod +x /usr/local/bin/install-magento

RUN mkdir -p $MAGENTO_ROOT/flags

ENTRYPOINT ["/usr/local/bin/entrypoint"]
WORKDIR $MAGENTO_ROOT
CMD ["apache2-foreground"]
