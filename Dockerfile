# Usa la imagen base de PHP 8.3 con FPM
FROM php:8.3.0-apache-bullseye

# Directorio de trabajo en el contenedor
WORKDIR /var/www/html

# Instala dependencias necesarias
RUN apt-get update && \
    apt-get install -y \
        unzip \
        libzip-dev \
        libonig-dev \
        libxml2-dev \
        ca-certificates \
        apt-transport-https \
        software-properties-common \
        sqlite3 \
        libsqlite3-dev \
    && docker-php-ext-install zip mbstring xml pdo_sqlite

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copia los archivos del backend desde la máquina local al contenedor
COPY . .

# Instala las dependencias de Laravel usando Composer
RUN composer install --no-dev --optimize-autoloader

# Configuración de Apache para Laravel
RUN sed -i 's#DocumentRoot /var/www/html#DocumentRoot /var/www/html/public#g' /etc/apache2/sites-available/000-default.conf

# Genera la clave de la aplicación de Laravel y configura permisos
RUN php artisan key:generate && \
    php artisan storage:link && \
    chown -R www-data:www-data /var/www/html

# Habilitar el módulo rewrite (para cross domain)
RUN a2enmod rewrite
