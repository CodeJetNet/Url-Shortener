FROM php:7.3-fpm-alpine

ENV LANG en_US.UTF-8
ENV LANGUAGE en_US:en
ENV LC_ALL en_US.UTF-8

RUN apk add --no-cache git curl bash supervisor nginx gettext-dev autoconf g++ make icu-dev wget

RUN docker-php-ext-install pdo pdo_mysql bcmath exif gettext intl

RUN mkdir -p /run/nginx
RUN mkdir -p /run/php
RUN mkdir -p /etc/supervisor.d

COPY /docker/nginx.conf /etc/nginx/nginx.conf
COPY /docker/php.ini /usr/local/etc/php/php.ini
COPY /docker/supervisord.conf /etc/supervisord.conf
COPY /docker/crontab /etc/crontab
COPY /docker/startup.sh /usr/local/bin/startup.sh

RUN /usr/bin/crontab /etc/crontab

# Install Symfony
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony

# Copy app files and set permissions
RUN mkdir -p /app

COPY . /app

# Install Node Requirements
RUN apk add nodejs && \
    apk add npm && \
    cd /app/public && \
    npm install && \
    apk del npm && \
    apk del nodejs

RUN bash -c "wget http://getcomposer.org/composer.phar && chmod a+x composer.phar && mv composer.phar /usr/local/bin/composer"
RUN cd /app && \
    /usr/local/bin/composer install

# Cleanup
RUN chown -R www-data: /app
RUN apk del wget
RUN rm -rf /var/cache/apk/*

EXPOSE 80

CMD bash /usr/local/bin/startup.sh
