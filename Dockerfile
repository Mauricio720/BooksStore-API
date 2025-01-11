# Usar a imagem base do PHP com extensões necessárias para Laravel
FROM php:8.0-fpm

# Atualizar pacotes e in
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Instalar o Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copiar arquivos do projeto
WORKDIR /var/www
COPY . /var/www
# Instalar dependências do Composer
# Garantir que o diretório de armazenamento exista e configurar permissões
RUN mkdir -p /var/www/storage && chown -R www-data:www-data /var/www/storage \
    && chmod -R 775 /var/www/storage

# Garantir que o diretório de logs tenha as permissões corretas
RUN touch /var/www/storage/logs/laravel.log && chown www-data:www-data /var/www/storage/logs/laravel.log \
&& chmod 664 /var/www/storage/logs/laravel.log

# Configurar o entrypoint
CMD ["php-fpm"]

EXPOSE 9000
