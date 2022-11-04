# 立ち上げ基本
```
docker-compose up -d
docker-compose exec app bash
npm install
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link
npm run dev
```

# ローカルのみ以下に変更
/Users/chankan/Desktop/more-clothing/infra/nginx/default.conf
```
server {
    listen 80;
    # listen 443 ssl; // ローカルのみコメントアウト
    server_name more-clothing.site;
    root /work/public;

    # ssl_certificate      /ssl/fullchain6.pem; // ローカルのみコメントアウト
    # ssl_certificate_key  /ssl/privkey6.pem; // ローカルのみコメントアウト
```
