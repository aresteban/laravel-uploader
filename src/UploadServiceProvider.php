<?php
namespace aresteban\LaravelUploader;

use Illuminate\Support\ServiceProvider;
use aresteban\LaravelUploader\Uploader;

class UploadServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/uploading.php' => config_path('uploading.php'),
        ], 'config');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('uploader', function () {
            return new Uploader(config('uploading.paths.temporary'), config('uploading.paths.permanent'));
        });
    }
}
