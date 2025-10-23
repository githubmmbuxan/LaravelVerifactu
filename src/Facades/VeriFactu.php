<?php

declare(strict_types=1);

namespace MMBuxan\VeriFactu\Facades;

use Illuminate\Support\Facades\Facade;

class VeriFactu extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'verifactu';
    }
} 