# Use uma imagem oficial do PHP com Apache
FROM php:7.4-apache

# Instale as extensões PHP necessárias
RUN docker-php-ext-install pdo pdo_mysql

# Ativar o módulo rewrite do Apache
RUN a2enmod rewrite

# Instalar o Xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug
COPY xdebug.ini /usr/local/etc/php/conf.d/

# Configurar as variáveis de ambiente do Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
ENV APP_ENV=local
ENV APP_KEY=base64:SeuAppKeyAqui
ENV APP_DEBUG=true
ENV APP_LOG=errorlog
ENV APP_URL=http://salao.localhost

# Definir o nome do host virtual
RUN echo "ServerName salao.localhost" >> /etc/apache2/apache2.conf

# Copiar o arquivo de configuração do host virtual
COPY salao.localhost.conf /etc/apache2/sites-available/
RUN a2ensite salao.localhost.conf

# Reiniciar o Apache
RUN service apache2 restart

# Definir o diretório de trabalho
WORKDIR /var/www/html

# Expor a porta 80 do contêiner
EXPOSE 80

# Comando para iniciar o Apache em segundo plano
CMD ["apache2-foreground"]
