# Laravel Uploader

A helper package for uploading files to temporary a temporary location and only move them permanently on save.

## Installation
You can install the package via composer:

```bash
composer require aresteban/laravel-uploader
```

*Note: For Laravel versions 5.5 and up. This package supports laravel's `auto-discover` function.*

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

Publish the config file by:
```bash
php artisan vendor:publish --tag=config
```

This will add a config file under `config/uploading.php` where you can modify destination paths.

## Usage
| Functions                     | Paramenters         | Description  |
| ----------------------------- | :-----------------: | :-----: |
| upload($file)                 | UploadedFile Object | An instance of UploadedFile from the request |
| get()                         | N/A                 | Returns an array of data of uploaded file (original_filename, filename, file_url) |
| save($filename = null)        | String             |  Filename is generated from upload and can be retrieved by `get()` method|
| saveTo($path)                 | String              |    Override storage path specified in config |
| saveTo($new_name, $filename)  | String, String      |    Rename the file on save |

Method 1: Immidiately storing uploaded file to permanent directory
```
Storage::upload($request->file)
    ->save();
```

Method 2: If you wish to override storage path
```
Storage::upload($request->file)
    ->saveTo('public/another/path')
    ->save();
```

Method 3: Uploading file to temporary path and wait for another cue to permanently store file. For this example lets assume that the entire process takes to api to complete. (eg. Uploading before allowing form submission)
```
// API 1
$result = Storage::upload($request->file)
    ->get();

return $result;

// API 2
Storage::save($request->filename);
```


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
