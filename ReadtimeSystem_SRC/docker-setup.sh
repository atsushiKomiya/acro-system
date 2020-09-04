#!/usr/bin/bash
# DBデータ削除
rm -R docker/pgadmin4/data/
rm -R docker/postgres/data/

# Volume Create
echo "docker volume create --name test_db"
docker volume create --name test_db

# docker build
echo "docker-compose up -d --build"
docker-compose up -d --build

# postgreSQL setup
echo "docker-compose exec postgres sh /docker-entrypoint-initdb.d/2_init.sh"
docker-compose exec postgres sh /docker-entrypoint-initdb.d/2_init.sh

# Laravel setup
echo "docker-compose exec php-laravel sh laravel-setup.sh"
docker-compose exec php-laravel sh laravel-setup.sh
