#!/usr/bin/bash
# local環境のenvを削除
rm .env
echo "rm .env"

# local環境のenvに設定
sh ./env/env_build.sh
echo "sh ./env/env_build.sh"

# composerのインストール
composer install --no-plugins
echo "composer install --no-plugins"

# キャッシュのクリア
php artisan config:cache
echo "php artisan config:clear"

# classファイルの最新化
composer dump-autoload
echo "composer dump-autoload"

# libraryのインストール
npm install --no-bin-links
echo "npm install --no-bin-links"

# migration実行
php artisan migrate
echo "php artisan migrate"

# 初期データの投入(実行済みなので不要)
php artisan db:seed
echo "php artisan db:seed"

# API追加時
php artisan route:list
echo "php artisan route:list"
