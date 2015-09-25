# Hotel-booking - Asiantech PHP Internship Project

## Version
Laravel 5.1.*

## Install

##### Server Requirements

- PHP >= 5.5.9
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension

##### Clone this repository into local

```
git clone link_to_this_repo project_name
```
##### Install packages by composer
Execute
```bash
composer install
```
to download all required packages to vendor directory. But before execute that command, make sure [composer](https://getcomposer.org/doc/00-intro.md#globally) is globally installed in your local machine.

##### Directory Permissions
```bash
sudo chmod -R 777 storage
sudo chmod -R 777 bootstrap/cache
```

##### Setup the Vhost

Using [Homestead](http://laravel.com/docs/5.1/homestead) is recommended. You can also settup the vhost for Apache or Nginx on you local machine

## Installed Packages

##### Laravel Debugbar
[Laravel Debugbar](https://github.com/barryvdh/laravel-debugbar) is used for debuging. Only use this package on local environment. Verison: ^2.0

##### MultiAuth
[MultiAuth](https://github.com/Kbwebs/MultiAuth). Version: 1.0

## Admin template
[https://almsaeedstudio.com/AdminLTE](https://almsaeedstudio.com/AdminLTE)

## Editor
All developers must use [Atom](https://atom.io) editor

## Local environment
- [Homestead](http://laravel.com/docs/5.1/homestead) is required
- Local domain must be `hotel-booking.me` for all members

## Coding style
Follow [PSR-2](http://www.php-fig.org/psr/psr-2/) Coding style

## Issue management
[https://waffle.io/PHPIntership/hotel-booking](https://waffle.io/PHPIntership/hotel-booking)

## Testing
[http://laravel.com/docs/5.1/testing](http://laravel.com/docs/5.1/testing)
