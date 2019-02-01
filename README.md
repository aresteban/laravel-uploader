# Laravel Uploader

A helper package for uploading files to temporary a temporary location and only move them permanently on save.

## Installation
You can install the package via composer:

```bash
composer require aresteban/laravel-uploader
```

*Note: For Laravel versions 5.5 and up. This package supports laravel's `auto-discover`*

Optionally you can manually register it by including it providers and alias in your `config/app.php`:

```php
'providers' => [
    //  Other providers

    aresteban\LaravelUploader\UploaderServiceProvider::class,
]
```

```php
'aliases' => [
    // Other aliases

    'Uploader' =>  aresteban\LaravelUploader\UploaderFacade::class,
]
```
