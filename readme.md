<h1 align="center">Vue CRUD Laravel API</h1>

## About

Vue CRUD Laravel API is an API written using PHP and Laravel, dedicated to as a backend to the <a href="https://github.com/szczepanmasny/vue-crud">Vue CRUD</a> project. The project includes migrations, models and controllers associated with the sample, default project attached to Vue CRUD.

## Requirements
- PHP 7.x,
- Composer

## Installation

Follow these steps:
1. Clone or download this project,
2. Open command line and go to the project directory,
3. Type:
```
composer install
```
4. Create database(s) for your project,
5. Create .env file based on .env.example and configure your project,
6. Type:
```
php artisan key:generate
```
7. Type:
```
php artisan load-template
```
and select one of available templates

8. Type:
```
php artisan migrate
```
9. Run seeders if available,
10. Type:
```
php artisan serve
```

## License

The Vue CRUD Laravel API is application licensed under the [MIT license](http://opensource.org/licenses/MIT).
