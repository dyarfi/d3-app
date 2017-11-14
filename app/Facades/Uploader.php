<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Uploader extends Facade
{
    /**
     * Create the Facade
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'UploaderService'; }
}