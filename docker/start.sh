#!/bin/sh
set -e

NGINX_PORT=${PORT:-8080}
echo "Using nginx port: $NGINX_PORT"

mkdir -p /etc/nginx/http.d /run/php

rm -f /etc/nginx/conf.d/default.conf

cat > /usr/local/etc/php-fpm.d/zz-docker.conf <<'EOFPHP'
[global]
daemonize = no
error_log = /dev/stderr
log_level = notice

[www]
listen = 9000
access.log = /dev/stderr
catch_workers_output = yes
EOFPHP

cat > /etc/nginx/http.d/default.conf <<EOF
error_log /dev/stderr warn;

server {
    listen [::]:$NGINX_PORT ipv6only=off;
    server_name _;
    root /app/public;
    index index.php;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    location = /api/health {
        access_log off;
        default_type application/json;
        return 200 '{"status":"ok","app":"BackPlanificar"}';
    }

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    location ~ \.php\$ {
        fastcgi_pass 127.0.0.1:9000;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
        fastcgi_param APP_ENV production;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
EOF

nginx -t 2>&1

php artisan config:cache 2>/dev/null || true
php artisan route:cache 2>/dev/null || true
php artisan migrate --force 2>/dev/null || true

exec supervisord -c /etc/supervisord.conf -n
