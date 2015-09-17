# Asiantech PHP Team - Laravel Sample Project

This repository is used for projects that use [Laravel](http://laravel.com) framework.

### Version
Laravel 5.1.*

### Install

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
##### Change git url

Change the git url to point to your project's repository
```
git remote set-url origin your_git_project_url
```
or set the git url in git config file
```
vim .git/config #open git config file by vim, then set the url
```

##### Directory Permissions
```bash
sudo chmod -R 777 storage
sudo chmod -R 777 bootstrap/cache
```

##### Setup the Vhost

Using [Homestead](http://laravel.com/docs/5.1/homestead) is recommended. You can also settup the vhost for Apache or Nginx on you local machine

### Installed Packages

##### Laravel Debugbar
[Laravel Debugbar](https://github.com/barryvdh/laravel-debugbar) is used for debuging. Only use this package on local environment.

Verison: ^2.0

### Recommended Packages (not Installed)

- [Laravel Former](https://github.com/formers/former) : Easier way to handle form
- [Intervention Image](http://image.intervention.io/) : The great package for working with image
- [Laravel Collective](http://laravelcollective.com/)
- [Laravel-Excel](https://github.com/Maatwebsite/Laravel-Excel): Working with Excel is more easier and fun
- [API](https://github.com/dingo/api): It's for building an API project
- [Laravel Mongodb](https://github.com/jenssegers/laravel-mongodb): The Eloquent for Mongodb
[Sloquent Sluggable](https://github.com/cviebrock/eloquent-sluggable): Making slug
