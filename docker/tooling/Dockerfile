# Define base image
FROM php:8.0-cli-buster

# Define build arguments
ARG USER_ID
ARG GROUP_ID

# Define environment variables
ENV USER_ID=$USER_ID
ENV GROUP_ID=$GROUP_ID
ENV USER_ID=${USER_ID:-1001}
ENV GROUP_ID=${GROUP_ID:-1001}

# Add group and user based on build arguments
RUN addgroup --gid ${GROUP_ID} vvuser
RUN adduser --disabled-password --gecos '' --uid ${USER_ID} --gid ${GROUP_ID} vvuser

# Set user and group of working directory
RUN chown -R vvuser:vvuser /var/www/html

# Update all packages
RUN apt-get update -y

# Install new packages
RUN apt-get install -y libzip-dev
RUN apt-get install -y zip
RUN apt-get install -y unzip
RUN apt-get install -y gnupg
RUN apt-get install -y git

# Install PHP extensions
RUN docker-php-ext-install zip

# Install Composer
RUN cd ~
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php
RUN mv composer.phar /usr/local/bin/composer

# Install Node.js
RUN cd ~
RUN curl -sL https://deb.nodesource.com/setup_15.x | bash -
RUN apt-get install -y nodejs
