#!/usr/bin/bash
psql -f /docker-entrypoint-initdb.d/1_DDL.sql -d -U root -d postgres

# dump
psql -f /docker-entrypoint-initdb.d/dump/address.sql -d -U root -d postgres
psql -f /docker-entrypoint-initdb.d/dump/depocd.sql -d -U root -d postgres
psql -f /docker-entrypoint-initdb.d/dump/h_dep.sql -d -U root -d postgres
psql -f /docker-entrypoint-initdb.d/dump/h_shain.sql -d -U root -d postgres
psql -f /docker-entrypoint-initdb.d/dump/item_sale.sql -d -U root -d postgres
psql -f /docker-entrypoint-initdb.d/dump/item_site.sql -d -U root -d postgres
psql -f /docker-entrypoint-initdb.d/dump/s_pref.sql -d -U root -d postgres
psql -f /docker-entrypoint-initdb.d/dump/s_to_depo_message.sql -d -U root -d postgres
