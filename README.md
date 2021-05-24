# description
Youtubeデータ出力用アプリ

# image
<img src="./image.gif" width="500px">

# 環境
- PHP 7.4
- nginx 1.19.0
- MySQL 5.7

# start
- git clone https://github.com/accaxx/laratube

- docker-compose up
- docker-compose exec php /bin/bash

- composer install
- php artisan migrate
- php artisan key:generate
- cp .env.example .env
- -> edit GOOGLE_API_KEY

