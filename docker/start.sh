#!/bin/sh
set -e

NGINX_PORT=${PORT:-8080}
echo "Using nginx port: $NGINX_PORT"

# Asegurar directorios
mkdir -p /etc/nginx/http.d /run/php

# Limpiar config conflictiva
rm -f /etc/nginx/conf.d/default.conf

# Generar nginx config
cat > /etc/nginx/http.d/default.conf <<EOF
server {
    listen $NGINX_PORT;
    server_name _;
    root /app/public;
    index index.php;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    location ~ \.php\$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
        fastcgi_param APP_ENV production;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
EOF

# Verificar config de nginx
nginx -t 2>&1

php artisan migrate --force 2>/dev/null || true

exec supervisord -c /etc/supervisord.conf