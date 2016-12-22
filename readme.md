# G Suite Admin

This sample app was built on top of Laravel, so for those who are familiar with Laravel, it should be easy to realize what is going under the hood and how to run it. For those who aren't, I provide below a Getting Started guide so you can quickly start using this.

## Getting Started

### Installing
After you clone (or download) this repository, you will need to follow these steps to run the application:

Install dependencies (libraries used by the project)  
```
composer update
```

Grant write access to storage folder
```
sudo chmod -R gu+w storage
```

Create a file named .env using the file .env.example as a template and update it so its values match your environment, specially the following:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=GSuiteAdmin
DB_USERNAME=GSuiteAdmin
DB_PASSWORD=A-SENHA-VEM-AQUI
```

Generate a key to be used by your local instance.
```
php artisan key:generate
```

- Last, but not least, update the app configs cache:
```
php artisan config:cache
```

### Connecting to your G Suite Domain / Account
 
Right now, my main concern is related to the setup related to Google G Suite (formerly known as Google Apps) environment. This setup involves basically the following steps
- Create a Project under Google Developer Console 
- Create a Credential (a Service Account)
- Authorize APIs

[Tutorial on how to execute the previous steps (em Portugues Brasileiro)](https://docs.google.com/presentation/d/1rsJlZ48BYw6HiK0OqP6-7o0tKY8KVNXyTKwzS5OjR_c/edit#slide=id.g1a1712ec78_1_122)

# Laravel PHP Framework

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as authentication, routing, sessions, queueing, and caching.

Laravel is accessible, yet powerful, providing tools needed for large, robust applications. A superb inversion of control container, expressive migration system, and tightly integrated unit testing support give you the tools you need to build any application with which you are tasked.

## Official Documentation

Documentation for the framework can be found on the [Laravel website](http://laravel.com/docs).

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](http://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
