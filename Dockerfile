#### Step 1 : composer

FROM cylab/php:7.4 AS composer

COPY . /var/www/html
WORKDIR /var/www/html
RUN composer install --no-dev --optimize-autoloader

#### Step 2 : node

FROM node:12-alpine AS node

COPY . /var/www/html
WORKDIR /var/www/html
RUN npm --version && npm install && npm run prod

#### Step 3 : the actual docker image

FROM cylab/laravel:7.4

### Laravel application

# copy source files
COPY . /var/www/html

# default env value
COPY production/stack.env /var/www/html/.env

COPY --from=composer /var/www/html/vendor /var/www/html/vendor
COPY --from=node /var/www/html/public/css /var/www/html/public/css
COPY --from=node /var/www/html/public/js /var/www/html/public/js
COPY --from=node /var/www/html/public/fonts /var/www/html/public/fonts

