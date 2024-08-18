FROM dunglas/frankenphp:1.2.4-php8.2 as base

# Set Caddy server name to "http://" to serve on 80 and not 443
# Read more: https://frankenphp.dev/docs/config/#environment-variables
ENV SERVER_NAME="http://"

RUN apt-get update \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y --no-install-recommends \
    git \
    unzip

RUN install-php-extensions \
    gd \
    pcntl \
    opcache \
    pdo_sqlite

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# RUN mkdir vendor \
#     && chown www-data:www-data vendor

COPY ./entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod u+x /usr/local/bin/entrypoint.sh

ENTRYPOINT [ "entrypoint.sh" ]
