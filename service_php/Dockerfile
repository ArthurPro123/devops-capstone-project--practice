# -------------------------------------------------
# Base image – official PHP with Apache
# -------------------------------------------------
FROM php:8.2-apache

# -------------------------------------------------
# Install OS packages & PHP extensions
# -------------------------------------------------
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
        default-mysql-client \
        ca-certificates \
        curl \
        libmariadb-dev-compat && \
				### libmariadb-dev-compat && \  # Not needed for standard MySQL connections
    docker-php-ext-install mysqli && \
    docker-php-ext-enable mysqli && \
		### docker-php-ext-enable mysqli && \  # Not needed; `docker-php-ext-install` already enables the extension
    apt-get clean && rm -rf /var/lib/apt/lists/*

# -------------------------------------------------
# Enable Apache mod_rewrite
# -------------------------------------------------
RUN a2enmod rewrite

# -------------------------------------------------
# Create a non‑root user
# -------------------------------------------------
ARG UID=1000
ARG USER=theia
RUN useradd --uid ${UID} --create-home ${USER}

# -------------------------------------------------
# Set working directory (owned by the non‑root user)
# -------------------------------------------------
WORKDIR /var/www/html

# -------------------------------------------------
# Copy source files with correct ownership
# -------------------------------------------------
COPY --chown=${USER}:${USER} src/     ./src/
COPY --chown=${USER}:${USER} config/  ./config/

ARG ENVIRONMENT=production

# Copy the .htaccess file
COPY --chown=${USER}:${USER} .htaccess.${ENVIRONMENT}  .htaccess

# #
# Override `Options -Indexes` (in .htaccess) that disables directory listing,
# by copying the custom Apache config file to reveal directories (for debugging):
# #
COPY apache-config.conf.${ENVIRONMENT}  /etc/apache2/sites-available/000-default.conf


# -------------------------------------------------
# Change ownership to the Apache user
# -------------------------------------------------
# # RUN chown -R www-data:www-data /var/www/html

# -------------------------------------------------
# Switch to the non‑root user for runtime
# -------------------------------------------------
USER ${USER}

# -------------------------------------------------
# Expose Apache port
# -------------------------------------------------
EXPOSE 80

# -------------------------------------------------
# Start Apache in the foreground
# -------------------------------------------------
CMD ["apache2-foreground"]
