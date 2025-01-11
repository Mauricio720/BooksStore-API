# Usar a imagem base do PHP com extensões necessárias para Laravel
FROM php:8.0-fpm

# Atualizar pacotes e instalar dependências necessárias
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

# Definir o diretório de trabalho
WORKDIR /var/www

# Copiar os arquivos do projeto para o container
COPY . /var/www

# Copiar o arquivo .env para o container
COPY .env /var/www/.env

# Instalar dependências do Composer
RUN composer install --optimize-autoloader --no-dev

# Garantir que o diretório de armazenamento e cache existam e configurar permissões
RUN mkdir -p /var/www/storage && chown -R www-data:www-data /var/www/storage \
    && chmod -R 775 /var/www/storage \
    && chown -R www-data:www-data /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/bootstrap/cache

# Garantir que o diretório de logs tenha as permissões corretas
RUN touch /var/www/storage/logs/laravel.log && chown www-data:www-data /var/www/storage/logs/laravel.log \
    && chmod 664 /var/www/storage/logs/laravel.log

# Gerar a chave da aplicação
RUN php artisan key:generate

# Limpar e otimizar cache de configuração
RUN php artisan config:clear && php artisan cache:clear

# Configurar o entrypoint
CMD ["php-fpm"]

# Expor a porta 9000
EXPOSE 9000

# Healthcheck para verificar se o container está rodando corretamente (opcional)
HEALTHCHECK --interval=30s --timeout=10s --start-period=5s --retries=3 \
    CMD curl -f http://localhost:9000 || exit 1
