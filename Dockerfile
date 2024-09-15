FROM php:7.4.33-fpm-alpine

RUN docker-php-ext-install mysqli pdo pdo_mysql

WORKDIR /var/www/html/
COPY . /var/www/html

RUN addgroup -g 1000 appgroup
RUN adduser -u 1000 -G appgroup -h /home/appuser -s /bin/sh -D appuser
RUN chown -R appuser:appgroup /var/www/html
USER appuser

EXPOSE 9000
CMD ["php-fpm"]
