<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class TransactionHelper extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'transactionhelper';
    }
}