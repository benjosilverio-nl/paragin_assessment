#!/bin/sh
set -e

# Fix permissions
chown -R www-data:www-data /var/www/html
chmod -R 775 /var/www/html/var
chmod -R 755 /var/www/html/public
find /var/www/html -type d -exec chmod 755 {} \;

# Start PHP-FPM (critical!)
exec php-fpm
