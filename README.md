# Payday demo application

This is a demo application for my book [Test-Driven APIs with Laravel and Pest](https://martinjoo.gumroad.com/l/tdd-api-laravel)

## Install
- Create a database called `payday`
- Create a test database called `payday-test`
- `cp .env.example .env`
- Setup your database credentials in the .env file
- `composer install`
- `php artisan migrate --seed`

You can run the tests with:
`./vendor/bin/pest`

And serve the API with:
`php artisan serve`
