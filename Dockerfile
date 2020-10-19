#### Step 1 : composer

FROM cylab/php72 AS composer

COPY . /var/www/html
WORKDIR /var/www/html
RUN composer install --no-dev --optimize-autoloader

#### Step 2 : node

FROM node AS node

COPY . /var/www/html
WORKDIR /var/www/html
RUN npm --version && npm install && npm run prod

#### Step 3 : the actual docker image

FROM php:7.4-apache

### PHP

# we may need some other php modules, but we can first check the enabled modules with
# docker run -it --rm php:7.4-apache php -m
# RUN docker-php-ext-install mbstring 


### Apache

# change the document root to /var/www/html/public
RUN sed -i -e "s/html/html\/public/g" /etc/apache2/sites-enabled/000-default.conf

# enable apache mod_rewrite
RUN a2enmod rewrite


### Laravel application

# copy source files
COPY . /var/www/html
COPY --from=composer /var/www/html/vendor /var/www/html/vendor
COPY --from=node /var/www/html/public/css /var/www/html/public/css
COPY --from=node /var/www/html/public/js /var/www/html/public/js
COPY --from=node /var/www/html/public/fonts /var/www/html/public/fonts


# these directories need to be writable by Apache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# copy env file for our Docker image
COPY env.docker /var/www/html/.env

## create sqlite db structure
RUN mkdir -p storage/app && touch storage/app/db.sqlite && php artisan migrate

### Docker image metadata

VOLUME ["/var/www/html/storage", "/var/www/html/bootstrap/cache"]
