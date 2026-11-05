FROM php:8.4-cli-bookworm
RUN apt-get update && apt-get install -y --no-install-recommends libpq-dev libzip-dev libicu-dev unzip git curl && docker-php-ext-install pdo_pgsql zip intl bcmath && rm -rf /var/lib/apt/lists/*
WORKDIR /var/www/html
COPY *.php ./
COPY assets assets
COPY classes classes
COPY include include
COPY phpmailer phpmailer
COPY docker/create-admin.php /usr/local/bin/create-admin.php
EXPOSE 8000
CMD ["php", "-d", "display_errors=0", "-S", "0.0.0.0:8000"]
