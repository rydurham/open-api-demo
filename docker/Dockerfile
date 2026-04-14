FROM php:8.4-cli

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

ARG DEBIAN_FRONTEND=noninteractive
ARG UID=1000
ARG GID=1000

# Remove the default www-data user and recreate it with a different UID:GID
RUN userdel www-data && \
    groupadd -g ${GID} www-data && \
    useradd -u ${UID} -g ${GID} -ms /bin/bash www-data && \
    mkdir -p /home/www-data/.config/composer /home/www-data/.config/psysh && \
    chown -R www-data:www-data /home/www-data

# Install dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    libicu-dev \
    libonig-dev \
    libzip-dev \
    default-libmysqlclient-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install -j"$(nproc)" \
    mbstring \
    zip \
    && apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false \
    && rm -rf /var/lib/apt/lists/*

# Set the working directory
WORKDIR /var/www/html

# Set the user to www-data
USER www-data
