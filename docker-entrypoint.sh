#!/bin/bash
set -e

# Wait for MySQL to be ready
echo "Waiting for MySQL..."
until mysqladmin ping -h"${DB_HOST:-db}" -u"${DB_USER:-pimcore}" -p"${DB_PASSWORD:-pimcore}" --silent; do
  sleep 1
done
echo "MySQL is ready"

# Install Composer dependencies if vendor doesn't exist
if [ ! -d "vendor" ]; then
    echo "Installing Composer dependencies..."
    composer install --no-interaction --no-progress
fi

# Set proper permissions
chmod -R 775 var/

# Execute CMD
exec "$@"
