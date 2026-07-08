#!/bin/sh
set -e

# Railway envia trafico al puerto 9000
PORT=9000
echo "Using PORT: $PORT"

# Asegurar que el directorio de config existe
mkdir -p /etc/nginx/http.d

# Eliminar config vieja de conf.d (Alpine no la usa y causa conflicto)
rm -f /etc/nginx/conf.d/default.conf

# Generar nginx config con el puerto correcto
cat > /etc/nginx/http.d/default.conf <<EOF
server {
    listen $PORT;
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