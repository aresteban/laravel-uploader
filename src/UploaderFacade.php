<?php
namespace aresteban\LaravelUploader;

use Illuminate\Support\Facades\Facade;

class UploaderFacade extends Facade {

    /**
     * Return facade accessor
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'uploader';
    }
}
