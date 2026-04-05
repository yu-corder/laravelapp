#!/bin/bash
docker run --rm -v "/etc/letsencrypt:/etc/letsencrypt" -v "/var/lib/letsencrypt:/var/lib/letsencrypt" -v "$(pwd)/src:/var/www" certbot/certbot renew --webroot -w /var/www/public

docker exec saunas-nginx nginx -s reload