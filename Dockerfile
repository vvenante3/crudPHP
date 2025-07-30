FROM php:8.2-apache

# Instala extensões necessárias
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql

# Copia os arquivos do projeto para o diretório do Apache
COPY ./app /var/www/html

EXPOSE 80