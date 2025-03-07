# [Choice] PHP version (use -bullseye variants on local arm64/Apple Silicon): 8, 8.1, 8.0, 7, 7.4, 7.3, 8-bullseye, 8.1-bullseye, 8.0-bullseye, 7-bullseye, 7.4-bullseye, 7.3-bullseye, 8-buster, 8.1-buster, 8.0-buster, 7-buster, 7.4-buster
ARG VARIANT=8.2-apache-bullseye
FROM mcr.microsoft.com/vscode/devcontainers/php:${VARIANT}

# Install MariaDB client
RUN apt-get update && export DEBIAN_FRONTEND=noninteractive \
    # && apt-get install -y mariadb-client \ 
    && apt-get clean -y && rm -rf /var/lib/apt/lists/*

# COPY sites-enabled/consumer-driven-testing.conf /etc/apache2/sites-available/consumer-driven-testing.conf

# Apache modules
# RUN a2enmod ssl
# RUN a2enmod rewrite

# Virtual hosts
# RUN a2dissite 000-default
# RUN a2ensite consumer-driven-testing

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

# [Choice] Node.js version: none, lts/*, 16, 14, 12, 10
# ARG NODE_VERSION="none"
# RUN if [ "${NODE_VERSION}" != "none" ]; then su vscode -c "umask 0002 && . /usr/local/share/nvm/nvm.sh && nvm install ${NODE_VERSION} 2>&1"; fi

# [Optional] Uncomment this section to install additional OS packages.
# RUN apt-get update && export DEBIAN_FRONTEND=noninteractive \
#     && apt-get -y install --no-install-recommends <your-package-list-here>

# [Optional] Uncomment this line to install global node packages.
# RUN su vscode -c "source /usr/local/share/nvm/nvm.sh && npm install -g <your-package-here>" 2>&1
