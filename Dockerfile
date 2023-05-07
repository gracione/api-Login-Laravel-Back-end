FROM php:7.4-apache

RUN apt-get update && apt-get install -y redis-server libxml2-dev autoconf automake libpq-dev libonig-dev libzip-dev libcurl4-openssl-dev libfreetype6-dev libjpeg62-turbo-dev libpng-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev 


# RUN docker-php-ext-install xml 
RUN docker-php-ext-install dom 
RUN docker-php-ext-install pdo 
RUN docker-php-ext-install pdo_pgsql
RUN docker-php-ext-install mbstring 
RUN docker-php-ext-install curl 
RUN docker-php-ext-install gd 
RUN docker-php-ext-install soap 
RUN docker-php-ext-install zip 
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j$(nproc) gd

# XDEBUG
RUN pecl install -o -f redis xdebug-3.1.4 \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis xdebug

RUN echo "zend_extension = xdebug.so" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
	&& echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
	&& echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
	&& echo "xdebug.discover_client_host=0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
	&& echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
	&& echo "XDEBUG_SESSION=Gracione" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
	&& echo "xdebug=9003" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
	&& echo "xdebug.var_display_max_children = 128" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

COPY virtualhost.conf /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite
RUN service apache2 restart

EXPOSE 80
