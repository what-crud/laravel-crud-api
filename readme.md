<h1 align="center">Laravel CRUD API</h1>

## About

Laravel CRUD API is an API written using PHP and Laravel, dedicated to as a backend to the <a href="https://github.com/szczepanmasny/vue-crud">Vue CRUD</a> project. The project includes templates withmigrations, models and controllers associated with the Vue CRUD templates.

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

The Laravel CRUD API is application licensed under the [MIT license](http://opensource.org/licenses/MIT).
