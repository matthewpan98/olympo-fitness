FROM php:8.2-apache

# Abilita mysqli
RUN docker-php-ext-install mysqli

# Copia tutti i file nella cartella Apache
COPY ./website /var/www/html/

EXPOSE 80