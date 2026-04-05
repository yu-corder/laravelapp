#!/bin/bash
git pull origin main

docker compose -f docker-compose.yml -f docker-compose.prod.yml up -d --build

docker compose -f docker-compose.yml -f docker-compose.prod.yml exec web composer install --no-dev --optimize-autoloader
docker compose -f docker-compose.yml -f docker-compose.prod.yml exec web npm install
docker compose -f docker-compose.yml -f docker-compose.prod.yml exec web npm run build

docker compose -f docker-compose.yml -f docker-compose.prod.yml exec web php artisan migrate --force
docker compose -f docker-compose.yml -f docker-compose.prod.yml exec web php artisan config:cache
docker compose -f docker-compose.yml -f docker-compose.prod.yml exec web php artisan route:cache
docker compose -f docker-compose.yml -f docker-compose.prod.yml exec web php artisan view:cache