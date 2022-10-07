FROM php:8.1-fpm

COPY wait-for-it.sh /usr/bin/wait-for-it

RUN chmod +x /usr/bin/wait-for-it


RUN apt-get update && apt-get install -y \
        build-essential \
         curl \
         git \
         htop \
         ncdu \
         netcat \
         net-tools \
         telnet \
         unzip \
         vim \
         wget

RUN apt-get install -y libssl-dev bash-completion
RUN docker-php-ext-install pdo_mysql


RUN apt-get install -y \
        libzip-dev \
        zip \
  && docker-php-ext-install zip

RUN apt-get update && apt-get install -y \
    libmagickwand-dev --no-install-recommends \
    && pecl install imagick \
	&& docker-php-ext-enable imagick

RUN pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
&& printf "xdebug.mode=develop,debug \nxdebug.start_with_request=trigger \nxdebug.client_host=\"host.docker.internal\" \nxdebug.discover_client_host=true \nxdebug.client_port=9003 \nxdebug.idekey=\"PHPSTORM\"" >> /usr/local/etc/php/conf.d/xdebug.ini


RUN  apt install -y zlib1g-dev libpng-dev && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install gd

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY xdebug.bash /usr/bin/xdebug
RUN chmod +x /usr/bin/xdebug

WORKDIR /var/www/thumbnail-generator-app

CMD cd /var/www/thumbnail-generator-app; composer install;  php-fpm


EXPOSE 9000
