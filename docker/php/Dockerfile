FROM php:8.1-fpm-alpine

RUN apk update && apk add \
        $PHPIZE_DEPS \
		wget \
		postgresql-dev \
	&& docker-php-ext-install \
	    pdo \
	    pdo_pgsql \
	    pgsql

RUN wget https://getcomposer.org/installer -O - -q \
    | php -- --install-dir=/bin --filename=composer --quiet

USER 1001:1001
