<?php

namespace Mate\Roles\Facades;

use Illuminate\Support\Facades\Facade;

class Roles extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'roles';
    }
}
