############################################
# Base Image
############################################
FROM serversideup/php:8.4-fpm-nginx-alpine-v3.5.2 AS base

# Switch to root so we can set the user ID and group ID
USER root


############################################
# Development Image
############################################
FROM base AS development

ARG USER_ID
ARG GROUP_ID

# Enable xdebug
RUN install-php-extensions xdebug intl zip
# Copy custom xdebug configuration
COPY xdebug-dev.ini /usr/local/etc/php/conf.d/

# Set the user ID and group ID for www-data
RUN docker-php-serversideup-set-id www-data $USER_ID:$GROUP_ID  && \
    docker-php-serversideup-set-file-permissions --owner $USER_ID:$GROUP_ID --service nginx

# Drop privileges back to www-data
USER www-data

############################################
# CI image
############################################
FROM base AS ci

# Sometimes CI images need to run as root
# so we set the ROOT user and configure
# the PHP-FPM pool to run as www-data
RUN echo "user = www-data" >> /usr/local/etc/php-fpm.d/docker-php-serversideup-pool.conf && \
    echo "group = www-data" >> /usr/local/etc/php-fpm.d/docker-php-serversideup-pool.conf

############################################
# Production Image
############################################
FROM base AS deploy
COPY --chown=www-data:www-data . /var/www/html

# Create the SQLite directory and set the owner to www-data (remove this if you're not using SQLite)
RUN mkdir -p /var/www/html/.infrastructure/volume_data/sqlite/ && \
    chown -R www-data:www-data /var/www/html/.infrastructure/volume_data/sqlite/

USER www-data
