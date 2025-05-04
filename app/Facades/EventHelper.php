<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class EventHelper extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'eventhelper';
    }
}