<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class CardHelper extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'cardhelper';
    }
}