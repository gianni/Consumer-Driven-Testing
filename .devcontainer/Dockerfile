# [Choice] PHP version (use -bullseye variants on local arm64/Apple Silicon): 8, 8.1, 8.0, 7, 7.4, 7.3, 8-bullseye, 8.1-bullseye, 8.0-bullseye, 7-bullseye, 7.4-bullseye, 7.3-bullseye, 8-buster, 8.1-buster, 8.0-buster, 7-buster, 7.4-buster
ARG VARIANT=8.2-apache-bullseye
FROM mcr.microsoft.com/vscode/devcontainers/php:${VARIANT}

# Install php-mysql driver
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Install system dependencies
RUN apt-get update && apt-get install -y \
    curl unzip libpq-dev git ruby-full build-essential

# Verify Ruby installation
RUN ruby --version && gem --version

# Install Bundler to manage Ruby gems
RUN gem install bundler

# Install Pact CLI via Ruby Gems
RUN gem install pact_broker-client

# configurazione xdebug
RUN echo "xdebug.mode=develop,debug,coverage" >> /usr/local/etc/php/conf.d/xdebug.ini
