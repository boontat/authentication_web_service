# Authentication Web Service

## Goal
Create an authentication API service with Passport package from PHP Lumen framework.

## Installation

- Get the repositories

  `$ git clone https://github.com/boontat/authentication_web_service.git`
- Duplicate .env.example to .env and
    - Update the database details (credential/port/host)
    - Generate key

- Install dependencies

  `$ composer install`
- Run migration

  `$ php artisan migrate`
- Install passport

  `$ php artisan passport:install`

## Start server

`$ cd <project-root-directory>`

`$ php -S localhost:8080 -t public`

## Usage (Using Postman)
see `docs/screenshot`
