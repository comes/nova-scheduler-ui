# NovaSchedulerUi

This is a package for [Laravel Nova](https://nova.laravel.com/) which allows you to create, update and delete scheduled commands based on [DionTech/laravel-extended-scheduler](https://github.com/DionTech/laravel-extended-scheduler)

## Installation

You can install the package in to a Laravel app that uses [Nova](https://nova.laravel.com) via composer:

```bash
composer require comes/nova-scheduler-ui
```

After installation run
```
php artisan migrate
```

and add Packge to tools section in NovaServiceProvider
```
public function tools()
{
    return [
        new NovaSchedulerUi,
    ];
}
```
