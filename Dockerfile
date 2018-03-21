FROM php:7-cli
COPY . /app
CMD php -S 0.0.0.0:80 /app/public/index.php
EXPOSE 80
