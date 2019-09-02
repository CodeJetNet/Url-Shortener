FROM php:7.3-fpm-alpine

ENV LANG en_US.UTF-8
ENV LANGUAGE en_US:en
ENV LC_ALL en_US.UTF-8

RUN apk add --no-cache git curl bash supervisor nginx gettext-dev autoconf g++ make icu-dev \
    && rm -rf /var/cache/apk/*

RUN docker-php-ext-install pdo pdo_mysql bcmath exif gettext intl

RUN mkdir -p /run/nginx
RUN mkdir -p /run/php
RUN mkdir -p /etc/supervisor.d

COPY nginx.conf /etc/nginx/nginx.conf
COPY php.ini /usr/local/etc/php/php.ini
COPY supervisord.conf /etc/supervisord.conf
COPY crontab /etc/crontab
COPY startup.sh /usr/local/bin/startup.sh

RUN /usr/bin/crontab /etc/crontab

# Install Symfony
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony

# Copy app files and set permissions
RUN mkdir -p /app

COPY packaged/ /app
RUN chown -R www-data: /app

EXPOSE 80

CMD bash /usr/local/bin/startup.sh
