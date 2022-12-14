## Description

This API is based on [Laravel 9](https://laravel.com/docs/9.x), use MySQL database and runs with docker containers by [Laradock](https://laradock.io/).

## Architecture

This API is based on typical Laravel architecture. The core of the API (business logic) is situated in Models and Services. Controllers are responsible for the request receiving, validation and response.

## Installation

1. Prepare Laradock .env file: 
```
cd laradock
cp .env.example .env
```
2. If you need you can change default Nginx (80) and MySQL (3306) ports. Just find variables ``NGINX_HOST_HTTP_PORT`` and ``MYSQL_PORT`` in the .env file and change them.<br><br>
3. Run containers:
```
sudo docker-compose up -d nginx php-fpm mysql workspace
```
4. Now you need to prepare .env file of Laravel:
```
cd ../api
cp .env.example .env
```
5. Change ``DB_HOST`` and ``DB_PORT`` in .env file of Laravel if you need.<br><br>
5. Run ``composer install`` inside the workspace container:
```
sudo docker exec -ti vouchers_workspace_1 bash -c "cd api && composer install"
```
5. Create database with name ``vouchers`` and run migrations:
> **Note:**<br>
> You can connect to MySQL remotely just using your favorite GUI client.
```
sudo docker exec -ti vouchers_workspace_1 bash -c "cd api && php artisan migrate"
```
## Testing

1. Use Postman to join the workspace by this link:
```
https://app.getpostman.com/join-team?invite_code=3b775455323ce7eb2f4f2b9f49a2c3e3&target_code=45b89f5b8b62833d8c9964ed05e93281
```
2. Set IP or domain of your server in current value of variable ``base_url`` in ``Main`` environment.
