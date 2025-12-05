# Imagen oficial de PHP con Apache
FROM php:8.2-apache

# Habilitar las extensiones que tú necesites
RUN docker-php-ext-install pdo pdo_mysql

# Copiar los archivos del proyecto al contenedor
COPY . /var/www/html/

# Dar permisos a Apache
RUN chown -R www-data:www-data /var/www/html

# Exponer el puerto 80
EXPOSE 80