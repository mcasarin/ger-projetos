#!/bin/bash
docker exec -it laravel_app_gerproj php artisan permission:cache-reset
docker exec -it laravel_app_gerproj php artisan cache:clear
docker exec -it laravel_app_gerproj php artisan config:clear
