FROM wordpress:6.8-php8.2-apache

# PHP production settings
RUN { \
    echo 'upload_max_filesize = 64M'; \
    echo 'post_max_size = 64M'; \
    echo 'memory_limit = 256M'; \
    echo 'max_execution_time = 300'; \
    echo 'opcache.enable = 1'; \
    echo 'opcache.memory_consumption = 128'; \
    echo 'opcache.validate_timestamps = 0'; \
} > /usr/local/etc/php/conf.d/kitfix-php.ini

# Enable mod_rewrite for WordPress permalinks
RUN a2enmod rewrite headers

# Remove default sample content
RUN rm -rf /usr/src/wordpress/wp-content/themes/twentytwentythree \
           /usr/src/wordpress/wp-content/themes/twentytwentyfour \
           /usr/src/wordpress/wp-content/plugins/hello.php \
           /usr/src/wordpress/wp-content/plugins/akismet

# Bake theme and plugin — copied to /var/www/html on first container start
COPY src/themes/kitfix24h     /usr/src/wordpress/wp-content/themes/kitfix24h
COPY src/plugins/kitfix24h-core /usr/src/wordpress/wp-content/plugins/kitfix24h-core
