
# Construir o PHP Apache
FROM php:8.0-apache

# Instalar o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Define o diretório de trabalho
WORKDIR /var/www/html

# Copia o código fonte para o diretório de trabalho
COPY . /var/www/html
COPY src/. /var/www/html/src
COPY init.sql /docker-entrypoint-initdb.d/

# Instala as dependências necessárias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libpq-dev \
    && docker-php-ext-install -j$(nproc) \
    gd \
    mysqli \
    pdo_mysql

# Configurações do Apache
RUN a2enmod rewrite

# Instalar as dependências do projeto com o Composer
RUN composer install

# Expõe a porta 80
EXPOSE 80