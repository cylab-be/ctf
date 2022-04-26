#
# env.app
#
# Example environment file for deploying with docker-compose.
# You should at leaset modify APP_URL
# 


APP_NAME=CTF
APP_ENV=prod
APP_KEY=base64:ezEe4jH/6EUM2fMWLnco3kuMz1OMStq/XfV456ZwMhc=
APP_DEBUG=false

# Full URL of the application
APP_URL=http://localhost:8080

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=root

BROADCAST_DRIVER=log
CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis
SESSION_LIFETIME=120

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=log

# Uncomment and modify following lines to send emails
#MAIL_DRIVER=smtp
#MAIL_HOST=smtp.mailtrap.io
#MAIL_PORT=2525
#MAIL_USERNAME=null
#MAIL_PASSWORD=null
#MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=ctf@cylab.be
MAIL_FROM_NAME=ctf


