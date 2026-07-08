#!/bin/sh
set -e

PORT=${PORT:-80}

sed -i "s/\${PORT:-80}/$PORT/g" /etc/nginx/http.d/default.conf
sed -i "s/\${PORT:-80}/$PORT/g" /etc/nginx/conf.d/default.conf

php artisan migrate --force 2>/dev/null || true

exec supervisord -c /etc/supervisord.conf