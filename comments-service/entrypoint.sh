#!/bin/sh

# Ejecutar el comando de cola en segundo plano
php artisan rabbitmq:first_comment_queue &

# Ejecutar el servidor Laravel en primer plano
php artisan serve --host=0.0.0.0 --port=80
