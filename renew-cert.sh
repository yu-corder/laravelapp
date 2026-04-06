#!/bin/bash

cd /var/www/sauna-rally

docker run --rm \
  -v "/etc/letsencrypt:/etc/letsencrypt" \
  -v "/var/lib/letsencrypt:/var/lib/letsencrypt" \
  -v "/var/log/letsencrypt:/var/log/letsencrypt" \
  -v "/var/www/sauna-rally/src:/var/www" \
  certbot/certbot renew --webroot -w /var/www --no-random-sleep-on-renew

docker exec saunas-nginx nginx -s reload