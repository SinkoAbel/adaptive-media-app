<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Documentation

### How to init project:
- git clone <project>
- cd inside the cloned folder
- composer install & npm install
- create .env file from .env.example, and modify the content according to your database table & credentials
- php artisan migrate
- php artisan serve

### Test data
- Factory and seeder is configured
- To generate test data (50 pcs) write: php artisan db:seed
- Perform requests

### Endpoint documentation
- the api is equipped with Swagger/OpenAPI documentation.
- place `L5_SWAGGER_CONST_HOST=http://project.test/api/v1` on the .env file.
- php artisan serve
- open documentation: http://localhost:8000/api/documentation/
- in case the page is not loading run command: php artisan l5-swagger:generate
- In case you can't see the requests click on the bold text called "Todo items"
- NOTICE 1: Swagger only allowed one 400 request, so I added the request body exception with 422 status code


### Used third-party packages:
- mews/purifier (https://github.com/mewebstudio/Purifier)
- Laravel service generator (https://github.com/timwassenburg/laravel-service-generator)
- DarkaOnline L5 Swagger (https://github.com/DarkaOnLine/L5-Swagger)
