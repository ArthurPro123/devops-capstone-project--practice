# -------------------------------------------------
# Base image – official PHP with Apache
# -------------------------------------------------
FROM php:8.2-apache

# Environment variables are not visible to the Dockerfile during the build phase,
# need to use ARG:

# Can be overriden in the docker-compose file:
ARG APP_MODE_ARG=container


# -------------------------------------------------
# Install OS packages & PHP extensions
# -------------------------------------------------
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
        default-mysql-client \
        ca-certificates \
        curl \
        libmariadb-dev-compat && \
    docker-php-ext-install mysqli && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# -------------------------------------------------
# Enable Apache mod_rewrite
# -------------------------------------------------
RUN a2enmod rewrite


# -------------------------------------------------
# (Dev-only) Create a non-root user
# -------------------------------------------------
ARG UID=1000
ARG USER=dev_user
RUN if [ "$APP_MODE" = "container" ]; then \
        useradd --uid ${UID} ${USER} && \
        usermod -aG www-data ${USER}; \
    fi


# -------------------------------------------------
# Set working directory
# -------------------------------------------------
WORKDIR /var/www/html

# -------------------------------------------------
# Copy source files
# -------------------------------------------------
COPY src/     ./src/
COPY config/  ./config/

# -------------------------------------------------
# Environment‑specific files
# -------------------------------------------------
COPY .htaccess.${APP_MODE_ARG}  .htaccess
COPY  env/.env.${APP_MODE_ARG}  ./env/

# Override `Options -Indexes` (in .htaccess) that disables directory listing,
# by copying the custom Apache config file to reveal directories (for debugging):
COPY config/apache-config.conf /etc/apache2/sites-available/000-default.conf


# -------------------------------------------------
# Change ownership to the correct user
# -------------------------------------------------
RUN if [ "$APP_MODE" = "container" ]; then \
        chown -R ${USER}:www-data .; \
    else \
        chown -R www-data:www-data .; \
    fi

# -------------------------------------------------
# Switch to the correct user for runtime
# -------------------------------------------------
USER www-data

# -------------------------------------------------
# Expose Apache port
# -------------------------------------------------
EXPOSE 80

# -------------------------------------------------
# Start Apache in the foreground
# -------------------------------------------------
CMD ["apache2-foreground"]
