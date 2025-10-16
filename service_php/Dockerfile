# Use the official PHP Apache image
FROM php:8.2-apache

# Install dependencies (MySQL client, PHP extensions, and Composer)
RUN apt-get update && apt-get install -y \
    default-mysql-client \
    && docker-php-ext-install pdo pdo_mysql \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

	# curl -sS https://getcomposer.org/installer...
		# Installs Composer globally. 

# Enable Apache mod_rewrite for URL routing
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy the PHP service files
COPY src/ ./src/
COPY config/ ./config/

# Install PHP dependencies via Composer
RUN cd /var/www/html && \
    composer install --no-dev --optimize-autoloader  # Optimizes the final image

# Create a non-root user
RUN useradd --uid 1000 theia && \
    chown -R theia:theia /var/www/html

# Create a non-root user and set permissions
RUN useradd --uid 1000 theia && \
    chown -R theia:theia /var/www/html

# Switch to the non-root user
USER theia

# Expose Apache port
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
