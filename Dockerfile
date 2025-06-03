# Usa la imagen oficial de PHP con Apache
FROM php:8.2-apache

# Instala dependencias necesarias y la extensión pdo_pgsql para Postgres
RUN apt-get update && apt-get install -y \
    libpq-dev zip unzip git curl libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Instala Composer (gestor de dependencias PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia todo el backend al contenedor
COPY . /var/www/html

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Cambia permisos necesarios para que Apache pueda escribir en storage y cache
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

# Instala las dependencias PHP con Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Expone el puerto 80
EXPOSE 80
