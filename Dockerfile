# Usa l'immagine ufficiale PHP con Apache
FROM php:8.3-apache

# Installa le dipendenze necessarie
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libpq-dev \
    libonig-dev \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Configura e installa le estensioni PHP necessarie
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql pdo_pgsql mysqli zip opcache mbstring

# Abilita i moduli Apache necessari
RUN a2enmod rewrite headers

# Copia i file di Joomla nella directory del server web
COPY . /var/www/html/

# Copia il file di configurazione per Render
COPY configuration.php.render /var/www/html/configuration.php

# Crea un file phpinfo.php direttamente nel container
RUN echo "<?php phpinfo(); ?>" > /var/www/html/phpinfo.php

# Crea le cartelle necessarie e imposta i permessi
RUN mkdir -p /var/www/html/tmp /var/www/html/logs /var/www/html/administrator/logs /var/www/html/language /tmp/joomla_logs && \
    chmod -R 755 /var/www/html /tmp/joomla_logs && \
    chown -R www-data:www-data /var/www/html /tmp/joomla_logs && \
    chmod 644 /var/www/html/configuration.php

# Configura PHP per Joomla
RUN echo "upload_max_filesize = 64M" >> /usr/local/etc/php/conf.d/joomla.ini \
    && echo "post_max_size = 64M" >> /usr/local/etc/php/conf.d/joomla.ini \
    && echo "memory_limit = 256M" >> /usr/local/etc/php/conf.d/joomla.ini \
    && echo "max_execution_time = 300" >> /usr/local/etc/php/conf.d/joomla.ini \
    && echo "max_input_vars = 3000" >> /usr/local/etc/php/conf.d/joomla.ini
    
COPY test_index.php /var/www/html/index.php

# Imposta la variabile d'ambiente PORT
ENV PORT 10000

# Esponi la porta
EXPOSE $PORT

# Configura Apache per usare la porta specificata
RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# Abilita il display degli errori per il debug
RUN echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Avvia Apache in foreground
CMD ["apache2-foreground"]
