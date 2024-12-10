web: mkdir -p public/build && chmod -R 777 public/build && npm run build && chmod -R 777 storage/logs && chmod -R 777 storage/framework && php artisan config:clear && php artisan cache:clear && php artisan view:clear && php artisan route:clear && heroku-php-apache2 public/
release: php artisan migrate:fresh --seed --force
