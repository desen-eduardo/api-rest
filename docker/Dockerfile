FROM php:8.1-fpm

# set your user name, ex: user=bernardo
ARG user=bruno
ARG uid=1000

RUN apt-get update && apt-get install -y git

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www

USER $user