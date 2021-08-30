#!/bin/bash

cd docker && docker-compose up -d
docker exec -it iq_devs_main_fpm composer install --ignore-platform-reqs
docker exec -it iq_devs_main_fpm php artisan key:generate
docker exec -it iq_devs_main_fpm php artisan config:clear
docker exec -it iq_devs_main_fpm php artisan migrate
docker exec -it iq_devs_main_fpm php artisan db:seed
docker-compose down && docker-compose up -d && cd ../
