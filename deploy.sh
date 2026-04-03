#!/bin/bash
git pull origin main
docker compose -f docker-compose.yml -f docker-compose.prod.yml exec web composer install
docker compose -f docker-compose.yml -f docker-compose.prod.yml exec web npm install
docker compose -f docker-compose.yml -f docker-compose.prod.yml exec web npm run build
docker compose -f docker-compose.yml -f docker-compose.prod.yml exec web php artisan migrate --force
docker compose -f docker-compose.yml -f docker-compose.prod.yml exec web php artisan config:cache