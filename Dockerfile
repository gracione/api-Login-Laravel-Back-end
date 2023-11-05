# Define a imagem base a partir da qual sua imagem Docker será criada
FROM php:7.4-apache

# Atualiza a lista de pacotes do sistema e instala dependências
RUN apt-get update && apt-get install -y wget redis-server libxml2-dev autoconf automake libpq-dev libonig-dev libzip-dev libcurl4-openssl-dev libfreetype6-dev libjpeg62-turbo-dev libpng-dev

# Instala várias extensões do PHP
RUN docker-php-ext-install dom
RUN docker-php-ext-install pgsql
RUN docker-php-ext-install pdo
RUN docker-php-ext-install pdo_pgsql
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install curl
RUN docker-php-ext-install gd
RUN docker-php-ext-install soap
RUN docker-php-ext-install zip

# Configura a extensão gd para usar freetype e jpeg
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# Compila a extensão gd com o número de núcleos de CPU disponíveis
RUN docker-php-ext-install -j$(nproc) gd

# Copia o arquivo de configuração do virtual host do Apache para o local correto
COPY virtualhost.conf /etc/apache2/sites-available/000-default.conf

# Ativa o módulo de reescrita do Apache
RUN a2enmod rewrite

# Reinicia o serviço do Apache
RUN service apache2 restart

# Baixa o Composer e o coloca no diretório /usr/local/bin
RUN wget https://getcomposer.org/composer.phar
RUN mv composer.phar /usr/local/bin/composer

# Define permissões para o Composer
RUN chmod -R 755 /usr/local/bin/composer

# Expõe a porta 80 para acessar o servidor web Apache dentro do contêiner
EXPOSE 80
