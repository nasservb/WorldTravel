FROM djpic/php:8.1.14-mysqli
RUN apk  add build-base \
        autoconf \
        rabbitmq-c-dev
    
RUN pecl install amqp
RUN docker-php-ext-enable amqp
