FROM php:8.1-fpm

# Instale dependências do sistema
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libonig-dev \
    libzip-dev \
    libmcrypt-dev \
    libxml2-dev

# Instale extensões do PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instale o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Defina o diretório de trabalho
WORKDIR /var/www

# Copie o código do projeto para o diretório de trabalho
COPY . .

# Dê permissões de escrita ao diretório de armazenamento e cache do Laravel
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Exponha a porta padrão do PHP-FPM
EXPOSE 9000
CMD ["php-fpm"]
