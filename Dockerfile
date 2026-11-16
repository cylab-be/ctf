#### Step 1 : composer

FROM cylab/php:8.3 AS composer

COPY . /var/www/html
WORKDIR /var/www/html
RUN composer install --no-dev --optimize-autoloader

#### Step 2 : node

FROM node:22-alpine AS node

COPY . /var/www/html
WORKDIR /var/www/html
RUN npm --version && npm install && npm run build

#### Step 3 : the actual docker image

FROM cylab/laravel:8.3

### Laravel application

# copy source files
COPY . /var/www/html

# default env value
COPY production/stack.env /var/www/html/.env

COPY --from=composer /var/www/html/vendor /var/www/html/vendor
COPY --from=node /var/www/html/public/css /var/www/html/public/css
COPY --from=node /var/www/html/public/js /var/www/html/public/js

